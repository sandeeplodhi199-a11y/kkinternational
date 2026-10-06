<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacalityController extends Controller
{
  
    public function facality(Request $request)
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "facality_view";

        $keyword = $request->keyword;
        $r_page = $request->r_page ?? 25;

        $data['keyword'] = $keyword;
        $data['r_page'] = $r_page;

        $page = Facality::where('is_deleted', 0)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->latest()
            ->paginate($r_page);


        $page->appends(['keyword' => $keyword, 'r_page' => $r_page]);

        return view('backend.facality.all', compact('data', 'page'))
            ->with('i', (request()->input('page', 1) - 1) * $r_page);
    }

    
    public function add_facality()
    {
        $data['menu'] = "categorys";
        $data['submenu'] = "facality_add";

        $courses = DB::table('tbl_course')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->get();
         $branches = DB::table('tbl_branch')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->get();
         $subjects = DB::table('tbl_subject')
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->get();        

        return view('backend.facality.add', compact("data", "courses","branches","subjects"));
    }

   
  public function saveFacality(Request $request)
{
    $user = Auth::user();

   
    $isUnique = $this->check_unique_phone('phone', $request->phone);
    if (!$isUnique) {
        return redirect()->back()->with('error', 'Facality phone already exists.');
    }

    $facality = new Facality();
    $facality->name = $request->name;
    $facality->email = $request->email ?? null;
    $facality->phone = $request->phone ?? null;

    $facality->alternate_phone = $request->alternate_phone ?? null;
    $facality->father_name = $request->father_name ?? null;
    $facality->mother_name = $request->mother_name ?? null;
    $facality->highest_qualification = $request->highest_qualification ?? null;

    $facality->present_address = $request->present_address ?? null;
    $facality->permanent_address = $request->permanent_address ?? null;

    $facality->state = $request->state ?? null;
    $facality->city = $request->city ?? null;

    $facality->orders_by = $request->orders_by ?? 0;

    $facality->status = 'Active';
    $facality->is_deleted = 0;
    $facality->add_id = $user->id;


    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = time() . '_photo.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('uploads'), $photoName);
        $facality->photo = $photoName;
    }


    

    $facality->branch_id = !empty($request->branch_ids)
                            ? implode(',', $request->branch_ids)
                            : null;

    $facality->course_id = !empty($request->course_ids)
                            ? implode(',', $request->course_ids)
                            : null;

    $facality->subject_id = !empty($request->subject_ids)
                            ? implode(',', $request->subject_ids)
                            : null;


    
    $facality->save();

    $facality->id_hash = md5($facality->id);
    $facality->save();


    
    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $file) {

            $docName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $docName);

            DB::table('tbl_facality_documents')->insert([
                'facality_id' => $facality->id,
                'document' => $docName,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Facality saved successfully!');
}

    public function check_unique_phone($key, $value)
    {
        if (!$value) return true;
        return !Facality::where($key, $value)->exists();
    }

   
  public function edit_facality($id_hash)
{

    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_39', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $data['menu'] = "categorys";
    $data['submenu'] = "facality_view";

    $page = Facality::where('id_hash', $id_hash)->first();

    // Load dropdown data
    $courses = DB::table('tbl_course')->where('is_deleted', 0)->where('status', 'Active')->get();
    $branches = DB::table('tbl_branch')->where('is_deleted', 0)->where('status', 'Active')->get();
    $subjects = DB::table('tbl_subject')->where('is_deleted', 0)->where('status', 'Active')->get();

    // Load existing documents
    $docs = DB::table('tbl_facality_documents')
        ->where('facality_id', $page->id)
        ->get();

    return view('backend.facality.edit', compact("data","page","courses","branches","subjects","docs"));
}

public function delete_document($id)
{
    $doc = DB::table('tbl_facality_documents')->where('id', $id)->first();

    if (!$doc) {
        return response()->json(['status' => 'error']);
    }

    $path = public_path('uploads/'.$doc->document);

    if (file_exists($path)) {
        unlink($path);
    }

    DB::table('tbl_facality_documents')->where('id', $id)->delete();

    return response()->json(['status' => 'success']);
}

public function Updatefacality(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required'
    ]);

    // Check unique phone
    $isUnique = $this->check_unique_phone_edit('phone', $request->phone, $request->id);
    if (!$isUnique) {
        return redirect()->back()->with('error', 'Facality phone already exists.');
    }

    $user = Auth::user();
    $facality = Facality::find($request->id);

    if (!$facality) {
        return redirect()->back()->with('error', 'Invalid Facality ID.');
    }

    // Basic fields
    $facality->name = $request->name;
    $facality->email = $request->email ?? null;
    $facality->phone = $request->phone ?? null;
    $facality->alternate_phone = $request->alternate_phone ?? null;
    $facality->father_name = $request->father_name ?? null;
    $facality->mother_name = $request->mother_name ?? null;
    $facality->highest_qualification = $request->highest_qualification ?? null;

    $facality->present_address = $request->present_address ?? null;
    $facality->permanent_address = $request->permanent_address ?? null;

    $facality->state = $request->state ?? null;
    $facality->city = $request->city ?? null;

    $facality->orders_by = $request->orders_by ?? 0;
    $facality->updated_id = $user->id;


    /* ================== PHOTO UPLOAD ================== */
    if ($request->hasFile('photo')) {

        // delete old photo if exists
        if ($facality->photo && file_exists(public_path('uploads/'.$facality->photo))) {
            unlink(public_path('uploads/'.$facality->photo));
        }

        $photo = $request->file('photo');
        $photoName = time() . '_photo.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('uploads'), $photoName);
        $facality->photo = $photoName;
    }


    /* ========== MULTIPLE CHECKBOX DATA SAVE ========== */
    $facality->branch_id = !empty($request->branch_ids)
                        ? implode(',', $request->branch_ids)
                        : null;

    $facality->course_id = !empty($request->course_ids)
                        ? implode(',', $request->course_ids)
                        : null;

    $facality->subject_id = !empty($request->subject_ids)
                        ? implode(',', $request->subject_ids)
                        : null;


    /* ================= SAVE BASIC DATA ================= */
    $facality->save();

    // Save md5 hashed ID
    $facality->id_hash = md5($facality->id);
    $facality->save();


    /* ========== UPLOAD NEW DOCUMENTS ========== */
    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $file) {

            $docName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $docName);

            DB::table('tbl_facality_documents')->insert([
                'facality_id' => $facality->id,
                'document' => $docName,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Facality updated successfully.');
}

public function check_unique_phone_edit($key, $value, $id)
{
    if (!$value) return true;

    return !Facality::where($key, $value)
        ->where('id', '!=', $id)
        ->exists();
}

    public function deleteFacality($id)
    {

        $user = Auth::user();
        $permExplodesub = explode(',', $user->permission_submenu ?? '');

        if (!in_array('2_40', $permExplodesub)) {
            abort(403, 'Unauthorized Access');
        }
        $pageUpd = Facality::find($id);
        if ($pageUpd) {
            $pageUpd->is_deleted = 1;
            $pageUpd->save();
        }
        return redirect()->back()->with('success', 'Facality deleted successfully.');
    }

   
    public function updateFacalityStatus(Request $request, $id)
    {
        $cat = Facality::find($id);
        if ($cat) {
            $cat->status = $request->status;
            $cat->save();
            return redirect()->back()->with('success', 'Status updated!');
        } else {
            return redirect()->back()->with('error', 'Facality not found.');
        }
    }
}

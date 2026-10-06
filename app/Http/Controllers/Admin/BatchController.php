<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class BatchController extends Controller
{
    public function index(){
        $this->batch();
    }

   public function batch(Request $request){
    $data['menu']  = "categorys";
    $data['submenu']  = "batch";

    $keywords = $request['keyword'];
    $data['keyword'] = $keywords;
    $r_page = $request['r_page'];

    if (!empty($r_page)) {
        $r_page = $r_page;
        $data['r_page'] = $r_page;
    } else {
        $r_page = 25;
        $data['r_page'] = 25;
    }

    if (!empty($keywords)) {
        $batchs = Batch::where('name', 'like', '%' . $keywords . '%')
            ->where('is_deleted', '0')
            ->latest()
            ->paginate($r_page);

        $batchs->appends(['keyword' => $keywords]);
        $batchs->appends(['r_page' => $r_page]);
    } else {
        $batchs = Batch::latest()
            ->where('is_deleted', '0')
            ->paginate($r_page);

        $batchs->appends(['r_page' => $r_page]);
    }

     $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();

    return view('backend.batch.batch', compact('data', 'batchs','branches'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

public function add_batch(){

    $data['menu'] = "categorys";
    $data['submenu'] = "add_batch";

 $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();
    return view('backend.batch.add', compact('data','branches'));
}

public function saveBatch(Request $request)
{

 
    
    $request->validate([
        'name' => 'required'
    ]);


    $user = Auth::user();

 
    $isUnique = $this->check_unique_name('name', $request->name);
    if (!$isUnique) {
        return redirect()->back()->with('error', 'Batch name already exists. Cannot add duplicate Batch.');
    }

  
    if (!empty($request->slug)) {
        $url_title = Str::slug($request->slug);
    } else {
        $url_title = Str::slug($request->name);
    }


    $uniqueSlug = $this->check_unique('slug', $url_title);


    $batch = new Batch();
    $batch->name = $request->name;
    $batch->slug = $uniqueSlug;
    $batch->orders_by = $request->orders_by;
    $batch->branch_id = $request->branch_id;
    $batch->status = $request->status;
    $batch->add_id = $user->id;

if ($file = $request->file('image')) {
    $filename = date('YmdHi') . $file->getClientOriginalName();
    $path = base_path('resources/views/backend/batch/uploads');

    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $file->move($path, $filename);
    $batch->image = $filename;
}



    $batch->save();

    $lastinsertedId = $batch->id;
    $batchUpdate = Batch::find($lastinsertedId);

    $batchUpdate->id_hash = md5($lastinsertedId);
    $batchUpdate->save();

    return redirect()->back()->with('success', 'Batch added successfully.');
}

public function check_unique_name($key, $value)
{
    return !Batch::where($key, $value)->exists();
}

public function check_unique($key, $value)
{
    $check = Batch::where($key, $value)->first();
    if (!empty($check)) {
        
        $value .= '1';
        return $this->check_unique($key, $value);
    } else {
        return $value;
    }
}




public function edit_batch($id_hash)
{
    
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_7', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }

    
    $data['menu'] = "categorys";
    $data['submenu'] = "batch";

    $batch = Batch::where('id_hash', $id_hash)->first();

    $branches = Branch::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

    return view('backend.batch.edit', compact('data', 'batch', 'branches'));
}


public function Updatebatch(Request $request){
    $request->validate([
        'name' => 'required'
    ]);

    $user = Auth::user();

    $isUnique = $this->check_unique_name_edit('name', $request->name, $request->id);
    if($isUnique == false){
        return redirect()->back()->with('error', 'Batch Name Already Available. So can not Add Batch!!!'); 
    }

    if(!empty($request->slug)){
        $url_title = Str::slug($request->slug);
    } else {
        $url_title = Str::slug($request->name);
    }

    $uniqueSlug = $this->check_uniqslug_edit('slug', $url_title, $request->id);

    $batch = Batch::find($request->id);
    if($batch){
        $batch->name = $request->name;
        $batch->slug = $uniqueSlug;
        $batch->orders_by = $request->orders_by;
        $batch->updated_id = $user->id;
    $batch->branch_id = $request->branch_id;


       
        if ($file = $request->file('image')) {
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $path = base_path('resources/views/backend/batch/uploads');

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

           
            if (!empty($batch->image)) {
                $oldImagePath = $path . '/' . $batch->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

           
            $file->move($path, $filename);
            $batch->image = $filename;
        }

        $batch->save();

       return redirect()->back()->with('success', 'Batch updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Batch not found.');
    }
}


public function check_unique_name_edit($key, $value, $id){
    return !Batch::where($key, $value)->where('id', '!=', $id)->exists();
}

public function check_uniqslug_edit($key, $value, $id){
    $check = Batch::where($key, $value)
        ->where('id', '!=' , $id)
        ->first();
        
    if(!empty($check)){
        $value1 = $value . "1";
        return $this->check_uniqslug_edit($key, $value1, $id);
    } else {
        return $value; 
    }
}


public function deleteBatch($id)
{
    
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('2_8', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }

    
    $batchUpd = Batch::find($id);
    $batchUpd->is_deleted = 1;
    $batchUpd->save();

    return redirect()->back()->with('success', 'Batch has been Deleted successfully.');
}

  public function updateBatchStatus(Request $request, $id)
{
    
    $batch = Batch::find($id);
    if ($batch) {
        $batch->status = $request->status;
        $batch->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Batch not found.');
    }
}


}
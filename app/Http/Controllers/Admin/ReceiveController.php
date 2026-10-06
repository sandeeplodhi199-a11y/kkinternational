<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ReceiveController extends Controller{
  public function index(){}

  // === Category management --------
  public function view(Request $request){

    $data['menu'] = "couriers";
    $data['submenu'] = "receive_view";

    $keyword = $request['keyword'];
    $data['keyword'] = $keyword;
    $r_page = $request['r_page'];
    if(!empty($r_page)){
      $r_page = $r_page;
      $data['r_page'] = $r_page;
    } else {
      $r_page = 25;
      $data['r_page'] = 25;
    }

    if(!empty($keyword)){
        $page = Receive::where('name', 'like', '%'.$keyword.'%')
        ->WHERE('is_deleted', '0')
        ->latest()
        ->paginate($r_page);
        $page->appends(['keyword' => $keyword]);
        $page->appends(['r_page' => $r_page]);
    } else {
        $page = Receive::latest()->WHERE('is_deleted', '0')->paginate($r_page);
        $page->appends(['r_page' => $r_page]);
    }

   

    return view('backend.receive.all',compact('data', 'page'))->with('i', (request()->input('page', 1) - 1) * $r_page);
  }

  public function add(){
    $data['menu'] = "couriers";
    $data['submenu'] = "receive_add";

   


    return view('backend.receive.add', compact("data"));
  }

  public function save(Request $request)
{
    $request->validate([
        'enrollment_number' => 'required',
        'phone'             => 'required',
    ]);

    $user = Auth::user();

  
    $enrollmentExists = Receive::where('is_deleted', '0')
        ->where('enrollment_number', $request->enrollment_number)
        ->exists();

    if ($enrollmentExists) {
        return redirect()->back()->with('error', 'Enrollment number already exists.');
    }

   
    $phoneExists = Receive::where('is_deleted', '0')
        ->where('phone', $request->phone)
        ->exists();

    if ($phoneExists) {
        return redirect()->back()->with('error', 'Phone number already exists.');
    }

    $page = new Receive;
    $page->enrollment_number = $request->enrollment_number;
    $page->student_name      = $request->student_name;
    $page->phone             = $request->phone;
    $page->what_in_packet    = $request->what_in_packet;
    $page->from_address        = $request->from_address;
    $page->docket_number     = $request->docket_number;
    $page->courier_company   = $request->courier_company;
    $page->sent_date         = $request->sent_date;
    $page->receive_date    = $request->receive_date;
    $page->status            = 'Active';
    $page->is_deleted        = "0";
    $page->id_hash           = "id_hash";
    $page->add_id            = $user->id;

    $page->save();
    $page->id_hash = md5($page->id);
    $page->save();

    return redirect()->back()->with('success', 'Receive has been saved successfully.');
}





  public function edit($id_hash){
     $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('3_8', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
      $data['menu'] = "couriers";
      $data['submenu'] = "receive_view";

      $page = Receive::where('id_hash', $id_hash)->first();
     

      return view('backend.receive.edit', compact("data", "page"));
  }

  public function update(Request $request)
{
    $request->validate([
        'id'                => 'required|exists:tbl_receive,id',
        'enrollment_number' => 'required',
        'phone'             => 'required',
    ]);

    $user = Auth::user();

    
    $enrollmentExists = Receive::where('is_deleted', '0')
        ->where('enrollment_number', $request->enrollment_number)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($enrollmentExists) {
        return redirect()->back()->with('error', 'Enrollment number already exists.');
    }

   
    $phoneExists = Receive::where('is_deleted', '0')
        ->where('phone', $request->phone)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($phoneExists) {
        return redirect()->back()->with('error', 'Phone number already exists.');
    }

    $page = Receive::find($request->id);
    $page->enrollment_number = $request->enrollment_number;
    $page->student_name      = $request->student_name;
    $page->phone             = $request->phone;
    $page->what_in_packet    = $request->what_in_packet;
    $page->from_address        = $request->from_address;
    $page->docket_number     = $request->docket_number;
    $page->courier_company   = $request->courier_company;
    $page->sent_date         = $request->sent_date;
    $page->receive_date    = $request->receive_date;
    $page->updated_id        = $user->id;

    $page->save();

    return redirect()->back()->with('success', 'Receive has been updated successfully.');
}

 
  public function delete($id){

     $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('3_9', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
    $pageUpd = Receive::find($id);
    $pageUpd->is_deleted = 1;
    $pageUpd->save();
    return redirect()->back()->with('success', 'Receive has been Deleted successfully.');
  }
  

       public function Receive(Request $request, $id)
{
    $cat = Receive::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Receive not found.');
    }
}


}
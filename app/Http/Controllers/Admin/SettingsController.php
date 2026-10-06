<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\General;
use App\Models\Home;
use App\Models\Footer;
use App\Models\WebsiteData;
use Illuminate\Http\Request;

class SettingsController extends Controller{
  public function index(){
    $this->setting();
  }

  // === setting management --------
  public function company(Request $request){

    $data['menu'] = "companies";
    $data['submenu'] = "company";

    $setting = Settings::WHERE('id', '1')->first();
    return view('backend.setting.view',compact('data', 'setting'));
  }

  
  public function update(Request $request){
    $setting = new Settings;
    $setting = Settings::find($request->id);
   
    $setting->setting20 = $request->setting20;
    $setting->setting21 = $request->setting21;
    $setting->setting22 = $request->setting22;
    $setting->setting23 = $request->setting23;
    $setting->setting24 = $request->setting24;
    $setting->setting25 = $request->setting25;
    $setting->setting26 = $request->setting26;
    $setting->setting27 = $request->setting27;
    $setting->setting29 = $request->setting29;
    $setting->setting30 = $request->setting30;
    $setting->setting31 = $request->setting31;
    $setting->setting32 = $request->setting32;
   
    

    if($request->file('setting33')){
      $file= $request->file('setting33');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->setting33 = $filename;
      } else {
        $setting->setting33 = $request->setting33_old;
      }
    }
    
    $setting->save();

    return redirect()->back()->with('success', 'Company Settings has been Updated successfully.');
  }


  // === General management --------
  public function general(Request $request){
 

  
    $data['menu'] = "companies";
    $data['submenu'] = "setting_gen";

    $setting = General::WHERE('id', '1')->first();
    return view('backend.setting.general',compact('data', 'setting'));
  }

  
  public function general_update(Request $request){
    $setting = new General;
    $setting = General::find($request->id);
    $setting->setting1 = $request->setting1;
    $setting->setting2 = $request->setting2;
    $setting->setting3 = $request->setting3;
    $setting->setting4 = $request->setting4;
    $setting->setting5 = $request->setting5;
    $setting->setting6 = $request->setting6;
    $setting->setting7 = $request->setting7;
    $setting->setting8 = $request->setting8;
    $setting->setting9 = $request->setting9;
    $setting->setting10 = $request->setting10;
    $setting->setting12 = $request->setting12;
    $setting->setting13 = $request->setting13;
    $setting->setting14 = $request->setting14;
    $setting->setting15 = $request->setting15;
   

    $setting->setting_five = $request->setting_five;


     if($request->file('setting11')){
      $file= $request->file('setting11');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->setting11 = $filename;
      } else {
        $setting->setting11 = $request->setting11_old;
      }
    }

    
    $setting->save();

    return redirect()->back()->with('success', 'General Settings has been Updated successfully.');
  }



   // === General management --------
  public function social(Request $request){
 

  
    $data['menu'] = "companies";
    $data['submenu'] = "social_gen";

    $setting = General::WHERE('id', '1')->first();
    return view('backend.setting.social',compact('data', 'setting'));
  }

  
  public function media_update(Request $request){
    $setting = new General;
    $setting = General::find($request->id);
    $setting->facebook = $request->facebook;
    $setting->instagram = $request->instagram;
    $setting->twitter = $request->twitter;
    $setting->youtube = $request->youtube;
    $setting->linkdin = $request->linkdin;
    $setting->whatsapp = $request->whatsapp;
    
   

   

    
    $setting->save();

    return redirect()->back()->with('success', 'Social Media Settings has been Updated successfully.');
  }

public function footer(){
    $data['menu'] = 'companies';
    $data['submenu'] = 'footer';

    $user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];

    $footers = Footer::where('status', 'Active')
        ->where('is_deleted', '0')
        ->paginate(5);

    return view('backend.setting.footer', compact('data','footers','permExplodesub'));
}

  public function save_foooter(Request $request){

   $request->validate([
    'name'=>'required',
    'link'=>'required'
   ]);

   $footer = new Footer();
   $footer->name = $request->name;
   $footer->link = $request->link;
   $footer->sequence = $request->sequence;
   $footer->is_deleted = '0';
   $footer->status = 'Active';

   $footer->save();


   return redirect()->back()->with('success', 'Footer Data Inserted Successfully!!');

  }


  public function edit_footer($id){
  
    $data['menu'] = 'companies';
    $data['submenu'] = 'footer';
 
    $footer = Footer::WHERE('is_deleted', '0')->WHERE('status','Active')->WHERE('id',$id)->first();
  

    return view('backend.setting.edit_footer', compact('data', 'footer'));

  }

  public function edit_save_footer(Request $request){

    $request->validate([
      'name'=> 'required',
      'link'=>'required'
    ]);

    $footer = new Footer();
    $footer = Footer::find($request->id);
    $footer->name = $request->name;
    $footer->link = $request->link;
    $footer->sequence = $request->sequence;

    $footer->save();

    return redirect()->back()->with('success', 'Footer Data Updated Suceessfully !!');

  }


  public function del_footer($id){
      
      

    $footer = Footer::find($id);
    $footer->delete();

    return redirect()->back()->with('success', 'Footer Data Deleted Successfully !!');

  }


     public function updatefooterStatus(Request $request, $id)
{
    $cat = Footer::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Footer not found.');
    }
}




public function website_data()
{
    $data['menu'] = 'companies';
    $data['submenu'] = 'website_data';

    $user = auth()->user();
    $permExplodesub = $user->permission_submenu
        ? explode(",", $user->permission_submenu)
        : [];

    $website_data = WebsiteData::where('is_deleted', '0')
        ->orderByDesc('id')
        ->paginate(10);

    return view('backend.setting.website_data', compact('data', 'website_data', 'permExplodesub'));
}


public function save_website_data(Request $request)
{
    $onlyImage = ['Accomplishment'];
    $onlyTextarea = ['Terms and Condition', 'Privacy Policy', 'Cancellation & Refund'];

    $request->validate([
        'type' => 'required',
        'name' => in_array($request->type, $onlyImage) ? 'nullable' : 'required',
        'image' => in_array($request->type, $onlyTextarea) ? 'nullable' : 'nullable',
    ]);

    $type = match ($request->type) {
        'Director Message' => 'Chairman Message',
        'Academic' => 'Academics',
        default => $request->type,
    };

    $footer = new WebsiteData();
    $footer->name = $request->name;
    $footer->type = $type;

    if ($file = $request->file('image')) {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $path = public_path('uploads');

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $filename);
        $footer->image = $filename;
    }

    $footer->is_deleted = '0';
    $footer->status = 'Active';
    $footer->save();

    return redirect()->back()->with('success', 'Website Data Inserted Successfully!');
}

public function edit_website_data($id)
{
    $data['menu'] = 'companies';
    $data['submenu'] = 'website_data';

    $website_data = WebsiteData::where('is_deleted', '0')
        ->where('id', $id)
        ->firstOrFail();

    return view('backend.setting.edit_website_data', compact('data', 'website_data'));
}




public function edit_save_website_data(Request $request)
{
    $onlyImage = ['Accomplishment'];
    $onlyTextarea = ['Terms and Condition', 'Privacy Policy', 'Cancellation & Refund'];

    $request->validate([
        'type' => 'required',
        'name' => in_array($request->type, $onlyImage) ? 'nullable' : 'required',
        'image' => in_array($request->type, $onlyTextarea) ? 'nullable' : 'nullable',
    ]);

    $type = match ($request->type) {
        'Director Message' => 'Chairman Message',
        'Academic' => 'Academics',
        default => $request->type,
    };

    $footer = WebsiteData::where('is_deleted', '0')->findOrFail($request->id);
    $footer->name = $request->name;
    $footer->type = $type;

    if ($file = $request->file('image')) {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $path = public_path('uploads');

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (!empty($footer->image)) {
            $oldImagePath = $path . '/' . $footer->image;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $file->move($path, $filename);
        $footer->image = $filename;
    }

    $footer->save();

    return redirect()->back()->with('success', 'Website Data Updated Successfully!');
}

public function del_website_data($id)
{
    $footer = WebsiteData::findOrFail($id);
    $footer->is_deleted = '1';   // soft delete — keeps the record
    $footer->save();

    // or use $footer->delete(); for hard delete

    return redirect()->back()->with('success', 'Website Data Deleted Successfully!');
}

public function updateWebsiteDataStatus(Request $request, $id)
{
    $cat = WebsiteData::find($id);
    if ($cat) {
        $cat->status = $request->status;
        $cat->save();
        return redirect()->back()->with('success', 'Status updated!');
    } else {
        return redirect()->back()->with('error', 'Website Data not found.');
    }
}

 
  public function home(Request $request){
    $data['menu'] = "companies";
    $data['submenu'] = "home";

    $setting = Home::WHERE('id', '1')->first();
    return view('backend.setting.home',compact('data', 'setting'));
  }

  
  public function home_update(Request $request){
    $setting = new Home;
    $setting = Home::find($request->id);
    $setting->home1 = $request->home1;
    $setting->home2 = $request->home2;
    $setting->home3 = $request->home3;
    $setting->home4 = $request->home4;
    $setting->home5 = $request->home5;
    $setting->home6 = $request->home6;
    $setting->home8 = $request->home8;
    $setting->home9 = $request->home9;
    $setting->home11 = $request->home11;
    $setting->home12 = $request->home12;
    $setting->home13 = $request->home13;
    $setting->home14 = $request->home14;
    $setting->home15 = $request->home15;
    $setting->home16 = $request->home16;
    $setting->home17 = $request->home17;
    $setting->home18 = $request->home18;
    $setting->home19 = $request->home19;
    $setting->home20 = $request->home20;
    $setting->home26 = $request->home26;
    $setting->home27 = $request->home27;
    $setting->home28 = $request->home28;


    if($request->file('home7')){
      $file= $request->file('home7');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home7 = $filename;
      } else {
        $setting->home7 = $request->home7_old;
      }
    }

    if($request->file('home10')){
      $file= $request->file('home10');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home10 = $filename;
      } else {
        $setting->home10 = $request->home10_old;
      }
    }

    if($request->file('home21')){
      $file= $request->file('home21');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home21 = $filename;
      } else {
        $setting->home21 = $request->home21_old;
      }
    }

    if($request->file('home22')){
      $file= $request->file('home22');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home22 = $filename;
      } else {
        $setting->home22 = $request->home22_old;
      }
    }

    if($request->file('home23')){
      $file= $request->file('home23');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home23 = $filename;
      } else {
        $setting->home23 = $request->home23_old;
      }
    }

    if($request->file('home24')){
      $file= $request->file('home24');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home24 = $filename;
      } else {
        $setting->home24 = $request->home24_old;
      }
    }

    if($request->file('home25')){
      $file= $request->file('home25');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      if(!empty($filename)){
        $setting->home25 = $filename;
      } else {
        $setting->home25 = $request->home25_old;
      }
    }
    
    $setting->save();

    return redirect()->back()->with('success', 'Home Settings has been Updated successfully.');
  }


  
    // === Quotation management --------
  public function quotation(Request $request){

   
  
    $data['menu'] = "companies";
    $data['submenu'] = "setting_quatation";

    $setting = General::WHERE('id', '1')->first();
    return view('backend.setting.quotation',compact('data', 'setting'));
  }

  
  public function quotation_update(Request $request){

    $setting = new General;
    $setting = General::find($request->id);
    $setting->school_name = $request->school_name;
     $setting->school_title = $request->school_title;
      $setting->school_address = $request->school_address;
    $setting->company_phone = $request->company_phone;
    $setting->company_email = $request->company_email;
    $setting->company_whatsapp_numer = $request->company_whatsapp_numer;
    $setting->company_address = $request->company_address;
    $setting->company_city = $request->company_city;
    $setting->company_state = $request->company_state;
    $setting->company_pincode = $request->company_pincode;
    $setting->company_gst_number = $request->company_gst_number;
    $setting->company_website = $request->company_website;
   
    $setting->company_term_condition_invoice = $request->company_term_condition_invoice;


    $setting->textable_enrollment_alpha = $request->textable_enrollment_alpha;
    $setting->textable_enrollment_numeric = $request->textable_enrollment_numeric;


    $setting->mid_term_alpha = $request->mid_term_alpha;
    $setting->mid_term_numeric = $request->mid_term_numeric;

    $setting->certificate_alpha = $request->certificate_alpha;
    $setting->certificate_numeric = $request->certificate_numeric;

    $setting->final_marksheet_alpha = $request->final_marksheet_alpha;
    $setting->final_marksheet_numeric = $request->final_marksheet_numeric;
    
    // $setting->textable_invoice_alpha = $request->textable_invoice_alpha;
    // $setting->textable_invoice_numeric = $request->textable_invoice_numeric;
    

    // $setting->without_textable_quotation_alpha = $request->without_textable_quotation_alpha;
    // $setting->without_textable_quotation_numeric = $request->without_textable_quotation_numeric;

    // $setting->without_textable_invoice_alpha = $request->without_textable_invoice_alpha;
    // $setting->without_textable_invoice_numeric = $request->without_textable_invoice_numeric;


    $setting->holder_name  = $request->holder_name;
    $setting->acc_name  = $request->acc_name;
    $setting->branch  = $request->branch;
    $setting->acc_type  = $request->acc_type;
    $setting->acc_num  = $request->acc_num;
    $setting->ifsc_code  = $request->ifsc_code;
   



    if ($request->file('company_logo')) {
      $file = $request->file('company_logo');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->company_logo = $filename;
    }
    
     if ($request->file('principal_sign')) {
      $file = $request->file('principal_sign');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->principal_sign = $filename;
    }
    
    
     if ($request->file('exam_controller_sign')) {
      $file = $request->file('exam_controller_sign');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->exam_controller_sign = $filename;
    }

       if ($request->file('company_signature')) {
      $file = $request->file('company_signature');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->company_signature = $filename;
    }
    

     if ($request->file('slip_payment')) {
      $file = $request->file('slip_payment');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->slip_payment = $filename;
    }
    

     if ($request->file('payment_history')) {
      $file = $request->file('payment_history');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->payment_history = $filename;
    }

     if ($request->file('id_card')) {
      $file = $request->file('id_card');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->id_card = $filename;
    }
    

     if ($request->file('admitcard')) {
      $file = $request->file('admitcard');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->admitcard = $filename;
    }
    

     if ($request->file('marksheet')) {
      $file = $request->file('marksheet');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->marksheet = $filename;
    }
    

     if ($request->file('certificate')) {
      $file = $request->file('certificate');
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $setting->certificate = $filename;
    }
    
    
    $setting->save();

    return redirect()->back()->with('success', 'General Settings has been Updated successfully.');
  }

  
}

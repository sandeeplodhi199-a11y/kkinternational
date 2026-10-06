<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller{
  public function index(){
    $this->slider();
  }

  // === Slider management --------
  public function slider(Request $request){

    $data['menu'] = "sliders";
    $data['submenu'] = "slider";


    $slider = Slider::all()->WHERE('is_deleted', '0');
    return view('backend.slider.view',compact('data', 'slider'));
  }

  public function add(){
    $data['menu'] = "sliders";
    $data['submenu'] = "slider";

    return view('backend.slider.add', compact("data"));
  }

  public function save(Request $request){
    $request->validate([
        'name' => 'required',
    ]);

    $slider = new Slider;
    $slider->name = $request->name;
    $slider->is_deleted = "0";
    if($request->file('image')){
      $file= $request->file('image');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      $slider->image = $filename;
    }
    $slider->status = $request->status;
    $slider->image_alt = $request->image_alt;
    $slider->image_title = $request->image_title;
    $slider->image_description = $request->image_description;
    $slider->order_by = $request->order_by;
    $slider->save();

    return redirect()->back()->with('success', 'Slider has been Save successfully.'); 
  }

  public function edit($id){
    $data['menu'] = "sliders";
    $data['submenu'] = "slider";

    $slider = Slider::where('id', $id)->first();

    return view('backend.slider.edit', compact("data", "slider"));
  }

  public function update(Request $request){
   

   

    $slider = new Slider;
    $slider = Slider::find($request->id);
    $slider->name = $request->name;
    $slider->status = $request->status;
    if($request->file('image')){
      $file= $request->file('image');
      $filename= date('YmdHi').$file->getClientOriginalName();
      $file-> move(public_path('uploads'), $filename);
      $slider->image = $filename;
    }
  
    $slider->order_by = $request->order_by;
    $slider->image_alt = $request->image_alt;
    $slider->image_title = $request->image_title;
    $slider->image_description = $request->image_description;
    $slider->save();

    return redirect()->back()->with('success', 'Blog has been Updated successfully.');
  }

  public function delete($id){
    $catUpd = Slider::find($id);
    $catUpd->is_deleted = 1;
    $catUpd->save();
    return redirect()->back()->with('success', 'Slider has been Deleted successfully.');
  }
}

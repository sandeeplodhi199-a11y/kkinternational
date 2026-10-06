<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    public function enquiry()
    {
        $data['menu']    = 'enquirys';
        $data['submenu'] = 'enquiry';
        $enquirys = Enquiry::latest()->paginate(15);

        return view('backend.enquiry.all', compact('data', 'enquirys'));
    }

    public function show($id)
    {
        $data['menu']    = 'enquirys';
        $data['submenu'] = 'enquiry';
        $enquiry = Enquiry::findOrFail($id);

        return view('backend.enquiry.detail', compact('data', 'enquiry'));
    }

    public function delete($id)
    {
        Enquiry::findOrFail($id)->delete();

        return redirect()->route('enquiry')
                         ->with('success', 'Enquiry deleted successfully.');
    }
}
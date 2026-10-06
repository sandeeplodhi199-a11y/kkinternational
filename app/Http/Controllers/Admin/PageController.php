<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function view() { return redirect()->back(); }
    public function add() { return redirect()->back(); }
    public function save(Request $request) { return redirect()->back(); }
    public function edit($id) { return redirect()->back(); }
    public function update(Request $request) { return redirect()->back(); }
    public function delete($id) { return redirect()->back(); }
    public function about_us_page() { return redirect()->back(); }
    public function save_about_us_page(Request $request) { return redirect()->back(); }
}

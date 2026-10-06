<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function news() { return redirect()->back(); }
    public function news_update($id) { return redirect()->back(); }
}

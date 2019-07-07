<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function checkout()
    {
        return view('checkout');
    }
}

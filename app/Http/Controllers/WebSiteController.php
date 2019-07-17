<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkout(Request $request)
    {
        if (preg_match("/monthly|annually|binnually/", $request->getRequestUri())) {
            return view('checkout');
        }

        return redirect()->route('checkout', 'annually');
    }
}

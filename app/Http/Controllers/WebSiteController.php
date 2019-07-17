<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class WebSiteController extends Controller
{
    public function index()
    {
        $plans = Plan::get(['name', 'slug', 'cost', 'is_primary']);

        return view('welcome', compact('plans'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkout(string $slug)
    {
        $plans = Plan::get(['name', 'slug', 'cost', 'is_primary']);
        $slugs = $plans->pluck('slug')->toArray();

        if (in_array($slug, $slugs)) {
            return view('checkout', ['plan' => $plans->firstWhere('slug', $slug)]);
        }

        return redirect()->route('checkout', $plans->firstWhere('is_primary', true)->slug);
    }
}

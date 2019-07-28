<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Addon;
use App\Enums\AddonType;

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
     * @param string $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkout(string $slug)
    {
        $plans = Plan::get(['name', 'slug', 'cost', 'is_primary']);
        $plans_slugs = $plans->pluck('slug')->toArray();

        if (in_array($slug, $plans_slugs)) {
            $plan = $plans->firstWhere('slug', $slug);
            $addons = Addon::whereType(AddonType::Subscription)->get(['name', 'code', 'description', 'cost']);
            
            return view('checkout', compact('plan', 'addons'));
        }

        $primary_slug = $plans->firstWhere('is_primary')->slug;

        return redirect()->route('checkout', $primary_slug);
    }
}

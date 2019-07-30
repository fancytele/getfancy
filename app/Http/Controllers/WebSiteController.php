<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Product;
use App\Enums\AddonType;

class WebSiteController extends Controller
{
    public function index()
    {
        $products = Product::get(['name', 'slug', 'cost', 'is_primary']);

        return view('welcome', compact('products'));
    }

    /**
     * Show the application dashboard.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkout(string $slug)
    {
        $products = Product::get(['name', 'slug', 'cost', 'is_primary']);
        $products_slugs = $products->pluck('slug')->toArray();

        if (in_array($slug, $products_slugs)) {
            $product = $products->firstWhere('slug', $slug);
            $addons = Addon::whereType(AddonType::Subscription)
                ->orderBy('code')
                ->get(['name', 'code', 'description', 'cost']);

            return view('checkout', compact('product', 'addons'));
        }

        $primary_slug = $products->firstWhere('is_primary')->slug;

        return redirect()->route('checkout', $primary_slug);
    }
}

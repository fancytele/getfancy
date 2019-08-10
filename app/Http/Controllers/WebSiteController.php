<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Product;
use App\Enums\AddonType;
use Illuminate\Support\Facades\Cache;

class WebSiteController extends Controller
{
    public function index()
    {
        $products = Product::getWithLocal(['name', 'slug', 'cost', 'is_primary']);

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
        $products = Product::getWithLocal(['name', 'slug', 'cost', 'is_primary']);
        $products_slugs = $products->pluck('slug')->toArray();

        if (in_array($slug, $products_slugs)) {
            $product = $products->firstWhere('slug', $slug);
            $addons = Addon::whereType(AddonType::Subscription)
                ->orderBy('code')
                ->getWithLocal(['name', 'code', 'description', 'cost']);

            return view('checkout', compact('product', 'addons'));
        }

        $primary_slug = $products->firstWhere('is_primary')->slug;

        return redirect()->route('checkout', $primary_slug);
    }

    /**
     * Get JSON localization to use on JS
     *
     * return @string
     */
    public function localization()
    {
        if (config('app.env') === 'local') {
            Cache::forget('lang-js');
        }

        $strings = Cache::rememberForever('lang-js', function () {
            $lang = config('app.locale');
            $files = glob(resource_path('lang/' . $lang . '.json'));

            if ($files) {
                return get_object_vars(json_decode(file_get_contents($files[0])));
            }

            return [];
        });

        header('Content-Type: text/javascript');
        return 'window.i18n = ' . json_encode($strings) . ';';
    }
}

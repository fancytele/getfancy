<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Product;
use App\Enums\AddonType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class WebSiteController extends Controller
{
    /**
     * Show Website homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

        return redirect()->route('web.checkout', $primary_slug);
    }

    /**
     * Set App lang
     *
     * @param Request $request
     * @return void
     */
    public function changeLocalization(Request $request)
    {
        $locale = $request->locale;

        if (Str::contains(config('fancy.supported_lang'), $locale)) {
            App::setLocale($locale);
            Cache::forget('lang-js');
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }

    /**
     * Get JSON localization to use on JS
     *
     * return @string
     */
    public function getJSONLocalization()
    {
        $strings = Cache::rememberForever('lang-js', function () {
            $lang = App::getLocale();
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

<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Product;
use App\Enums\AddonType;
use App\Mail\ContactUsMail;
use App\Mail\HaveUsCallYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
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
        $products = Product::get(['name', 'slug', 'cost', 'discount', 'is_primary']);

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
     * Send Email to Support about new User who wants to be call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callYou(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;

        Mail::send(new HaveUsCallYouMail($name, $phone));

        return response()->json(['message' => 'success']);
    }

    public function contactUs(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        Mail::send(new ContactUsMail($name, $email, $message));

        return response()->json(['message' => 'success']);
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

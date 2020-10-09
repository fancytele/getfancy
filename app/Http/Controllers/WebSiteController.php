<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Enums\AddonCode;
use App\Product;
use App\Mail\ContactUsMail;
use App\Mail\HaveUsCallYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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
        $products = Product::get(['name', 'description', 'slug', 'cost', 'discount', 'is_primary']);

        return view('home', compact('products'));
    }

    /**
     * Show the application dashboard.
     *
     * @param int $plan_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkout(int $plan_id)
    {
        if(!$plan_id)
        {
            return redirect()->route('web.homepage');
        }
        $product = Product::find($plan_id);
        $addons = Addon::subscription()->orWhere('code', AddonCode::PROFESSIONAL_RECORDING)->get();

        return view('checkout', compact('product', 'addons'));
    }

    /**
     * Send Email to Support about new User who wants to be call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callYou(Request $request)
    {
        Mail::send(new HaveUsCallYouMail($request->name, $request->phone));

        return response()->json(['message' => 'success']);
    }

    /**
     * Send Email to Support about new User who wants to Contact Us
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        echo 'window.i18n = ' . json_encode($strings) . ';';
        exit();
    }

    //Milestone4

    public function getPlanCost(Request $request){

        $validator = Validator::make($request->all(),[
            'price' => 'required|numeric|between:10,99.99'
        ]);

        if($validator->fails()) {
            return Redirect::to('/#cost')->withErrors($validator);
        }

        $product = Product::create([
            'name' => 'Monthly',
            'slug' => 'monthly',
            'cost' => $request->price,
        ]);

        return redirect()->route('web.checkout', $product->id);
    }

    //Milestone1
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPrivacyPolicy(){
        return view('privacy-policy');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTermsOfService(){
        return view('terms-of-service');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCookiePolicy(){
        return view('cookie-policy');
    }
}

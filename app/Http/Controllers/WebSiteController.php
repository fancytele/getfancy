<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Enums\AddonCode;
use App\Product;
use App\Mail\ContactUsMail;
use App\Mail\HaveUsCallYouMail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WebSiteController extends Controller
{
    /**
     * Show Website homepage.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     * @param string $product_id
     * @param float $price
     * @return Application|Factory|RedirectResponse|View
     */
    public function checkout(string $product_id, float $price)
    {
        if(!$product_id && !$price)
        {
            return redirect()->route('web.homepage');
        }

        $addons = Addon::subscription()->orWhere('code', AddonCode::PROFESSIONAL_RECORDING)->get();

        return view('checkout', compact('product_id', 'addons' ,'price'));
    }

    /**
     * Send Email to Support about new User who wants to be call
     *
     * @param Request $request
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return RedirectResponse
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

    public function getPlanPrice(Request $request){

        $validator = Validator::make($request->all(),[
            'price' => 'required|numeric|min:'.env('MINIMUM_PRODUCT_PRICE')
        ]);

        if($validator->fails()) {
            return Redirect::to('/#price')->withErrors($validator);
        }

        return redirect()->route('web.checkout', [env('STRIPE_PRODUCT_ID'), $request->price]);
    }

    //Milestone1
    /**
     * @return Application|Factory|View
     */
    public function getPrivacyPolicy(){
        return view('privacy-policy');
    }

    /**
     * @return Application|Factory|View
     */
    public function getTermsOfService(){
        return view('terms-of-service');
    }

    /**
     * @return Application|Factory|View
     */
    public function getCookiePolicy(){
        return view('cookie-policy');
    }
}

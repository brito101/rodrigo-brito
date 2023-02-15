<?php

namespace App\Http\Controllers\Site;

use App\Helpers\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function index(Request $request)
    {
        $cookie = filter_var($request->cookie, FILTER_SANITIZE_STRIPPED);

        Cookie::set('cookieConsent', $cookie, (12 * 43200));  // 1 year

        $body = '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KBGXKNM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
        $head = '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!="dataLayer"?&l="+l:"";j.async=true;j.src="https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);})(window,document,"script","dataLayer","GTM-KBGXKNM");</script>';
        if ($cookie == 'accept') {
            $json['gtmHead'] = $head;
            $json['gtmBody'] = $body;
        }

        $json['cookie'] = true;
        return \response()->json($json);
    }
}

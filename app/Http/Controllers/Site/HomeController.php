<?php

namespace App\Http\Controllers\Site;

use App\Helpers\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Meta;

class HomeController extends Controller
{
    public function index()
    {
        Meta::title(env('APP_NAME'));
        Meta::set('description', env('APP_DESCRIPTION'));
        # Default
        Meta::set('og:type', 'article');
        Meta::set('og:site_name', env('APP_NAME'));
        Meta::set('og:locale', app()->getLocale());
        Meta::set('og:url', route('site.home'));
        Meta::set('twitter:url', route('site.home'));
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        # Canonical URL
        Meta::set('canonical', route('site.home'));

        $cookieConsent = Cookie::get('cookieConsent');

        return \view('site.home.index', \compact('cookieConsent'));
    }
}

<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Meta;

class TermsController extends Controller
{
    public function index()
    {
        Meta::title(env('APP_NAME') . ' - Termos de uso');
        Meta::set('description', 'Ao utilizar esse site você concorda com os termos aqui descritos.');
        # Default
        Meta::set('og:type', 'article');
        Meta::set('og:site_name', env('APP_NAME'));
        Meta::set('og:locale', app()->getLocale());
        Meta::set('og:url', route('site.home'));
        Meta::set('twitter:url', route('site.home'));
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        # Canonical URL
        Meta::set('canonical', route('site.terms'));

        return \view('site.terms.index');
    }
}

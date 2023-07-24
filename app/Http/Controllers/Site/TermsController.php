<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Meta;

class TermsController extends Controller
{
    public function index()
    {
        $title = 'Rodrigo Brito - Termos de uso';
        $route = route('site.terms');
        $description = 'Ao utilizar esse site você concorda com os termos aqui descritos.';
        /** Meta */
        Meta::title($title);
        Meta::set('description', $description);
        Meta::set('og:type', 'article');
        Meta::set('og:site_name', $title);
        Meta::set('og:locale', app()->getLocale());
        Meta::set('og:url', $route);
        Meta::set('twitter:url', $route);
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        Meta::set('canonical', $route);

        return \view('site.terms.index');
    }
}

<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Meta;

class AboutController extends Controller
{
    public function index()
    {
        $title = 'Saiba mais sobre o Rodrigo Brito';
        $route = route('site.about');
        $description = env('APP_DESCRIPTION');
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

        $certificates = Certificate::select('title', 'cover', 'status')->where('status', 'post')->orderBy('title')->get();

        return \view('site.about.index', \compact('certificates'));
    }
}

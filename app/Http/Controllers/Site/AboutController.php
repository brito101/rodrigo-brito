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
        Meta::title('Saiba mais sobre o ' . env('APP_NAME'));
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
        Meta::set('canonical', route('site.about'));

        $certificates = Certificate::select('title', 'cover', 'status')->where('status', 'post')->orderBy('title')->get();

        return \view('site.about.index', \compact('certificates'));
    }
}

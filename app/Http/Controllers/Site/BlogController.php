<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Meta;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = env('APP_SHORT_NAME') . ' - Blog';
        $route = route('site.blog');
        $description = 'Confira dicas e sacadas sobre desenvolvimento web.';
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

        $title = null;
        $search = null;

        $posts = Blog::where('status', 'post')->orderBy('created_at', 'desc')->paginate(6);

        return \view('site.blog.index', \compact('title', 'search', 'posts'));
    }

    public function search(Request $request)
    {
        if ($request->search) {
            $search = filter_var($request->search, FILTER_SANITIZE_STRIPPED);
            return \redirect()->route('site.blog.search.page', ['search' => $search]);
        } else {
            return \redirect()->route('site.blog');
        }
    }

    public function searchPage($search = null)
    {
        $title = env('APP_SHORT_NAME') . ' - Blog';
        $route = route('site.blog');
        $description = 'Confira dicas e sacadas sobre desenvolvimento web.';
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

        if ($search) {
            $title = 'PESQUISA POR: ' . $search;
        }

        $posts = Blog::where('status', 'post')->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
            $query->orWhere('subtitle', 'like', "%{$search}%");
            $query->orWhere('content', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(6);

        return \view('site.blog.index', \compact('title', 'search', 'posts'));
    }
}

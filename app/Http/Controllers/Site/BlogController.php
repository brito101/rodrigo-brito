<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategoriesPivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $title = 'Rodrigo Brito - Blog';
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

        return \view('site.blog.index', \compact('title', 'search', 'posts', 'title'));
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
        $title = 'Rodrigo Brito - Blog';
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

        return \view('site.blog.index', \compact('title', 'search', 'posts', 'title'));
    }

    public function post($uri)
    {
        $uri = filter_var($uri, FILTER_SANITIZE_STRIPPED);
        $post = Blog::where('uri', $uri)->where('status', 'post')->first();
        if ($post) {
            $title = 'Rodrigo Brito - ' . $post->title;
            $route = route('site.blog.post', ['uri' => $uri]);
            $description = $post->subtitle;
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

            $postsId = [];
            foreach ($post->categories as $category) {
                $postsId[] .= $category->post->id;
            }

            if (!Auth::user()) {
                $post->views++;
                $post->update();
            }

            $related = Blog::inRandomOrder()
                ->whereIn('id', $postsId)
                ->where('id', '!=', $post->id)
                ->where('status', 'post')
                ->limit(3)->get();

            return \view('site.blog.post', \compact('title', 'post', 'related', 'title'));
        } else {
            return view('errors.404');
        }
    }
}

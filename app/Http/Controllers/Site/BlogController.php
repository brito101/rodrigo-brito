<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategoriesPivot;
use App\Models\BlogCategory;
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

        $posts = Blog::where('status', 'post')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return \view('site.blog.index', \compact('title', 'posts'));
    }

    public function post($uri)
    {
        $uri = filter_var($uri, 513);
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
            Meta::set('image', url('storage/blog/min/' . $post->cover));
            Meta::set('canonical', $route);

            $categories = [];
            foreach ($post->categories as $category) {
                $categories[] .= $category->post->id;
            }

            if (!Auth::user()) {
                $post->views++;
                $post->update();
            }

            $related = BlogCategoriesPivot::inRandomOrder()
                ->whereIn('blog_category_id', $categories)
                ->with('post')
                ->limit(3)->get();

            return \view('site.blog.post', \compact('title', 'post', 'related', 'title'));
        } else {
            return view('errors.404');
        }
    }

    public function search(Request $request)
    {
        $search = filter_var($request->s, 513);

        $title = 'Rodrigo Brito - Blog';
        $route = route('site.blog.search', ['s' => $search]);
        $description = 'Pesquisa por: ' . $search;
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

        $posts = Blog::where('status', 'post')
            ->where('title', 'LIKE', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(6)->withQueryString();

        return \view('site.blog.index', \compact('title', 'posts', 'search', 'description'));
    }


    public function category(Request $request)
    {
        $category = filter_var($request->category, 513);

        $category = BlogCategory::where('uri', $category)->first();

        if ($category) {

            $title = 'Rodrigo Brito - Artigos em: ' . $category->title;
            $route = route('site.blog.category', ['category' => $category->uri]);
            $description = 'Artigos em: ' . $category->title;
            /** Meta */
            Meta::title($title);
            Meta::set('description', $description);
            Meta::set('og:type', 'article');
            Meta::set('og:site_name', $title);
            Meta::set('og:locale', app()->getLocale());
            Meta::set('og:url', $route);
            Meta::set('twitter:url', $route);
            Meta::set('robots', 'index,follow');
            Meta::set('image', url('storage/blog-categories/min/' . $category->cover));
            Meta::set('canonical', $route);

            $blogCategories = BlogCategoriesPivot::where('blog_category_id', $category->id)->pluck('blog_id');

            $posts = Blog::where('status', 'post')
                ->whereIn('id', $blogCategories)
                ->with('categories')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            return \view('site.blog.index', \compact('title', 'posts', 'description'));
        } else {
            return view('errors.404');
        }
    }
}

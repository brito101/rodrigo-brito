<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategoriesPivot;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Meta;

class PortfolioController extends Controller
{
    public function index()
    {
        $title = 'Rodrigo Brito - Portfolio';
        $route = route('site.portfolio');
        $description = 'Confira meu portfólio.';
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

        $posts = Portfolio::where('status', 'post')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return \view('site.portfolio.index', \compact('title', 'posts'));
    }

    public function post($uri)
    {
        $uri = filter_var($uri, 513);
        $post = Portfolio::where('uri', $uri)->where('status', '!=', 'trash')->first();

        if ($post) {

            $title = 'Rodrigo Brito - '.$post->title;
            $route = route('site.portfolio.post', ['uri' => $uri]);
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
            Meta::set('image', url('storage/portfolio/min/'.$post->cover));
            Meta::set('canonical', $route);

            $categories = [];
            foreach ($post->categories as $category) {
                $categories[] .= $category->portfolio_category_id;
            }

            if (! Auth::user()) {
                $post->views++;
                $post->update();
            }

            $related = Portfolio::whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('portfolio_category_id', $categories);
            })->where('id', '!=', $post->id)->inRandomOrder()->limit(3)->get();

            return \view('site.portfolio.post', \compact('title', 'post', 'related', 'title'));
        } else {
            return view('errors.404');
        }
    }

    public function search(Request $request)
    {
        $search = filter_var($request->s, 513);

        $title = 'Rodrigo Brito - Portfolio';
        $route = route('site.portfolio.search', ['s' => $search]);
        $description = 'Pesquisa por: '.$search;
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

        $posts = Portfolio::where('status', 'post')
            ->where('title', 'LIKE', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(9)->withQueryString();

        return \view('site.portfolio.index', \compact('title', 'posts', 'search', 'description'));
    }

    public function category(Request $request)
    {
        $category = filter_var($request->category, 513);

        $category = PortfolioCategory::where('uri', $category)->first();

        if ($category) {

            $title = 'Rodrigo Brito - Projetos em: '.$category->title;
            $route = route('site.portfolio.category', ['category' => $category->uri]);
            $description = 'Projetos em: '.$category->title;
            /** Meta */
            Meta::title($title);
            Meta::set('description', $description);
            Meta::set('og:type', 'article');
            Meta::set('og:site_name', $title);
            Meta::set('og:locale', app()->getLocale());
            Meta::set('og:url', $route);
            Meta::set('twitter:url', $route);
            Meta::set('robots', 'index,follow');
            Meta::set('image', url('storage/portfolio-categories/min/'.$category->cover));
            Meta::set('canonical', $route);

            $portfolioCategories = PortfolioCategoriesPivot::where('portfolio_category_id', $category->id)->pluck('portfolio_id');

            $posts = Portfolio::where('status', 'post')
                ->whereIn('id', $portfolioCategories)
                ->with('categories')
                ->orderBy('created_at', 'desc')
                ->paginate(9);

            return \view('site.portfolio.index', \compact('title', 'posts', 'description'));
        } else {
            return view('errors.404');
        }
    }
}

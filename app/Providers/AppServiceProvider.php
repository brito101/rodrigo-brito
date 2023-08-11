<?php

namespace App\Providers;

use App\Helpers\Cookie;
use App\Models\BlogCategory;
use App\Models\PortfolioCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.default');
        View::share('siteBlogCategories', BlogCategory::orderBy('title')->get(['title', 'uri']));
        View::share('sitePortfolioCategories', PortfolioCategory::orderBy('title')->get(['title', 'uri']));
        View::share('cookieConsent', Cookie::get('cookieConsent'));
    }
}

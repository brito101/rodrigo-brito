<?php

use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ChangelogController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\BlogController as SiteBlogController;
use App\Http\Controllers\Site\CookieController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PortfolioController as SitePortfolioController;
use App\Http\Controllers\Site\TermsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.home');
    Route::prefix('admin')->name('admin.')->group(function () {
        /** Chart home */
        Route::get('/chart', [AdminController::class, 'chart'])->name('home.chart');

        /** Users */
        Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::resource('users', UserController::class)->except('show');

        /** Certificates */
        Route::resource('certificates', CertificateController::class)->except('show');

        /** Blog */
        Route::resource('blog', BlogController::class)->except('show');
        Route::resource('blog-categories', BlogCategoryController::class)->except('show');

        /** Portfolio */
        Route::resource('portfolio', PortfolioController::class)->except('show');
        Route::resource('portfolio-categories', PortfolioCategoryController::class)->except('show');

        /**
         * ACL
         * */
        /** Permissions */
        Route::resource('permission', PermissionController::class)->except('show');

        /** Roles */
        Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permissions');
        Route::put('role/{role}/permission/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
        Route::resource('role', RoleController::class)->except('show');

        /** Changelog */
        Route::get('/changelog', [ChangelogController::class, 'index'])->name('changelog');
    });
});

/** Site */
Route::group(['middleware' => ['log']], function () {
    Route::name('site.')->group(function () {
        /** Home */
        Route::get('/', [HomeController::class, 'index'])->name('home');
        /** Terms */
        Route::get('/termos', [TermsController::class, 'index'])->name('terms');
        /** About */
        Route::get('/sobre', [AboutController::class, 'index'])->name('about');

        /** Blog */
        Route::get('/blog/buscar/{s?}', [SiteBlogController::class, 'search'])->name('blog.search');
        Route::get('/blog/{uri}', [SiteBlogController::class, 'post'])->name('blog.post');
        Route::get('/blog', [SiteBlogController::class, 'index'])->name('blog');
        Route::get('/blog/em/{category}', [SiteBlogController::class, 'category'])->name('blog.category');

        /** Portfolio */
        Route::get('/portfolio/buscar/{s?}', [SitePortfolioController::class, 'search'])->name('portfolio.search');
        Route::get('/portfolio/{uri}', [SitePortfolioController::class, 'post'])->name('portfolio.post');
        Route::get('/portfolio', [SitePortfolioController::class, 'index'])->name('portfolio');
        Route::get('/portfolio/em/{category}', [SitePortfolioController::class, 'category'])->name('portfolio.category');

        /** Cookie */
        Route::post('/cookie-consent', [CookieController::class, 'index'])->name('cookie.consent');
    });
});

Auth::routes([
    'register' => false,
]);

Route::fallback(function () {
    return view('errors.404');
});

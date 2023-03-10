<?php

use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\BlogController as SiteBlogController;
use App\Http\Controllers\Site\CookieController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\TermsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.home');
    Route::prefix('admin')->name('admin.')->group(function () {
        /** Chart home */
        Route::get('/chart', [AdminController::class, 'chart'])->name('home.chart');

        /** Users */
        Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::resource('users', UserController::class);

        /** Certificates */
        Route::resource('certificates', CertificateController::class);

        /** Blog */
        Route::resource('blog', BlogController::class);
        Route::resource('blog-categories', BlogCategoryController::class);

        /**
         * ACL
         * */
        /** Permissions */
        Route::resource('permission', PermissionController::class);
        /** Roles */
        Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permissions');
        Route::put('role/{role}/permission/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
        Route::resource('role', RoleController::class);
    });
});

/** Site */
Route::name('site.')->group(function () {
    /** Home */
    Route::get('/', [HomeController::class, 'index'])->name('home');
    /** Terms */
    Route::get('/termos', [TermsController::class, 'index'])->name('terms');
    /** About */
    Route::get('/sobre', [AboutController::class, 'index'])->name('about');
    /** Blog */
    Route::get('/blog/{uri}', [SiteBlogController::class, 'post'])->name('blog.post');
    Route::post('/blog-search', [SiteBlogController::class, 'search'])->name('blog.search');
    Route::get('/blog/buscar/{search}', [SiteBlogController::class, 'searchPage'])->name('blog.search.page');
    Route::get('/blog', [SiteBlogController::class, 'index'])->name('blog');





    /** Cookie */
    Route::post("/cookie-consent", [CookieController::class, 'index'])->name('cookie.consent');
});

Auth::routes([
    'register' => false,
]);

Route::fallback(function () {
    return view('errors.404');
});

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LangsController;
use App\Http\Controllers\Admin\TranslationsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\PortfoliosController;
use App\Http\Controllers\Admin\TeamsController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\GalleriesController;
use App\Http\Controllers\Admin\OtziviController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\PortfolioCategoryController;




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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

        Route::get('langs', [LangsController::class, 'index'])->name('langs.index');
        Route::get('/langs/create', [LangsController::class, 'create'])->name('lang.create');
        Route::post('/langs/store', [LangsController::class, 'store'])->name('lang.store');
        Route::post('/langs/destroy/{id}', [LangsController::class, 'destroy'])->name('lang.destroy');
        Route::get('/translations', [TranslationsController::class, 'index'])->name('translations.index');
        Route::post('/translations/update/{id}', [TranslationsController::class, 'tr_update'])->name('translation.tr_update');
        Route::post('/translations/destroy/{id}', [TranslationsController::class, 'destroy'])->name('translation.destroy');
        Route::get('/translations/{id}/create', [TranslationsController::class, 'create'])->name('translation.create');
        Route::post('/translations/{id}/update', [TranslationsController::class, 'update'])->name('translation.update');
        Route::get('/translations/search', [TranslationsController::class, 'search'])->name('translation.search');
        Route::post('translations', [TranslationsController::class, 'group_store'])->name('group.store');
        Route::get('/translations/{id}', [TranslationsController::class, 'group_show'])->name('group.show');
        Route::resource('categories', CategoriesController::class);
        Route::post('/categories-image-upload',[CategoriesController::class,'upload'])->name('category.upload');
        Route::post('/post-image-upload',[PostsController::class,'upload'])->name('post.upload');
        Route::post('/product-image-upload',[ProductsController::class,'upload'])->name('product.upload');
        Route::resource('products', ProductsController::class);
        Route::resource('posts', PostsController::class);
        Route::get('/post/filter', [PostsController::class, 'filterProducts']);

        //search start
        Route::get('/post_categories/search', [CategoriesController::class, 'search'])->name('categories.search');
        Route::get('/product_categories/search', [ProductCategoryController::class, 'search'])->name('product_categories.search');
        Route::get('/portfolio_categories/search', [PortfolioCategoryController::class, 'search'])->name('portfolio_categories.search');
        Route::get('/service_categories/search', [ServiceCategoryController::class, 'search'])->name('service_categories.search');

        Route::get('/product/search', [ProductsController::class, 'search'])->name('product.search');
        Route::post('/product/status', [ProductsController::class, 'status'])->name('product.status');

        Route::get('/post/search', [PostsController::class, 'search'])->name('post.search');
        Route::post('/post/status', [PostsController::class, 'status'])->name('post.status');

        Route::get('/portfolio/search', [PortfoliosController::class, 'search'])->name('portfolio.search');
        Route::post('/portfolio/status', [PortfoliosController::class, 'status'])->name('portfolio.status');
        Route::get('/team/search', [TeamsController::class, 'search'])->name('team.search');

        Route::get('/partner/search', [PartnersController::class, 'search'])->name('partner.search');
        Route::get('/faq/search', [FaqController::class, 'search'])->name('faq.search');
        Route::get('/zayavka/search', [OtziviController::class, 'z_search'])->name('zayavka.search');
        Route::post('/zayavka/status', [OtziviController::class, 'status'])->name('zayavka.status');

        Route::get('/otzivi/search', [OtziviController::class, 'search'])->name('otzivi.search');
        Route::get('/service/search', [ServicesController::class, 'search'])->name('service.search');
        Route::post('/service/status', [ServicesController::class, 'status'])->name('service.status');

        // Route::post('upload', [PortfoliosController::class, 'ajax'])->name('portfolio.ajax');
        Route::post('upload-image-via-ajax', [ProductsController::class, 'uploadImageViaAjax'])->name('uploadImageViaAjax');
        // Route::post('store-image', [ProductsController::class, 'img_store'])->name('img.store');


        //search end



      Route::resource('services', ServicesController::class);
        Route::post('/servic/upload',[ServicesController::class,'upload'])->name('servic.upload');
        Route::resource('portfolios', PortfoliosController::class);
        Route::post('/portfolio/upload',[PortfoliosController::class,'upload'])->name('portfolio.upload');
        Route::post('/portfolio/ajax',[PortfoliosController::class,'ajax'])->name('portfolio.ajax');
        Route::post('/post/ajax',[PostsController::class,'ajax'])->name('post.ajax');
        Route::post('/product_categories/ajax',[ProductCategoryController::class,'ajax'])->name('product_categories.ajax');
        Route::post('/partner/ajax',[PartnersController::class,'ajax'])->name('partner.ajax');
        Route::post('/banner/ajax',[GalleriesController::class,'ajax'])->name('banners.ajax');
        Route::post('/banner/ajax',[GalleriesController::class,'ajax'])->name('banners.ajax');
        Route::post('/information/ajax',[OtziviController::class,'ajax'])->name('information.ajax');
        Route::resource('teams', TeamsController::class);
        Route::post('/team/upload',[TeamsController::class,'upload'])->name('team.upload');

        // Route::post('/banners/upload',[GalleriesController::class,'upload'])->name('banner.upload');
        // Route::post('/banners',[GalleriesController::class,'store'])->name('banner.store');
        // Route::post('/banners',[G
    //alleriesController::class,'index'])->name('banner.index');
        // Route::post('/banners',[GalleriesController::class,'destroy'])->name('banner.destroy');
        Route::resource('banners', GalleriesController::class);

        Route::resource('partners', PartnersController::class);
        Route::get('/information',[OtziviController::class,'in_index'])->name('information.upload');
        Route::put('/information/{id}', [OtziviController::class, 'in_store'])->name('information.store');
        Route::resource('otzivi', OtziviController::class);
        Route::resource('faq', FaqController::class);
        Route::post('/otzivi/upload',[OtziviController::class,'upload'])->name('otzivi.upload');
        Route::post('/faq/upload',[FaqController::class,'upload'])->name('faq.upload');

        Route::get('zayavkas', [OtziviController::class, 'z_index'])->name('z.index');
        Route::post('/zayavkas/destroy/{id}', [OtziviController::class, 'z_destroy'])->name('zayavkas.destroy');
        Route::post('zayavkas/{id}/deactivate', [OtziviController::class, 'deactivate'])->name('deactivate');

        Route::get('sertificates', [ServicesController::class, 'sertificates_index'])->name('sertificates.index');
        Route::post('/sertificates/store', [ServicesController::class, 'sertificates_store'])->name('sertificate.store');
        Route::post('/sertificates/destroy/{id}', [ServicesController::class, 'sertificates_destroy'])->name('sertificate.destroy');
        Route::resource('product_categories', ProductCategoryController::class);
        Route::resource('portfolio_categories', PortfolioCategoryController::class);
        Route::resource('service_categories', ServiceCategoryController::class);
        Route::post('product/categories/upload',[ProductCategoryController::class,'upload'])->name('product_categories.upload');
        Route::post('portfolio/categories/upload',[PortfolioCategoryController::class,'upload'])->name('portfolio_categories.upload');
        Route::post('service/categories/upload',[ServiceCategoryController::class,'upload'])->name('service_categories.upload');
        Route::post('otzivi/upload',[OtziviController::class,'upload'])->name('otzivi.upload');

    Route::post('/upload',[CategoriesController::class,'upload'])->name('upload');
    Route::post('/upload',[PartnersController::class,'upload'])->name('partner.upload');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Brand\Index;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

// Frontend Routes
Route::controller(FrontendController::class)->group(function(){
    Route::get('/','index');
    Route::get('/collections','category');
    Route::get('/collections/{category_slug}','products');
    Route::get('/collections/{category_slug}/{product_slug}','productView');
    Route::get('/thank-you','thankYou');
    Route::get('/new-arrivals','newArrival');
    Route::get('/featured-products','featuredProducts');

});

Route::middleware('auth')->group(function(){
    Route::get('/wishlist',[WishlistController::class,'index']);
    Route::get('/cart',[CartController::class,'index']);
    Route::get('/checkout',[CheckoutController::class,'index']);
    Route::get('/orders',[OrderController::class,'index']);
    Route::get('/orders/{order}',[OrderController::class,'show']);

});


Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index']);

    Route::get('/settings',[SettingController::class,'index']);
    Route::post('/settings',[SettingController::class,'store']);


    // Category Routes
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/category','index');
        Route::get('/category/create','create');
        Route::post('/category','store');
        Route::get('/category/{category}/edit','edit');
        Route::put('/category/{category}','update');
    });

    Route::get('/brands',Index::class);

    // Product Routes
    Route::controller(ProductController::class)->group(function(){
        Route::get('/products','index');
        Route::get('/products/create','create');
        Route::post('/products','store');
        Route::get('/products/{product}/edit','edit');
        Route::put('/products/{product}','update');
        Route::get('/products/{product}/delete','destroy');

        Route::get('/product-image/{product_image}/delete','destroyImage');

        Route::post('/product-color/{id}','updateProductColorQty');
        Route::delete('/product-color/{id}/delete','destroyProductColor');
    });

    // Color Routes
    Route::controller(ColorController::class)->group(function(){
        Route::get('/colors','index');
        Route::get('/colors/create','create');
        Route::post('/colors','store');
        Route::get('/colors/{color}/edit','edit');
        Route::put('/colors/{color}','update');
        Route::get('/colors/{color}/delete','destroy');
    });

    // Slider Routes
    Route::controller(SliderController::class)->group(function(){
        Route::get('/sliders','index');
        Route::get('/sliders/create','create');
        Route::post('/sliders','store');
        Route::get('/sliders/{slider}/edit','edit');
        Route::put('/sliders/{slider}','update');
        Route::get('/sliders/{slider}/delete','destroy');

    });

    // Order Routes
    Route::controller(AdminOrderController::class)->group(function(){
        Route::get('/orders','index');
        Route::get('/orders/{order}','show');
        Route::put('/orders/{order}','updateOrderStatus');

        Route::get('/invoice/{order}','viewInvoice');
        Route::get('/invoice/{order}/generate','generateInvoice');
    });

    // User Routes
    Route::controller(UserController::class)->group(function(){
        Route::get('/users','index');
        Route::get('/users/create','create');
        Route::post('/users','store');
        Route::get('/users/{user_id}/edit','edit');
        Route::put('/users/{user_id}','update');
        Route::get('/users/{user_id}/delete','destroy');

    });
});

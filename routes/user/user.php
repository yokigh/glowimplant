<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\StatckController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\Admin\PaymentController;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Country;
use App\Http\Controllers\EmailNewsletterController;

Route::group([
    'prefix' => '{lang}',
    'where' => ['lang' => 'en|ar|es|de|fr'],
    'middleware' => ['setLocale'], 
], function () {
    Route::get('/',[StatckController::class,'index'])->name('home.page');
    Route::get('/contact-us',[StatckController::class,'contact'])->name('contact.page');
    Route::get('/contact-us/{contac}',[StatckController::class,'contactshow'])->name('contactshow.page');
    Route::get('/about',[StatckController::class,'about'])->name('about.page');
    Route::get('/category/{category}',[StatckController::class,'showcategory'])->name('showcategory.page');
    Route::get('/subcategory/{subcategory}',[StatckController::class,'showsubcategory'])->name('showsubcategory.page');
    Route::get('/subcategory/product/{subcategory}',[StatckController::class,'showsubcategoryproduct'])->name('showsubcategoryproduct.page');
    Route::get('/category/product/{category}',[StatckController::class,'showcategoryproduct'])->name('showcategoryproduct.page');
    Route::get('/products',[StatckController::class,'products'])->name('products.page');
    Route::get('/products/{product}',[StatckController::class,'showproduct'])->name('products.showproducts');
    Route::get('/event',[StatckController::class,'event'])->name('event.page');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart',[CartController::class,'getcat'])->name('getcart.view');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/charge/', [PaymentController::class, 'processPayment'])->name('checkout.charge');
Route::get('/checkout/success', [PaymentController::class, 'checkoutSuccess'])->name('checkout.success');
Route::post('/newsletter/subscribe', [EmailNewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/search-products', [StatckController::class, 'search'])->name('search.products');
Route::get('payments',[StatckController::class, 'payment'])->name('payments.page');


});
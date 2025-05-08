<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProccerrpaymentController;
use App\Http\Controllers\Admin\ProstheticCategoryController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ProstheticProductController;

Route::group([
    'prefix' => '{lang}/admin',
    'where' => ['lang' => 'en|ar|es|de|fr'],
    'middleware' => ['setLocale', 'auth', 'verified', 'admin'], 
], function () {
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard.admins');
    Route::get('virifay/{user}',[UserController::class,'virifay'])->name('users.virifay');
    Route::get('forgetpassword/{user}',[UserController::class,'forgetpassword'])->name('users.forgetpassword');
    Route::resource('users', UserController::class);
    Route::get('only-user',[UserController::class,'onlyuser'])->name('users.onlyuser');
    Route::get('only-user/create',[UserController::class,'createuseronly'])->name('createuseronly.index');
    Route::get('only-agancy',[UserController::class,'onlyagancy'])->name('users.onlyagancy');
    Route::get('only-agancy/create',[UserController::class,'createagancyonly'])->name('createagancyonly.index');
    Route::get('only-admin',[UserController::class,'onlyadmin'])->name('users.onlyadmin');
    Route::get('only-admin/create',[UserController::class,'createadminonly'])->name('createadminonly.index');
    Route::post('user/create',[UserController::class,'store'])->name('user.store');
    Route::resource('countries', CountryController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('events', EventController::class);
    Route::resource('contactus', ContactUsController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('about-us', AboutUsController::class);
    Route::get('/profille/update',[ProfileController::class,'index'])->name('user.profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/payment',[ProccerrpaymentController::class,'index'])->name('index.pay');
    Route::get('/payment/{payment}',[ProccerrpaymentController::class,'show'])->name('show.pay');
    Route::post('/payment/add-notes',[ProccerrpaymentController::class,'addnotes'])->name('payment.notes');
    Route::get('/newslatters',[NewsletterController::class,'index'])->name('create.newslatter');
    Route::post('/newslatters',[NewsletterController::class,'store'])->name('store.newslatter');
    Route::resource('prostatic_categories', ProstheticCategoryController::class);
    Route::resource('prosthetic_products', ProstheticProductController::class);
});
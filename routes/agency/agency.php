<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agency\DashagancyController;
use App\Http\Controllers\Agency\ProductagencyController;


Route::group([
    'prefix' => '{lang}/agency',
    'where' => ['lang' => 'en|ar|es|de|fr'],
    'middleware' => ['setLocale', 'auth', 'verified', 'agency'], 
], function () {
    Route::get('dashboard',[DashagancyController::class,'index'])->name('dash.agency');
    Route::get('payment/{payment}',[DashagancyController::class,'show'])->name('agancypayment.show');
    Route::post('/payment/add-notes',[DashagancyController::class,'addnotes'])->name('agancypayment.notes');
    Route::get('products',[ProductagencyController::class,'index'])->name('product.agency');
    Route::get('product/{product}',[ProductagencyController::class,'show'])->name('agencyproducts.show');
    Route::get('product/{product}/edit',[ProductagencyController::class,'edit'])->name('agencyproducts.edit');
    Route::put('product/{product}',[ProductagencyController::class,'update'])->name('agencyproducts.update');
    Route::get('users',[DashagancyController::class,'onlyuser'])->name('onlyuser.agency');
    Route::get('users/{user}',[DashagancyController::class,'showuser'])->name('onlshowuseryuser.agency');
    Route::get('/profille/update',[DashagancyController::class,'indexprofile'])->name('agancy.profile');
    Route::put('/profile/update', [DashagancyController::class, 'updateprofile'])->name('agancy.profile.update');
});
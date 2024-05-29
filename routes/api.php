<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserController;
use App\Mail\verifyingMail;
use App\Models\Verify_email;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@register');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout')->middleware('auth:sanctum');
    Route::get('find-user-by-token', 'App\Http\Controllers\AuthController@getUserByToken');
    Route::get('current-user', 'App\Http\Controllers\AuthController@getCurrentUser');
});


Route::middleware(['lastActivity'])->group(function () {


// Route::ApiResource('users', 'App\Http\Controllers\Api\UserController');
Route::ApiResource('employees', 'App\Http\Controllers\Api\EmployeeController');
Route::ApiResource('suppliers', 'App\Http\Controllers\Api\SupplierController');
Route::ApiResource('categories', 'App\Http\Controllers\Api\CategoryController');
Route::ApiResource('products', 'App\Http\Controllers\Api\ProductController');
Route::get('get-products/{shuffle?}', 'App\Http\Controllers\Api\ProductController@getProducts');
Route::ApiResource('expenses', 'App\Http\Controllers\Api\ExpenseController');
Route::ApiResource('customers', 'App\Http\Controllers\Api\CustomerController');
Route::ApiResource('orders', 'App\Http\Controllers\Api\OrderController');
Route::get('today-orders', 'App\Http\Controllers\Api\OrderController@todayOrders');
// Route::ApiResource('order-details', 'App\Http\Controllers\Api\OrderDetailController');
Route::get('order-details-by-order-id/{orderId}', 'App\Http\Controllers\Api\OrderDetailController@showByOrder');
Route::post('salary/pay/{id}', 'App\Http\Controllers\Api\SalaryController@pay');



Route::prefix('cart')->group(function(){
    // Route::ApiResource('cart/product', 'App\Http\Controllers\Api\CartController');
    Route::post('add/{id}', 'App\Http\Controllers\Api\CartController@addToCart');
    Route::delete('delete/{id}', 'App\Http\Controllers\Api\CartController@deleteProduct');
    Route::get('get', 'App\Http\Controllers\Api\CartController@cartProducts');
    Route::put('increment/{id}', 'App\Http\Controllers\Api\CartController@increaseQuantity');
    Route::put('decrement/{id}', 'App\Http\Controllers\Api\CartController@decreaseQuantity');
});

// Search Routes
Route::prefix('search')->group(function(){
    Route::get('suppliers/{name}', 'App\Http\Controllers\Api\SupplierController@search');
    Route::get('categories/{name}', 'App\Http\Controllers\Api\CategoryController@search');
    //Algolia search
    Route::get('products/{keyword}', 'App\Http\Controllers\Api\ProductController@search');
});


//profile
Route::put('update-profile/{id}', 'App\Http\Controllers\Api\ProfileController@updateProfile');

});
//end of lastActivity middleware



//verify email
Route::post('verify', 'App\Http\Controllers\Api\VerificationEmailController@verification');
Route::post('send-verification-code', 'App\Http\Controllers\Api\VerificationEmailController@sendMail');
Route::get('email/{id}','App\Http\Controllers\Api\VerificationEmailController@getEmail');

//Localization
Route::get('language/{lang}', 'App\Http\Controllers\LocalizationController@changeLang');


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserController;
use App\Mail\verifyingMail;
use App\Models\Verify_email;
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
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('findUserByToken', 'App\Http\Controllers\AuthController@getUserByToken');

    Route::post('verify', 'App\Http\Controllers\AuthController@verification');

    Route::get('verifyEmail/{id}','App\Http\Controllers\AuthController@getOTP');
});
Route::ApiResource('users', 'App\Http\Controllers\Api\UserController');
Route::ApiResource('employees', 'App\Http\Controllers\Api\EmployeeController');
Route::ApiResource('suppliers', 'App\Http\Controllers\Api\SupplierController');
Route::ApiResource('categories', 'App\Http\Controllers\Api\CategoryController');
Route::ApiResource('products', 'App\Http\Controllers\Api\ProductController');
Route::ApiResource('expenses', 'App\Http\Controllers\Api\ExpenseController');
Route::ApiResource('customers', 'App\Http\Controllers\Api\CustomerController');
Route::ApiResource('orders', 'App\Http\Controllers\Api\OrderController');
Route::get('todayorders', 'App\Http\Controllers\Api\OrderController@TodayOrders');
Route::ApiResource('orderDetails', 'App\Http\Controllers\Api\OrderDetailsController');
Route::get('orderDetailsByOrderId/{orderId}', 'App\Http\Controllers\Api\OrderDetailsController@showByOrder');
Route::post('salary/pay/{id}', 'App\Http\Controllers\Api\SalaryController@pay');
Route::get('products/getByCategory/{id}', 'App\Http\Controllers\Api\ProductController@GetProductByCategory');

Route::ApiResource('pos/', 'App\Http\Controllers\Api\PosController');


Route::prefix('cart')->group(function(){
    // Route::ApiResource('cart/product', 'App\Http\Controllers\Api\CartController');
    Route::get('AddToCart/{id}', 'App\Http\Controllers\Api\CartController@AddToCart');
    Route::get('products', 'App\Http\Controllers\Api\CartController@CartProducts');
    Route::get('delete/{id}', 'App\Http\Controllers\Api\CartController@DeleteProduct');
    Route::get('increment/{id}', 'App\Http\Controllers\Api\CartController@increaseQuantity');
    Route::get('decrement/{id}', 'App\Http\Controllers\Api\CartController@decreaseQuantity');
});


Route::post('order', 'App\Http\Controllers\Api\PosController@AddOrder');

// Search Routes
Route::prefix('search')->group(function(){
    Route::get('suppliers/{name}', 'App\Http\Controllers\Api\SupplierController@search');
    Route::get('categories/{name}', 'App\Http\Controllers\Api\CategoryController@search');
});
//factory
Route::get('factory/products/{number}', 'App\Http\Controllers\Api\ProductController@fac');

//OTP
Route::post('sendVerificationCode', 'App\Http\Controllers\AuthController@sendMail');

//profile
Route::put('updateProfile/{id}', 'App\Http\Controllers\Api\ProfileController@updateProfile');



//Mail
// Route::get('/verifyingE-mail', function(){
//     Mail::to('m.abdelghany.dev@gmail.com')
//     ->send(new verifyingMail());
//     return response()->json([
//         'status' => 'success',
//         'message' => 'email sent successfully',
//     ], 203);
// });


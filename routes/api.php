<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReponsitoryAPIController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('web/food', [ReponsitoryAPIController::class, 'getAll_food']); 
Route::get('web/food_detail', [ReponsitoryAPIController::class, 'getDetail_Food']);
Route::get('web/food_bestseller', [ReponsitoryAPIController::class, 'getBestseller_food']);
Route::get('web/same_food', [ReponsitoryAPIController::class, 'same_Food']);
Route::get('web/category_id', [ReponsitoryAPIController::class, 'getCategoryById']);
Route::get('web/coupon', [ReponsitoryAPIController::class, 'get_coupon']);
Route::get('web/food_new', [ReponsitoryAPIController::class, 'getNew_food']);
Route::get('web/food_discount', [ReponsitoryAPIController::class, 'getDiscount_food']);
Route::get('web/customer', [ReponsitoryAPIController::class, 'getAll_customer']);
Route::get('web/category', [ReponsitoryAPIController::class, 'getAll_category']);
Route::get('web/slider', [ReponsitoryAPIController::class, 'get_slider']);
Route::get('web/city', [ReponsitoryAPIController::class, 'get_city']);
Route::get('web/pronvice', [ReponsitoryAPIController::class, 'get_pronvice']);
Route::get('web/ward', [ReponsitoryAPIController::class, 'get_ward']);
Route::get('web/info_orders', [ReponsitoryAPIController::class, 'info_orders']);
Route::get('web/cancel_order', [ReponsitoryAPIController::class, 'cancel_order']);
Route::get('web/detail_order', [ReponsitoryAPIController::class, 'get_order_detail']);
Route::get('web/check_coupon', [ReponsitoryAPIController::class, 'check_coupon']);
Route::get('web/shipping_fee', [ReponsitoryAPIController::class, 'shipping_fee']);
Route::get('web/register', [ReponsitoryAPIController::class, 'register']);
Route::get('web/login', [ReponsitoryAPIController::class, 'login']);
Route::get('web/order_detail', [ReponsitoryAPIController::class, 'order']);

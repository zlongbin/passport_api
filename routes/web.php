<?php

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

Route::get('/', function () {
    return view('welcome');
});
// 登录注册
Route::post('/passport/reg',"User\UserController@reg");
Route::post('/passport/login',"User\UserController@login");
//个人中心
Route::post('/home/center',"Home\HomeController@center");
// 商品
Route::post('/goods/goods',"Goods\GoodsController@goods");
Route::post('/goods/goodsDetail',"Goods\GoodsController@goodsDetail");
// 购物车
Route::post('/cart/cart',"Cart\CartController@cart");
// 订单
Route::post('/order/order',"Order\OrderController@order");

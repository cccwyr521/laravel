<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/***********************首页*****************/
Route::post('home/banners','Api\HomeController@banners');//首页banner图接口
Route::post('home/news','Api\HomeController@newsList');//首页最新小说的接口
Route::post('home/clicks','Api\HomeController@clicksList');//首页点击排行接口


Route::post('category/list','Api\CategoryController@getCategory');//分类列表接口
Route::post('category/novel','Api\CategoryController@getCategoryNovel');//分类小说接口
Route::post('search/novel','Api\SearchController@getSearchList');
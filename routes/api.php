<?php

use Illuminate\Http\Request;
/**
 * 全域 API 路由群組
 */

use Illuminate\Support\Facades\Route;
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

// 新增會員
Route::post('v1/user/create', 'HomeController@createMember')
        ->name('v1/user/create');
// 刪除會員
Route::post('v1/user/delete', 'HomeController@deleteMember')
        ->name('v1/user/delete');
// 修改會員密碼
Route::post('v1/user/pwd/change', 'HomeController@changePassword')
        ->name('v1/user/pwd/change');
// 驗證帳號密碼
Route::get('v1/user/login', 'HomeController@login')
        ->name('v1/user/login');

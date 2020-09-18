<?php

use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;


Route::post('user/login', [LoginController::class, 'login']);

Route::get('category/all', [CategoryController::class, 'index']);
Route::get('category/per/{per?}', [CategoryController::class, 'pagination']);


Route::group(array('prefix' => 'secure', 'middleware' => 'auth:api'), function () {
    Route::get('user/all', [UserController::class, 'index']);
    Route::post('category/save', [CategoryController::class, 'store']);
    Route::post('category/edit/slug/{slug}', [CategoryController::class, 'update']);
    Route::post('category/remove/slug/{slug}', [CategoryController::class, 'destroy']);
});

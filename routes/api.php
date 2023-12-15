<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CsrfController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/registration', [UserController::class, 'registration']);
Route::post('/signin', [UserController::class, 'signin']);
Route::get('/', [ProductController::class, 'showproduct']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/favourite', [UserController::class, 'addToFavourite']);
    Route::post('/signout', [UserController::class, 'signout']);
    Route::get('/loggedinuser', [UserController::class, 'loggedinuser']);
    Route::post('/addproduct', [AdminController::class, 'addproduct']);
});








// Admin Controller




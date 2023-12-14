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

// Route::middleware('auth:sanctum')->get('sanctum/csrf-cookie', function (Request $request) {
//     return response()->json(['message' => 'CSRF cookie set']);
// });

// Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);



Route::post('/registration', [UserController::class, 'registration']);
Route::post('/signin', [UserController::class, 'signin']);
// Route::post('/signout', [UserController::class, 'signout']); 

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/favourite', [UserController::class, 'addToFavourite']);
    Route::post('/signout', [UserController::class, 'signout']);
    Route::get('/loggedinuser', [UserController::class, 'loggedinuser']);
});

// Route::middleware('auth:sanctum')->post('/favourite', [UserController::class, 'addToFavourite']);
// Route::middleware('auth:sanctum')->post('/signout', [UserController::class, 'signout']);
// Route::middleware('auth:sanctum')->get('/loggedinuser', [UserController::class, 'loggedinuser']);

Route::get('/', [ProductController::class, 'showproduct']);
Route::post('/product/{id}', [ProductController::class, 'addtocart']);
Route::middleware('auth:sanctum')->post('/updatecart', [ProductController::class, 'updateCart']);

Route::middleware('auth:sanctum')->post('/addproduct', [AdminController::class, 'addproduct']);



// Route::group(['middleware'=>['auth:sanctum']], function () {
//     Route::get('/user/{id}', [UserController::class, 'userinfo']);

// });
// Route::get('/user/{id}', [UserController::class, 'userinfo'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/user/{id}', [UserController::class, 'userinfo']);



// Admin Controller




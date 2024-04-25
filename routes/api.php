<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    NewsController,
    CategoryController,
};

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

// app routes
Route::group(['middleware' => 'auth'], function () {

    // category routes
    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/all', [CategoryController::class, 'index'])->name('index');
        Route::get('/{id}/news', [CategoryController::class, 'retriveCategoryNews'])->name('retrive.news');
        Route::get('/search/{name}/news', [CategoryController::class, 'searchRecursiveNews'])->name('search.news');
    });

    // news routes
    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
        Route::get('/all', [NewsController::class, 'index'])->name('index');
        Route::post('/store', [NewsController::class, 'store'])->name('store');
        Route::get('/{id}/show', [NewsController::class, 'show'])->name('show');
        Route::put('/{id}/update', [NewsController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [NewsController::class, 'destroy'])->name('delete');
    });
});


// auth routes
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


// unAutorize route
Route::get('/unAutorized', function () {
    return response()->json([
        'msg' => 'unAutorized route'
    ]);
})->name('login');

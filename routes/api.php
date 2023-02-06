<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\Admin\BookController as AdminBookController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/books', [BookController::class, 'getBooks']);
Route::get('/books/{id}', [BookController::class, 'getBook']);
Route::get('/filters', [BookController::class, 'getBookFilters']);

Route::group(['middleware' => 'auth:sanctum'], function() {
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/user', [UserController::class, 'user']);

	Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {
		Route::group(['prefix' => 'books'], function () {
			Route::get('/', [AdminBookController::class, 'getBooks']);
			Route::get('/{id}', [AdminBookController::class, 'getBook']);
			Route::post('/save', [AdminBookController::class, 'store']);
			Route::put('/update/{id}', [AdminBookController::class, 'update']);
			Route::delete('/{id}', [AdminBookController::class, 'destroy']);
		});

	});
});



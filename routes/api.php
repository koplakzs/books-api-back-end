<?php

use App\Http\Controllers\api\booksController;
use App\Http\Controllers\api\userController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("register", [userController::class, 'register']);
Route::post('login', [userController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [userController::class, 'user']);
    Route::delete('user/logout', [userController::class, 'logout']);
    Route::post('books/add', [booksController::class, 'store']);
    Route::get('books', [booksController::class, 'index']);
    Route::put('books/{book_id}/edit', [booksController::class, 'update']);
    Route::get('books/{book_id}', [booksController::class, 'show']);
    Route::delete('books/{book_id}', [booksController::class, 'destroy']);
    // Route::apiResource('books', booksController::class);
});

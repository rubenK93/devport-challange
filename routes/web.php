<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\ScoreController;

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

Route::get('/', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);
Route::view('/error', 'error')->name('error');

Route::middleware('check-link')->prefix('user')->group(function () {
    Route::get('/{unique_link}', [LinkController::class, 'show'])->name('links.show');
    Route::post('/{unique_link}/store', [LinkController::class, 'store']);
    Route::post('/{unique_link}/link/{user_link}/deactivate', [LinkController::class, 'deactivateLink']);
    Route::post('/{unique_link}/score', [ScoreController::class, 'store']);
    Route::get('/{unique_link}/score', [ScoreController::class, 'index']);
});

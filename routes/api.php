<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SubjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
*/

Route::apiResource(name: '/books', controller: BookController::class);
Route::apiResource(name: '/authors', controller: AuthorController::class);
Route::apiResource(name: '/subjects', controller: SubjectController::class);

Route::get('/catalog', [ReportController::class, 'index']);

Route::get('/', function() {
    return response()->json(['message' => 'API working!']);
});


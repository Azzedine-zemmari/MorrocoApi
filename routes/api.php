<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\ItineraireController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::post('/destination/add',[ItineraireController::class,'store']);
    Route::put('/destination/update/{id}', [ItineraireController::class, 'update']);
    Route::post('/favoris/add/{id}',[FavorisController::class,'addTofavoris']);
});
Route::post("/register" , [AuthController::class , 'store']);
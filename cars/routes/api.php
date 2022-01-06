<?php

use App\Http\Controllers\BodyController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ModellController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', [UserController::class, 'createUser']);

//Brand routes
//--get
Route::get('/brands', [BrandController::class, 'index']);
Route::get('/brands/{id}', [BrandController::class, 'getBrand']);
//--create
Route::post('/brands', [BrandController::class, 'createBrand']);
//--update
Route::put('brands/{id}', [BrandController::class, 'updateBrand']);
//--delete
Route::delete('brands/{id}', [BrandController::class, 'deleteBrand']);

//Model routes
Route::get('/models', [ModellController::class, 'index']);
Route::get('/models/{id}', [ModellController::class, 'getModel']);
Route::post('/models', [ModellController::class, 'createModel']);
Route::put('/models/{id}', [ModellController::class, 'updateModel']);
Route::delete('models/{id}', [ModellController::class, 'deleteModel']);
//Model-fuel_type routes
Route::post('/models/{modelId}/fuels/{fuelId}', [ModellController::class, 'addFuel']);
Route::delete('/models/{modelId}/fuels/{fuelId}', [ModellController::class, 'removeFuel']);
//Model-body_type routes
Route::post('/models/{modelId}/bodies/{bodyId}', [ModellController::class, 'addBody']);
Route::delete('/models/{modelId}/bodies/{bodyId}', [ModellController::class, 'removeBody']);

//Fuel routes
Route::get('/fuels', [FuelController::class, 'index']);
Route::get('/fuels/{id}', [FuelController::class, 'getFuel']);
Route::post('/fuels', [FuelController::class, 'createFuel']);
Route::put('/fuels/{id}', [FuelController::class, 'updateFuel']);
Route::delete('/fuels/{id}', [FuelController::class, 'deleteFuel']);


//Body routes
Route::get('/bodies', [BodyController::class, 'index']);
Route::get('/bodies/{id}', [BodyController::class, 'getBody']);
Route::post('/bodies', [BodyController::class, 'createBody']);
Route::put('/bodies/{id}', [BodyController::class, 'updateBody']);
Route::delete('/bodies/{id}', [BodyController::class, 'deleteBody']);

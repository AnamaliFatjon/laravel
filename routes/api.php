<?php

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
Route::post('/register', 'App\Http\Controllers\Auth\UserAuthController@register');
Route::post('/login', 'App\Http\Controllers\Auth\UserAuthController@login');

Route::apiResource('/employee', 'App\Http\Controllers\EmployeeController')->middleware('auth:api');
Route::get('/categorie/', 'App\Http\Controllers\CategorieController@index1')->middleware('auth:api');
Route::get('categorie/{id}', 'App\Http\Controllers\CategorieController@index2')->middleware('auth:api');
//Route::apiResource('categorie', 'App\Http\Controllers\CategorieController')->middleware('auth:api');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

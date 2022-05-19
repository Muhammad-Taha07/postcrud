<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//On-Boarding(Sign Up, Login, Change Password, Forget Password) API's

//Viewing User via API
Route::get('users/viewusers', 'AuthController@allUser');

//Sign Up (User Registration)
Route::post('users/register', 'AuthController@register');

//Login User
Route::post('users/login','AuthController@login');


//Request Reset Password
Route::post('users/resetpass', 'AuthController@RequestResetPass');

//View User
// Route::middleware('auth:api')->prefix('users')->group(function(){
//     Route::get('getUser','AuthController@userInfo');
// });

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

Route::prefix('users')->group(function () {
    //Viewing User via API
    Route::get('/viewusers', 'AuthController@allUser');

    //Sign Up (User Registration)
    Route::post('/register', 'AuthController@register');

    //Login User
    Route::post('/login','AuthController@login');

    //Request Reset Password
    Route::post('/send-code', 'AuthController@RequestResetPass');

    Route::post('/user-verification', 'AuthController@userAccountVerification');

    //Deleting User from database using Delete API
    Route::delete('/user-delete/{id}', 'AuthController@deleteUser');
});


//View User
// Route::middleware('auth:api')->prefix('users')->group(function(){
//     Route::get('getUser','AuthController@userInfo');
// });

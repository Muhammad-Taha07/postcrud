<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!

*/

/* On-Boarding(Sign Up, Login, Change Password, Forget Password) API's */

Route::prefix('users')->group(function () {
    Route::get('/viewusers', [AuthController::class, 'allUser']);
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/send-code',[AuthController::class,'RequestResetPass']);
    Route::post('/user-verification',[AuthController::class,'userAccountVerification']);
    Route::delete('/user-delete/{id}', [AuthController::class,'deleteUser']);
});

Route::middleware('auth:api')->prefix('posts')->group(function()
{
    Route::get('/getposts', [PostController::class,'fetchPosts']);
    Route::post('/createpost', [PostController::class, 'createPost']);
    Route::get('/fetchjoin',[PostController::class,'useJoins']);
    Route::get('/fetching',[PostController::class,'RealtionshipFetch']);
});

Route::post('/fileupload', [PostController::class, 'uploadFile']);

    Route::get('user-not-loggedin', function(){
            return response()->json([
              "success" => false,
              "status" => 401,
              "message" => "You are not logged in"
            ], 401);
    })->name("user-not-loggedin");

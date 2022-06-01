<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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
    Route::get('/viewusers', [AuthController::class, 'allUser']);

    //Sign Up (User Registration)
    Route::post('/register', [AuthController::class,'register']);

    //Login User
    Route::post('/login',[AuthController::class,'login']);

    //Request Reset Password API
    Route::post('/send-code',[AuthController::class,'RequestResetPass']);

    //User Verification API
    Route::post('/user-verification',[AuthController::class,'userAccountVerification']);

    //Deleting User from database using Delete API
    Route::delete('/user-delete/{id}', [AuthController::class,'deleteUser']);
});

Route::middleware('auth:api')->prefix('posts')->group(function()
{
    Route::get('/getposts', [PostController::class,'fetchPosts']);
    Route::post('/createpost', [PostController::class, 'createPost']);
});

    Route::get('user-not-loggedin', function(){
        return response()->json([
            "success" => false,
            "status" => 401,
            "message" => "You are not logged in"
        ], 401);
    })->name("user-not-loggedin");

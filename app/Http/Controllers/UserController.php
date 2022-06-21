<?php

namespace App\Http\Controllers;

use App\Http\Requests\userSignUp;
use App\User;
use Exception;

use Illuminate\Http\Request;
        // return ["data"=>$user1];
class UserController extends Controller
{
    //Listing/Viewing datafrom database
    public function allUser()
    {
        try{
            $user = User::all();

            return response()->json([
                "success" => true,
                "status" => 200,
                "message" => "User fetched successfully",
                "data" => $user
            ],200);
        }
        catch(Exception $exception)
        {
            return response()->json([
                "success" => false,
                "status"  => 500,
                "message" => $exception,
                "track"   => $exception->getMessage()
            ],500);
        }
    }

/* API For User Registration */
    public function storeData(userSignUp $req)
    {
        try
        {
            $user = User::create([
                'name'=> $req->name,
                'email'=> $req->email,
                'password'=> $req->password,
                'verification_code' => $req->verification_code,
                'verification_expiry' => $req->verification_expiry,
                'status' => $req->status,
                'last_login' => $req->last_login
            ]);

            return response()->json([
                "success" => true,
                "status" => 200,
                "message" => 'User Registered Successfully',
                "data" => $user
            ], 200);
        }

        catch(Exception $exception)
        {
            return response()->json([
                "success" => false,
                "status"  => 500,
                "message" => $exception,
                "track"   => $exception->getMessage()
            ], 500);
        }

    }


}

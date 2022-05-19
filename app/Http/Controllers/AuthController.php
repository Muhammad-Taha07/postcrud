<?php

namespace App\Http\Controllers;

use App\Http\Requests\userLogin;
use App\Http\Requests\userSignUp;
use App\Http\Requests\ResetPassword;
use App\User;
use App\AccessToken;
use App\config\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
// use Mail;
use Exception;

class AuthController extends Controller
{
    /**
     * User : Registration with Validation Code.
     */
    public function register(userSignUp $request)
    {
        $input = $request->all();
        $digits = 4;
        $verificationCode = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $verificationExp = Carbon::parse($input['current_time'] == now())->addDays(7);
        $verificationExp = $verificationExp->toArray();

        $user = User::create([
            'name'      =>  $request->name,
            'email'     => $request->email,
            'password'  => \Hash::make($request->password),
            'status'    => Constants::USER_STATUS_UNVERIFIED,
            'verification_code'   => $verificationCode,
            'verifciation_expiry' => $verificationExp['formatted'],
            'created_at' => $input['current_time']
        ]);

        /**
         * User Created Successfully | E-Mail Verification CODE being Sent
         */
        $email = 'm.taha164@gmail.com';
        $check = Mail::raw("Your user Registration Code is: $verificationCode", function ($message) use($email){
        $message->to($email)->subject('Account Verification Code - User Registration')->from(env('MAIL_FROM'));
        });

        return response()->json([
            'status'    =>  200,
            'success'   =>  true,
            'message'   =>  'User created Successfully',
            'data'      =>  $user
        ], 200);
    }

    /**
     * User Login Method Along with Constant file to change user Status.
     */
    public function login(userLogin $request)
    {
        try {
            $input = $request->all();
            if (!Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'error' => 'Try Again Email/Password is Incorrect'
                ], 400);
            }

            $user       = Auth::user();
            $userModel  = new User();
            $userId     = $user->id;
            $userStatus = $user->status;

            /**
             * Restricting Users via User Status from Constant File (config/Constant.php)
             */
            if ($userStatus == Constants::USER_STATUS_IN_ACTIVE) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'error' => 'User is Inactive'
                ], 400);
            }

            if ($userStatus == Constants::USER_STATUS_UNVERIFIED) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'error' => 'User is Unverified'
                ], 400);
            }

            /**
             * Creating Token for Oauth_access_token ON LOGIN
             */
            DB::beginTransaction();
            $accessTokenModel = new AccessToken();
            $destroyToken = $accessTokenModel->sessionDestroyed($userId);
            $token = $user->createToken('postcrud')->accessToken;
            DB::commit();

            /**
             * User LOGIN Success Response
             */
            $success = array(
                'user_id'  => $userId,
                'username' => $user->name,
                'email'  => $user->email,
                'status' =>  $userStatus
            );
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'logged in successfull',
                'data' => $success
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'error' => ['message' => $exception->getMessage()]
            ], 500);
        }
    }

    /**
     * User : Viewing All user
     */
    public function allUser()
    {
        try {
            $user1 = User::all();

            return response()->json([
                "success" => true,
                "status" => 200,
                "message" => "User fetched successfully",
                "data" => $user1
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $exception
            ], 500);
        }
    }

    // $input = $request->all();
    // $digits = 4;
    // $verificationCode = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    // $verificationExp = Carbon::parse($input['current_time'] == now())->addDays(7);
    // $verificationExp = $verificationExp->toArray();

    // $user = User::create([
    //     'name'      =>  $request->name,
    //     'email'     => $request->email,
    //     'password'  => \Hash::make($request->password),
    //     'status'    => Constants::USER_STATUS_UNVERIFIED,
    //     'verification_code'   => $verificationCode,
    //     'verifciation_expiry' => $verificationExp['formatted'],
    //     'created_at' => $input['current_time']

    public function RequestResetPass(ResetPassword $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $input = $request->all();
            $email = $input['email'];
            $current_time = $input['current_time'];

            $user = User::where('email', $email)->first();
            //If user is not found
            if (!$user) {
                return response()->json([
                    "success" => false,
                    "status" => 400,
                    "error" => 'Please enter a valid Email Address'
                ], 400);
            }

/**
 * Generating Verification Code on Request Reset Password
 */
            $user_id = $user->id;
            $digits = 4;
            $verificationCode = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $verificationExp = Carbon::parse($input['current_time'] == now())->addDays(7);
            $verificationExp = $verificationExp->toArray();
            $resetPwData['verification_code'] = $verificationCode;
            $resetPwData['verifciation_expiry'] = $verificationExp['formatted'];
            $resetPwData['updated_at'] = $current_time;

            $data = $user->updateUser($user_id, $resetPwData);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Error generating verification code'
                ], 400);
            }
                   /**
         * User Created Successfully | E-Mail Verification CODE being Sent
         */
        $email = 'm.taha164@gmail.com';
        $check = Mail::raw("Your user Registration Code is: $verificationCode", function ($message) use($email){
        $message->to($email)->subject('Account Verification Code - User Registration')->from(env('MAIL_FROM'));
        });

            DB::commit();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Verification Code Generated Successfully',
                'data' => $data
            ], 200);

        }
        catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }


    }
}

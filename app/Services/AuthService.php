<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Api\VerificationEmailController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;


class AuthService
{
    public function register(Request $request)
    {          
        $user=User::where('email',$request->email)->first();
        if($user){
            if($user->email_verified_at){
                return response()->json([
                    'status' => 'error',
                    'message' => "email already has been taken",
                ], 409);
            }
            User::where('email',$request->email)->delete();
        }
        
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return app(VerificationEmailController::class)->sendMail($request);
    }
    public function login(Request $request)
    {      
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::user();
            if ($user->email_verified_at) {
                $token = $user->createToken('api-Application')->plainTextToken;
                return $this->respondWithToken($token,$request->rememberMe);
            }
            app(VerificationEmailController::class)->sendMail($request);
            return response()->json([
                'type' => 'verify',
                'status' => 'warning',
                'message' => 'Please verify your email',
                'data' =>$user->id,
            ], 422);//fix the status code to 102 Processing
        } else {
            return response()->json([
                'type' => 'incorrect',
                'status' => 'error',
                'message' => 'Email or password is incorrect',
            ],401);
        }
        
    }

    protected function respondWithToken($token,$rememberMe)
    {
        Session::put('last_activity', now());
        $token =explode("|",$token)[1];
        $cookie = cookie('persistent_token', $token, 60 * 24 * 30);
        return response()->json([
            'status' =>'success',
            'message' => 'logged in successfully',
            'access_token' => Crypt::encryptString($token),
            'data' => Auth::user(),
            'remember me' => $rememberMe,
        ])->withCookie($cookie);
    }
}
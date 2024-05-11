<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verify_email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\verifyEmailResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\verifyingMail;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Api\VerificationEmailController;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','logout','getUserByToken','getEmail','sendMail']]);
    }

    public function register(Request $request)
    {
        $user=DB::table('users')->where('email',$request->email)->first();
        if($user){
            if($user->email_verified_at){
                return response()->json([
                    'status' => 'error',
                    'message' => "email already has been taken",
                ], 200);
            }
            DB::table('users')->where('email',$request->email)->delete();
        }
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if (!$validation) {
            return response()->json($validation->errors(), 202);
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
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $userRecord=User::where('email',$request->email)->first();
        
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                if ($userRecord->email_verified_at) {
                    $user = Auth::user();
                    $token = $user->createToken('api-Application')->plainTextToken;
                    return $this->respondWithToken($token);
                }
                return response()->json([
                    'type' => 'verify',
                    'status' => 'warning',
                    'message' => 'Please verify your email',
                    'data' =>$userRecord->id,
                ], 422);
            } else {
                return response()->json([
                    'type' => 'incorrect',
                    'status' => 'error',
                    'message' => 'Email or password is incorrect',
                ],422);
            }
            

    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    
    public function getUserByToken(Request $request){
        
        $token = \Laravel\Sanctum\PersonalAccessToken::findToken(Crypt::decryptString($request->token));
        $userId = $token->tokenable_id;
        
        return response()->json([
            'message' => 'found User',
            'data' => UserResource::collection(User::all()->where('id', $userId)),
        ]);
    }



    protected function respondWithToken($token)
    {
        $token =explode("|",$token)[1];
        return response()->json([
            'status' =>'success',
            'message' => 'logged in successfully',
            'access_token' => Crypt::encryptString($token),
            'data' => Auth::user(),
        ]);
    }

}

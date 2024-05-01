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


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','logout','getUserByToken','verification','getOTP','sendMail']]);
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
        return $this->sendOTP($user->email,$user->id);

    }

    public function sendOTP(string $email,int $id){
        $OTP=rand(100000, 999999);

        Mail::to($email)
            ->send(new verifyingMail($OTP));

            Verify_email::updateOrCreate(
                ['email' => $email],
                ['OTP' => $OTP, 'userId' => $id]);

            return response()->json([
                'status' => 'warning',
                'message' => 'Please verify your email',
                'data' => $id,
            ], 422);
        // return $this->login($request);
    }
    public function verification(Request $request){
        $validation = $request->validate([
            'OTP' => 'required|digits:6',
        ]);
        $user= Verify_email::where('email',$request->email)->first();

        if($user->OTP == $request->OTP){
            User::where('id',$user->userId)->update(['email_verified_at' => Carbon::now()]);
            return response()->json([
                'status' => 'success',
                'message' => 'Email verifyed successfuly',
                'data' =>$user
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Wrong verification code',
        ], 422);
        
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
                    'status' => 'warning',
                    'message' => 'Please verify your email',
                    'data' =>$userRecord->id,
                ], 422);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email or password is incorrect',
                ]);
            }
            

    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    
    public function getUserByToken(Request $request){
        
        $token = \Laravel\Sanctum\PersonalAccessToken::findToken($request->token);
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
            'access_token' => $token,
            'data' => Auth::user(),
        ]);
    }

    public function getOTP(int $id){
        $user=Verify_email::all()->where('userId',$id);
        return response()->json([
            'status' => 'success',
            'message' => "Please verify your account",
            'data'     =>verifyEmailResource::collection($user),
        ]);
    }

    public function sendMail(Request $request){
        $OTP=rand(100000, 999999);

        Mail::to($request->email)
            ->send(new verifyingMail($OTP));

            $user=Verify_email::updateOrCreate(
                ['email' => $request->email],
                ['OTP' => $OTP, 'userId' => $request->id]);

            return response()->json([
                'status' => 'success',
                'message' => 'we have sent verification code to your email',
                'data' => verifyEmailResource::make($user),
            ]);
    }
}

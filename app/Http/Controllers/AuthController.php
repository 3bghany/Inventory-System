<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Api\VerificationEmailController;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Session;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','logout','getUserByToken','getCurrentUser']]);
        $this->authService = $authService;
    }

    public function register(SignupRequest $request)
    {
        $response=$this->authService->register($request);
        return $response;
    }


    public function login(LoginRequest $request)
    {        
        $response=$this->authService->login($request);
        return $response;
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        // Clear the cookie
        $cookie = Cookie::forget('persistent_token');

        return response()->json([
            'status' =>'success',
            'message' => 'Logged out successfully'
            ])->withCookie($cookie);
    }
    
    public function getUserByToken(Request $request){
        
        $token = \Laravel\Sanctum\PersonalAccessToken::findToken(Crypt::decryptString($request->header('Token')));
        $userId = $token->tokenable_id;
        
        return response()->json([
            'status' =>'success',
            'message' => 'found User',
            'data' => UserResource::collection(User::all()->where('id', $userId)),
        ]);
    }

    public function getCurrentUser(){
        return response()->json([
            'status' =>'success',
            'message' => 'found User',
            'data' => new UserResource(Auth::user()),
        ]);
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

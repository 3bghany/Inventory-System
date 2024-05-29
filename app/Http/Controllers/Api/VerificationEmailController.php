<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\VerifyEmailResource;
use App\Models\User;
use App\Models\VerifyEmail;
use Illuminate\Support\Carbon;
use App\Http\Requests\CheckVCodeRequest;
use App\Services\VerifyEmailService;

class VerificationEmailController extends Controller
{
    protected $verifyEmailService;

    public function __construct(VerifyEmailService $verifyEmailService)
    {
        $this->verifyEmailService = $verifyEmailService;
    }

    public function verification(CheckVCodeRequest $request){

        $user= VerifyEmail::where('email',$request->email)->first();

        if($user->OTP == $request->OTP){
            User::where('id',$user->userId)->update(['email_verified_at' => Carbon::now()]);
            return response()->json([
                'status' => 'success',
                'message' => 'Email verifyed successfuly',
                'data' =>$user
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Wrong verification code',
        ], 400);
        
    }

    public function getEmail(int $id){
        return response()->json([
            'status' => 'success',
            'message' => "Please verify your account",
            'data'     =>VerifyEmailResource::collection(VerifyEmail::all()->where('userId',$id)),
        ]);
    }

    public function sendMail(Request $request){
        
            $verifyUser= $this->verifyEmailService->sendMail($request);

            return response()->json([
                'type' => 'verify',
                'status' => 'success',
                'message' => 'we have sent verification code to your email',
                'data' => new VerifyEmailResource($verifyUser),
            ]);
    }

}

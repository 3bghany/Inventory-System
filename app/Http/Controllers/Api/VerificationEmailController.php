<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\verifyEmailResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\verifyingMail;
use App\Models\User;
use App\Models\Verify_email;
use Illuminate\Support\Carbon;
use DB;

class VerificationEmailController extends Controller
{

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

    public function getEmail(int $id){
        $user=Verify_email::all()->where('userId',$id);
        return response()->json([
            'status' => 'success',
            'message' => "Please verify your account",
            'data'     =>verifyEmailResource::collection($user),
        ]);
    }

    public function sendMail(Request $request){
        $OTP=rand(100000, 999999);

        $user = User::where('email',$request->email)->first();
            Mail::to($request->email)
                ->send(new verifyingMail($OTP,$user->name));

            $verifyUser=Verify_email::updateOrCreate(
                ['email' => $user->email],
                ['OTP' => $OTP, 'userId' => $user->id]);

            return response()->json([
                'type' => 'verify',
                'status' => 'success',
                'message' => 'we have sent verification code to your email',
                'data' => verifyEmailResource::make($verifyUser),
            ]);
    }

}

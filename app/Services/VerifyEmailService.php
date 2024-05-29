<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyingMail;
use App\Models\User;
use App\Models\VerifyEmail;

class VerifyEmailService
{
    
    public function sendMail(Request $request){
        $OTP=rand(100000, 999999);

        $user = User::where('email',$request->email)->first();
            Mail::to($request->email)
                ->send(new VerifyingMail($OTP,$user->name));

        $verifyUser=VerifyEmail::updateOrCreate(
            ['email' => $user->email],
            ['OTP' => $OTP, 'userId' => $user->id]);

        return $verifyUser;
    }

}
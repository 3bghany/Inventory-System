<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileService
{
    public function updateProfile(User $profile,Request $request){
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user->save();

        return $user;
    }
}
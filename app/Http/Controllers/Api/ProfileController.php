<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use DB;

class ProfileController extends Controller
{
    public function updateProfile(Request $request, string $id){
        $validation = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|digits:11',
        ]);
        $user = User::find($id);


        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user->save();

        if($user->wasChanged()){
            return response()->json([
                'status' => 'success',
                'message' => 'employee updated successfully',
                'data' => UserResource::collection(User::all()->where('id',$id)),
            ]);
            }
            return response()->json([
                'status' => 'warning',
                'message' => "you didn't apply any changes",
                'data' => 'null',
            ]);
    }   
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\Base64ImageDecoder;
use App\Http\Resources\UserResource;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All Users viewed successfully',
            'data' => UserResource::collection(User::all()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(User::find($id)){
            return response()->json([
                'status' => 'success',
                'message' => 'user viewed successfully',
                'data' => UserResource::collection(User::all()->where('id',$id)),
            ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => 'No such record to show',
            'data' => UserResource::collection(User::all()->where('id',$id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'phone'=>'nullable|digits_between:10,15',
            'email'=>'required|email|unique:users,email,'.$id,
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user->save();

        if($user->wasChanged()){
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => UserResource::collection(User::all()->where('id',$id)),
        ]);
        }
        return response()->json([
            'status' => 'warning',
            'message' => "No Changes applied",
            'data' => UserResource::collection(User::all()->where('id',$id)),
        ]);

    }

}

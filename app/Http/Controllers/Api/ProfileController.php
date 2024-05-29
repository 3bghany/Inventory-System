<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateProfileRequest;

use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function updateProfile(UpdateProfileRequest $request, string $id){

        $user = User::findOrFail($id);
        $updatedUser= $this->profileService->updateProfile($user,$request);

        if($updatedUser->wasChanged()){
            return response()->json([
                'status' => 'success',
                'message' => 'profile updated successfully',
                'data' => new UserResource($updatedUser),
            ]);
            }
            return response()->json([
                'status' => 'warning',
                'message' => "you didn't apply any changes",
                'data' => new UserResource($updatedUser),
            ]);
    }   
}

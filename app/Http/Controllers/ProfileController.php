<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function showProfile()
    {
        // return Auth::user()->load('role');
        return User::with('role')->find(Auth::id());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only([
            'first_name',
            'last_name',
        ]));
        return $user . " Update Successfully";
    }

    /**
     * Update the specified resource in storage.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:2|confirmed',
            'current_password' => 'required|string|min:2',
        ]);
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.'
            ], 400);
        }


        $user->update([
            'password' => Hash::make($request->input(('password'))),
        ]);

        return $user . " Password Update Successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyProfile(string $id)
    {
        $user = Auth::user();
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });
        User::destroy($user->id);
    }
}
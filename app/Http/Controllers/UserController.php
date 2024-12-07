<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return response()->json($users);
    }
    public function create()
    {
        return response()->json([
            'message' => 'Hello, World from create!',
        ]);
    }
    public function store(UserRequest $request)
    {
        // dd($request->all());
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    public function edit(string $id)
    {
        return response()->json([
            'message' => 'Hello, World from edit!',
        ]);
    }
    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        return response($user, Response::HTTP_CREATED);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        User::destroy($id);
        return response()->json([
            'user' => $user,
            'message' => 'delete successfully!',
        ]);
    }

    public function profile()
    {
        return Auth::user();
    }
    public function updateProfile(UserRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only([
            'first_name',
            'last_name',
            'email',
        ]));

        return response()->json([
            'user' => $user,
            'message' => 'Update Profile successfully!',
        ]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:2|confirmed',
        ]);

        $user = Auth::user();
        $user->update(([
            'password' => Hash::make($request->input(('password'))),
        ]));

        return response()->json([
            'user' => $user,
            'message' => 'Update Password successfully!',
        ]);
    }
    public function destroyProfile(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        User::destroy($id);

        return response()->json([
            'user' => $user,
            'message' => 'Delete User successfully!',
        ]);
    }
}

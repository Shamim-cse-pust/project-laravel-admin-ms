<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        Gate::authorize('view', 'users');
        $users = User::paginate(5);
        return UserResource::collection($users);
    }
    public function create()
    {
        return response()->json([
            'message' => 'Hello, World from create!',
        ]);
    }
    public function store(UserRequest $request)
    {
        Gate::authorize('edit', 'users');
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('1234'),
            'role_id' => $request->role_id,
        ]);
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        Gate::authorize('view', 'users');
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
        Gate::authorize('view', 'users');
        $user = User::find($id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);
        return response($user, Response::HTTP_CREATED);
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        Gate::authorize('edit', 'users');
        $user = User::find($id);
        User::destroy($id);
        return response()->json([
            'user' => $user,
            'message' => 'delete successfully!',
        ]);
    }
}

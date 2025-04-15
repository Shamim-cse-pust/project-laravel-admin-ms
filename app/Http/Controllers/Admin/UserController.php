<?php

namespace App\Http\Controllers\Admin;

use Cache;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\AdminAddedEvent;
use App\Http\Requests\UserRequest;
use App\Events\UserCacheFlushEvent;
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
        return Cache::remember('users', (20 * 60), function () {
            sleep(2);
            return UserResource::collection(User::paginate(50));
        });
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
            'is_influencer' => $request->is_influencer,
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id ? $request->role_id : 3,
        ]);
        event(new AdminAddedEvent($user));
        event(new UserCacheFlushEvent());

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        Gate::authorize('view', 'users');
        return response()->json([
            'user' => new UserResource($user),
        ]);
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
        ]);
        UserRole::where('user_id', $id)->delete();
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
        ]);

        event(new UserCacheFlushEvent());

        return response($user, Response::HTTP_CREATED);
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        Gate::authorize('edit', 'users');
        $user = User::find($id);
        User::destroy($id);
        event(new UserCacheFlushEvent());
        return response()->json([
            'user' => $user,
            'message' => 'delete successfully!',
        ]);
    }
}

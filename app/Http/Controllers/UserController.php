<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json($users);
    }
    public function create(){
        return response()->json([
            'message' => 'Hello, World from create!',
        ]);
    }
    public function store(Request $request){
        // dd($request->all());
       $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:3',
       ]);
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
        ]);    }
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        // dd($user);
        // dd($request->all());
       $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:3',
       ]);
       $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
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
}

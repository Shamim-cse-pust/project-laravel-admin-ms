<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'message' => 'Hello, World from index!',
        ]);
    }
    public function hello(Request $request){
        return response()->json([
            'message' => 'Hello, World! from hello',
        ]);
    }
}

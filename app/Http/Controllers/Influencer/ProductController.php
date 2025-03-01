<?php

namespace App\Http\Controllers\Influencer;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();
        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            $query->where('id', $searchTerm) // Exact match for ID
                  ->orWhere('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('slug', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('price', 'LIKE', "%{$searchTerm}%");
        }

        $products = $query->get();

        return response()->json([
            'data' => $products
        ]);
    }
}

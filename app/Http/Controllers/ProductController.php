<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $cacheExpiration = 300;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json(ProductResource::collection($products));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $time = time();
        $imageName = 'product_image_' . $time . '.' . $extension;
        $imagePath = $request->file('image')->storeAs('images/products', $imageName, 'public');
        $imagePath = '/storage/' . $imagePath;

        $product = Product::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
        ]);

        return $product . " Created Successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find(($id));
        $product = new ProductResource($product);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find(($id));
        if ($product->image) {
            $path = public_path($product->image);
            unlink($path);
        }

        if ($request->image) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $time = time();
            $imageName = 'product_image_' . $time . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/products', $imageName, 'public');
            $imagePath = '/storage/' . $imagePath;
        } else {
            $imagePath = null;
        }
        $product->Update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Product Update Successfully",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => "id not exist",
            ]);
        }
        Product::destroy($id);
        return response()->json([
            'message' => "ID " . $id . " Delete successfully",
        ]);
    }
}

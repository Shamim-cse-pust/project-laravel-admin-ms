<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
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
        $imageNumber = Product::count() + 1;
        $imageName = 'product_image' . $imageNumber . '.' . $extension;
        $imagePath = $request->file('image')->storeAs('images/products', $imageName, 'public');
        // dd(vars: $imagePath);

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
        // dd(new ProductResource($product));
        $product = new ProductResource($product);
        // dd($product->image);
        return view('welcome', ['product' => $product]);
        return view('welcome', compact(response()->json(new ProductResource($product))));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Image</title>
</head>
<body>
    <h1>Product Image</h1>
    {{-- <img src="{{ asset('/image/products/default_product.jpeg') }}" alt="Product18 Image"> --}}
    {{-- <img src="{{ asset({{$product->image}}) }}" alt="Product Image"> --}}
    <h1>{{$product->image}}</h1>
    <img src="{{ asset($product->image) }}" alt="Product Image">


</body>
</html>

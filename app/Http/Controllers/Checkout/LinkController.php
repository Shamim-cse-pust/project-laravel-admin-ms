<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    public function show($code)
    {
        $link = Link::where('code', $code)->first();

        if (!$link) {
            return response()->json(['message' => 'Link not found'], 404);
        }

        return new LinkResource($link);
    }
}

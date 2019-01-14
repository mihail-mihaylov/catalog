<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::where('user_id', auth()->id())->get());
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:products|min:2|max:20',
            'description' => 'required',
            'price' => 'regex:/^\d*(\.\d{2})?$/',
            'active' => 'boolean',
        ]);
        $data = array_merge($request->all(),['user_id' => auth()->user()->id]);
        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->userHaveAccessTo($product) ? response()->json($product, 200) : response()->json(null, 203);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:products|min:2|max:20',
            'description' => 'required',
            'price' => 'regex:/^\d*(\.\d{2})?$/',
            'active' => 'boolean',
        ]);

        $product->update($request->all());

        return $this->userHaveAccessTo($product) ? response()->json($product, 200) : response()->json(null, 203);
    }

    public function delete(Product $product): JsonResponse
    {
        $product->delete();

        return $this->userHaveAccessTo($product) ? response()->json(null, 204) : response()->json(null, 203);
    }

    public function userHaveAccessTo(Product $product): bool
    {
        return $product->getUserId() === auth()->id();
    }
}

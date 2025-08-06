<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    //
    public function showView():View|RedirectResponse{
        return view('owner.products');
    }
    /**
     * Handle the request to add a new product.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addProduct(Request $request): JsonResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'perishable_status' => 'required|in:0,1',
        ]);
        
        $product = Products::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'perishable_status' => (bool)$validated['perishable_status'],
        ]);
        
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'perishable_status' => $product->perishable_status
        ], 201);
    }
}

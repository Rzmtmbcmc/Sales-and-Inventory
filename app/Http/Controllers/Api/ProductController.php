<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search and filters
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Search by product name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by perishable status
        if ($request->filled('perishable')) {
            $query->perishable($request->perishable);
        }

        // Filter by stock level
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'low':
                    $query->lowStock();//method name is scopeLowStock() in the Product model
                    break;
                case 'out':
                    $query->outOfStock();//method name is scopeOutOfStock() in the Product model
                    break;
            }
        }

        // Order by name
        $query->orderBy('name', 'asc');

        // Pagination
        $perPage = $request->get('per_page', 10);
        $products = $query->paginate($perPage);

        return response()->json($products);
    }

      public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'data' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->fresh()
        ]);
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get product statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_products' => Product::count(),
            'total_quantity' => Product::sum('quantity'),
            'perishable_products' => Product::perishable('yes')->count(),
            'low_stock_products' => Product::lowStock()->count(),
            'out_of_stock_products' => Product::outOfStock()->count(),
            'average_price' => Product::avg('price')
        ];

        return response()->json($stats);
    }
}
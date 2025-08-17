<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

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
    public function checkstock($id){
        $product = Products::find($id);
        if($product::where('id',$id)->quantity == 0){
            $product->delete();
            return true;
        }
        return false;
    }
public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Get all products for dropdowns if 'all' parameter is present
        if ($request->has('all')) {
            $products = $query->get(['id', 'name']);
            return response()->json($products);
        }
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

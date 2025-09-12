<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Product;
use App\Models\PastOrder;
use Illuminate\Http\Request;
use App\Models\PastOrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get analytics data for the dashboard.
     */
    public function analytics(Request $request): JsonResponse
    {
        try {
            $year = $request->get('year', Carbon::now()->year);

            // Start with a base query on PastOrder that applies year filter
            $baseQuery = PastOrder::query()->whereYear('created_at', $year);

            // Apply brand and branch filters
            if ($request->filled('brand_id')) {
                $baseQuery->where('brand_id', $request->brand_id);
            }
            if ($request->filled('branch_id')) {
                $baseQuery->where('branch_id', $request->branch_id);
            }
            if ($request->filled('product_id')) {
                $baseQuery->whereHas('items', function ($q) use ($request) {
                    $q->where('product_id', $request->product_id);
                });
            }

            // Get the filtered orders to be used for all calculations
            $filteredOrders = $baseQuery->get();

            // Calculate totals from the filtered orders
            $totalSalesThisYear = $filteredOrders->sum('total_amount');
            $totalOrdersThisYear = $filteredOrders->count();

            // Calculate monthly totals for the graph
            $graphData = $filteredOrders->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('M');
            })->map(function ($group) {
                return $group->sum('total_amount');
            });

            // Calculate most orders and total sales for the current month from filtered orders
            $mostOrdersThisMonth = $filteredOrders
                ->filter(function ($order) {
                    return Carbon::parse($order->created_at)->month === Carbon::now()->month;
                })
                ->count();
            
            $totalSalesThisMonth = $filteredOrders
                ->filter(function ($order) {
                    return Carbon::parse($order->created_at)->month === Carbon::now()->month;
                })
                ->sum('total_amount');
            
            // Find the top and bottom products based on the filtered orders' IDs
            $pastOrderIds = $filteredOrders->pluck('id');

            
            // Find top 10 products
            $top10Products = PastOrderItem::select('past_order_items.product_id', DB::raw('SUM(past_order_items.quantity) as total_quantity_sold'), 'products.name')
                ->join('products', 'past_order_items.product_id', '=', 'products.id')
                ->whereIn('past_order_id', $pastOrderIds)
                ->groupBy('past_order_items.product_id', 'products.name')
                ->orderByDesc('total_quantity_sold')
                ->take(10)
                ->get();

            // Find bottom 10 products
            $bottom10Products = PastOrderItem::select('past_order_items.product_id', DB::raw('SUM(past_order_items.quantity) as total_quantity_sold'), 'products.name')
                ->join('products', 'past_order_items.product_id', '=', 'products.id')
                ->whereIn('past_order_id', $pastOrderIds)
                ->groupBy('past_order_items.product_id', 'products.name')
                ->orderBy('total_quantity_sold')
                ->take(10)
                ->get();
            
                $productSales = PastOrderItem::select('past_order_items.product_id', DB::raw('SUM(past_order_items.quantity * price) as total_sales'))
                ->whereIn('past_order_id', $pastOrderIds)
                ->with('product:id,name')
                ->groupBy('product_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->product->name => $item->total_sales];
                });
            return response()->json([
                'success' => true,
                'product_sales' => $productSales,
                'graph_data' => $graphData,
                'rankings' => [
                    'top_10_products' => $top10Products,
                    'bottom_10_products' => $bottom10Products,
                    'most_orders_this_month' => $mostOrdersThisMonth,
                    'total_sales_this_month' => $totalSalesThisMonth,
                    'total_orders_this_year' => $totalOrdersThisYear,
                    'total_sales_this_year' => $totalSalesThisYear,
                ],
                'filters' => [
                    'brands' => Brand::all(),
                    'branches' => Branch::all(),
                    'products' => Product::all(['id', 'name']),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve analytics: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showView()
    {
        if (!Auth::check()) {
            return redirect()->route('Login');
        }
        return view('owner.dashboard');
    }
}
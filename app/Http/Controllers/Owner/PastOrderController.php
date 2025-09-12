<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PastOrder;
use Illuminate\Support\Facades\Auth;

class PastOrderController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('homepage');
        }

        $this->authorize('viewAny', PastOrder::class);

        $query = PastOrder::with(['items.product', 'brand', 'branch']);

        // Filters
        $search = request()->input('search');
        $startDate = request()->input('start_date');
        $endDate = request()->input('end_date');
        $branchSearch = request()->input('branch_search');
        $brandSearch = request()->input('brand_search');
        $sortDirection = request()->input('sort_direction', 'desc');
        $sortBy = 'created_at';

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhereHas('brand', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%") ;
                  })
                  ->orWhereHas('branch', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%") ;
                  });
            });
        }
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        if ($branchSearch) {
            $query->whereHas('branch', function ($q) use ($branchSearch) {
                $q->where('name', 'like', "%$branchSearch%") ;
            });
        }
        if ($brandSearch) {
            $query->whereHas('brand', function ($q) use ($brandSearch) {
                $q->where('name', 'like', "%$brandSearch%") ;
            });
        }
        $query->orderBy($sortBy, $sortDirection);

        $pastOrders = $query->paginate(15);

        // KPI Stats
        $stats = [
            'total_orders' => PastOrder::count(),
            'total_amount' => PastOrder::sum('total_amount'),
            'orders_today' => PastOrder::whereDate('created_at', now()->toDateString())->count(),
            'orders_this_month' => PastOrder::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        // Pagination info for blade
        $showingStart = ($pastOrders->currentPage() - 1) * $pastOrders->perPage() + 1;
        $showingEnd = $showingStart + $pastOrders->count() - 1;
        $totalEntries = $pastOrders->total();

        return view('owner.past-orders', compact('pastOrders', 'stats', 'showingStart', 'showingEnd', 'totalEntries'));
    }

    public function destroy(PastOrder $pastOrder)
    {
        $this->authorize('delete', $pastOrder);

        $pastOrder->delete();

        return redirect()->route('owner.past-orders')
                        ->with('success', 'Past order deleted successfully.');
    }

    public function show(PastOrder $pastOrder)
    {
        if (!Auth::check()) {
            return redirect()->route('homepage');
        }

        $this->authorize('view', $pastOrder);

        $pastOrder = PastOrder::with(['items.product', 'brand', 'branch'])->findOrFail($pastOrder->id);

        return view('owner.past-orders.show', compact('pastOrder'));
    }
}
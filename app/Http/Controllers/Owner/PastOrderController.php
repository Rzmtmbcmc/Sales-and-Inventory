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

        $sortBy = request()->input('sort_by', 'created_at');
        $sortDirection = request()->input('sort_direction', 'desc');

        if (in_array($sortDirection, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $pastOrders = $query->paginate(15);

        return view('owner.past-orders', compact('pastOrders'));
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
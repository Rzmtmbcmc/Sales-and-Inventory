<?php

namespace App\Http\Controllers;

use App\Models\RejectedGood;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;

class RejectedGoodsController extends Controller
{
    public function index()
    {
        $rejectedGoods = RejectedGood::with(['brand', 'branch', 'items.product'])->paginate(10);
        return view('owner.rejected-goods.index', compact('rejectedGoods'));
    }

    public function create()
    {
        $brands = Brand::all();
        $branches = Branch::all();
        $products = Product::select('id', 'name', 'price')->get();
        return view('owner.rejected-goods.create', compact('brands', 'branches', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'brand_id' => 'required|exists:brands,id',
            'branch_id' => 'required|exists:branches,id',
            'dr_no' => 'required|unique:rejected_goods',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'product_items.*.product_id' => 'required|exists:products,id',
            'product_items.*.quantity' => 'required|integer|min:1',
        ]);

        $rejectedGood = RejectedGood::create($validated);

        foreach ($validated['product_items'] as $item) {
            $rejectedGood->items()->create($item);
        }

        return redirect()->route('owner.rejected-goods.index')->with('success', 'Rejected good created successfully.');
    }

    public function show(RejectedGood $rejectedGood)
    {
        $this->authorize('view', $rejectedGood);
        $rejectedGood->load(['brand', 'branch', 'items.product']);
        return view('owner.rejected-goods.show', compact('rejectedGood'));
    }

    public function edit(RejectedGood $rejectedGood)
    {
        $this->authorize('update', $rejectedGood);
        $brands = Brand::all();
        $branches = Branch::all();
        return view('owner.rejected-goods.edit', compact('rejectedGood', 'brands', 'branches'));
    }

    public function update(Request $request, RejectedGood $rejectedGood)
    {
        $this->authorize('update', $rejectedGood);

        $validated = $request->validate([
            'date' => 'required|date',
            'brand_id' => 'required|exists:brands,id',
            'branch_id' => 'required|exists:branches,id',
            'dr_no' => 'required|unique:rejected_goods,dr_no,' . $rejectedGood->id,
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'product_items.*.product_id' => 'required|exists:products,id',
            'product_items.*.quantity' => 'required|integer|min:1',
        ]);

        $rejectedGood->update($validated);

        $rejectedGood->items()->delete();
        foreach ($validated['product_items'] as $item) {
            $rejectedGood->items()->create($item);
        }

        return redirect()->route('owner.rejected-goods.index')->with('success', 'Rejected good updated successfully.');
    }

    public function destroy(RejectedGood $rejectedGood)
    {
        $this->authorize('delete', $rejectedGood);
        $rejectedGood->delete();
        return redirect()->route('owner.rejected-goods.index')->with('success', 'Rejected good deleted successfully.');
    }
}
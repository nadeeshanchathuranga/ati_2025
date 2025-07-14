<?php

namespace App\Http\Controllers;
use App\Models\Fertilizer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class FertilizerController extends Controller
{
    public function index()
    {
        $fertilizers = Fertilizer::latest()->get();
        return view('fertilizers.index', compact('fertilizers'));
    }

    public function create()
    {
        return view('fertilizers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        Fertilizer::create($request->all());

        return redirect()->route('fertilizers.index')->with('success', 'Fertilizer created successfully.');
    }

    public function edit(Fertilizer $fertilizer)
    {
        return view('fertilizers.edit', compact('fertilizer'));
    }

    public function update(Request $request, Fertilizer $fertilizer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $fertilizer->update($request->all());

        return redirect()->route('fertilizers.index')->with('success', 'Fertilizer updated successfully.');
    }




 public function destroy($id)
{
    $fertilizer = Fertilizer::findOrFail($id);

    // Set status to 'inactive' instead of deleting
    $fertilizer->status = 'inactive';
    $fertilizer->save();

    return redirect()->back()->with('success', 'Fertilizer marked as inactive successfully.');
}

public function fertilizerSale()
{
    $suppliers = Supplier::with(['tea', 'supplierTeaStock'])
        ->whereHas('supplierTeaStock') // Only get suppliers with tea stock
        ->orderByRaw("FIELD(status, 'active', 'inactive')")
        ->get();

    // Calculate income for each supplier
    $suppliers->each(function ($supplier) {
        $totalGrams = $supplier->supplierTeaStock->sum('tea_weight');
        $pricePerGram = $supplier->tea->buy_price ?? 0;
        $supplier->calculated_income = $totalGrams * $pricePerGram;
    });

    return view('fertilizers.sale', compact('suppliers'));
}


}

<?php

namespace App\Http\Controllers;
use App\Models\Fertilizer;
use App\Models\Supplier;
use App\Models\FertilizerSale;
use App\Models\FertilizerSaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // Toggle status
    $fertilizer->status = $fertilizer->status === 'active' ? 'inactive' : 'active';
    $fertilizer->save();

    return redirect()->back()->with('success', 'Fertilizer status updated successfully.');
}


public function fertilizerSale()
{
    $suppliers = Supplier::with(['tea', 'supplierTeaStock'])->get();
    $fertilizers = Fertilizer::where('status','active')->get();



    return view('fertilizers.sale', compact('suppliers','fertilizers'));
}



public function fertilizerSaleView()
{
    $sales = FertilizerSale::with(['supplier', 'items.fertilizer'])
        ->latest()
        ->get()
        ->groupBy('supplier_id'); // ✅ Group by supplier_id

    return view('fertilizers.fertilizer_view', compact('sales'));
}


public function fertilizerSaleStore(Request $request)
{
    $request->validate([
        'supplier_id'     => 'required|exists:suppliers,id',
        'supplier_income' => 'required|numeric|min:0',
        'total_cost'      => 'required|numeric|min:0',
        'fertilizers'     => 'required|array',
    ]);

    // Calculate total from fertilizers
    $calculatedTotal = 0;

    foreach ($request->fertilizers as $fertilizerId => $data) {
        if (!isset($data['selected'])) continue;

        $grams = floatval($data['grams'] ?? 0);
        if ($grams <= 0) continue;

        $fertilizer = Fertilizer::findOrFail($fertilizerId);
        $price = $fertilizer->price;
        $calculatedTotal += $grams * $price;

        if ($grams > $fertilizer->stock) {
            return back()->with('error', "Not enough stock for {$fertilizer->name}.");
        }
    }

    if ($calculatedTotal > $request->supplier_income) {
        return back()->with('error', 'Total cost exceeds supplier income.');
    }

    try {
        DB::beginTransaction();

        // Create the fertilizer sale
        $sale = FertilizerSale::create([
            'supplier_id'     => $request->supplier_id,
            'supplier_income' => $request->supplier_income,
            'total_cost'      => $calculatedTotal,
        ]);

        // Deduct the total cost from supplier's tea income
        $supplier = Supplier::findOrFail($request->supplier_id);
        $supplier->tea_income -= $calculatedTotal;
        $supplier->save();

        // Create sale items and update fertilizer stock
        foreach ($request->fertilizers as $fertilizerId => $data) {
            if (!isset($data['selected'])) continue;

            $grams = floatval($data['grams'] ?? 0);
            if ($grams <= 0) continue;

            $fertilizer = Fertilizer::findOrFail($fertilizerId);
            $unitPrice = $fertilizer->price;
            $lineTotal = $grams * $unitPrice;

            FertilizerSaleItem::create([
                'fertilizer_sale_id' => $sale->id,
                'fertilizer_id'      => $fertilizerId,
                'quantity_grams'     => $grams,
                'unit_price'         => $unitPrice,
                'line_total'         => $lineTotal,
            ]);

            // Decrement stock
            $fertilizer->decrement('stock', $grams);
        }

        DB::commit();

        return redirect()->route('fertilizers_sale')->with('success', 'Fertilizer sale recorded successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}









}

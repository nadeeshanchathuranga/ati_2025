<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Models\Tea;
use App\Models\SupplierTeaStock;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
   public function index()
{
    // Update tea_income_completed to 1 where tea_income is 0
    Supplier::where('tea_income', 0)
        ->where('tea_income_completed', 0) // prevent unnecessary writes
        ->update(['tea_income_completed' => 1]);

    // Fetch suppliers with related data
    $suppliers = Supplier::with('tea', 'supplierTeaStock')
        ->orderByRaw("FIELD(status, 'active', 'inactive')")
        ->get();

    return view('suppliers.index', compact('suppliers'));
}

   public function create()
{
    $teas = Tea::where('status', 1)->get();

    // Generate a unique Register ID, e.g., "REG-0001", "REG-0002"
    $latestSupplier = Supplier::latest()->first();
    $nextId = $latestSupplier ? $latestSupplier->id + 1 : 1;
    $generatedRegisterId = 'REG-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    return view('suppliers.create', compact('teas', 'generatedRegisterId'));
}


   public function teaStockForm()
{
       $suppliers = Supplier::where('status','active')->get();
    return view('suppliers.tea_stock_form', compact('suppliers'));
}

public function getTeaStock(Supplier $supplier)
{
    return response()->json($supplier->supplierTeaStock()->orderByDesc('date')->get());
}


public function store(Request $request)
{


    $request->validate([
        'tea_id' => 'required|exists:teas,id',
        'register_id' => 'required|string|unique:suppliers,register_id',
        'supplier_name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'phone_number' => [
            'required',
            'regex:/^\d{10}$/',
        ],


    ], [
        'phone_number.regex' => 'Phone number must be exactly 10 digits.',
    ]);

    Supplier::create([
        'tea_id' => $request->tea_id,
        'register_id' => $request->register_id,
        'supplier_name' => $request->supplier_name,
        'address' => $request->address,
        'phone_number' => $request->phone_number,

        'status' => '1',
    ]);

    return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
}


 public function teaStock(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'tea_weight'  => 'required|numeric|min:1',
        'date'        => 'required|date',
    ]);

    // Get the supplier
    $supplier = Supplier::find($request->supplier_id);

    if (!$supplier) {
        return redirect()->back()->withErrors('Supplier not found.');
    }

    // Get the tea record
    $tea = Tea::find($supplier->tea_id);

    if (!$tea) {
        return redirect()->back()->withErrors('Tea not found for this supplier.');
    }

    // Calculate total cost for this stock
    $teaCost = $tea->buy_price * $request->tea_weight;



    // Update tea total weight
    $tea->total_weight += $request->tea_weight;
    $tea->save();

    // Update supplier's tea_income
    $supplier->tea_income += $teaCost;
    $supplier->save();

    // Create the stock record
    SupplierTeaStock::create([
        'supplier_id' => $supplier->id,
        'tea_weight'  => $request->tea_weight,
        'date'        => $request->date,
    ]);

    return redirect()->route('suppliers.index')->with('success', 'Tea stock added successfully.');
}


public function showDetails($id)
{
    $supplier = Supplier::with(['tea', 'supplierTeaStock'])->findOrFail($id);
    return response()->json($supplier);
}



    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
       $teas = Tea::where('status', 1)->get();
         $suppliers = Supplier::with('tea')->get();
        return view('suppliers.edit', compact('supplier', 'teas'));
    }


public function update(Request $request, Supplier $supplier)
{
    $request->validate([
        'tea_id' => 'required|exists:teas,id',
        'register_id' => 'required|string|max:20',
        'supplier_name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'phone_number' => [
            'required',
            'regex:/^\d{10}$/'
        ],


    ], [
        'phone_number.regex' => 'Phone number must be exactly 10 digits.',
    ]);

    // Update only the necessary fields
    $supplier->update([
        'tea_id' => $request->tea_id,
        'register_id' => $request->register_id,
        'supplier_name' => $request->supplier_name,
        'address' => $request->address,
        'phone_number' => $request->phone_number,

        'status' => '1',
    ]);

    return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
}

    /**
     * Instead of deleting, change status to inactive/active
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->status = $supplier->status === 'active' ? 'inactive' : 'active';
        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', 'Supplier status updated.');
    }




public function processTeaIncome(Request $request)
{

  
    $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'amount' => 'required|numeric|min:1',
    ]);

    $supplier = Supplier::findOrFail($request->supplier_id);

    // Deduct payment
    $supplier->tea_income -= $request->amount;

    // If fully paid, mark as completed
    if ($supplier->tea_income <= 0) {
        $supplier->tea_income = 0;
        $supplier->tea_income_completed = 1;
    }

    $supplier->save();

    return redirect()->route('suppliers.index')->with('success', 'Payment processed successfully!');
}


}

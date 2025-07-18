<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\Tea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function index()
    {



        $sales = Sale::with('customer', 'items')->latest()->get();
        return view('sales.index', compact('sales'));
    }

   public function create()
{
    $teas = Tea::with('suppliers.supplierTeaStock')->where('status', '1')->get();


    $customers = Customer::all();
    return view('sales.create', compact('customers', 'teas'));
}




public function receipt($id)
{
    $sale = Sale::with(['customer', 'items.tea'])->findOrFail($id);
    return view('sales.receipt', compact('sale'));
}



public function store(Request $request)
{
    try {
        // Validate base fields
        $validatedData = $request->validate([
            'customer_id' => 'nullable|integer|exists:customers,id',
            'customer.name' => 'nullable|string|max:255',
            'customer.email' => 'nullable|email|max:255',
            'customer.phone' => 'nullable|string|max:20',
            'customer.address' => 'nullable|string|max:255',
            'total_cost' => 'required|numeric|min:0',
            'cash' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.tea_grade' => 'required|string',
            'items.*.weight' => 'required|numeric|min:0.1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.item_total' => 'required|numeric|min:0',
            'items.*.date' => 'required|date',
            'items.*.buy_price' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'balance' => 'required|numeric'
        ]);

        // Extra check for cash vs total
        if ($validatedData['cash'] < $validatedData['total_cost']) {
            return response()->json([
                'success' => false,
                'message' => 'Cash amount is less than total cost'
            ], 422);
        }

        DB::beginTransaction();

        // Handle customer creation or fetch
        $customerId = $validatedData['customer_id'];

        if (!$customerId && isset($validatedData['customer']['name'])) {
            $customer = Customer::create([
                'name' => $validatedData['customer']['name'],
                'email' => $validatedData['customer']['email'] ?? null,
                'phone' => $validatedData['customer']['phone'] ?? null,
                'address' => $validatedData['customer']['address'] ?? null,
            ]);

            $customerId = $customer->id;
        }

        // Create Sale
        $sale = Sale::create([
            'customer_id' => $customerId,
            'total_cost' => $validatedData['total_cost'],
            'cash' => $validatedData['cash'],
            'discount' => $validatedData['discount'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $processedItems = [];

        foreach ($validatedData['items'] as $item) {
            $tea = Tea::where('tea_grade', $item['tea_grade'])
                      ->whereDate('date', $item['date'])
                      ->lockForUpdate()
                      ->first();

            if (!$tea) {
                throw new \Exception("Tea grade '{$item['tea_grade']}' not found for date '{$item['date']}'");
            }

            $requestedWeight = round($item['weight'], 2);
            $availableWeight = round($tea->total_weight, 2);

            if ($availableWeight < $requestedWeight) {
                throw new \Exception("Insufficient quantity for {$item['tea_grade']}. Available: {$availableWeight}g, Requested: {$requestedWeight}g");
            }

            SaleItem::create([
                'sales_id' => $sale->id,
                'tea_id' => $tea->id,
                'quantity' => $requestedWeight,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Reduce stock
            $tea->reduceStock($requestedWeight);

            $processedItems[] = [
                'tea_grade' => $item['tea_grade'],
                'weight' => $requestedWeight,
                'unit_price' => $item['unit_price'],
                'item_total' => $item['item_total'],
                'remaining_weight' => $tea->total_weight
            ];
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Sale completed successfully',
            'data' => [
                'sale_id' => $sale->id,
                'customer_id' => $customerId,
                'total_amount' => $sale->total_cost,
                'cash_received' => $sale->cash,
                'discount_applied' => $sale->discount,
                'balance' => $validatedData['balance'],
                'payment_method' => $validatedData['payment_method'],
                'items_count' => count($processedItems),
                'items' => $processedItems,
                'created_at' => $sale->created_at->format('Y-m-d H:i:s')
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Sale creation failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }



}





}

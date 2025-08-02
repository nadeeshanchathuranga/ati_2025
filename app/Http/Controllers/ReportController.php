<?php

namespace App\Http\Controllers;
use App\Models\Tea;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{



    public function index(Request $request)
{
    // Get all suppliers for dropdown
    $suppliers = Supplier::select('id', 'supplier_name')->get();

    $query = DB::table('supplier_tea_stock')
        ->join('suppliers', 'supplier_tea_stock.supplier_id', '=', 'suppliers.id')
        ->join('teas', 'suppliers.tea_id', '=', 'teas.id')
        ->select(
            DB::raw('DATE(supplier_tea_stock.date) as collect_date'),
            'suppliers.supplier_name',
            'suppliers.phone_number',
            'teas.tea_grade',
            'teas.buy_price',
            'teas.selling_price',
            'supplier_tea_stock.tea_weight',
            'supplier_tea_stock.supplier_id' // Add this for reference
        );

    // Date filter
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('supplier_tea_stock.date', [$request->from, $request->to]);
    }

    // Supplier filter - Updated to use supplier_tea_stock.supplier_id
    if ($request->filled('supplier_id')) {
        $query->where('supplier_tea_stock.supplier_id', $request->supplier_id);
    }

    $data = $query->orderBy('supplier_tea_stock.date', 'ASC')->get();

    return view('reports.index', compact('data', 'suppliers'));
}

}



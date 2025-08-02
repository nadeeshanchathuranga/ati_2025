@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="row">
    <div class="col-lg-6 text-start">
        <a href="{{ route('dashboard') }}" class="btn btn-warning back-btn px-4 py-2 rounded-3">
            Home
        </a>
    </div>
</div>

    <h1 class="h1-font text-center mb-4">Supplier Tea Collection Full Report</h1>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="from" class="form-label">From Date</label>
            <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <label for="to" class="form-label">To Date</label>
            <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
        </div>
        {{-- Added Supplier Filter Dropdown --}}
        <div class="col-md-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-control">
                <option value="">All Suppliers</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->supplier_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Summary Section --}}
    @if($data->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Summary</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <strong>Total Records:</strong> {{ $data->count() }}
                        </div>
                        <div class="col-md-2">
                            <strong>Total Weight:</strong> {{ number_format($data->sum('tea_weight'), 2) }} kg
                        </div>
                        <div class="col-md-3">
                            <strong>Total Buy Value:</strong> {{ number_format($data->sum(function($item) { return $item->buy_price * $item->tea_weight; }), 2) }}
                        </div>
                        <div class="col-md-3">
                            <strong>Total Sell Value:</strong> {{ number_format($data->sum(function($item) { return $item->selling_price * $item->tea_weight; }), 2) }}
                        </div>

                         <div class="col-md-2 px-0">
    <strong>Total Profit:</strong>
    {{ number_format(
        $data->sum(function($item) {
            return ($item->selling_price - $item->buy_price) * $item->tea_weight;
        }),
    2) }}
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <table id="reportTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Supplier Name</th>
                <th>Phone</th>
                <th>Tea Grade</th>
                <th>Buy Price</th>
                <th>Selling Price</th>
                <th>Weight (kg)</th>
                <th>Total Buy Value</th>
                <th>Total Sell Value</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{ $item->collect_date }}</td>
                    <td>{{ $item->supplier_name }}</td>
                    <td>{{ $item->phone_number }}</td>
                    <td>{{ $item->tea_grade }}</td>
                    <td>{{ number_format($item->buy_price, 2) }}</td>
                    <td>{{ number_format($item->selling_price, 2) }}</td>
                    <td>{{ number_format($item->tea_weight, 2) }}</td>
                    <td>{{ number_format($item->buy_price * $item->tea_weight, 2) }}</td>
                    <td>{{ number_format($item->selling_price * $item->tea_weight, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#reportTable", {
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'pdfHtml5',
        ],
        responsive: true,
        paging: true,
        pageLength: 25,
        order: [[0, 'desc']], // Order by date descending
        columnDefs: [
            {
                targets: [4, 5, 6, 7, 8], // Price and weight columns
                className: 'text-end'
            }
        ]
    });
});
</script>

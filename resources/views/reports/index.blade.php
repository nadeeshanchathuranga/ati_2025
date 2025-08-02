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
        <div class="col-md-4">
            <label for="from" class="form-label">From Date</label>
            <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-4">
            <label for="to" class="form-label">To Date</label>
            <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

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
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->collect_date }}</td>
                    <td>{{ $item->supplier_name }}</td>
                    <td>{{ $item->phone_number }}</td>
                    <td>{{ $item->tea_grade }}</td>
                    <td>{{ number_format($item->buy_price, 2) }}</td>
                    <td>{{ number_format($item->selling_price, 2) }}</td>
                    <td>{{ number_format($item->tea_weight, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
        });
    });



</script>




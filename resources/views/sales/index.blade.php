@extends('layouts.app')

@section('content')
<div class="container mt-5">

<div class="mb-3 text-end">
                <a href="{{ route('sales.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Add New Sale
                </a>
            </div>


  <table id="saleTable" class="table   table-bordered  align-middle">
    <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Total Cost</th>
                <th>Cash Paid</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody class="text-white fs-1-new">
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->customer->name }}</td>

                <td>{{ $sale->total_cost }}</td>
                <td>{{ $sale->cash }}</td>
                <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                <td>
    <a href="{{ route('sales.receipt', $sale->id) }}" class="btn btn-info btn-sm" target="_blank">View</a>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
       <script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable("#saleTable", {
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

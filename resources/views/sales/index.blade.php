@extends('layouts.app')

@section('content')
<div class="container mt-5">



 <div class="row mb-3">

<div class="col-lg-6 text-start">
 <a href="{{ route('dashboard') }}" class="btn btn-warning back-btn px-4 py-2 rounded-3">
    Home
</a>
</div>
<div class="col-lg-6 text-end">
  <a href="{{ route('sales.create') }}" class="btn btn-success">
                  +  Add New Sale
                </a>
</div>
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
           <td>{{ $sale->customer->name }}
    <!-- Customer Details Button -->
<button
    class="btn btn-outline-info btn-sm rounded-2 fw-semibold"
    data-bs-toggle="modal"
    data-bs-target="#customerModal{{ $sale->id }}"
>
    View Customer
</button>

<!-- Modal -->
<div class="modal fade" id="customerModal{{ $sale->id }}" tabindex="-1" aria-labelledby="customerModalLabel{{ $sale->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content text-start rounded-3 shadow">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title fs-4" id="customerModalLabel{{ $sale->id }}">Customer Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark fs-6">
        <div class="mb-2">
          <strong>Name:</strong> <span class="ms-2">{{ $sale->customer->name }}</span>
        </div>
        <div class="mb-2">
          <strong>Email:</strong> <span class="ms-2">{{ $sale->customer->email }}</span>
        </div>
        <div class="mb-2">
          <strong>Phone:</strong> <span class="ms-2">{{ $sale->customer->phone }}</span>
        </div>
        <div class="mb-2">
          <strong>Address:</strong> <span class="ms-2">{{ $sale->customer->address }}</span>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</td>

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

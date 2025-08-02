


@extends('layouts.app')

@section('content')
         <div class="container-fluid mt-5">
            <div class="container">
                <div class="row">
               <div class="col-lg-12 mx-auto">

   <h1 class="h1-font text-dark fw-bolder text-center fs-4">Tea Price Index</h1>

          @if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif


 <div class="row mb-3">

<div class="col-lg-6 text-start">
 <a href="{{ route('dashboard') }}" class="btn btn-warning back-btn px-4 py-2 rounded-3">
    Home
</a>
</div>
<div class="col-lg-6 text-end">
     <a href="{{ route('teas.create') }}" class="btn btn-success">
                  +  Add New Tea
                </a>
</div>
 </div>

      <div class="table-responsive">


<table id="teaTable" class="table table-striped table-bordered table-hover align-middle">
    <thead class="table-success">
        <tr>
            <th>#</th> <!-- Index column -->
            <th>Tea Grade</th>
            <th>Buy Price (per 1g)</th>
            <th>Selling Price (per 1g)</th>
            <th>Date</th>
            <th>Total Weight</th>
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody class="text-white fs-1-new">
        @foreach($teas as $index => $tea)
        <tr>
            <td>{{ $index + 1 }}</td> <!-- Displaying index starting from 1 -->
            <td>{{ $tea->tea_grade }}</td>
            <td>{{ $tea->buy_price }}</td>
            <td>{{ $tea->selling_price }}</td>
            <td>{{ $tea->date }}</td>
      <td>
    @if ($tea->total_weight <= 100)
        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">
            Low Stock ({{ $tea->total_weight }}g)
        </span>
    @else
        {{ $tea->total_weight }} g
    @endif
</td>

            <td>
                <span class="badge {{ $tea->status ? 'bg-success' : 'bg-secondary' }}">
                    {{ $tea->status ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td class="text-center">
                <a href="{{ route('teas.edit', $tea->id) }}" class=" btn btn-sm btn-primary me-1">
                    Edit
                </a>
                <form action="{{ route('teas.destroy', $tea->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>





  </div>
            </div>
         </div>
         </div>
</div>
         @endsection

         <script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable("#teaTable", {
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


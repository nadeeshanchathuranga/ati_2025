@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="container mx-auto">
           <div class="row mx-auto">
    <!-- Tea Price Card -->
    <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/tea-leaves.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Tea Leaves">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">Tea Price</h1>
                <a href="{{ route('teas.index') }}" class="mt-3 px-1 enter-btn">Enter</a>
            </div>
        </div>
    </div>

    <!-- Supplier Card -->
    <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/supplier.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Supplier">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">Supplier</h1>
                <a href="{{ route('suppliers.index') }}" class="mt-3 px-1 enter-btn">Enter</a>
            </div>
        </div>
    </div>


      <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/in-stock.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Supplier">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">Tea Stock</h1>
                <a href="{{ route('tea_stock_store') }}" class="mt-3 px-1 enter-btn">Enter</a>
            </div>
        </div>
    </div>


    <!-- Fertilizer Price Card -->
    <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/fertilizer.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Fertilizer">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">Fertilizer Price</h1>
                <a href="{{ route('fertilizers.index') }}" class="mt-3 px-1 enter-btn">Enter</a>
            </div>
        </div>
    </div>



      <!-- Fertilizer Price Card -->
    <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/vendor.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Fertilizer">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">POS</h1>
                <a href="{{ route('sales.index') }}" class="mt-3 px-1 enter-btn">Enter</a>
            </div>
        </div>
    </div>


     <!-- Fertilizer Price Card -->
    <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/fertilizer_pos.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Fertilizer">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">Fertilizer POS</h1>
                <a href="{{ route('fertilizers_sale_view') }}" class="mt-3 px-1 enter-btn">Enter</a>
            </div>
        </div>
    </div>




       <div class="col-lg-3 mb-3 d-flex">
        <div class="card text-center p-3 w-100 d-flex flex-column">
            <img src="{{ asset('images/report.png') }}" class="card-img-top w-50 mx-auto mt-3" alt="Fertilizer">
            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                <h1 class="h4 fw-bold">Reports</h1>
               <a href="{{ route('reports.index') }}" class="mt-3 px-1 enter-btn">Enter</a>

            </div>
        </div>
    </div>
</div>

        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <h1 class="text-white fw-bolder text-center fs-4">Add New Fertilizer</h1>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('tea_stock_store') }}" method="POST" id="teaStockForm">
                    @csrf

                    <div class="mb-3">
                        <label class="text-white">Supplier</label>
                        <select name="supplier_id" id="supplierSelect" class="form-control" required>
                            <option value="">-- Select Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Tea Weight</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" step="0.001" id="weight_kg" class="form-control" placeholder="Kg">
                            </div>
                            <div class="col">
                                <input type="number" step="0.001" id="weight_g" class="form-control" placeholder="Grams">
                            </div>
                        </div>
                        <input type="hidden" name="tea_weight" id="tea_weight">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    // Fill total tea weight when supplier is selected
    $('#supplierSelect').on('change', function () {
        const supplierId = $(this).val();

        if (supplierId) {
            $.get(`/supplier/${supplierId}/total-weight`, function (data) {
                $('#weight_kg').val(data.total_kg);
            }).fail(function () {
                $('#weight_kg').val('');
                alert("Failed to load tea weight.");
            });
        } else {
            $('#weight_kg').val('');
        }
    });

    // Before submitting, calculate total grams and set in hidden field
    document.getElementById("teaStockForm").addEventListener("submit", function (e) {
        const kg = parseFloat(document.getElementById("weight_kg").value) || 0;
        const g = parseFloat(document.getElementById("weight_g").value) || 0;

        const totalGrams = (kg * 1000) + g;
        document.getElementById("tea_weight").value = totalGrams;
    });
</script>
@endsection

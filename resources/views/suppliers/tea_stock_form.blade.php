@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <h2 class="text-center text-white mb-4">Add Tea Stock</h2>

        <form action="{{ route('tea_stock_store') }}" method="POST" id="teaStockForm">
            @csrf

            <div class="mb-3">
                <label class="text-white">Supplier</label>
                <select name="supplier_id" class="form-control" required>
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
                        <input type="number" step="0.01" id="weight_kg" class="form-control" placeholder="Enter weight in kg">
                    </div>
                    <div class="col">
                        <input type="number" step="0.01" id="weight_g" class="form-control" placeholder="Enter weight in grams">
                    </div>
                </div>
                <!-- Hidden field to store the final weight value in grams -->
                <input type="hidden" name="tea_weight" id="tea_weight">
            </div>

            <div class="mb-3">
                <label class="text-white">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-success px-4">Add Stock</button>
            </div>
        </form>
    </div>
</div>

{{-- jQuery --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function () {
    let syncing = false;

    // KG → Grams conversion
    $('#weight_kg').on('input', function () {
        if (syncing) return;
        syncing = true;

        let kg = parseFloat($(this).val()) || 0;
        let grams = (kg * 1000).toFixed(2);

        $('#weight_g').val(grams);
        $('#tea_weight').val(grams); // Update hidden field

        syncing = false;
    });

    // Grams → KG conversion
    $('#weight_g').on('input', function () {
        if (syncing) return;
        syncing = true;

        let grams = parseFloat($(this).val()) || 0;
        let kg = (grams / 1000).toFixed(3); // More precision for kg

        $('#weight_kg').val(kg);
        $('#tea_weight').val(grams.toFixed(2)); // Update hidden field

        syncing = false;
    });

    // Form validation before submit
    $('#teaStockForm').on('submit', function (e) {
        let grams = parseFloat($('#weight_g').val()) || 0;
        let kg = parseFloat($('#weight_kg').val()) || 0;

        // Ensure we have a valid weight
        if (grams <= 0 && kg <= 0) {
            e.preventDefault();
            alert('Please enter a valid weight.');
            return false;
        }

        // If only kg is entered, convert to grams
        if (kg > 0 && grams <= 0) {
            grams = kg * 1000;
        }

        // Store the final weight in grams
        $('#tea_weight').val(grams.toFixed(2));

        return true;
    });

    // Clear all weight fields function (optional)
    function clearWeightFields() {
        $('#weight_kg').val('');
        $('#weight_g').val('');
        $('#tea_weight').val('');
    }
});
</script>

@endsection

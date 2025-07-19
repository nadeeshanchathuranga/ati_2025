@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <h1 class="text-white fw-bolder text-center fs-4">Edit Supplier</h1>

                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" id="supplierForm">
                    @csrf
                    @method('PUT')

                <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8 mx-auto">

                            <div class="mb-3">
                                <label class="text-white">Tea Grade</label>
                                <select name="tea_id" id="tea_id" class="form-control" required>
                                    <option value="">-- Select Grade --</option>
                                    @foreach($teas as $tea)
                                        <option value="{{ $tea->id }}"
                                            data-price="{{ $tea->buy_price }}"
                                            {{ $supplier->tea_id == $tea->id ? 'selected' : '' }}>
                                            {{ $tea->tea_grade }} - 1g ({{ $tea->buy_price }} Rs)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Register ID</label>
                                <input type="text" name="register_id" class="form-control" value="{{ $supplier->register_id }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Supplier Name</label>
                                <input type="text" name="supplier_name" class="form-control" value="{{ $supplier->supplier_name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Address</label>
                                <textarea name="address" class="form-control" required>{{ $supplier->address }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control"
                                       value="{{ $supplier->phone_number }}" required
                                       pattern="^\d{10}$"
                                       maxlength="10"
                                       minlength="10"
                                       title="Phone number must be exactly 10 digits">
                            </div>


                             <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-success px-4">Edit Supplier</button>
                            </div>

                        </div>


                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

{{-- jQuery for dynamic bidirectional calculation --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
    function calculateIncome() {
        const teaSelect = $('#tea_id');
        const pricePerGram = parseFloat(teaSelect.find('option:selected').data('price')) || 0;

        const weightKg = parseFloat($('#tea_weight').val()) || 0;
        const weightGrams = parseFloat($('#tea_weight_grams').val()) || 0;

        const totalGrams = (weightKg * 1000) + weightGrams;
        const income = totalGrams * pricePerGram;

        $('#price_per_gram').val(pricePerGram.toFixed(2));
        $('#tea_income').val(income.toFixed(2));
    }

    // Sync kg to grams
    $('#tea_weight').on('input', function () {
        const kg = parseFloat($(this).val()) || 0;
        $('#tea_weight_grams').val((kg * 1000).toFixed(2));
        calculateIncome();
    });

    // Sync grams to kg
    $('#tea_weight_grams').on('input', function () {
        const grams = parseFloat($(this).val()) || 0;
        $('#tea_weight').val((grams / 1000).toFixed(2));
        calculateIncome();
    });

    $('#tea_id').on('change', calculateIncome);

    // Initial calculation on page load
    calculateIncome();
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bolder text-center fs-4">Fertilizer Sale</h1>

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Alert --}}
                @if(session('error'))
                    <div class="alert alert-danger" id="error-alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('fertilizer-sale.store') }}" method="POST">
                    @csrf

                    <div class="row py-3">
                        <!-- Supplier Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label text-white">Select Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">-- Select --</option>
                                @foreach($suppliers as $supplier)
                                    @php
                                        $income = $supplier->calculated_income ?? 0;
                                    @endphp
                                    <option value="{{ $supplier->id }}" data-income="{{ $income }}">
                                        {{ $supplier->supplier_name }}
                                        @if($income > 0)
                                            ({{ number_format($income, 2) }} LKR)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Income Display -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white">Supplier Income</label>
                            <input type="text" id="income_display" class="form-control" value="0.00 LKR" readonly>
                            <input type="hidden" name="supplier_income" id="supplier_income">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const supplierSelect = document.getElementById('supplier_id');
        const incomeDisplay = document.getElementById('income_display');
        const hiddenIncome = document.getElementById('supplier_income');

        supplierSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            let income = selectedOption.getAttribute('data-income');

            if (this.value && income !== null) {
                const formattedIncome = parseFloat(income).toFixed(2);
                incomeDisplay.value = formattedIncome + ' LKR';
                hiddenIncome.value = formattedIncome;
            } else {
                incomeDisplay.value = "0.00 LKR";
                hiddenIncome.value = "";
            }
        });
    });
</script>
@endsection

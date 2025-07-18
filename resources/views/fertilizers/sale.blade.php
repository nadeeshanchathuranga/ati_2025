@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bolder text-center fs-4">Fertilizer Sale</h1>

                {{-- Success / Error --}}
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

                <form action="{{ route('fertilizer-sale.store') }}" method="POST">
                    @csrf

                    <div class="row py-3">
                        <!-- Supplier Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label text-white">Select Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">-- Select --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" data-income="{{ $supplier->tea_income }}">
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total Income Display -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white">Total Supplier Income</label>
                            <input type="text" id="income_display" class="form-control" value="0.00 LKR" readonly>
                            <input type="hidden" name="supplier_income" id="supplier_income">
                        </div>

                        <!-- Fertilizer List Table -->
                        <div class="col-lg-12">
                            <label class="form-label text-white">Select Fertilizers & Enter Quantity (g)</label>
                            <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd;">
                                <table class="table table-bordered table-striped bg-white m-0">
                                    <thead class="table-dark sticky-top" style="top: 0; z-index: 1;">
                                        <tr>
                                            <th>Select</th>
                                            <th>Fertilizer Name</th>
                                            <th>Stock (g)</th>
                                            <th>1g Price (LKR)</th>
                                            <th>Enter Grams</th>
                                            <th>Line Total (LKR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fertilizers as $fertilizer)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="fertilizers[{{ $fertilizer->id }}][selected]" class="fertilizer-checkbox" data-id="{{ $fertilizer->id }}">
                                                </td>
                                                <td>{{ $fertilizer->name }}</td>
                                                <td>{{ $fertilizer->stock }}</td>
                                                <td class="price" data-id="{{ $fertilizer->id }}">{{ number_format($fertilizer->price, 2) }}</td>
                                                <td>
                                                    <input type="number" name="fertilizers[{{ $fertilizer->id }}][grams]" class="form-control grams-input" min="1" data-id="{{ $fertilizer->id }}" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control line-total" id="line_total_{{ $fertilizer->id }}" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Total Cost -->
                        <div class="col-md-6 mt-4">
                            <label class="form-label text-white fw-bold">Total Cost (LKR)</label>
                            <input type="text" name="total_cost" id="total_cost" class="form-control fw-bold" value="0.00" readonly>
                        </div>

                        <!-- Warning if income is less -->
                        <div class="col-md-6 mt-4">
                            <div id="income-warning" class="alert alert-danger d-none">
                                Supplier income is less than total cost!
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const supplierSelect = document.getElementById('supplier_id');
        const incomeDisplay = document.getElementById('income_display');
        const supplierIncomeInput = document.getElementById('supplier_income');
        const totalCostInput = document.getElementById('total_cost');
        const warningBox = document.getElementById('income-warning');

        let supplierIncome = 0;

        supplierSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            supplierIncome = parseFloat(selectedOption.getAttribute('data-income')) || 0;

            incomeDisplay.value = supplierIncome.toFixed(2) + ' LKR';
            supplierIncomeInput.value = supplierIncome;
            checkIncome();
        });

        function checkIncome() {
            const totalCost = parseFloat(totalCostInput.value) || 0;
            warningBox.classList.toggle('d-none', totalCost <= supplierIncome);
        }

        function calculateTotal() {
            let total = 0;

            document.querySelectorAll('.fertilizer-checkbox').forEach(checkbox => {
                const id = checkbox.dataset.id;
                const gramsInput = document.querySelector(`.grams-input[data-id="${id}"]`);
                const priceCell = document.querySelector(`.price[data-id="${id}"]`);
                const lineTotalInput = document.getElementById(`line_total_${id}`);

                if (checkbox.checked && gramsInput.value) {
                    const grams = parseFloat(gramsInput.value);
                    const price = parseFloat(priceCell.textContent.replace(',', ''));
                    const lineTotal = grams * price;

                    lineTotalInput.value = lineTotal.toFixed(2);
                    total += lineTotal;
                } else {
                    lineTotalInput.value = '';
                }
            });

            totalCostInput.value = total.toFixed(2);
            checkIncome();
        }

        // Enable/disable grams input based on checkbox
        document.querySelectorAll('.fertilizer-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const id = this.dataset.id;
                const gramsInput = document.querySelector(`.grams-input[data-id="${id}"]`);
                gramsInput.disabled = !this.checked;
                if (!this.checked) {
                    gramsInput.value = '';
                }
                calculateTotal();
            });
        });

        // Recalculate on grams input
        document.querySelectorAll('.grams-input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
    });
</script>
@endsection

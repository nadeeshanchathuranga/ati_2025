@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <h1 class="h1-font text-dark fw-bolder text-center fs-4">Supplier Details</h1>

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

                <div class="mb-3 text-end">

                </div>




 <div class="row mb-3">

<div class="col-lg-6 text-start">
 <a href="{{ route('dashboard') }}" class="btn btn-warning back-btn px-4 py-2 rounded-3">
    Home
</a>
</div>
<div class="col-lg-6 text-end">
     <a href="{{ route('suppliers.create') }}" class="btn btn-success">
                      +  Add New Supplier
                    </a>
</div>
 </div>



                <div class="table-responsive">
                    <table id="supplierTable" class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Supplier Name</th>
                                <th>Tea Grade</th>
                                <th>Weight (kg)</th>
                                <th>Income (Rs)</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-white fs-1-new">
                            @foreach($suppliers as $index => $supplier)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->tea->tea_grade ?? 'N/A' }}</td>
                                <td>{{ number_format($supplier->supplierTeaStock->sum('tea_weight') / 1000, 3) }} kg</td>

                                @php
                                    $totalGrams = $supplier->supplierTeaStock->sum('tea_weight');
                                    $pricePerGram = $supplier->tea->buy_price ?? 0;
                                    $income = $totalGrams * $pricePerGram;
                                @endphp

                                <td>
                                    {{ number_format($supplier->tea_income) ?? 'N/A' }}

                                    @if ($supplier->tea_income == 0)
                                        <span class="ml-2 inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                            Completed
                                        </span>
                                    @elseif ($supplier->tea_income > 0)
                                        <a href="#"
                                           class="ml-2 inline-block px-4 py-2 text-md rounded-3 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-full pay-btn"
                                           data-id="{{ $supplier->id }}"
                                           data-income="{{ $supplier->tea_income }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#payModal">
                                            Pay
                                        </a>
                                    @endif
                                </td>

                                <td>{{ $supplier->phone_number }}</td>
                                <td>
                                    <span class="badge {{ $supplier->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($supplier->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class=" btn btn-sm btn-primary me-1">
                                        Edit
                                    </a>

                                    <a href="#"
                                       class="btn btn-sm btn-info me-1 view-supplier-btn"
                                       data-id="{{ $supplier->id }}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#supplierViewModal">
                                        View
                                    </a>

                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                       <button type="submit"
    class="btn btn-sm btn-{{ $supplier->status === 'active' ? 'danger' : 'success' }}"
    onclick="return confirm('Are you sure you want to {{ $supplier->status === 'active' ? 'deactivate' : 'activate' }} this supplier?')">
    {{ $supplier->status === 'active' ? 'Deactivate' : 'Activate' }}
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

<!-- Pay Modal - MOVED OUTSIDE THE LOOP -->
<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <form method="POST" action="{{ route('tea_income.process') }}">
        @csrf
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title" id="payModalLabel">Pay Supplier</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="supplier_id" id="paySupplierId">
            <p><strong>Tea Income:</strong> <span id="payIncomeDisplay">0</span> LKR</p>
            <div class="mb-3">
                <label for="payAmount" class="form-label">Payment Amount (LKR)</label>
                <input type="number" min="1" class="form-control" id="payAmount" name="amount" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Pay Now</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Supplier View Modal -->
<div class="modal fade" id="supplierViewModal" tabindex="-1" aria-labelledby="supplierViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="supplierViewModalLabel">Supplier Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <h6 class="text-dark">
                        <span id="modalSupplierName" hidden>Loading...</span>
                    </h6>
                    <input type="hidden" id="modalSupplierId" />
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle shadow-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Weight (kg)</th>
                            </tr>
                        </thead>
                        <tbody id="teaStockTableBody">
                            <tr>
                                <td colspan="3">
                                    <div class="spinner-border text-secondary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                               <th colspan="2">Total</th>
                               <th id="totalTeaWeight">0.000 kg</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // View supplier functionality
        const viewButtons = document.querySelectorAll(".view-supplier-btn");
        viewButtons.forEach(button => {
            button.addEventListener("click", function () {
                const supplierId = this.getAttribute("data-id");
                const supplierName = this.getAttribute("data-name");

                document.getElementById("modalSupplierId").value = supplierId;
                document.getElementById("modalSupplierName").textContent = supplierName;

                const tbody = document.getElementById("teaStockTableBody");
                const totalWeightElement = document.getElementById("totalTeaWeight");

                tbody.innerHTML = `<tr>
                    <td colspan="3" class="text-center">
                        <div class="spinner-border text-secondary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>`;
                totalWeightElement.textContent = '0.000 kg';

                fetch(`/suppliers/${supplierId}/tea-stock`)
                    .then(res => res.json())
                    .then(data => {
                        let total = 0;
                        if (data.length > 0) {
                            const rows = data.map((item, index) => {
                                const weightGrams = parseFloat(item.tea_weight);
                                const weightKg = weightGrams / 1000;
                                total += weightKg;
                                return `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.date}</td>
                                        <td>${weightKg.toFixed(3)} kg</td>
                                    </tr>
                                `;
                            });
                            tbody.innerHTML = rows.join('');
                        } else {
                            tbody.innerHTML = `<tr><td colspan="3" class="text-center">No stock records found</td></tr>`;
                        }
                        totalWeightElement.textContent = total.toFixed(3) + ' kg';
                    })
                    .catch(() => {
                        tbody.innerHTML = `<tr><td colspan="3" class="text-danger text-center">Error loading data</td></tr>`;
                        totalWeightElement.textContent = '0.000 kg';
                    });
            });
        });

        // Pay functionality - FIXED
        const payButtons = document.querySelectorAll(".pay-btn");
        payButtons.forEach(button => {
            button.addEventListener("click", function () {
                const supplierId = this.getAttribute("data-id");
                const income = this.getAttribute("data-income");

                console.log("Supplier ID:", supplierId); // Debug log
                console.log("Income:", income); // Debug log

                // Set supplier ID
                const supplierIdInput = document.getElementById("paySupplierId");
                if (supplierIdInput) {
                    supplierIdInput.value = supplierId;
                }

                // Set income display
                const incomeElement = document.getElementById("payIncomeDisplay");
                if (incomeElement) {
                    const formattedIncome = parseFloat(income).toLocaleString('en-LK', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    incomeElement.textContent = formattedIncome;
                    console.log("Income display updated:", formattedIncome); // Debug log
                } else {
                    console.error("payIncomeDisplay element not found!"); // Debug log
                }

                // Optional: Set default payment amount to full income
                const payAmountInput = document.getElementById("payAmount");
                if (payAmountInput) {
                    payAmountInput.value = parseFloat(income).toFixed(2);
                }
            });
        });

        // Initialize DataTable
        new DataTable("#supplierTable", {
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

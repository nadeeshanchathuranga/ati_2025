@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <h1 class="text-white fw-bolder text-center fs-4">Supplier Details</h1>

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
                    <a href="{{ route('suppliers.create') }}" class="btn btn-success">
                      +  Add New Supplier
                    </a>
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

{{-- <td>
    {{ number_format($totalGrams) }} g × {{ number_format($pricePerGram, 2) }} = {{ number_format($income, 2) }} LKR
</td> --}}

       <td>{{ number_format($supplier->tea_income) ?? 'N/A' }}</td>

<td>{{ $supplier->phone_number }}</td>
                                 <td>
                                    <span class="badge {{ $supplier->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($supplier->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        Edit
                                    </a>


   <a href="#"
   class="btn btn-sm btn-outline-info me-1 view-supplier-btn"
   data-id="{{ $supplier->id }}"
   data-bs-toggle="modal"
   data-bs-target="#supplierViewModal">
View
</a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                      <button type="submit"
        class="btn btn-sm btn-outline-{{ $supplier->status === 'active' ? 'danger' : 'success' }}"
        onclick="return confirm('Are you sure you want to {{ $supplier->status === 'active' ? 'deactivate' : 'activate' }} this supplier?')">
    <i class="fas {{ $supplier->status === 'active' ? 'fa-user-slash' : 'fa-user-check' }}"></i>
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
                        {{-- Supplier Name: {{ $supplier->supplier_name }} --}}


                        <span id="modalSupplierName" hidden>Loading...</span></h6>
                    <input type="hidden" id="modalSupplierId" />
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle shadow-sm">
                        <thead class="table-light">
                            <tr>
                                <th  >#</th>
                                <th  >Date</th>
                                <th  >Weight (kg)</th>
                            </tr>
                        </thead>
                        <tbody id="teaStockTableBody" class=" ">
                            <tr>
                                <td colspan="2">
                                    <div class="spinner-border text-secondary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                               <th colspan="2">Total</th>
        <th id="totalTeaWeight"  >0.000 kg</th>
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



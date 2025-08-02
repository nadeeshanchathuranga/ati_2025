@extends('layouts.app')

@section('content')
<div class="container mt-5">


     <div class="row mb-3">

<div class="col-lg-6 text-start">
 <a href="{{ route('fertilizers.index') }}" class="btn btn-info text-white back-btn px-4 py-2 rounded-3">
    Back
</a>
</div>

 </div>
    <div class="mb-3 text-end">
        <a href="{{ route('fertilizers_sale') }}" class="btn btn-success">
          +  Add New Fertilizer Sale
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0 h1-font">Fertilizer Sales Records</h4>
        </div>
        <div class="card-body">
                <div class="table-responsive">
            <table id="fertilizerSaleTable" class="table table-bordered table-striped">



                <thead class="thead-dark">
                    <tr>

                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Supplier Income</th>


                        <th>Fertilizer List</th>

                        <th>Sale Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1; @endphp
                    @foreach($sales as $supplierId => $groupedSales)
                        @foreach($groupedSales as $index => $sale)
                        <tr class="supplier-group-{{ $supplierId }}">

                             <td>{{ $sale->supplier->register_id }}</td>

                            <td>
                                @if($index == 0)
                                    <strong>{{ $sale->supplier->supplier_name ?? 'N/A' }}</strong>
                                @else
                                    <span class="text-muted">{{ $sale->supplier->supplier_name ?? 'N/A' }}</span>
                                @endif
                            </td>
                            <td>
    Rs. {{ number_format($sale->supplier_income, 2) }}

    <p class="text-dark fs-6">Balance : <b>Rs. {{ number_format($sale->supplier_income - $sale->total_cost, 2) }}</b></p>
</td>


                            <td>
                                <ul class="mb-0">
                                    @foreach($sale->items as $item)
                                        <li>
                                            {{ $item->fertilizer->name ?? 'N/A' }} -
                                            {{ $item->quantity_grams }}g * Rs.{{ number_format($item->unit_price, 2) }} =
                                            Rs.{{ number_format($item->line_total, 2) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $sale->created_at->format('d M Y h:i A') }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
          </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .supplier-group-border {
        border-top: 3px solid #007bff !important;
    }

    .supplier-group-row {
        background-color: #f8f9fa;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
    }

    .dataTables_wrapper .dataTables_length {
        float: left;
    }

    .table tbody tr.supplier-group-start {
        border-top: 3px solid #007bff;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = new DataTable("#fertilizerSaleTable", {
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
            ],
            responsive: true,
            paging: true,
            pageLength: 25,
            order: [[1, 'asc'], [6, 'desc']], // Sort by Supplier ID first, then Created At
            columnDefs: [
                {
                    targets: 5, // Items column
                    orderable: false,
                    searchable: true
                }
            ],
            language: {
                search: "Search records:",
                lengthMenu: "Show _MENU_ records per page",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            drawCallback: function(settings) {
                // Add visual grouping after table is drawn
                let api = this.api();
                let rows = api.rows({ page: 'current' }).nodes();
                let last = null;

                api.column(1, { page: 'current' }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).addClass('supplier-group-start');
                        last = group;
                    }
                });
            }
        });

        // Add row grouping functionality
        table.on('order.dt search.dt', function () {
            let lastSupplierId = null;

            table.rows().every(function () {
                let data = this.data();
                let supplierId = data[1]; // Supplier ID column

                if (lastSupplierId !== supplierId) {
                    $(this.node()).addClass('supplier-group-start');
                    lastSupplierId = supplierId;
                } else {
                    $(this.node()).removeClass('supplier-group-start');
                }
            });
        });
    });
</script>
@endsection

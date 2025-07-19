@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <h1 class="text-white fw-bolder text-center fs-4">Fertilizer Price Index</h1>

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
                    <a href="{{ route('fertilizers.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add New Fertilizer
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="fertilizerTable" class="table   table-bordered   align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Fertilizer Name</th>
                                <th>Stock (g)</th>
                                <th>Price (Rs)</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-white fs-1-new">
                            @foreach($fertilizers as $index => $fertilizer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $fertilizer->name }}</td>
                               <td>
    @if ($fertilizer->stock <= 10)
        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">
            Low ({{ $fertilizer->stock }}g)
        </span>
    @else
        {{ $fertilizer->stock }}g
    @endif
</td>

                                    <td>{{ $fertilizer->price }}</td>
                                    <td>{{ $fertilizer->date }}</td>
                                    <td>
                                        <span class="badge {{ $fertilizer->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($fertilizer->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('fertilizers.edit', $fertilizer->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('fertilizers.destroy', $fertilizer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure? This will mark it as inactive.')">
                                                <i class="fas fa-trash-alt"></i>
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

{{-- DataTable Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable("#fertilizerTable", {
            buttons: ["copyHtml5", "csvHtml5", "excelHtml5", "pdfHtml5"],
            responsive: true,
            paging: true,
        });
    });
</script>

@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <h1 class="h1-font text-dark fw-bolder text-center fs-4">Add New Supplier</h1>

                <form action="{{ route('suppliers.store') }}" method="POST" id="supplierForm">
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8 mx-auto">

                            <div class="mb-3">
                                <label class="text-white">Tea Grade</label>
                                <select name="tea_id" id="tea_id" class="form-control" required>
                                    <option value="">-- Select Grade --</option>
                                    @foreach($teas as $tea)
                                        <option value="{{ $tea->id }}" data-price="{{ $tea->buy_price }}">
                                            {{ $tea->tea_grade }} - 1g ({{ $tea->buy_price }} Rs)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Register ID</label>
                                <input type="text" name="register_id" class="form-control" value="{{ $generatedRegisterId }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Supplier Name</label>
                                <input type="text" name="supplier_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Address</label>
                                <textarea name="address" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="text-white">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" required
                                       pattern="^\d{10}$"
                                       maxlength="10"
                                       minlength="10"
                                       title="Phone number must be exactly 10 digits">
                            </div>


                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-success px-4">Create Supplier</button>
                            </div>
                        </div>


                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

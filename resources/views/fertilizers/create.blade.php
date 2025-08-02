@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">


                 <div class="row mb-3">

<div class="col-lg-6 text-start">
 <a href="{{ route('fertilizers.index') }}" class="btn btn-info text-white back-btn px-4 py-2 rounded-3">
    Back
</a>
</div>

 </div>

        <div class="row">
            <div class="col-lg-6 mx-auto">

                <h1 class="h1-font text-dark fw-bolder text-center fs-4">Add New Fertilizer</h1>

                <form action="{{ route('fertilizers.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="text-white">Fertilizer Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Stock (g)</label>
                        <input type="number" name="stock" class="form-control" step="1" required>
                    </div>

                    <div class="mb-3">
                 <label class="text-white">Price per Gram (Rs)</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="mb-3 d-none">
                        <label class="text-white">Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success px-4">Create</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

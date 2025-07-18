@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">

                <h1 class="text-white fw-bolder text-center fs-4">Add New Fertilizer</h1>

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

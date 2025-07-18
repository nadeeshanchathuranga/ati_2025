@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">

                <h1 class="text-white fw-bolder text-center fs-4">Edit Fertilizer</h1>

                <form action="{{ route('fertilizers.update', $fertilizer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="text-white">Fertilizer Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $fertilizer->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Stock (g)</label>
                        <input type="number" name="stock" class="form-control" step="1" value="{{ $fertilizer->stock }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Price per Gram (Rs)</label>
                        <input type="number" name="price" class="form-control" step="0.01" value="{{ $fertilizer->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $fertilizer->date }}" required>
                    </div>

                    <div class="mb-3 d-none">
                        <label class="text-white">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $fertilizer->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $fertilizer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3 text-end">
                        <a href="{{ route('fertilizers.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

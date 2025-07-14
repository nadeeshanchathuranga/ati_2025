@extends('layouts.app')

@section('content')
  <div class="container-fluid mt-5">
            <div class="container">
                <div class="row">
               <div class="col-lg-6 mx-auto">

   <h1 class="text-white fw-bolder text-center fs-4">Add New Tea</h1>

    <form action="{{ route('teas.store') }}" method="POST">
        @csrf
       <div class="mb-3">
    <label class="text-white">Tea Grade</label>
    <select name="tea_grade" class="form-control" required>
        <option value="">-- Select Grade --</option>
        <option value="BOP">BOP</option>
        <option value="FBOP">FBOP</option>
        <option value="PEKOE">PEKOE</option>
        <option value="DUST">DUST</option>
    </select>
</div>
        <div class="mb-3">
           <label class="text-white">Buy Price (per 1g)</label>
            <input type="number" name="buy_price" class="form-control" step="0.01" required>
        </div>
         <div class="mb-3">
           <label class="text-white">Selling Price (per 1g)</label>
            <input type="number" name="selling_price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="text-white">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="text-white">Status</label>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success px-4">Create</button>
    </form>
</div>
</div>
</div>
</div>
@endsection

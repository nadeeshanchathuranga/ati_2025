@extends('layouts.app')

@section('content')
  <div class="container-fluid mt-5">
            <div class="container">
                <div class="row">
               <div class="col-lg-6 mx-auto">

   <h1 class="text-white fw-bolder text-center fs-4 pb-4">Edit Tea</h1>


    <form action="{{ route('teas.update', $tea->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Tea Grade --}}
        <div class="mb-3">
            <label class="text-white">Tea Grade</label>
            <select name="tea_grade" class="form-control" required>
                @foreach(['BOP', 'FBOP', 'PEKOE', 'DUST'] as $grade)
                    <option value="{{ $grade }}" {{ (old('tea_grade', $tea->tea_grade) == $grade) ? 'selected' : '' }}>
                        {{ $grade }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Price --}}
        <div class="mb-3">
          <label class="text-white">Buy Price (per 1g)</label>
            <input type="number" name="buy_price" value="{{ old('buy_price', $tea->buy_price) }}" class="form-control" step="0.01" required>
        </div>


          <div class="mb-3">
          <label class="text-white">Selling Price (per 1g)</label>
            <input type="number" name="selling_price" value="{{ old('selling_price', $tea->selling_price) }}" class="form-control" step="0.01" required>
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label class="text-white">Date</label>
            <input type="date" name="date" value="{{ old('date', $tea->date) }}" class="form-control" required>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="text-white">Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $tea->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $tea->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</div>
</div>
</div>


@endsection

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ __('messages.edit_car') }} #{{ $car->id }}:</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cars.update', $car) }}" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('messages.reg_number') }}</label>
                <input class="form-control" name="reg_number" value="{{ old('reg_number', $car->reg_number) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.brand') }}</label>
                <input class="form-control" name="brand" value="{{ old('brand', $car->brand) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.model') }}</label>
                <input class="form-control" name="model" value="{{ old('model', $car->model) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.owner') }}</label>
                <select name="owner_id" class="form-select">
                    <option value="">-- {{ __('messages.unassigned') }} --</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" @selected(old('owner_id', $car->owner_id) == $owner->id)>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Car photos</label>
                <input type="file" name="photos[]" class="form-control" multiple>
            </div>

            <button class="btn btn-primary">{{ __('messages.save') }}</button>
            <a href="{{ route('cars.index') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
        </form>

        @if($car->photos->count())
            <hr class="my-4">
            <h4>Car photos</h4>

            <div class="row mb-3">
                @foreach($car->photos as $photo)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="img-fluid rounded border mb-2" alt="Car photo">

                        <form method="POST" action="{{ route('cars.photos.destroy', $photo) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete photo</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

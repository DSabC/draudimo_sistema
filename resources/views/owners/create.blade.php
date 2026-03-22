@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ __('messages.add_owner') }}:</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('owners.store') }}" class="mt-3">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('messages.name') }}</label>
                <input class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.surname') }}</label>
                <input class="form-control" name="surname" value="{{ old('surname') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.phone') }}</label>
                <input class="form-control" name="phone" value="{{ old('phone') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.email') }}</label>
                <input class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.address') }}</label>
                <input class="form-control" name="address" value="{{ old('address') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.cars') }}</label>

                @forelse($cars as $car)
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="cars[]"
                            value="{{ $car->id }}"
                            id="car{{ $car->id }}"
                            {{ in_array($car->id, old('cars', [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="car{{ $car->id }}">
                            {{ $car->brand }} {{ $car->model }} ({{ $car->reg_number }})
                        </label>
                    </div>
                @empty
                    <div class="text-muted">{{ __('messages.no_cars_available') }}</div>
                @endforelse
            </div>
            <button class="btn btn-primary mt-3">{{ __('messages.save') }}</button>
            <a href="{{ route('owners.index') }}" class="btn btn-secondary mt-3">{{ __('messages.back') }}</a>
        </form>
    </div>
@endsection

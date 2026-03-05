@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Pridėti naują savininką:</h2>

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
                <label class="form-label">Vardas</label>
                <input class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pavardė</label>
                <input class="form-control" name="surname" value="{{ old('surname') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Telefono nr.</label>
                <input class="form-control" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">E. paštas</label>
                <input class="form-control" name="email" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Adresas</label>
                <input class="form-control" name="address" value="{{ old('address') }}">
            </div>

            <button class="btn btn-primary">Išsaugoti</button>
            <a href="{{ route('owners.index') }}" class="btn btn-secondary">Atgal</a>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Pridėti naują automobilį:</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cars.store') }}" class="mt-3">
            @csrf

            <div class="mb-3">
                <label class="form-label">Registracijos numeris</label>
                <input class="form-control" name="reg_number" value="{{ old('reg_number') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Markė</label>
                <input class="form-control" name="brand" value="{{ old('brand') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Modelis</label>
                <input class="form-control" name="model" value="{{ old('model') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Savininkas</label>
                <select name="owner_id" class="form-select">
                    <option value="">-- Nepriskirta --</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" @selected(old('owner_id') == $owner->id)>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Išsaugoti</button>
            <a href="{{ route('cars.index') }}" class="btn btn-secondary">Atgal</a>
        </form>
    </div>
@endsection

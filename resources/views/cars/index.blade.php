@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <h2>Automobiliai</h2>
            <a href="{{ route('cars.create') }}" class="btn btn-success">Pridėti</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Numeris</th>
                <th>Markė</th>
                <th>Modelis</th>
                <th>Savininkas</th>
                <th>Veiksmai</th>
            </tr>
            </thead>

            <tbody>
            @foreach($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->reg_number }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>
                        @if($car->owner)
                            {{ $car->owner->name }} {{ $car->owner->surname }}
                        @else
                            <span class="text-muted">Nepriskirta</span>
                        @endif
                    </td>
                    <td >
                        <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning mb-1">Redaguoti</a>

                        <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Tikrai ištrinti?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger mb-1">Trinti</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

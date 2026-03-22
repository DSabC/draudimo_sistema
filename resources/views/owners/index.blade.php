@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <h2>Automobilių savininkai</h2>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('owners.create') }}" class="btn btn-success">Pridėti</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavardė</th>
                <th>Telefono nr.</th>
                <th>E. paštas</th>
                <th>Adresas</th>
                <th>Automobiliai</th>
                <th>Veiksmai</th>
            </tr>
            </thead>

            <tbody>
            @foreach($owners as $owner)
                <tr>
                    <td>{{ $owner->id }}</td>
                    <td>{{ $owner->name }}</td>
                    <td>{{ $owner->surname }}</td>
                    <td>{{ $owner->phone }}</td>
                    <td>{{ $owner->email }}</td>
                    <td>{{ $owner->address }}</td>
                    <td>
                        @foreach($owner->cars as $car)
                            <div>
                                {{ $car->brand }} {{ $car->model }} ({{ $car->reg_number }})
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning mb-1">Redaguoti</a>

                            <form action="{{ route('owners.destroy', $owner) }}" method="POST" onsubmit="return confirm('Tikrai ištrinti?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Trinti</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

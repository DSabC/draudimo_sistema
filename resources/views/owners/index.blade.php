@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <h2>Automobilių savininkai</h2>
            <a href="{{ route('owners.create') }}" class="btn btn-success">Pridėti</a>
        </div>

        @if(session('success'))
            <div class="aler alert-success">{{ session('success') }}</div>
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
                        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning">Redaguoti</a>

                        <form action="{{ route('owners.destroy', $owner) }}" method="POST" class="d-inline" onsubmit="return confirm('Tikrai ištrinti?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Trinti</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

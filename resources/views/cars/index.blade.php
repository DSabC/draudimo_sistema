@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <h2>{{ __('messages.cars') }}</h2>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('cars.create') }}" class="btn btn-success">{{ __('messages.add') }}</a>
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
                <th>{{ __('messages.reg_number') }}</th>
                <th>{{ __('messages.brand') }}</th>
                <th>{{ __('messages.model') }}</th>
                <th>{{ __('messages.owner') }}</th>
                <th>{{ __('messages.actions') }}</th>
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
                            <span class="text-muted">{{ __('messages.unassigned') }}</span>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning mb-1">{{ __('messages.edit') }}</a>

                            <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.delete_confirm') }}')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger mb-1">{{ __('messages.delete') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

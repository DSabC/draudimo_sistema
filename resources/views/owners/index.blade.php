@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <h2>{{ __('messages.owners') }}</h2>
            @auth
                @can('create', App\Models\Owner::class)
                    <a href="{{ route('owners.create') }}" class="btn btn-success">{{ __('messages.add') }}</a>
                @endcan
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.surname') }}</th>
                <th>{{ __('messages.phone') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.address') }}</th>
                <th>{{ __('messages.cars') }}</th>
                <th>{{ __('messages.actions') }}</th>
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
                        @can('update', $owner)
                            <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning mb-1">{{ __('messages.edit') }}</a>
                        @endcan

                        @can('delete', $owner)
                            <form action="{{ route('owners.destroy', $owner) }}" method="POST" onsubmit="return confirm('{{ __('messages.delete_confirm') }}')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">{{ __('messages.delete') }}</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

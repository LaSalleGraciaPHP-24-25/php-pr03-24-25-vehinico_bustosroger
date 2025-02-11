@extends('layouts.app')

@section('title', 'Lista de Apartamentos')

@section('content')
    <h1>Lista de Apartamentos</h1>
    <a href="{{ route('apartments.create') }}" class="btn btn-primary mb-3">Crear Apartamento</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Precio de Alquiler</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment)
                <tr>
                    <td>{{ $apartment->id }}</td>
                    <td>{{ $apartment->address }}</td>
                    <td>{{ $apartment->city }}</td>
                    <td>{{ $apartment->rented_price }} €</td>
                    <td>
                        <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-info">Mostrar</a>
                        <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
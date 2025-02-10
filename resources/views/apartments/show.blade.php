@extends('layouts.app')

@section('title', 'Detalles del Apartamento')

@section('content')
    <h1>Detalles del Apartamento #{{ $apartment->id }}</h1>
    <p><strong>Dirección:</strong> {{ $apartment->address }}</p>
    <p><strong>Ciudad:</strong> {{ $apartment->city }}</p>
    <p><strong>Código Postal:</strong> {{ $apartment->postal_code }}</p>
    <p><strong>Precio de Alquiler:</strong> {{ $apartment->rented_price }} €</p>
    <p><strong>Alquilado:</strong> {{ $apartment->rented ? 'Sí' : 'No' }}</p>
    <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning">Editar</a>
    <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
    <a href="{{ route('apartments.index') }}" class="btn btn-secondary">Volver</a>
@endsection
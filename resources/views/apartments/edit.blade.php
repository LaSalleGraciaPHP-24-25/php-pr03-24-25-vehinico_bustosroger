@extends('layouts.app')

@section('title', 'Editar Apartamento')

@section('content')
    <h1>Editar Apartamento #{{ $apartment->id }}</h1>
    <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $apartment->address }}" required>
        </div>
        <div class="form-group">
            <label for="city">Ciudad</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ $apartment->city }}" required>
        </div>
        <div class="form-group">
            <label for="postal_code">Código Postal</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ $apartment->postal_code }}" required>
        </div>
        <div class="form-group">
            <label for="rented_price">Precio de Alquiler</label>
            <input type="number" step="0.01" name="rented_price" id="rented_price" class="form-control" value="{{ $apartment->rented_price }}" required>
        </div>
        <div class="form-group">
            <label for="rented">Alquilado</label>
            <select name="rented" id="rented" class="form-control" required>
                <option value="0" {{ $apartment->rented ? '' : 'selected' }}>No</option>
                <option value="1" {{ $apartment->rented ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" class="form-control">
            @if ($apartment->photo)
                <img src="{{ asset('storage/' . $apartment->photo) }}" alt="Foto del apartamento" style="max-width: 200px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>

        <div class="form-group">
            {!! captcha_img() !!}
            <input type="text" name="captcha" class="form-control" placeholder="Introduce el CAPTCHA" required>
        </div>
    </form>
@endsection
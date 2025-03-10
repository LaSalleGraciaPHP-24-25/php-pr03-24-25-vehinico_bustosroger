@extends('layouts.app')

@section('title', 'Crear Apartamento')

@section('content')
    <h1>Crear Apartamento</h1>
    <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="city">Ciudad</label>
            <input type="text" name="city" id="city" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="postal_code">Código Postal</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="rented_price">Precio de Alquiler</label>
            <input type="number" step="0.01" name="rented_price" id="rented_price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="rented">Alquilado</label>
            <select name="rented" id="rented" class="form-control" required>
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Usuario</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>

        <div class="form-group">
            {!! captcha_img() !!}
            <input type="text" name="captcha" class="form-control" placeholder="Introduce el CAPTCHA" required>
        </div>
    </form>
@endsection
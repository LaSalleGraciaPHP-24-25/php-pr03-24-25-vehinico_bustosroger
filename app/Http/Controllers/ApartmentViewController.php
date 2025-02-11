<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Apartment;
use App\Models\User;

class ApartmentViewController extends Controller
{
    public function index()
    {
        $apartments = Apartment::orderBy('city')->orderBy('address')->paginate(10);
        return view('apartments.index', compact('apartments'));
    }

    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }

    public function create()
    {
        // Obtener todos los usuarios desde la base de datos
        $users = \App\Models\User::all(); // Asegúrate de importar el modelo User si no lo has hecho
        return view('apartments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'rented_price' => 'required|numeric',
            'rented' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $path;
        }

        Apartment::create($validatedData);
        return redirect()->route('apartments.index')->with('success', 'Apartamento creado con éxito');
    }

    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.edit', compact('apartment'));
    }

    // 🔹 Actualizar un apartamento
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'rented_price' => 'required|numeric',
            'rented' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $apartment = Apartment::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($apartment->photo) {
                Storage::disk('public')->delete($apartment->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $path;
        }

        $apartment->update($validatedData);

        return redirect()->route('apartments.show', $apartment->id);
    }

    // 🔹 Eliminar un apartamento
    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);

        if ($apartment->photo) {
            Storage::disk('public')->delete($apartment->photo);
        }

        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartamento eliminado con éxito');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Apartment;

class ApartmentViewController extends Controller
{
    // 🔹 Mostrar lista de apartamentos
    public function index()
    {
        $apartments = Apartment::orderBy('city')->orderBy('address')->paginate(10);
        return view('apartments.index', compact('apartments'));
    }

    // 🔹 Mostrar detalles de un apartamento
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }

    // 🔹 Mostrar formulario de creación
    public function create()
    {
        return view('apartments.create');
    }

    // 🔹 Guardar un nuevo apartamento
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'rented_price' => 'required|numeric',
            'rented' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $path;
        }

        Apartment::create($validatedData);

        return redirect()->route('apartments.index')->with('success', 'Apartamento creado con éxito');
    }

    // 🔹 Mostrar formulario de edición
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
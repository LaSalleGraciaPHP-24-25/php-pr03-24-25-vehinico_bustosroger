<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Apartment;
use Mews\Captcha\Facades\Captcha;

class ApartmentController extends Controller
{
    // Mostrar lista de apartamentos (para la vista index)
    public function index(Request $request)
    {
        $query = Apartment::with(['user:id,email', 'platforms:id,name']);

        if ($request->has('city')) {
            $query->where('city', 'like', $request->city . '%');
        }

        $apartments = $query->orderBy('city')->orderBy('address')->get();

        return view('apartments.index', compact('apartments'));
    }

    // Mostrar detalles de un apartamento (para la vista show)
    public function show($id)
    {
        $apartment = Apartment::with(['user:id,email', 'platforms:id,name'])->findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }

    // Mostrar formulario de creación (para la vista create)
    public function create()
    {
        return view('apartments.create');
    }

    // Guardar un nuevo apartamento (para la vista create)
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:100',
            'city' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'rented_price' => 'nullable|numeric|min:0|max:999999.99',
            'rented' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captcha' => 'required|captcha',
        ]);

        $apartment = new Apartment($request->except('photo'));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $apartment->photo = $path;
        }

        $apartment->user_id = Auth::id();
        $apartment->save();

        return redirect()->route('apartments.show', $apartment->id);
    }

    // Mostrar formulario de edición (para la vista edit)
    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.edit', compact('apartment'));
    }

    // Actualizar un apartamento (para la vista edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:100',
            'city' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'rented_price' => 'nullable|numeric|min:0|max:999999.99',
            'rented' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captcha' => 'required|captcha',
        ]);

        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->hasFile('photo')) {
            if ($apartment->photo) {
                Storage::disk('public')->delete($apartment->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $apartment->photo = $path;
        }

        $apartment->update($request->except('photo'));

        return redirect()->route('apartments.show', $apartment->id);
    }

    // Eliminar un apartamento (para la vista index)
    public function destroy($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($apartment->photo) {
            Storage::disk('public')->delete($apartment->photo);
        }

        $apartment->delete();

        return redirect()->route('apartments.index');
    }

    // Actualizar plataforma de un apartamento (API)
    public function updatePlatform(Request $request, $id)
    {
        $request->validate([
            'premium' => 'required|boolean',
            'platform' => 'required|exists:platforms,id',
        ]);

        $apartment = Apartment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $exists = $apartment->platforms()->where('platform_id', $request->platform)->exists();

        if ($exists) {
            $apartment->platforms()->updateExistingPivot($request->platform, [
                'premium' => $request->premium,
            ]);
        } else {
            $apartment->platforms()->attach($request->platform, [
                'register_date' => now(),
                'premium' => $request->premium,
            ]);
        }

        return response()->json($apartment->load('platforms:id,name'), 200);
    }

    // Mostrar apartamentos por estado de alquiler (API)
    public function getApartmentsByRentedStatus(Request $request)
    {
        $request->validate([
            'rented' => 'required|boolean',
        ]);

        $apartments = Apartment::where('rented', $request->rented)
            ->with(['user:id,email'])
            ->get()
            ->map(function ($apartment) {
                return [
                    'id' => $apartment->id,
                    'address' => $apartment->address,
                    'city' => $apartment->city,
                    'postal_code' => $apartment->postal_code,
                    'rented_price' => $apartment->rented_price,
                    'rented' => $apartment->rented,
                    'user_email' => $apartment->user->email,
                ];
            });

        return response()->json($apartments, 200);
    }

    // Mostrar apartamentos con precio superior a 1000€ (API)
    public function getApartmentsHighPrice()
    {
        $apartments = Apartment::where('rented_price', '>', 1000)
            ->with(['user:id,email'])
            ->get();

        return response()->json($apartments, 200);
    }
}
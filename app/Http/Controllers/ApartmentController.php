<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        // Inicializar la consulta con las relaciones correctas
        $query = Apartment::with([
            'user:id,email', // Solo traer el email del usuario
            'platforms:id,name' // Solo traer el nombre de las plataformas
        ]);

        // Aplicar el filtro por ciudad si se proporciona
        if ($request->has('city')) {
            $query->where('city', 'like', $request->city . '%');
        }

        // Obtener los apartamentos con los filtros aplicados
        $apartments = $query->get();

        // Formatear la respuesta para cumplir con los requisitos
        $formattedApartments = $apartments->map(function ($apartment) {
            return [
                'id' => $apartment->id,
                'address' => $apartment->address,
                'city' => $apartment->city,
                'postal_code' => $apartment->postal_code,
                'rented_price' => $apartment->rented_price,
                'rented' => $apartment->rented,
                'user_email' => $apartment->user->email, // Solo el email del usuario
                'platforms' => $apartment->platforms->pluck('name') // Solo nombres de plataformas
            ];
        });

        return response()->json($formattedApartments);
    }

    public function show($id)
    {
        $apartment = Apartment::with(['user:id,email', 'platforms:id,name'])->findOrFail($id);

        return response()->json([
            'id' => $apartment->id,
            'address' => $apartment->address,
            'city' => $apartment->city,
            'postal_code' => $apartment->postal_code,
            'rented_price' => $apartment->rented_price,
            'rented' => $apartment->rented,
            'user_email' => $apartment->user->email, // Solo email
            'platforms' => $apartment->platforms->pluck('name') // Solo nombres de plataformas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:100',
            'city' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'rented_price' => 'nullable|numeric|min:0|max:999999.99',
            'rented' => 'required|boolean',
        ]);

        $apartment = Apartment::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return response()->json([
            'id' => $apartment->id,
            'address' => $apartment->address,
            'city' => $apartment->city,
            'postal_code' => $apartment->postal_code,
            'rented_price' => $apartment->rented_price,
            'rented' => $apartment->rented,
            'user_email' => $apartment->user->email,
            'platforms' => $apartment->platforms->pluck('name')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $apartment->update($request->all());

        return response()->json([
            'id' => $apartment->id,
            'address' => $apartment->address,
            'city' => $apartment->city,
            'postal_code' => $apartment->postal_code,
            'rented_price' => $apartment->rented_price,
            'rented' => $apartment->rented,
            'user_email' => $apartment->user->email,
            'platforms' => $apartment->platforms->pluck('name')
        ]);
    }

    public function destroy($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $apartment->delete();

        return response()->json(['message' => 'Apartment deleted']);
    }
    public function updatePlatform(Request $request, $id)
    {
        $request->validate([
            'premium' => 'required|boolean',
            'platform' => 'required|exists:platforms,id'
        ]);

        // Obtener el apartamento con el usuario autenticado
        $apartment = Apartment::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        // Verificar si la plataforma ya está asociada
        $exists = $apartment->platforms()->where('platform_id', $request->platform)->exists();

        if ($exists) {
            // Si existe, actualizamos el campo "premium"
            $apartment->platforms()->updateExistingPivot($request->platform, [
                'premium' => $request->premium
            ]);
        } else {
            // Si no existe, la agregamos con la relación correcta
            $apartment->platforms()->attach($request->platform, [
                'register_date' => now(),
                'premium' => $request->premium
            ]);
        }

        // Devolver el apartamento con las plataformas actualizadas
        return response()->json($apartment->load('platforms:id,name'), 200);
    } 
}

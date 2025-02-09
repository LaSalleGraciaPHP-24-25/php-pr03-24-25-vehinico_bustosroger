<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Apartment;
use Laravel\Sanctum\HasApiTokens;
class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::with(['user:id,email', 'platforms:id,name']);

        if ($request->has('city')) {
            $query->where('city', 'like', $request->city . '%');
        }

        $apartments = $query->get();

        return response()->json($apartments);
    }

    public function show($id)
    {
        $apartment = Apartment::with(['user:id,email', 'platforms:id,name'])->findOrFail($id);
        return response()->json($apartment);
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
        return response()->json($apartment, 201);
    }

    public function update(Request $request, $id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $apartment->update($request->all());
        return response()->json($apartment);
    }

    public function destroy($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $apartment->delete();
        return response()->json(['message' => 'Apartment deleted']);
    }
}

<?php
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

    
}

<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Http\Requests\StorePlatformRequest;
use App\Http\Requests\UpdatePlatformRequest;

class PlatformController extends Controller
{
    public function index()
    {
        return response()->json(Platform::all());
    }

    public function show($id)
    {
        return response()->json(Platform::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:platforms',
            'owner' => 'required|string',
        ]);

        $platform = Platform::create($request->all());
        return response()->json($platform, 201);
    }

    public function update(Request $request, $id)
    {
        $platform = Platform::findOrFail($id);
        $platform->update($request->all());
        return response()->json($platform);
    }

    public function destroy($id)
    {
        Platform::findOrFail($id)->delete();
        return response()->json(['message' => 'Platform deleted']);
    }
}
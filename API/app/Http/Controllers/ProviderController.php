<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        try {
            $providers = Provider::active()->get();
            return response()->json([
                'status' => true,
                'providers' => $providers,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_company' => 'required|string|min:2|max:255',
                'ruc' => 'required|string|min:6|max:255',
                'telefono' => 'required|string|max:250',
                'email' => 'required|string|max:250',
                'direccion' => 'required|string|max:250',
                'contacto' => 'required|string|max:250',
            ]);
            $provider = Provider::create($request->all());
            return response()->json([
                'status' => true,
                'provider' => $provider
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $provider = User::findOrFail($id);
            $provider->update(['is_active' => 0]);

            return response()->json([
                'status' => true,
                'message' => '1'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // 1. Validación más estricta
            $validated = $request->validate([
                'name_company' => 'required|string|min:2|max:255',
                'ruc' => 'required|string|min:6|max:255',
                'telefono' => 'required|string|max:250',
                'email' => 'required|string|max:250',
                'direccion' => 'required|string|max:250',
                'contacto' => 'required|string|max:250',
            ]);
            $provider = Provider::findOrFail($id);
            $dataToUpdate = [];

            if (isset($validated['name_company'])) $dataToUpdate['name_company'] = $validated['name_company'];
            if (isset($validated['ruc'])) $dataToUpdate['ruc'] = $validated['ruc'];
            if (isset($validated['telefono'])) $dataToUpdate['telefono'] = $validated['telefono'];
            if (isset($validated['email'])) $dataToUpdate['email'] = $validated['email'];
            if (isset($validated['direccion'])) $dataToUpdate['direccion'] = $validated['direccion'];
            if (isset($validated['contacto'])) $dataToUpdate['contacto'] = $validated['contacto'];

            $provider->update($dataToUpdate);
            return response()->json([
                'status' => true,
                'message' => 'updated',
                'provider' => $provider
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar usuario',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $provider = Provider::findOrFail($id);

            return response()->json([
                'status' => true,
                'provider' => $provider
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

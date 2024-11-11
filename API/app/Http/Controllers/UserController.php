<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = User::active()->get();
            return response()->json([
                'status' => true,
                'users' => $users,
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
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|string|min:6|max:255',
                'password' => 'required|string|max:250',
            ]);
            $user = User::create($request->all());
            return response()->json([
                'status' => true,
                'user' => $user
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
            $user = User::findOrFail($id);
            $user->update(['is_active' => 0]);

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
                'name' => 'sometimes|string|min:2|max:255',
                'email' => 'sometimes|string|email|max:255',
                'password' => 'sometimes|string|min:6|max:250',
            ]);
            // 2. Buscar el usuario
            $user = User::findOrFail($id);

            // 3. Preparar datos para actualizar
            $dataToUpdate = [];

            if (isset($validated['name'])) {
                $dataToUpdate['name'] = $validated['name'];
            }

            if (isset($validated['email'])) {
                $dataToUpdate['email'] = $validated['email'];
            }

            // 4. Manejar la contraseña de forma segura
            if (isset($validated['password'])) {
                $dataToUpdate['password'] = Hash::make($validated['password']);
            }

            // 5. Actualizar solo los campos validados
            $user->update($dataToUpdate);

            // 6. Retornar respuesta sin la contraseña
            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user->makeHidden(['password'])
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
            $user = User::findOrFail($id);

            return response()->json([
                'status' => true,
                'user' => $user->makeHidden(['password'])
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

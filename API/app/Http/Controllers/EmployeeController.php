<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employee = Employee::active()->get();
            return response()->json([
                'status' => true,
                'employee' => $employee,
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
                'lastname' => 'required|string|min:6|max:255',
                'identification' => 'required|string|max:250',
                'phone' => 'required|string|max:250',
                'email' => 'required|string|max:250',
                'role' => 'required|string|max:250',
            ]);
            $employee = Employee::create($request->all());
            return response()->json([
                'status' => true,
                'employee' => $employee
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
            $employee = User::findOrFail($id);
            $employee->update(['is_active' => 0]);

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
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'lastname' => 'required|string|min:6|max:255',
                'identification' => 'required|string|max:250',
                'phone' => 'required|string|max:250',
                'email' => 'required|string|max:250',
                'role' => 'required|string|max:250',
            ]);
            $employee = Employee::findOrFail($id);
            $dataToUpdate = [];

            if (isset($validated['name'])) $dataToUpdate['name'] = $validated['name'];
            if (isset($validated['lastname'])) $dataToUpdate['lastname'] = $validated['lastname'];
            if (isset($validated['identification'])) $dataToUpdate['identification'] = $validated['identification'];
            if (isset($validated['phone'])) $dataToUpdate['phone'] = $validated['phone'];
            if (isset($validated['email'])) $dataToUpdate['email'] = $validated['email'];
            if (isset($validated['role'])) $dataToUpdate['role'] = $validated['role'];

            $employee->update($dataToUpdate);
            return response()->json([
                'status' => true,
                'message' => 'updated',
                'employee' => $employee
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
            $employee = Employee::findOrFail($id);

            return response()->json([
                'status' => true,
                'employee' => $employee
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::active()->get();
            return response()->json([
                'status' => true,
                'products' => $products,
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'name' => 'required|string|max:100',
                    'description' => 'nullable|string',
                    'sale_price' => 'required|numeric|min:0',
                    'stock' => 'nullable|numeric|min:0',
                ]
            );
            $product = Product::create($request->all());
            return response()->json([
                'status' => true,
                'data' => $product
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update(['status' => 0]);

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
            $request->validate(
                [
                    'name' => 'required|string|max:100',
                    'description' => 'nullable|string',
                    'sale_price' => 'required|numeric|min:0',
                    'stock' => 'nullable|numeric|min:0',
                ]
            );
            $product = Product::findOrFail($id);
            $dataToUpdate = [];

            if (isset($validated['name'])) {
                $dataToUpdate['name'] = $validated['name'];
            }

            if (isset($validated['description'])) {
                $dataToUpdate['description'] = $validated['description'];
            }
            if (isset($validated['sale_price'])) {
                $dataToUpdate['sale_price'] = $validated['password'];
            }
            if (isset($validated['stock'])) {
                $dataToUpdate['stock'] = $validated['stock'];
            }

            $product->update($dataToUpdate);

            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado exitosamente',
                'product' => $product
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
                'message' => 'producto no encontrado'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar producto',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'status' => true,
                'product' => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

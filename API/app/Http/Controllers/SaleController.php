<?php
// SaleController.php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        try {
            $sales = Sale::active()
                ->with(['client', 'seller', 'details.product'])
                ->get();

            return response()->json([
                'status' => true,
                'sales' => $sales
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validar request
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'seller_id' => 'required|exists:employees,id',
                'date_sale' => 'required|date',
                'total' => 'required|numeric|min:0',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|numeric|min:1',
                'products.*.price' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            // Crear la venta
            $sale = Sale::create([
                'client_id' => $validated['client_id'],
                'seller_id' => $validated['seller_id'],
                'date_sale' => $validated['date_sale'],
                'total' => $validated['total'],
                'is_active' => 1
            ]);

            // Guardar los detalles
            foreach ($request->products as $product) {
                SalesDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['quantity'] * $product['price']
                ]);

                // Aquí podrías agregar lógica para actualizar el stock
                // Product::find($product['product_id'])->decrement('stock', $product['quantity']);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'sale' => $sale->load(['client', 'seller', 'details.product'])
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $sale = Sale::with(['client', 'seller', 'details.product'])
                ->findOrFail($id);

            return response()->json([
                'status' => true,
                'sale' => $sale
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $sale = Sale::findOrFail($id);

            // Anular la venta
            $sale->update(['is_active' => 0]);

            // Si quieres revertir el stock:
            // foreach($sale->details as $detail) {
            //     Product::find($detail->product_id)
            //         ->increment('stock', $detail->quantity);
            // }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Venta anulada correctamente'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

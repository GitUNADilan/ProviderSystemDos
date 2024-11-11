<?php
// PurchaseController.php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        try {
            $purchases = Purchase::active()
                ->with(['provider', 'employee', 'details'])
                ->get();

            return response()->json([
                'status' => true,
                'purchases' => $purchases
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
                'provider_id' => 'required|exists:providers,id',
                'employee_id' => 'required|exists:employees,id',
                'purchase_date' => 'required|date',
                'total' => 'required|numeric|min:0',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|numeric|min:1',
                'products.*.price' => 'required|numeric|min:0'
            ]);

            // Usar transacción para asegurar que todo se guarde o nada
            DB::beginTransaction();

            // Crear la compra
            $purchase = Purchase::create([
                'provider_id' => $validated['provider_id'],
                'employee_id' => $validated['employee_id'],
                'purchase_date' => $validated['purchase_date'],
                'total' => $validated['total'],
                'is_active' => 1
            ]);

            // Guardar los detalles
            foreach ($request->products as $product) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['quantity'] * $product['price']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'purchase' => $purchase->load('details')
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
            $purchase = Purchase::with(['provider', 'employee', 'details'])
                ->findOrFail($id);

            return response()->json([
                'status' => true,
                'purchase' => $purchase
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
            $purchase = Purchase::findOrFail($id);
            $purchase->update(['is_active' => 0]);

            return response()->json([
                'status' => true,
                'message' => 'Compra anulada correctamente'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

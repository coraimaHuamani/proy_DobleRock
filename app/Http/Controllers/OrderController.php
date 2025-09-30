<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->rol !== 'cliente') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $productos = [];
            foreach ($validated['productos'] as $prod) {
                $producto = Producto::findOrFail($prod['id']);
                $subtotal = $producto->precio * $prod['cantidad'];
                $total += $subtotal;
                $productos[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $prod['cantidad'],
                    'precio' => $producto->precio,
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pendiente',
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($productos as $prod) {
                $order->productos()->attach($prod['producto_id'], [
                    'cantidad' => $prod['cantidad'],
                    'precio' => $prod['precio'],
                ]);
            }

            // Aquí iría la integración con la pasarela de pago (Stripe, PayPal, etc.)
            // Ejemplo: $order->payment_id = $stripePaymentId; $order->status = 'pagado';

            DB::commit();
            return response()->json($order->load('productos'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al procesar la orden'], 500);
        }
    }
}
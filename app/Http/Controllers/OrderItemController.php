<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'product_id'   => 'nullable|exists:products,id',
            'product_name' => 'required|string|max:100',
            'quantity'     => 'required|integer|min:1',
            'unit_price'   => 'required|numeric|min:0',
            'options'      => 'nullable|array',
        ]);

        $subtotal = $request->quantity * $request->unit_price;

        // Guardar opciones como array (se convertirá a JSON automáticamente si el modelo tiene $casts)
        $options = $request->input('options', []);
        // Asegurarse de que los sabores (si vienen como string separado por comas) se conviertan en array
        if (isset($options['sabores_input']) && is_string($options['sabores_input'])) {
            $saboresArray = explode(',', $options['sabores_input']);
            $options['sabores'] = [];
            foreach ($saboresArray as $sabor) {
                $sabor = trim($sabor);
                if ($sabor !== '') {
                    $options['sabores'][] = ['sabor' => $sabor, 'cantidad_bolas' => 1]; // simplificado
                }
            }
            unset($options['sabores_input']);
        }

        // Si los toppings vienen como string, los convertimos en array
        if (isset($options['toppings_input']) && is_string($options['toppings_input'])) {
            $options['toppings'] = array_filter(array_map('trim', explode(',', $options['toppings_input'])));
            unset($options['toppings_input']);
        }

        $item = new OrderItem([
            'product_id'   => $request->product_id,
            'product_name' => $request->product_name,
            'quantity'     => $request->quantity,
            'unit_price'   => $request->unit_price,
            'subtotal'     => $subtotal,
            'options'      => $options,
        ]);

        $ticket->items()->save($item);

        // Recalcular total del ticket
        $ticket->total = $ticket->items()->sum('subtotal');
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)->with('success', 'Producto agregado');
    }
}
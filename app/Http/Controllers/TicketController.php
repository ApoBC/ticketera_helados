<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    // Lista de tickets del día
    public function index()
    {
        $tickets = Ticket::with('user')
                    ->whereDate('created_at', Carbon::today())
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('tickets.index', compact('tickets'));
    }

    // Mostrar formulario para nuevo ticket
    public function create()
    {
        // Obtener todos los productos activos, ordenados por categoría
    $products = Product::where('is_active', 1)
        ->orderBy('category')
        ->orderBy('name')
        ->get();
    
    return view('tickets.create', compact('products'));
    }

    // Guardar nuevo ticket
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
        ]);

        // Generar número de ticket secuencial del día
        $lastToday = Ticket::whereDate('created_at', Carbon::today())
                        ->orderBy('id', 'desc')
                        ->first();
        $nextNumber = $lastToday ? ((int) substr($lastToday->ticket_number, -4)) + 1 : 1;
        $ticketNumber = Carbon::now()->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'customer_name' => $request->customer_name,
            'total' => 0,
            'status' => 'abierto',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    // Mostrar detalle del ticket y formulario para agregar ítems
    public function show(Ticket $ticket)
    {
        $ticket->load('items', 'user'); // relación orderItems + quién lo creó
        $products = Product::where('is_active', 1)->get(); // catálogo de productos
        return view('tickets.show', compact('ticket', 'products'));
    }

    // Vista para impresión térmica
    public function print(Ticket $ticket)
    {
        $ticket->load('items', 'user');
        return view('tickets.print', compact('ticket'));
    }

    // Cerrar ticket (cambiar estado)
    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'cerrado']);
        return redirect()->route('tickets.index')->with('success', 'Ticket cerrado');
    }
// app/Http/Controllers/TicketController.php
// app/Http/Controllers/TicketController.php

public function vendedorDashboard()
{
    $ticketsHoy = Ticket::with('user')->whereDate('created_at', Carbon::today())
        ->orderBy('created_at', 'desc')
        ->get();
    
    $ticketsActivos = Ticket::with('user')->where('status', 'abierto')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $totalVentasHoy = Ticket::whereDate('created_at', Carbon::today())
        ->where('status', 'cerrado')
        ->sum('total');
    
    $totalTicketsHoy = Ticket::whereDate('created_at', Carbon::today())->count();
    $ticketsAbiertos = Ticket::where('status', 'abierto')->count();
    $ticketsCerrados = Ticket::where('status', 'cerrado')->count();

    return view('vendedor.dashboard', compact(
        'ticketsHoy', 
        'ticketsActivos', 
        'totalVentasHoy', 
        'totalTicketsHoy',
        'ticketsAbiertos',
        'ticketsCerrados'
    ));
}


public function addItem(Request $request, Ticket $ticket)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Verificar que el ticket esté abierto
    if ($ticket->status === 'cerrado') {
        return back()->with('error', 'No se pueden agregar productos a un ticket cerrado');
    }

    $product = Product::findOrFail($request->product_id);

    // Si el producto controla stock, verificar disponibilidad antes de vender
    if ($product->tracksStock() && $product->stock < $request->quantity) {
        return back()->with('error', "Stock insuficiente de \"{$product->name}\". Disponible: {$product->stock}");
    }

    $subtotal = $product->base_price * $request->quantity;

    DB::transaction(function () use ($ticket, $product, $request, $subtotal) {
        // Crear el item
        OrderItem::create([
            'ticket_id' => $ticket->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'options' => null,
            'quantity' => $request->quantity,
            'unit_price' => $product->base_price,
            'subtotal' => $subtotal,
        ]);

        // Descontar del inventario (solo si el producto controla stock)
        if ($product->tracksStock()) {
            $product->decrement('stock', $request->quantity);
        }

        // Actualizar el total del ticket
        $ticket->increment('total', $subtotal);
    });

    return redirect()->route('tickets.show', $ticket)
        ->with('success', 'Producto agregado al ticket');
}



}
<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    // Lista de tickets del día
    public function index()
    {
        $tickets = Ticket::whereDate('created_at', Carbon::today())
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('tickets.index', compact('tickets'));
    }

    // Mostrar formulario para nuevo ticket
    public function create()
    {
        return view('tickets.create');
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
        // Al cargar los productos para el formulario de agregar
$productos = Product::whereIn('category', ['helado', 'postre', 'bebida'])->get();

        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'customer_name' => $request->customer_name,
            'total' => 0,
            'status' => 'abierto',
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    // Mostrar detalle del ticket y formulario para agregar ítems
    public function show(Ticket $ticket)
    {
        $ticket->load('items'); // relación orderItems
        $products = Product::where('is_active', 1)->get(); // catálogo de productos
        return view('tickets.show', compact('ticket', 'products'));
    }

    // Vista para impresión térmica
    public function print(Ticket $ticket)
    {
        $ticket->load('items');
        return view('tickets.print', compact('ticket'));
    }

    // Cerrar ticket (cambiar estado)
    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'cerrado']);
        return redirect()->route('tickets.index')->with('success', 'Ticket cerrado');
    }

    
}
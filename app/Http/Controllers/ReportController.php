<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function daily()
    {
        $today = Carbon::today();

        // Totales generales del día
        $ticketsHoy = Ticket::whereDate('created_at', $today);
        $totalTicketsHoy = (clone $ticketsHoy)->count();
        $ticketsAbiertos = (clone $ticketsHoy)->where('status', 'abierto')->count();
        $ticketsCerrados = (clone $ticketsHoy)->where('status', 'cerrado')->count();

        // Total vendido: suma de todos los ítems agregados hoy (ya sea que el ticket
        // esté abierto o cerrado, porque el producto ya se descontó del stock al venderse)
        $totalVendidoHoy = OrderItem::whereHas('ticket', function ($q) use ($today) {
            $q->whereDate('created_at', $today);
        })->sum('subtotal');

        // Ventas por trabajador (agrupado por quién registró el ticket)
        $ventasPorTrabajador = Ticket::whereDate('tickets.created_at', $today)
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->select(
                'users.name as trabajador',
                DB::raw('COUNT(DISTINCT tickets.id) as total_tickets'),
                DB::raw('SUM(tickets.total) as total_vendido')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_vendido')
            ->get();

        // Tickets sin usuario asociado (creados antes del módulo de trazabilidad)
        $ventasSinTrabajador = Ticket::whereDate('created_at', $today)
            ->whereNull('user_id')
            ->count();

        // Ventas por producto
        $ventasPorProducto = OrderItem::whereHas('ticket', function ($q) use ($today) {
                $q->whereDate('created_at', $today);
            })
            ->select(
                'product_name',
                DB::raw('SUM(quantity) as cantidad_vendida'),
                DB::raw('SUM(subtotal) as total_vendido')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_vendido')
            ->get();

        return view('admin.reports.daily', compact(
            'today',
            'totalTicketsHoy',
            'ticketsAbiertos',
            'ticketsCerrados',
            'totalVendidoHoy',
            'ventasPorTrabajador',
            'ventasSinTrabajador',
            'ventasPorProducto'
        ));
    }
}

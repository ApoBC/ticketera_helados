@extends('layouts.app')

@section('title', 'Ventas del Día')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-600">📊 Ventas de hoy — {{ $today->format('d/m/Y') }}</h2>
            <a href="{{ route('admin.panel') }}" class="text-sm text-gray-500 hover:text-gray-700">← Volver al panel</a>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl shadow-md p-6 border-2 border-green-200 text-center">
                <div class="text-3xl mb-1">💰</div>
                <p class="text-2xl font-bold text-green-600">S/ {{ number_format($totalVendidoHoy, 2) }}</p>
                <p class="text-sm text-gray-500">Total vendido hoy</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 border-2 border-yellow-200 text-center">
                <div class="text-3xl mb-1">🧾</div>
                <p class="text-2xl font-bold text-yellow-600">{{ $totalTicketsHoy }}</p>
                <p class="text-sm text-gray-500">Tickets del día</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 border-2 border-blue-200 text-center">
                <div class="text-3xl mb-1">📋</div>
                <p class="text-2xl font-bold text-blue-600">{{ $ticketsAbiertos }} / {{ $ticketsCerrados }}</p>
                <p class="text-sm text-gray-500">Abiertos / Cerrados</p>
            </div>
        </div>

        <!-- Ventas por trabajador -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-200 mb-8">
            <h3 class="text-lg font-semibold text-purple-600 mb-4">👥 Ventas por trabajador</h3>

            @if ($ventasPorTrabajador->isEmpty())
                <p class="text-gray-500 text-center py-4">Todavía no hay ventas registradas hoy.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-500 text-sm">
                                <th class="py-2">Trabajador</th>
                                <th class="py-2 text-center">Tickets</th>
                                <th class="py-2 text-right">Total vendido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventasPorTrabajador as $fila)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $fila->trabajador }}</td>
                                    <td class="py-3 text-center">{{ $fila->total_tickets }}</td>
                                    <td class="py-3 text-right font-bold text-purple-600">S/ {{ number_format($fila->total_vendido, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($ventasSinTrabajador > 0)
                <p class="text-xs text-gray-400 mt-3">
                    ⓘ {{ $ventasSinTrabajador }} ticket(s) de hoy no tienen trabajador asociado (creados antes de activar la trazabilidad).
                </p>
            @endif
        </div>

        <!-- Ventas por producto -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-yellow-200">
            <h3 class="text-lg font-semibold text-yellow-600 mb-4">🍦 Ventas por producto</h3>

            @if ($ventasPorProducto->isEmpty())
                <p class="text-gray-500 text-center py-4">Todavía no hay productos vendidos hoy.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-500 text-sm">
                                <th class="py-2">Producto</th>
                                <th class="py-2 text-center">Cantidad vendida</th>
                                <th class="py-2 text-right">Total vendido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventasPorProducto as $fila)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $fila->product_name }}</td>
                                    <td class="py-3 text-center">{{ $fila->cantidad_vendida }}</td>
                                    <td class="py-3 text-right font-bold text-yellow-600">S/ {{ number_format($fila->total_vendido, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

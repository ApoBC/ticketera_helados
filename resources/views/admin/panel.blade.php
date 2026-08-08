@extends('layouts.app')

@section('title', 'Dashboard Vendedor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-yellow-200">
            <div class="flex items-center mb-6">
                <div class="text-4xl mr-4">🍦</div>
                <div>
                    <h2 class="text-2xl font-bold text-yellow-600">Dashboard Vendedor</h2>
                    <p class="text-gray-600">Bienvenido, {{ Auth::user()->name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                    <div class="text-3xl mb-2">🧾</div>
                    <h3 class="font-bold">Nuevo Ticket</h3>
                    <p class="text-sm text-gray-600">Crear pedido</p>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                    <div class="text-3xl mb-2">📋</div>
                    <h3 class="font-bold">Tickets Activos</h3>
                    <p class="text-sm text-gray-600">Ver pedidos abiertos</p>
                </div>
            </div>

            <!-- Lista de tickets activos -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Tickets Activos</h3>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-center">No hay tickets activos</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
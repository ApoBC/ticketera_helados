@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-yellow-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-yellow-600">🍦 Productos</h2>
                <a href="{{ route('admin.products.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600">
                    + Nuevo producto
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4">{{ session('error') }}</div>
            @endif

            @if ($outOfStockProducts->isNotEmpty() || $lowStockProducts->isNotEmpty())
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6">
                    <h4 class="font-bold text-red-700 mb-2">⚠️ Alertas de inventario</h4>
                    @if ($outOfStockProducts->isNotEmpty())
                        <p class="text-sm text-red-700">
                            <strong>Agotados:</strong> {{ $outOfStockProducts->pluck('name')->join(', ') }}
                        </p>
                    @endif
                    @if ($lowStockProducts->isNotEmpty())
                        <p class="text-sm text-orange-700 mt-1">
                            <strong>Stock bajo:</strong>
                            @foreach ($lowStockProducts as $p)
                                {{ $p->name }} ({{ $p->stock }}){{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>
                    @endif
                </div>
            @endif

            @forelse ($products as $category => $items)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 capitalize">{{ $category }}s</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b text-gray-500 text-sm">
                                    <th class="py-2">Nombre</th>
                                    <th class="py-2">Precio</th>
                                    <th class="py-2">Stock</th>
                                    <th class="py-2">Estado</th>
                                    <th class="py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $product)
                                    <tr class="border-b last:border-0 {{ !$product->is_active ? 'opacity-50' : '' }}">
                                        <td class="py-3">{{ $product->name }}</td>
                                        <td class="py-3">{{ $product->formatted_price }}</td>
                                        <td class="py-3">
                                            @if (!$product->tracksStock())
                                                <span class="text-xs text-gray-400">No controlado</span>
                                            @elseif ($product->isOutOfStock())
                                                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-600 font-bold">Agotado</span>
                                            @elseif ($product->isLowStock())
                                                <span class="text-xs px-2 py-1 rounded-full bg-orange-100 text-orange-600 font-bold">{{ $product->stock }} (bajo)</span>
                                            @else
                                                <span class="text-sm text-gray-600">{{ $product->stock }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <span class="text-xs px-2 py-1 rounded-full {{ $product->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                                {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-right space-x-2">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 text-sm">Editar</a>
                                            <form method="POST" action="{{ route('admin.products.toggle', $product) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                                    {{ $product->is_active ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('¿Eliminar {{ $product->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No hay productos todavía.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

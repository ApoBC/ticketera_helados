@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-yellow-200">
            <h2 class="text-2xl font-bold text-yellow-600 mb-6">Editar Producto</h2>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select name="category" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" @selected(old('category', $product->category) === $cat)>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Precio (S/)</label>
                    <input type="number" step="0.01" min="0" name="base_price" value="{{ old('base_price', $product->base_price) }}" required
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                </div>

                <div class="border-t pt-4">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="track_stock" id="track_stock" value="1"
                               @checked($product->tracksStock())
                               onchange="document.getElementById('stockFields').style.display = this.checked ? 'block' : 'none'"
                               class="rounded border-gray-300">
                        <label for="track_stock" class="text-sm text-gray-700">Controlar stock de este producto</label>
                    </div>
                    <div id="stockFields" style="{{ $product->tracksStock() ? '' : 'display: none;' }}" class="space-y-3 pl-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock actual</label>
                            <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alertar cuando quede en (o menos de)</label>
                            <input type="number" min="0" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-400">
                    Para activar/desactivar el producto, usa el botón correspondiente en el listado.
                </p>

                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500">Cancelar</a>
                    <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

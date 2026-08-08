<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket {{ $ticket->ticket_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h3">Ticket #{{ $ticket->ticket_number }}</h1>
                <p class="mb-0"><strong>Cliente:</strong> {{ $ticket->customer_name }}</p>
                <p><strong>Estado:</strong> 
                    <span class="badge bg-{{ $ticket->status === 'abierto' ? 'success' : 'secondary' }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </p>
            </div>
            <div>
                <a href="{{ route('tickets.print', $ticket) }}" class="btn btn-outline-secondary" target="_blank">🖨️ Imprimir</a>
                @if($ticket->status === 'abierto')
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h4 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-plus-circle text-green-500"></i> Agregar Producto
        </h4>
        <form action="{{ route('tickets.items.store', $ticket) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                    <select name="product_id" id="product_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" required>
                        <option value="">Selecciona un producto...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->base_price }}">
                                {{ $product->name }} - S/ {{ number_format($product->base_price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                    <input type="number" name="quantity" id="quantity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" value="1" min="1" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endif
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary">Volver a lista</a>
            </div>
        </div>

        <!-- Lista de ítems -->
        <div class="card mb-4">
            <div class="card-header">Ítems del pedido</div>
            <div class="card-body">
                @if($ticket->items->isEmpty())
                    <p class="text-muted">No hay productos agregados aún.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Personalización</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Precio Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ticket->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>
                                            @if($item->options)
                                                <small>
                                                    @php $opt = $item->options; @endphp
                                                    @if(isset($opt['tipo'])) Tipo: {{ $opt['tipo'] }}<br> @endif
                                                    @if(!empty($opt['sabores']))
                                                        Sabores: 
                                                        @foreach($opt['sabores'] as $s)
                                                            {{ $s['sabor'] }}{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                        <br>
                                                    @endif
                                                    @if(!empty($opt['toppings']))
                                                        Toppings: {{ implode(', ', $opt['toppings']) }}
                                                    @endif
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total</th>
                                    <th class="text-end">${{ number_format($ticket->total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Formulario para agregar ítem (solo si el ticket está abierto) -->
        @if($ticket->status === 'abierto')
            <div class="card">
                <div class="card-header">Agregar producto</div>
                <div class="card-body">
                    <form action="{{ route('tickets.items.store', $ticket) }}" method="POST" id="addItemForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="product_id" class="form-label">Producto</label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    <option value="">Selecciona un producto</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-category="{{ $product->category }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->formatted_price }}">
                                            {{ $product->name }} ({{ $product->category }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label for="unit_price" class="form-label">Precio Unitario</label>
                                <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" required>
                            </div>
                            <!-- Campo oculto para el nombre del producto (se llena con JS) -->
                            <input type="hidden" name="product_name" id="product_name">
                        </div>

                        <!-- Campos dinámicos de personalización -->
                        <div id="customizationFields" class="mt-3" style="display: none;">
                            <hr>
                            <div class="row">
                                <div class="col-md-4" id="tipoField" style="display: none;">
                                    <label class="form-label">Tipo</label>
                                    <select name="options[tipo]" id="options_tipo" class="form-select">
                                        <option value="">Seleccionar</option>
                                        <option value="cono">Cono</option>
                                        <option value="vaso">Vaso</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="conoField" style="display: none;">
                                    <label class="form-label">Tipo de cono</label>
                                    <select name="options[cono_tipo]" class="form-select">
                                        <option value="normal">Normal</option>
                                        <option value="waffle">Waffle</option>
                                        <option value="chocolate">Chocolate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2" id="saboresField" style="display: none;">
                                <label class="form-label">Sabores (separados por coma)</label>
                                <input type="text" name="options[sabores_input]" class="form-control" placeholder="Ej: fresa, chocolate, vainilla">
                                <small class="text-muted">Escribe los sabores, uno por bola si es necesario.</small>
                            </div>
                            <div class="mt-2" id="toppingsField" style="display: none;">
                                <label class="form-label">Toppings (separados por coma)</label>
                                <input type="text" name="options[toppings_input]" class="form-control" placeholder="Ej: chispas, crema, nueces">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Agregar al ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Cabecera -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-yellow-200 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="text-4xl mr-4">🧾</div>
                    <div>
                        <h2 class="text-2xl font-bold text-yellow-600">Ticket #{{ $ticket->ticket_number }}</h2>
                        <p class="text-gray-600">Cliente: {{ $ticket->customer_name }}</p>
                        <p class="text-sm text-gray-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold 
                        @if($ticket->status === 'abierto') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Agregar producto (solo si está abierto) -->
        @if($ticket->status === 'abierto')
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 border-2 border-dashed border-yellow-200">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">
                    <i class="fas fa-plus-circle text-green-500"></i> Agregar Producto
                </h4>
                <form action="{{ route('tickets.items.store', $ticket) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                            <select name="product_id" id="product_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" required>
                                <option value="">Selecciona un producto...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->base_price }}">
                                        {{ $product->name }} - S/ {{ number_format($product->base_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                            <input type="number" name="quantity" id="quantity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" value="1" min="1" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300">
                                <i class="fas fa-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <!-- Items del ticket -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <i class="fas fa-list text-yellow-500 mr-2"></i> Productos
                <span class="ml-2 text-sm text-gray-500">({{ $ticket->items->count() }})</span>
            </h3>

            @if($ticket->items->isEmpty())
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <p class="text-gray-500">No hay productos en este ticket</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Producto</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Cant.</th>
                                <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">Precio</th>
                                <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ticket->items as $item)
                                <tr class="border-t border-gray-100 hover:bg-yellow-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $item->product_name }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-600">S/ {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right font-bold text-yellow-600">S/ {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="border-t-2 border-gray-300 bg-gray-50">
                                <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-700">TOTAL</td>
                                <td class="px-4 py-3 text-right font-bold text-yellow-600 text-lg">S/ {{ number_format($ticket->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Acciones -->
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('vendedor.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-full transition-all duration-300">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            
            <a href="{{ route('tickets.print', $ticket) }}" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full transition-all duration-300">
                <i class="fas fa-print"></i> Imprimir
            </a>

            @if($ticket->status === 'abierto')
                <form method="POST" action="{{ route('tickets.close', $ticket) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full transition-all duration-300" 
                            onclick="return confirm('¿Cerrar este ticket?')">
                        <i class="fas fa-check"></i> Cerrar Ticket
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
    <!-- Script para manejar la personalización dinámica -->
    <script>
        document.getElementById('product_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const category = selected.getAttribute('data-category');
            const name = selected.getAttribute('data-name');
            const price = selected.getAttribute('data-price');

            document.getElementById('product_name').value = name;
            document.getElementById('unit_price').value = price || '';
            
            const customization = document.getElementById('customizationFields');
            const tipoField = document.getElementById('tipoField');
            const conoField = document.getElementById('conoField');
            const saboresField = document.getElementById('saboresField');
            const toppingsField = document.getElementById('toppingsField');

            // Mostrar/ocultar campos según categoría
            if (category === 'helado') {
                customization.style.display = 'block';
                tipoField.style.display = 'block';
                conoField.style.display = 'block';
                saboresField.style.display = 'block';
                toppingsField.style.display = 'block';
            } else if (category === 'postre' || category === 'bebida') {
                customization.style.display = 'block';
                tipoField.style.display = 'none';
                conoField.style.display = 'none';
                saboresField.style.display = 'none';
                toppingsField.style.display = 'block'; // Por si quieren agregar topping extra
            } else {
                customization.style.display = 'none';
            }
        });
    </script>
</body>
</html>
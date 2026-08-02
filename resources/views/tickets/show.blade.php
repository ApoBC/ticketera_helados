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
                    <form action="{{ route('tickets.close', $ticket) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Cerrar Ticket</button>
                    </form>
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
                                            data-price="{{ $product->base_price }}">
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
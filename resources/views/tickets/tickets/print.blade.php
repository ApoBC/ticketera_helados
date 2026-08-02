<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ticket {{ $ticket->ticket_number }}</title>
    <style>
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 5mm;
                font-family: 'Courier New', monospace;
                font-size: 12px;
                line-height: 1.3;
            }
            .no-print { display: none; }
        }
        .text-center { text-align: center; }
        hr { border: none; border-top: 1px dashed #000; margin: 4px 0; }
        strong { font-weight: bold; }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.close(), 1000);">
    <div class="text-center">
        <strong>HELADERÍA EL POLO</strong><br>
        <small>RUC: 12345678901</small><br>
        <small>Av. Siempre Viva 742</small><br>
        <small>{{ $ticket->created_at->format('d/m/Y H:i') }}</small>
    </div>
    <hr>
    <p><strong>Cliente:</strong> {{ $ticket->customer_name }}</p>
    <p><strong>Ticket:</strong> {{ $ticket->ticket_number }}</p>
    <hr>
    @foreach($ticket->items as $item)
        <p>
            <strong>{{ $item->product_name }}</strong> (x{{ $item->quantity }})<br>
            @if($item->options)
                @php $opt = $item->options; @endphp
                @if(isset($opt['tipo'])) {{ ucfirst($opt['tipo']) }} @endif
                @if(!empty($opt['sabores']))
                    Sabores: {{ implode(', ', array_column($opt['sabores'], 'sabor')) }}
                @endif
                @if(!empty($opt['toppings']))
                    <br>Toppings: {{ implode(', ', $opt['toppings']) }}
                @endif
            @endif
            <br>S/. {{ number_format($item->subtotal, 2) }}
        </p>
    @endforeach
    <hr>
    <p class="text-center"><strong>TOTAL: S/. {{ number_format($ticket->total, 2) }}</strong></p>
    <hr>
    <p class="text-center">¡Gracias por su compra!</p>
    <p class="text-center no-print">
        <small>Este ticket se envió a la impresora.</small>
    </p>
</body>
</html>
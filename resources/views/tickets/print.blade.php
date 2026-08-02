<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $ticket->ticket_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            width: 80mm;
            margin: 0 auto;
            padding: 2mm;
            font-family: 'Courier New', 'Consolas', 'Monaco', monospace;
            font-size: 10px;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        .bold { font-weight: bold; }
        .double-height { font-size: 14px; font-weight: bold; }
        .double-width { font-size: 12px; font-weight: bold; letter-spacing: 1px; }
        
        .divider {
            border: none;
            border-top: 1px dashed #000;
            margin: 3px 0;
        }
        
        .divider-double {
            border: none;
            border-top: 2px solid #000;
            margin: 3px 0;
        }

        .item-name { font-weight: bold; }
        .item-detail { font-size: 9px; padding-left: 4px; }
        .item-price { text-align: right; }
        
        .total-section {
            font-size: 12px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        td {
            vertical-align: top;
            padding: 1px 0;
        }

        .qr-placeholder {
            text-align: center;
            margin: 5px 0;
            font-size: 8px;
            border: 1px dashed #ccc;
            padding: 10px;
        }

        /* Configuración de impresión */
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            
            body {
                width: 80mm;
                margin: 0;
                padding: 2mm;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none !important;
            }
        }

        /* Vista previa en pantalla */
        @media screen {
            body {
                margin: 20px auto;
                padding: 10px;
                border: 1px solid #ddd;
                box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
                min-height: 200px;
            }
        }
    </style>
</head>
<body onload="window.print(); setTimeout(function() { window.close(); }, 1500);">
    
    {{-- ENCABEZADO --}}
    <div class="text-center">
        <div class="double-height">HELADERÍA</div>
        <div class="double-width">EL POLO</div>
        <small>RUC: 12345678901</small><br>
        <small>Av. Siempre Viva 742</small><br>
        <small>Tel: (01) 555-1234</small>
    </div>
    
    <div class="divider-double"></div>
    
    {{-- DATOS DEL TICKET --}}
    <table>
        <tr>
            <td class="text-left bold">Ticket:</td>
            <td class="text-right">#{{ $ticket->ticket_number }}</td>
        </tr>
        <tr>
            <td class="text-left bold">Fecha:</td>
            <td class="text-right">{{ $ticket->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="text-left bold">Hora:</td>
            <td class="text-right">{{ $ticket->created_at->format('H:i:s') }}</td>
        </tr>
        <tr>
            <td class="text-left bold">Cliente:</td>
            <td class="text-right">{{ $ticket->customer_name }}</td>
        </tr>
    </table>
    
    <div class="divider-double"></div>
    
    {{-- DETALLE DE PRODUCTOS --}}
    <table>
        <thead>
            <tr class="bold">
                <td colspan="2">PRODUCTO</td>
                <td class="text-center">CANT</td>
                <td class="text-right">PRECIO</td>
            </tr>
        </thead>
        <tbody>
            @foreach($ticket->items as $item)
                <tr>
                    <td colspan="2" class="item-name">
                        {{ strtoupper($item->product_name) }}
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                
                {{-- Detalles de personalización --}}
                @if($item->options)
                    @php $opt = $item->options; @endphp
                    
                    {{-- Tipo y cono --}}
                    @if(isset($opt['tipo']) && $opt['tipo'])
                        <tr>
                            <td colspan="4" class="item-detail">
                                Tipo: {{ ucfirst($opt['tipo']) }}
                                @if(isset($opt['cono_tipo']) && $opt['cono_tipo'])
                                    ({{ ucfirst($opt['cono_tipo']) }})
                                @endif
                            </td>
                        </tr>
                    @endif
                    
                    {{-- Sabores --}}
                    @if(!empty($opt['sabores']))
                        <tr>
                            <td colspan="4" class="item-detail">
                                Sabores:
                                @foreach($opt['sabores'] as $sabor)
                                    {{ $sabor['sabor'] }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    
                    {{-- Toppings --}}
                    @if(!empty($opt['toppings']))
                        <tr>
                            <td colspan="4" class="item-detail">
                                + Toppings: {{ implode(', ', $opt['toppings']) }}
                            </td>
                        </tr>
                    @endif
                    
                    {{-- Notas adicionales --}}
                    @if(isset($opt['notas']) && $opt['notas'])
                        <tr>
                            <td colspan="4" class="item-detail">
                                Nota: {{ $opt['notas'] }}
                            </td>
                        </tr>
                    @endif
                    
                    {{-- Línea separadora entre items --}}
                    <tr>
                        <td colspan="4" style="font-size: 6px;">- - - - - - - - - - - - - - - - - - - - - - - -</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    
    <div class="divider"></div>
    
    {{-- TOTAL --}}
    <table class="total-section">
        <tr>
            <td class="text-left bold double-width">TOTAL</td>
            <td class="text-right bold double-width">S/. {{ number_format($ticket->total, 2) }}</td>
        </tr>
    </table>
    
    <div class="divider-double"></div>
    
    {{-- PIE DEL TICKET --}}
    <div class="text-center">
        <p class="bold">¡GRACIAS POR SU COMPRA!</p>
        <small>Vuelva pronto</small>
        <br>
        <small>Síguenos en redes sociales</small>
        <br>
        <small>@heladeriaelpolo</small>
    </div>
    
    <div class="divider"></div>
    
    {{-- MENSAJE DE CORTE DE PAPEL --}}
    <div class="text-center" style="font-size: 8px;">
        - - - - - - - - - - - - - - - - - - -<br>
        CORTAR AQUÍ<br>
        - - - - - - - - - - - - - - - - - - -<br>
    </div>
    
    {{-- BOTÓN DE IMPRIMIR (solo visible en pantalla) --}}
    <div class="text-center no-print" style="margin-top: 15px;">
        <button onclick="window.print();" style="
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        ">
            🖨️ Imprimir Ticket
        </button>
        <br><br>
        <small style="color: #666;">Si no se abre el diálogo de impresión,<br>presiona Ctrl+P o haz clic en el botón</small>
    </div>

    {{-- Script para forzar impresión y cierre --}}
    <script>
        // Pequeño delay para asegurar que la página cargue antes de imprimir
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
            
            // Cerrar ventana después de imprimir (si se abrió como popup)
            window.onafterprint = function() {
                setTimeout(function() {
                    window.close();
                }, 1000);
            };
        };
    </script>
</body>
</html>
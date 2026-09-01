<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #<?php echo e($ticket->ticket_number); ?></title>
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
    
    
    <div class="text-center">
        <div class="double-height">HELADERÍA</div>
        <div class="double-width">EL POLO</div>
        <small>RUC: 12345678901</small><br>
        <small>Av. Siempre Viva 742</small><br>
        <small>Tel: (01) 555-1234</small>
    </div>
    
    <div class="divider-double"></div>
    
    
    <table>
        <tr>
            <td class="text-left bold">Ticket:</td>
            <td class="text-right">#<?php echo e($ticket->ticket_number); ?></td>
        </tr>
        <tr>
            <td class="text-left bold">Fecha:</td>
            <td class="text-right"><?php echo e($ticket->created_at->format('d/m/Y')); ?></td>
        </tr>
        <tr>
            <td class="text-left bold">Hora:</td>
            <td class="text-right"><?php echo e($ticket->created_at->format('H:i:s')); ?></td>
        </tr>
        <tr>
            <td class="text-left bold">Cliente:</td>
            <td class="text-right"><?php echo e($ticket->customer_name); ?></td>
        </tr>
        <tr>
            <td class="text-left bold">Atendido por:</td>
            <td class="text-right"><?php echo e($ticket->user->name ?? 'N/D'); ?></td>
        </tr>
    </table>
    
    <div class="divider-double"></div>
    
    
    <table>
        <thead>
            <tr class="bold">
                <td colspan="2">PRODUCTO</td>
                <td class="text-center">CANT</td>
                <td class="text-right">PRECIO</td>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $ticket->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="2" class="item-name">
                        <?php echo e(strtoupper($item->product_name)); ?>

                    </td>
                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                    <td class="text-right"><?php echo e(number_format($item->subtotal, 2)); ?></td>
                </tr>
                
                
                <?php if($item->options): ?>
                    <?php $opt = $item->options; ?>
                    
                    
                    <?php if(isset($opt['tipo']) && $opt['tipo']): ?>
                        <tr>
                            <td colspan="4" class="item-detail">
                                Tipo: <?php echo e(ucfirst($opt['tipo'])); ?>

                                <?php if(isset($opt['cono_tipo']) && $opt['cono_tipo']): ?>
                                    (<?php echo e(ucfirst($opt['cono_tipo'])); ?>)
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    
                    <?php if(!empty($opt['sabores'])): ?>
                        <tr>
                            <td colspan="4" class="item-detail">
                                Sabores:
                                <?php $__currentLoopData = $opt['sabores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sabor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($sabor['sabor']); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    
                    <?php if(!empty($opt['toppings'])): ?>
                        <tr>
                            <td colspan="4" class="item-detail">
                                + Toppings: <?php echo e(implode(', ', $opt['toppings'])); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    
                    <?php if(isset($opt['notas']) && $opt['notas']): ?>
                        <tr>
                            <td colspan="4" class="item-detail">
                                Nota: <?php echo e($opt['notas']); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    
                    <tr>
                        <td colspan="4" style="font-size: 6px;">- - - - - - - - - - - - - - - - - - - - - - - -</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div class="divider"></div>
    
    
    <table class="total-section">
        <tr>
            <td class="text-left bold double-width">TOTAL</td>
            <td class="text-right bold double-width">S/. <?php echo e(number_format($ticket->total, 2)); ?></td>
        </tr>
    </table>
    
    <div class="divider-double"></div>
    
    
    <div class="text-center">
        <p class="bold">¡GRACIAS POR SU COMPRA!</p>
        <small>Vuelva pronto</small>
        <br>
        <small>Síguenos en redes sociales</small>
        <br>
        <small>@heladeriaelpolo</small>
    </div>
    
    <div class="divider"></div>
    
    
    <div class="text-center" style="font-size: 8px;">
        - - - - - - - - - - - - - - - - - - -<br>
        CORTAR AQUÍ<br>
        - - - - - - - - - - - - - - - - - - -<br>
    </div>
    
    
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
</html><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/tickets/print.blade.php ENDPATH**/ ?>
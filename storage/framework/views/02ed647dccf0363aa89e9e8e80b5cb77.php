<?php $__env->startSection('title', 'Ventas del Día'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-600">📊 Ventas de hoy — <?php echo e($today->format('d/m/Y')); ?></h2>
            <a href="<?php echo e(route('admin.panel')); ?>" class="text-sm text-gray-500 hover:text-gray-700">← Volver al panel</a>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl shadow-md p-6 border-2 border-green-200 text-center">
                <div class="text-3xl mb-1">💰</div>
                <p class="text-2xl font-bold text-green-600">S/ <?php echo e(number_format($totalVendidoHoy, 2)); ?></p>
                <p class="text-sm text-gray-500">Total vendido hoy</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 border-2 border-yellow-200 text-center">
                <div class="text-3xl mb-1">🧾</div>
                <p class="text-2xl font-bold text-yellow-600"><?php echo e($totalTicketsHoy); ?></p>
                <p class="text-sm text-gray-500">Tickets del día</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 border-2 border-blue-200 text-center">
                <div class="text-3xl mb-1">📋</div>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($ticketsAbiertos); ?> / <?php echo e($ticketsCerrados); ?></p>
                <p class="text-sm text-gray-500">Abiertos / Cerrados</p>
            </div>
        </div>

        <!-- Ventas por trabajador -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-200 mb-8">
            <h3 class="text-lg font-semibold text-purple-600 mb-4">👥 Ventas por trabajador</h3>

            <?php if($ventasPorTrabajador->isEmpty()): ?>
                <p class="text-gray-500 text-center py-4">Todavía no hay ventas registradas hoy.</p>
            <?php else: ?>
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
                            <?php $__currentLoopData = $ventasPorTrabajador; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b last:border-0">
                                    <td class="py-3"><?php echo e($fila->trabajador); ?></td>
                                    <td class="py-3 text-center"><?php echo e($fila->total_tickets); ?></td>
                                    <td class="py-3 text-right font-bold text-purple-600">S/ <?php echo e(number_format($fila->total_vendido, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if($ventasSinTrabajador > 0): ?>
                <p class="text-xs text-gray-400 mt-3">
                    ⓘ <?php echo e($ventasSinTrabajador); ?> ticket(s) de hoy no tienen trabajador asociado (creados antes de activar la trazabilidad).
                </p>
            <?php endif; ?>
        </div>

        <!-- Ventas por producto -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-yellow-200">
            <h3 class="text-lg font-semibold text-yellow-600 mb-4">🍦 Ventas por producto</h3>

            <?php if($ventasPorProducto->isEmpty()): ?>
                <p class="text-gray-500 text-center py-4">Todavía no hay productos vendidos hoy.</p>
            <?php else: ?>
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
                            <?php $__currentLoopData = $ventasPorProducto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b last:border-0">
                                    <td class="py-3"><?php echo e($fila->product_name); ?></td>
                                    <td class="py-3 text-center"><?php echo e($fila->cantidad_vendida); ?></td>
                                    <td class="py-3 text-right font-bold text-yellow-600">S/ <?php echo e(number_format($fila->total_vendido, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/admin/reports/daily.blade.php ENDPATH**/ ?>
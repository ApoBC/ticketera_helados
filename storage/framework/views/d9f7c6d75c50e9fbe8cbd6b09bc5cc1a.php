

<?php $__env->startSection('title', 'Dashboard Vendedor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Encabezado con botón Nuevo Ticket -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-yellow-200 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="text-4xl mr-4">🍦</div>
                    <div>
                        <h2 class="text-2xl font-bold text-yellow-600">Dashboard Vendedor</h2>
                        <p class="text-gray-600">Bienvenido, <?php echo e(Auth::user()->name); ?></p>
                        <p class="text-sm text-gray-500"><?php echo e(date('d/m/Y H:i')); ?></p>
                    </div>
                </div>
                <!-- BOTÓN NUEVO TICKET -->
                <a href="<?php echo e(route('vendedor.tickets.create')); ?>" 
                   class="bg-blue-500 hover:bg-red-600 text-black font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-plus-circle"></i> Nuevo Ticket
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl p-6 shadow-md">
                <div class="text-2xl mb-1">📊</div>
                <div class="text-2xl font-bold text-yellow-700">S/ <?php echo e(number_format($totalVentasHoy ?? 0, 2)); ?></div>
                <p class="text-sm text-gray-600">Ventas de hoy</p>
            </div>
            <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl p-6 shadow-md">
                <div class="text-2xl mb-1">🧾</div>
                <div class="text-2xl font-bold text-blue-700"><?php echo e($totalTicketsHoy ?? 0); ?></div>
                <p class="text-sm text-gray-600">Tickets de hoy</p>
            </div>
            <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-xl p-6 shadow-md">
                <div class="text-2xl mb-1">✅</div>
                <div class="text-2xl font-bold text-green-700"><?php echo e($ticketsCerrados ?? 0); ?></div>
                <p class="text-sm text-gray-600">Cerrados</p>
            </div>
            <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl p-6 shadow-md">
                <div class="text-2xl mb-1">⏳</div>
                <div class="text-2xl font-bold text-red-700"><?php echo e($ticketsAbiertos ?? 0); ?></div>
                <p class="text-sm text-gray-600">Abiertos</p>
            </div>
        </div>

        <!-- Mensaje de éxito -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Tickets Activos -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-yellow-200 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <i class="fas fa-list text-yellow-500 mr-2"></i> 
                Tickets Activos
                <span class="ml-2 text-sm text-gray-500">(<?php echo e($ticketsActivos->count()); ?>)</span>
            </h3>
            
            <?php if($ticketsActivos->isEmpty()): ?>
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <p class="text-gray-500">No hay tickets activos</p>
                    <p class="text-sm text-gray-400 mt-2">Crea un nuevo ticket para comenzar</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Ticket</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Cliente</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Total</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Fecha</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ticketsActivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-100 hover:bg-yellow-50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800"><?php echo e($ticket->ticket_number); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($ticket->customer_name); ?></td>
                                    <td class="px-4 py-3 text-sm font-bold text-yellow-600">S/ <?php echo e(number_format($ticket->total, 2)); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex space-x-2">
                                            <a href="<?php echo e(route('tickets.show', $ticket)); ?>" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-full text-xs">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <a href="<?php echo e(route('tickets.print', $ticket)); ?>" 
                                               target="_blank"
                                               class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-full text-xs">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('tickets.close', $ticket)); ?>" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" 
                                                        class="bg-black-500 hover:bg-black-600 text-Black py-1 px-3 rounded-full text-xs"
                                                        onclick="return confirm('¿Cerrar este ticket?')">
                                                    <i class="fas fa-check"></i> Cerrar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tickets de hoy -->
        <div class="bg-black rounded-2xl shadow-xl p-6 border-2 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <i class="fas fa-history text-gray-500 mr-2"></i> 
                Tickets de Hoy
                <span class="ml-2 text-sm text-gray-500">(<?php echo e($ticketsHoy->count()); ?>)</span>
            </h3>
            
            <?php if($ticketsHoy->isEmpty()): ?>
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <p class="text-gray-500">No hay tickets registrados hoy</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Ticket</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Cliente</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Total</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Estado</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ticketsHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-100 hover:bg-blue-50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800"><?php echo e($ticket->ticket_number); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($ticket->customer_name); ?></td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-600">S/ <?php echo e(number_format($ticket->total, 2)); ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <?php if($ticket->status === 'abierto'): ?>
                                            <span class="bg-yellow-100 text-black-800 py-1 px-3 rounded-full text-xs">Abierto</span>
                                        <?php else: ?>
                                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Cerrado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Heladeria v1\ticketera_helados\resources\views/vendedor/dashboard.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Dashboard Vendedor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Encabezado con botón Nuevo Ticket -->
        <div class="card mb-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-xl bg-ink flex items-center justify-center text-2xl mr-4">🍦</div>
                    <div>
                        <h2 class="text-2xl font-bold text-ink">Dashboard Vendedor</h2>
                        <p class="text-gray-500">Bienvenido, <?php echo e(Auth::user()->name); ?></p>
                        <p class="text-sm text-gray-400"><?php echo e(date('d/m/Y H:i')); ?></p>
                    </div>
                </div>
                <a href="<?php echo e(route('vendedor.tickets.create')); ?>" class="btn-ink text-lg">
                    <i class="fas fa-plus-circle mr-2"></i> Nuevo Ticket
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="card !p-6">
                <div class="w-10 h-10 rounded-lg bg-mint flex items-center justify-center text-xl mb-2">📊</div>
                <div class="text-2xl font-bold text-ink">S/ <?php echo e(number_format($totalVentasHoy ?? 0, 2)); ?></div>
                <p class="text-sm text-gray-500">Ventas de hoy</p>
            </div>
            <div class="card !p-6">
                <div class="w-10 h-10 rounded-lg bg-mint flex items-center justify-center text-xl mb-2">🧾</div>
                <div class="text-2xl font-bold text-ink"><?php echo e($totalTicketsHoy ?? 0); ?></div>
                <p class="text-sm text-gray-500">Tickets de hoy</p>
            </div>
            <div class="card !p-6">
                <div class="w-10 h-10 rounded-lg bg-mint flex items-center justify-center text-xl mb-2">✅</div>
                <div class="text-2xl font-bold text-ink"><?php echo e($ticketsCerrados ?? 0); ?></div>
                <p class="text-sm text-gray-500">Cerrados</p>
            </div>
            <div class="card !p-6">
                <div class="w-10 h-10 rounded-lg bg-mint flex items-center justify-center text-xl mb-2">⏳</div>
                <div class="text-2xl font-bold text-ink"><?php echo e($ticketsAbiertos ?? 0); ?></div>
                <p class="text-sm text-gray-500">Abiertos</p>
            </div>
        </div>

        <!-- Mensaje de éxito -->
        <?php if(session('success')): ?>
            <div class="bg-mint border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Tickets Activos -->
        <div class="card mb-6">
            <h3 class="text-lg font-semibold text-ink mb-4 flex items-center">
                <i class="fas fa-list text-gray-400 mr-2"></i> 
                Tickets Activos
                <span class="ml-2 text-sm text-gray-400">(<?php echo e($ticketsActivos->count()); ?>)</span>
            </h3>
            
            <?php if($ticketsActivos->isEmpty()): ?>
                <div class="bg-mint rounded-xl p-8 text-center">
                    <p class="text-gray-500">No hay tickets activos</p>
                    <p class="text-sm text-gray-400 mt-2">Crea un nuevo ticket para comenzar</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Ticket</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Cliente</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Total</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Fecha</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ticketsActivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-50 hover:bg-mint/50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-ink"><?php echo e($ticket->ticket_number); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($ticket->customer_name); ?></td>
                                    <td class="px-4 py-3 text-sm font-bold text-ink">S/ <?php echo e(number_format($ticket->total, 2)); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-400"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="btn-ink !h-10 !px-4 text-sm">
                                                <i class="fas fa-eye mr-1"></i> Ver
                                            </a>
                                            <a href="<?php echo e(route('tickets.print', $ticket)); ?>" target="_blank"
                                               class="h-10 w-10 flex items-center justify-center bg-white border border-gray-200 hover:bg-gray-50 text-ink rounded-full active:scale-95 transition-transform">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('tickets.close', $ticket)); ?>" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" 
                                                        class="btn-outline !h-10 !px-4 text-sm"
                                                        onclick="return confirm('¿Cerrar este ticket?')">
                                                    <i class="fas fa-check mr-1"></i> Cerrar
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
        <div class="card">
            <h3 class="text-lg font-semibold text-ink mb-4 flex items-center">
                <i class="fas fa-history text-gray-400 mr-2"></i> 
                Tickets de Hoy
                <span class="ml-2 text-sm text-gray-400">(<?php echo e($ticketsHoy->count()); ?>)</span>
            </h3>
            
            <?php if($ticketsHoy->isEmpty()): ?>
                <div class="bg-mint rounded-xl p-8 text-center">
                    <p class="text-gray-500">No hay tickets registrados hoy</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Ticket</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Cliente</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Total</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Estado</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-400">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ticketsHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-50 hover:bg-mint/50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-ink"><?php echo e($ticket->ticket_number); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($ticket->customer_name); ?></td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-600">S/ <?php echo e(number_format($ticket->total, 2)); ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <?php if($ticket->status === 'abierto'): ?>
                                            <span class="bg-mint text-green-800 py-1 px-3 rounded-full text-xs font-medium">Abierto</span>
                                        <?php else: ?>
                                            <span class="bg-ink text-white py-1 px-3 rounded-full text-xs font-medium">Cerrado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-400"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/vendedor/dashboard.blade.php ENDPATH**/ ?>
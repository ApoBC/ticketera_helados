<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tickets - Heladería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Tickets del día <?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?></h1>
            <a href="<?php echo e(route('vendedor.tickets.create')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300">
    <i class="fas fa-plus-circle"></i> Nuevo Ticket
</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($tickets->isEmpty()): ?>
            <div class="alert alert-info">No hay tickets registrados hoy.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ticket #</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($ticket->ticket_number); ?></td>
                                <td><?php echo e($ticket->customer_name); ?></td>
                                <td>$<?php echo e(number_format($ticket->total, 2)); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($ticket->status === 'abierto' ? 'success' : 'secondary'); ?>">
                                        <?php echo e(ucfirst($ticket->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($ticket->created_at->format('H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                    <a href="<?php echo e(route('tickets.print', $ticket)); ?>" class="btn btn-sm btn-outline-secondary" target="_blank">Imprimir</a>
                                    <?php if($ticket->status === 'abierto'): ?>
                                        <form action="<?php echo e(route('tickets.close', $ticket)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Cerrar</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Heladeria v1\ticketera_helados\resources\views/tickets/index.blade.php ENDPATH**/ ?>
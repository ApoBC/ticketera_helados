<nav class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo: chip negro + texto bold, estilo del sistema de diseño -->
            <div class="flex items-center">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-ink flex items-center justify-center text-lg">🍦</span>
                    <span class="text-lg font-bold text-ink">Heladería</span>
                </a>
            </div>

            <!-- Menú de navegación -->
            <div class="flex items-center gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->isSuperAdmin()): ?>
                        <a href="<?php echo e(route('superadmin.panel')); ?>" class="text-sm font-medium text-gray-600 hover:text-ink transition-colors">
                            <i class="fas fa-crown"></i> Superadmin
                        </a>
                    <?php endif; ?>
                    <?php if(Auth::user()->isAdminOrAbove()): ?>
                        <a href="<?php echo e(route('admin.panel')); ?>" class="text-sm font-medium text-gray-600 hover:text-ink transition-colors">
                            <i class="fas fa-cog"></i> Admin
                        </a>
                        <a href="<?php echo e(route('admin.team.index')); ?>" class="text-sm font-medium text-gray-600 hover:text-ink transition-colors">
                            <i class="fas fa-users"></i> Equipo
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('account.password.edit')); ?>" class="w-9 h-9 flex items-center justify-center rounded-full bg-mint text-ink hover:bg-gray-100 transition-colors" title="Cambiar contraseña">
                        <i class="fas fa-key text-sm"></i>
                    </a>

                    <div class="flex items-center gap-2 pl-2 border-l border-gray-100">
                        <div class="text-right leading-tight hidden sm:block">
                            <p class="text-sm font-semibold text-ink"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-gray-400 capitalize"><?php echo e(Auth::user()->role); ?></p>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-ink !h-10 !px-4 text-sm">
                            <i class="fas fa-sign-out-alt mr-2"></i> Salir
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-600 hover:text-ink transition-colors">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="btn-ink !h-10 !px-5 text-sm">
                        Registrarse
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>
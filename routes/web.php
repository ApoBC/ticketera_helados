<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Models\Product;

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (protegido)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Rutas protegidas por roles
Route::middleware(['auth'])->group(function () {

    // Rutas de tickets (compartidas por todos los roles autenticados)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/print', [TicketController::class, 'print'])->name('tickets.print');
    Route::patch('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::post('/tickets/{ticket}/items', [TicketController::class, 'addItem'])->name('tickets.items.store');

    // Cambiar la propia contraseña (cualquier usuario autenticado, sin importar el rol)
    Route::get('/mi-cuenta/password', [AccountController::class, 'editPassword'])->name('account.password.edit');
    Route::patch('/mi-cuenta/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    // Admin (accesible por admin y superadmin, ya que superadmin puede hacer todo lo de admin)
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/admin/panel', function () {
            $lowStockCount = Product::whereNotNull('stock')
                ->whereColumn('stock', '<=', 'low_stock_threshold')
                ->count();
            return view('admin.panel', compact('lowStockCount'));
        })->name('admin.panel');

        Route::get('/admin/tickets', [TicketController::class, 'index'])
            ->name('admin.tickets.index');

        // CRUD de productos (helados, toppings, bebidas, postres)
        Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::patch('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::patch('/admin/products/{product}/toggle', [ProductController::class, 'toggleActive'])->name('admin.products.toggle');
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // Dashboard de ventas del día
        Route::get('/admin/reports/daily', [ReportController::class, 'daily'])->name('admin.reports.daily');

        // Gestión de equipo: superadmin ve/edita a todos, admin solo a vendedores
        // (el control fino de "quién puede tocar a quién" vive en UserController)
        Route::get('/admin/team', [UserController::class, 'index'])->name('admin.team.index');
        Route::get('/admin/team/create', [UserController::class, 'create'])->name('admin.team.create');
        Route::post('/admin/team', [UserController::class, 'store'])->name('admin.team.store');
        Route::get('/admin/team/{user}/edit', [UserController::class, 'edit'])->name('admin.team.edit');
        Route::patch('/admin/team/{user}', [UserController::class, 'update'])->name('admin.team.update');
        Route::patch('/admin/team/{user}/role', [UserController::class, 'updateRole'])->name('admin.team.updateRole');
        Route::delete('/admin/team/{user}', [UserController::class, 'destroy'])->name('admin.team.destroy');
    });

    // Superadmin (zona exclusiva)
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/superadmin/panel', function () {
            return view('superadmin.panel');
        })->name('superadmin.panel');
    });

    // Vendedor - TODAS las rutas de tickets
    Route::middleware('role:vendedor')->group(function () {
        // Dashboard del vendedor
        Route::get('/vendedor/dashboard', [TicketController::class, 'vendedorDashboard'])
            ->name('vendedor.dashboard');
        
        // Crear ticket
        Route::get('/vendedor/tickets/create', [TicketController::class, 'create'])
            ->name('vendedor.tickets.create');
        
        // Guardar ticket
        Route::post('/vendedor/tickets', [TicketController::class, 'store'])
            ->name('vendedor.tickets.store');
    });
});
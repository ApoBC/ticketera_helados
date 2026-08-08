<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Ruta principal
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

// ... otras rutas ...

    // Rutas de tickets (compartidas)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/print', [TicketController::class, 'print'])->name('tickets.print');
    Route::patch('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    
    // 👇 AGREGAR ESTA RUTA
    Route::post('/tickets/{ticket}/items', [TicketController::class, 'addItem'])->name('tickets.items.store');
    // Admin
    Route::get('/admin/panel', function () {
        return view('admin.panel');
    })->middleware('role:admin')->name('admin.panel');

    Route::get('/admin/tickets', [TicketController::class, 'index'])
        ->middleware('role:admin')->name('admin.tickets.index');

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

    // Rutas de tickets (compartidas)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/print', [TicketController::class, 'print'])->name('tickets.print');
    Route::patch('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
});
<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('/tickets/{ticket}/items', [OrderItemController::class, 'store'])->name('tickets.items.store');
Route::post('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
Route::get('/tickets/{ticket}/print', [TicketController::class, 'print'])->name('tickets.print');
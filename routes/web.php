<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/login', '/admin/login')->name('login');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/buscar', [HomeController::class, 'search'])->name('search');

Route::get('/elegir/{id}', [SeatController::class, 'select'])->name('seats');

Route::post('/comprar', [SeatController::class, 'purchase'])->name('purchase');

Route::get('/imprimir', [TicketController::class, 'print'])->name('tickets.print');

Route::get('/lang/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/validar', [ValidationController::class, 'index'])->name('validation.index');
Route::post('/validar', [ValidationController::class, 'validate'])->name('validation.validate');

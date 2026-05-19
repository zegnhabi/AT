<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\BrandingController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('drivers', DriverController::class)->except(['show']);

    Route::resource('buses', BusController::class)->except(['show']);

    Route::get('ciudades', [CityController::class, 'index'])->name('cities.index');
    Route::get('ciudades/{city}/viajes', [CityController::class, 'trips'])->name('cities.trips');

    Route::get('viajes', [TripController::class, 'index'])->name('trips.index');
    Route::get('viajes/{trip}', [TripController::class, 'show'])->name('trips.show');
    Route::delete('viajes/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

    Route::get('corte', [CashierController::class, 'corte'])->name('cashier.corte');
    Route::get('arqueo', [CashierController::class, 'arqueo'])->name('cashier.arqueo');

    Route::get('marca', [BrandingController::class, 'index'])->name('branding');
    Route::post('marca', [BrandingController::class, 'update']);
    Route::get('marca/restaurar-logo', [BrandingController::class, 'resetLogo'])->name('branding.reset-logo');
    Route::get('marca/restaurar-favicon', [BrandingController::class, 'resetFavicon'])->name('branding.reset-favicon');
});

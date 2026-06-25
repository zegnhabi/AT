<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\BrandingController;
use App\Http\Controllers\Admin\CancellationController;
use App\Http\Controllers\Admin\AuthController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('drivers', DriverController::class)->except(['show']);

        Route::resource('buses', BusController::class)->except(['show']);

        Route::get('ciudades', [CityController::class, 'index'])->name('cities.index');
        Route::post('ciudades', [CityController::class, 'store'])->name('cities.store');
        Route::get('ciudades/{city}/viajes', [CityController::class, 'trips'])->name('cities.trips');

        Route::get('viajes', [TripController::class, 'index'])->name('trips.index');
        Route::get('viajes/crear', [TripController::class, 'create'])->name('trips.create');
        Route::post('viajes', [TripController::class, 'store'])->name('trips.store');
        Route::get('viajes/{trip}', [TripController::class, 'show'])->name('trips.show');
        Route::get('viajes/{trip}/editar', [TripController::class, 'edit'])->name('trips.edit');
        Route::put('viajes/{trip}', [TripController::class, 'update'])->name('trips.update');
        Route::delete('viajes/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

        Route::get('corte', [CashierController::class, 'corte'])->name('cashier.corte');
        Route::get('corte/exportar', [CashierController::class, 'exportCorte'])->name('cashier.corte.export');
        Route::get('arqueo', [CashierController::class, 'arqueo'])->name('cashier.arqueo');
        Route::get('arqueo/exportar', [CashierController::class, 'exportArqueo'])->name('cashier.arqueo.export');

        Route::get('viajes/{trip}/pasajeros', [TripController::class, 'pasajeros'])->name('trips.pasajeros');

        Route::get('cancelaciones/{ticket}', [CancellationController::class, 'index'])->name('cancellations.index');
        Route::post('cancelaciones/{ticket}', [CancellationController::class, 'destroy'])->name('cancellations.destroy');

        Route::get('personalizacion', [BrandingController::class, 'index'])->name('branding');
        Route::post('personalizacion', [BrandingController::class, 'update']);
        Route::get('personalizacion/restaurar-logo', [BrandingController::class, 'resetLogo'])->name('branding.reset-logo');
        Route::get('personalizacion/restaurar-favicon', [BrandingController::class, 'resetFavicon'])->name('branding.reset-favicon');

        Route::post('personalizacion/traducciones', [BrandingController::class, 'translationStore'])->name('branding.translation.store');
        Route::put('personalizacion/traducciones/{key}', [BrandingController::class, 'translationUpdate'])->name('branding.translation.update');
        Route::delete('personalizacion/traducciones/{key}', [BrandingController::class, 'translationDestroy'])->name('branding.translation.destroy');
        Route::post('personalizacion/traducciones/importar', [BrandingController::class, 'translationImport'])->name('branding.translation.import');
    });
});

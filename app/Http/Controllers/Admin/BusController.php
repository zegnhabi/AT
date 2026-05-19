<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('driver')->orderBy('id')->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        $drivers = Driver::orderBy('name')->get();
        return view('admin.buses.form', ['bus' => new Bus, 'drivers' => $drivers]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seat_count'    => 'required|integer|min:1|max:100',
            'model_year'    => 'nullable|integer|min:1990|max:' . (now()->year + 1),
            'serial_number' => 'nullable|string|max:20',
            'driver_id'     => 'nullable|exists:drivers,id',
        ]);

        Bus::create($validated);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Autobús creado correctamente.');
    }

    public function edit(Bus $bus)
    {
        $drivers = Driver::orderBy('name')->get();
        return view('admin.buses.form', compact('bus', 'drivers'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'seat_count'    => 'required|integer|min:1|max:100',
            'model_year'    => 'nullable|integer|min:1990|max:' . (now()->year + 1),
            'serial_number' => 'nullable|string|max:20',
            'driver_id'     => 'nullable|exists:drivers,id',
        ]);

        $bus->update($validated);

        return redirect()->route('admin.buses.index')
            ->with('success', 'Autobús actualizado correctamente.');
    }

    public function destroy(Bus $bus)
    {
        $bus->trips()->delete();
        $bus->delete();

        return redirect()->route('admin.buses.index')
            ->with('success', 'Autobús eliminado correctamente.');
    }
}

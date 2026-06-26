<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 25, 50, 'all']) ? $perPage : 10;

        $query = Driver::withCount('buses')->orderBy('name');

        if ($perPage === 'all') {
            $drivers = $query->get();
            $total = max($drivers->count(), 1);
            $drivers = new \Illuminate\Pagination\LengthAwarePaginator(
                $drivers, $drivers->count(), $total, 1,
                ['path' => $request->url(), 'query' => array_merge($request->query(), ['per_page' => 'all'])]
            );
        } else {
            $drivers = $query->paginate($perPage)->withQueryString();
        }

        return view('admin.drivers.index', compact('drivers', 'perPage'));
    }

    public function create()
    {
        return view('admin.drivers.form', ['driver' => new Driver]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:65',
            'gender' => 'nullable|in:M,F',
            'age'    => 'nullable|integer|min:18|max:99',
            'phone'  => 'nullable|string|max:20',
        ]);

        Driver::create($validated);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Chofer creado correctamente.');
    }

    public function edit(Driver $driver)
    {
        return view('admin.drivers.form', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:65',
            'gender' => 'nullable|in:M,F',
            'age'    => 'nullable|integer|min:18|max:99',
            'phone'  => 'nullable|string|max:20',
        ]);

        $driver->update($validated);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Chofer actualizado correctamente.');
    }

    public function destroy(Driver $driver)
    {
        $driver->buses()->update(['driver_id' => null]);
        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Chofer eliminado correctamente.');
    }
}

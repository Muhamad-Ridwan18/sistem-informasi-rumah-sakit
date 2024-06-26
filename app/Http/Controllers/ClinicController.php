<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::latest()->paginate(10);
        return view('clinics.index', compact('clinics'));
    }

    public function create()
    {
        return view('clinics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tarif' => 'nullable|string',
        ]);

        Clinic::create($request->all());

        return redirect()->route('clinics.index')
            ->with('success', 'Clinic registered successfully.');
    }

    public function show(Clinic $clinic)
    {
        return view('clinics.show', compact('clinic'));
    }

    public function edit(Clinic $clinic)
    {
        return view('clinics.edit', compact('clinic'));
    }

    public function update(Request $request, Clinic $clinic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tarif' => 'nullable|string',
        ]);

        $clinic->update($request->all());

        return redirect()->route('clinics.index')
            ->with('success', 'Clinic information updated successfully.');
    }

    public function destroy(Clinic $clinic)
    {
        $clinic->delete();

        return redirect()->route('clinics.index')
            ->with('success', 'Clinic deleted successfully.');
    }
}


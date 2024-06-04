<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Str; 

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);

        return view('medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'jenis' => 'required',
        ]);
        $code = "O" . Str::random(5);

        $medicines = Medicine::create([
            'code' => $code,
            'name' => $request->name,
            'price' => $request->price,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('medicines.index')
            ->with('success', 'Medicines registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'jenis' => 'required',
            'code' => 'required',
        ]);

        $medicines = Medicine::find($id);
        $medicines->update($request->all());

        return redirect()->route('medicines.index')
            ->with('success', 'Medicines updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicines = Medicine::find($id);
        $medicines->delete();
        return redirect()->route('medicines.index')
            ->with('success', 'Medicines deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    public function index()
    {
        $medicalHistories = MedicalHistory::all();
        return view('medical_histories.index', compact('medicalHistories'));
    }

    public function create()
    {
        // Logika untuk menampilkan form pembuatan riwayat medis baru
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
        ]);

        // Simpan riwayat medis baru ke dalam database
        MedicalHistory::create($request->all());

        return redirect()->route('medical_histories.index')
            ->with('success', 'Medical history created successfully.');
    }

    public function show(MedicalHistory $medicalHistory)
    {
        // Logika untuk menampilkan detail riwayat medis
    }

    public function edit(MedicalHistory $medicalHistory)
    {
        // Logika untuk menampilkan form pengeditan riwayat medis
    }

    public function update(Request $request, MedicalHistory $medicalHistory)
    {
        // Validasi input
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
        ]);

        // Perbarui riwayat medis yang ada di database
        $medicalHistory->update($request->all());

        return redirect()->route('medical_histories.show', $medicalHistory)
            ->with('success', 'Medical history updated successfully.');
    }

    public function destroy(MedicalHistory $medicalHistory)
    {
        // Hapus riwayat medis dari database
        $medicalHistory->delete();

        return redirect()->route('medical_histories.index')
            ->with('success', 'Medical history deleted successfully.');
    }
}

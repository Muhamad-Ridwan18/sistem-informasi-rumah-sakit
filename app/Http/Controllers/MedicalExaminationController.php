<?php

namespace App\Http\Controllers;

use App\Models\MedicalExamination;
use Illuminate\Http\Request;

class MedicalExaminationController extends Controller
{
    public function index()
    {
        $medicalExaminations = MedicalExamination::all();
        return view('medical_examinations.index', compact('medicalExaminations'));
    }

    public function create()
    {
        return view('medical_examinations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'examination_datetime' => 'required|date',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        MedicalExamination::create($request->all());

        return redirect()->route('medical_examinations.index')
            ->with('success', 'Medical examination registered successfully.');
    }

    public function show(MedicalExamination $medicalExamination)
    {
        return view('medical_examinations.show', compact('medicalExamination'));
    }

    public function edit(MedicalExamination $medicalExamination)
    {
        return view('medical_examinations.edit', compact('medicalExamination'));
    }

    public function update(Request $request, MedicalExamination $medicalExamination)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'examination_datetime' => 'required|date',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        $medicalExamination->update($request->all());

        return redirect()->route('medical_examinations.show', $medicalExamination)
            ->with('success', 'Medical examination information updated successfully.');
    }

    public function destroy(MedicalExamination $medicalExamination)
    {
        $medicalExamination->delete();

        return redirect()->route('medical_examinations.index')
            ->with('success', 'Medical examination deleted successfully.');
    }
}

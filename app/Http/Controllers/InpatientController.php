<?php

namespace App\Http\Controllers;

use App\Models\Inpatient;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Room;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class InpatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Inpatient::query();

        // Apply date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $inpatients = $query->with(['patient', 'room'])->latest()->paginate(10);
        
        $patients = Patient::all();
        $doctors = Doctor::all();
        $rooms = Room::all();

        return view('inpatients.index', compact('inpatients', 'patients', 'doctors', 'rooms'));
    }


    public function create()
    {
        return view('inpatients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'admitted_at' => 'required|date_format:Y-m-d\TH:i',
            'discharged_at' => 'nullable|date_format:Y-m-d\TH:i',
            'room_number' => 'required|string',
        ]);

        $admitted_at = Carbon::now()->toDateTimeString();
        $inpatient = Inpatient::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'admitted_at' => $admitted_at,
            'discharged_at' => $request->discharged_at,
            'room_number' => $request->room_number,
        ]);


        return redirect()->route('inpatients.index')
            ->with('success', 'Inpatient registered successfully.');
    }

    public function show(Inpatient $inpatient)
    {
        return view('inpatients.show', compact('inpatient'));
    }

    public function edit(Inpatient $inpatient)
    {
        return view('inpatients.edit', compact('inpatient'));
    }

    public function update(Request $request, Inpatient $inpatient)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'admitted_at' => 'required|date_format:Y-m-d\TH:i',
            'discharged_at' => 'nullable|date_format:Y-m-d\TH:i',
            'room_number' => 'required|string',
        ]);

        $inpatient->update($request->all());

        return redirect()->route('inpatients.index')
            ->with('success', 'Inpatient information updated successfully.');
    }

    public function destroy(Inpatient $inpatient)
    {
        $inpatient->delete();

        return redirect()->route('inpatients.index')
            ->with('success', 'Inpatient deleted successfully.');
    }

    public function printBracelet(Inpatient $inpatient)
    {
        $pdf = Pdf::loadView('inpatients.bracelet', compact('inpatient'))
        ->setPaper([0, 0, 671, 200], 'potrait');

        return $pdf->stream('bracelet.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Inpatient;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Room;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InpatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Inpatient::query();
        // create query for filter data in view where room_number
        if ($request->has('room_number')) {
            $room_number = $request->input('room_number');
            $query = Inpatient::where('room_number', $room_number);
        }
        $inpatients = $query->with(['patient','room'])->paginate(10);
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

        Inpatient::create($request->all());

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

<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Clinic;
use App\Models\MedicalHistory;
use App\Models\MedicalExamination;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        // Check for search input
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('full_name', 'like', "%{$search}%")
                ->orWhere('medical_record_number', 'like', "%{$search}%");
        }
        // Check for gender
        if ($request->has('gender')) {
            $gender = $request->input('gender');
            if (!empty($gender)) {
                $query->where('gender', $gender);
            }
        }

        // Check for created_at
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }    

        $patients = $query->latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $clinics = Clinic::all();
        return view('patients.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:patients',
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'address' => 'required|string',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $medicalRecordNumber = 'MR-' . random_int(10000000, 99999999);
        $patient = Patient::create(array_merge(
            $request->all(),
            ['medical_record_number' => $medicalRecordNumber]
        ));

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        $doctors = Doctor::all();
        $medicalHistories = $patient->medicalHistories()->latest()->get();
        $medicalExaminations = $patient->medicalExaminations()->latest()->get();
        
        return view('patients.show', compact('patient', 'medicalHistories', 'medicalExaminations', 'doctors'));
    }

    public function edit(Patient $patient)
    {
        $clinics = Clinic::all();
        return view('patients.edit', compact('patient', 'clinics'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => ['required', 'string', 'max:20', Rule::unique('patients')->ignore($patient->id)],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'address' => 'required|string',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',

        ]);

        $patient->update($request->all());

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient information updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function addMedicalHistory(Request $request, Patient $patient)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
        ]);

        $medicalHistory = new MedicalHistory($request->all());
        $patient->medicalHistories()->save($medicalHistory);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Medical history added successfully.');
    }

    public function addMedicalExamination(Request $request, Patient $patient)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'examination_datetime' => 'required|date_format:Y-m-d\TH:i',
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
        ]);


        $latestQueue = $patient->latestClinic()->first();
        
        if (!$latestQueue) {
            return redirect()->route('patients.show', $patient)
                ->with('error', 'Patient has no queue history.');
        }

        $clinicId = $latestQueue->clinic_id;

        $medicalExamination = new MedicalExamination([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'clinic_id' => $clinicId,
            'examination_datetime' => $request->examination_datetime,
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
        ]);

        if ($medicalExamination->save()) {
            Log::info('Medical examination saved successfully for patient ID ' . $patient->id);
        } else {
            Log::error('Failed to save medical examination for patient ID ' . $patient->id);
        }

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Medical examination added successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        $patients = Patient::where('full_name', 'like', "%{$searchTerm}%")
                            ->orWhere('nik', 'like', "%{$searchTerm}%")
                            ->get(['id', 'full_name as text']);

        return response()->json($patients);
    }
}

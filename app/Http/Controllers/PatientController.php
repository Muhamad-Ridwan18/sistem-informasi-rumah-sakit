<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Clinic;
use App\Models\Medicine;
use App\Models\MedicalHistory;
use App\Models\MedicalExamination;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('medical_record_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gender')) {
            $gender = $request->input('gender');
            $query->where('gender', $gender);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // jika auth user role nya == doctor maka tampilkan pasien yang visit history terakhirnya adalah dokter itu
        if (auth()->user()->role == 'doctor') {
            $query->whereHas('visitHistories', function($q) {
                $q->where('doctor_id', auth()->user()->id);
            });
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
        $medicines = Medicine::all();
        $doctors = Doctor::all();
        $medicalHistories = $patient->medicalHistories()->latest()->get();
        $medicalExaminations = $patient->medicalExaminations()->latest()->get();
        
        return view('patients.show', compact('patient', 'medicalHistories', 'medicalExaminations', 'doctors', 'medicines'));
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
        // get docter id from inpatient
        $inpatient = $patient->inpatients()->first();
        if ($inpatient) {
            $doctorId = $inpatient->doctor_id;
        }
        // dd($inpatient);
        // get docter id from last visit
        $latestQueue = $patient->latestClinic()->first();
        $doctorId = $latestQueue->doctor_id ?? $inpatient->doctor_id;

        $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'medicines' => 'array', 
            'medicines.*' => 'exists:medicines,id', 
        ]);
        
        $latestQueue = $patient->latestClinic()->first();
       

        $clinicId = $latestQueue->clinic_id ?? 1;

        $medicalExamination = new MedicalExamination([
            'patient_id' => $patient->id,
            'doctor_id' => $doctorId ?? $inpatient->doctor_id,
            'clinic_id' => $clinicId ,
            'examination_datetime' => Carbon::now()->toDateTimeString(),
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
        ]);

        if ($medicalExamination->save()) {
            // Menyimpan obat yang terkait dengan pemeriksaan medis
            $medicalExamination->medicines()->attach($request->medicines);

            Log::info('Medical examination saved successfully for patient ID ' . $patient->id);
        } else {
            Log::error('Failed to save medical examination for patient ID ' . $patient->id);
        }

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Medical examination added successfully.');
    }

    public function printBilling($id) 

    {
        $no_invoice = 'INV-' . random_int(10000000, 99999999);
        $dateNow = Carbon::now();
        $dateNow = $dateNow->format('d-m-Y');
        $dateNow = explode('-', $dateNow);
        $dateNow = $dateNow[2] . '-' . $dateNow[1] . '-' . $dateNow[0];
        $medicalExamination = MedicalExamination::findOrFail($id);
        
        $html = view('patients.print-billing', compact('medicalExamination', 'no_invoice', 'dateNow'))->render();
        
        $pdf = Pdf::loadHTML($html);
        
        return $pdf->stream('Billing.pdf');
    }

    public function printResep($id) 

    {
        $no_invoice = 'INV-' . random_int(10000000, 99999999);
        $dateNow = Carbon::now();
        $dateNow = $dateNow->format('d-m-Y');
        $dateNow = explode('-', $dateNow);
        $dateNow = $dateNow[2] . '-' . $dateNow[1] . '-' . $dateNow[0];
        $medicalExamination = MedicalExamination::findOrFail($id);
        
        $html = view('patients.print-resep', compact('medicalExamination', 'no_invoice', 'dateNow'))->render();
        
        $pdf = Pdf::loadHTML($html);
        
        return $pdf->stream('Billing.pdf');
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

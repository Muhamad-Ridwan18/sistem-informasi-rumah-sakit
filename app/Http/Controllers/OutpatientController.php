<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\VisitHistory;
use Illuminate\Http\Request;

class OutpatientController extends Controller
{
    public function index()
    {
        $outpatients = VisitHistory::select('patient_id', 'clinic_id', \DB::raw('MAX(created_at) as last_visit'))
            ->with(['patient', 'clinic'])
            ->groupBy('patient_id', 'clinic_id')
            ->paginate(10);

        return view('outpatients.index', compact('outpatients'));
    }

    public function destroy(VisitHistory $outpatient)
    {
        $outpatient->delete();
        return redirect()->route('outpatients.index');
    }
}

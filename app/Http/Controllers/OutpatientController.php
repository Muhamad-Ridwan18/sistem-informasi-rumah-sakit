<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\VisitHistory;
use Illuminate\Http\Request;

class OutpatientController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitHistory::latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $outpatients = $query->paginate(10);
        

        return view('outpatients.index', compact('outpatients'));
    }

    public function destroy(VisitHistory $outpatient)
    {
        $outpatient->delete();
        return redirect()->route('outpatients.index');
    }
}

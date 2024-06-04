<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Patient;
use App\Models\Clinic;
use App\Models\VisitHistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::all();
        $patients = Patient::all();
        $clinics = Clinic::all();
        return view('queues.index', compact('queues', 'patients', 'clinics'));
    }

    public function create(Request $request)
    {
        $patientId = $request->input('patient_id');
        $clinicId = $request->input('clinic_id');
    
        $patient = Patient::with('clinic')->find($patientId);
        if (!$patient) {
            return redirect()->route('queue.index')
                ->with('error', 'Patient not found.');
        }
        
        $clinic = Clinic::find($clinicId);
        if (!$clinic) {
            return redirect()->route('queue.index')
                ->with('error', 'Clinic not found.');
        }

        $clinicName = $clinic->name;
        $clinicInitials = $this->getInitials($clinicName);

        $queueNumber = $this->generateQueueNumber($clinicInitials);
        $queueCode = $clinicInitials . str_pad($queueNumber, 3, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'patient_id' => $patientId,
            'clinic_id' => $clinicId,
            'queue_code' => $queueCode,
            'queue_number' => $queueNumber,
            'status' => 'pending',
        ]);

        VisitHistory::create([
            'patient_id' => $patientId,
            'clinic_id' => $clinicId,
            'visit_date' => now(),
        ]);

        return redirect()->route('queue.index')
            ->with('success', 'Queue created successfully.');
    }

    public function printQueueNumber($id)
    {
        $queue = Queue::findOrFail($id);
        
        $html = view('queues.print', compact('queue'))->render();
        
        $pdf = Pdf::loadHTML($html);
        
        return $pdf->stream('queue_number.pdf');
    }

    private function generateQueueNumber($clinicInitials)
    {
        // Find the latest queue number for this clinic
        $latestQueue = Queue::where('queue_code', 'LIKE', $clinicInitials . '%')->latest()->first();
        $queueNumber = $latestQueue ? ((int)substr($latestQueue->queue_code, strlen($clinicInitials)) + 1) : 1;
        return $queueNumber;
    }

    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }

    public function updateStatus(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $queue->update(['status' => $validated['status']]);

        return redirect()->route('queue.index')->with('success', 'Queue status updated successfully.');
    }
}

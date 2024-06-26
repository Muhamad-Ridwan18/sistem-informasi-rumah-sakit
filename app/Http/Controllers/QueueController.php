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
    public function index(Request $request)
    {
        $queueUmum = Queue::where('clinic_id', 1)->get();

        // Ambil antrian dengan clinic_id 2
        $queueDalam = Queue::where('clinic_id', 2)->get();

        $queues = Queue::query();

        if ($request->has('clinic_id')) {
            $queues->where('clinic_id', $request->clinic_id);
        }

        // Ambil semua antrian yang sudah difilter
        $queues = $queues->get();

        $patients = Patient::all();
        $clinics = Clinic::all();

        return view('queues.index', compact('queues', 'patients', 'clinics', 'queueUmum', 'queueDalam'));
    }

    public function create(Request $request)
    {
        $patientId = $request->input('patient_id');
        $clinicId = $request->input('clinic_id');
    
        $existingQueue = Queue::where('patient_id', $patientId)
                           ->where('clinic_id', $clinicId)
                           ->whereDate('created_at', now()->toDateString())
                           ->first();

        if ($existingQueue) {
            return redirect()->route('queue.index')
                ->with('error', 'Patient already has a queue for this clinic today.');
        }
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Room;
use App\Models\Clinic;
use App\Models\Queue;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'Petugas Poliklinik Umum') {
            $clinics = Clinic::where('id', 1)->get();
        } elseif ($user->role == 'Petugas Spesialis') {
            $clinics = Clinic::where('id', 2)->get();
        } else {
            $clinics = Clinic::all();
        }

        // Inisialisasi nomor antrian saat ini untuk setiap klinik
        $currentQueueNumbers = [];
        foreach ($clinics as $clinic) {
            $currentQueueNumbers[$clinic->id] = 'No active queues today';
        }

        $queuesByClinic = [];

        $maleQueues = Queue::whereHas('patient', function ($query) {
            $query->where('gender', 'male');
        })->whereDate('created_at', Carbon::today())->get();

        $femaleQueues = Queue::whereHas('patient', function ($query) {
            $query->where('gender', 'female');
        })->whereDate('created_at', Carbon::today())->get();

        foreach ($clinics as $clinic) {
            $queuesByClinic[$clinic->id] = Queue::with('patient')
                ->where('clinic_id', $clinic->id)
                ->whereDate('created_at', Carbon::today())
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Mendapatkan nomor antrian saat ini untuk setiap klinik
        foreach ($clinics as $clinic) {
            $currentQueue = Queue::where('status', 'pending')
                ->whereDate('created_at', Carbon::today())
                ->where('clinic_id', $clinic->id)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($currentQueue) {
                $currentQueueNumbers[$clinic->id] = $currentQueue->queue_number;
            }
        }

        return view('home', [
            'clinicCount' => Clinic::count(),
            'patients' => Patient::count(),
            'doctors' => Doctor::count(),
            'rooms' => Room::count(),
            'maleQueues' => $maleQueues,
            'femaleQueues' => $femaleQueues,
            'clinics' => $clinics,
            'queuesByClinic' => $queuesByClinic,
            'currentQueueNumbers' => $currentQueueNumbers,
        ]);

    }

    public function updateQueue(Request $request)
    {
        $request->validate([
            'clinic_id' => 'required|exists:clinics,id', // Pastikan clinic_id valid
        ]);
        $clinicId = $request->input('clinic_id');

        $currentQueue = Queue::where('clinic_id', $clinicId)
                            ->whereDate('created_at', today())
                            ->where('status', 'pending') // Filter by active status
                            ->orderBy('created_at', 'asc')
                            ->first();

        if ($currentQueue) {
            // Jika ada antrian yang aktif, hapus antrian tersebut
            $currentQueue->delete();
            return redirect()->back()->with('success', 'Antrian aktif direset.');
        } else {
            // Jika tidak ada antrian yang aktif, jangan hapus antrian
            return redirect()->back()->with('error', 'Tidak ada antrian aktif.');
        }
    }
}

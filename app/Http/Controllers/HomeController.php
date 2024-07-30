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
        // Fetch all clinics
        $user = auth()->user();

        if ($user->role == 'Petugas Poliklinik Umum') {
            $clinics = Clinic::where('id', 1)->get();
        } elseif ($user->role == 'Petugas Spesialis') {
            $clinics = Clinic::where('id', 2)->get();
        } else {
            $clinics = Clinic::all();
        }

        // Fetch all queues grouped by clinic
        $queuesByClinic = Queue::with('patient')
            ->whereDate('created_at', today())
            ->get()
            ->groupBy('clinic_id');

        // Calculate the current queue number for each clinic
        $currentQueueNumbers = $queuesByClinic->map(function ($queues) {
            return $queues->first()->queue_number ?? 0;
        });

        // Pass the data to the view
        return view('home', [
            'clinics' => $clinics,
            'queuesByClinic' => $queuesByClinic,
            'currentQueueNumbers' => $currentQueueNumbers,
            'rooms' => Room::count(),
            'doctors' => Doctor::count(),
            'patients' => Patient::count(),
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

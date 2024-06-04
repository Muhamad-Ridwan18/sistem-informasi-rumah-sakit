<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Room;
use App\Models\Clinic;
use App\Models\Queue;

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
        $patients = Patient::count();
        $doktors = Doctor::count();
        $rooms = Room::count();
        $clinic = Clinic::count();
        $queue = Queue::with('patient')->get();

        return view('home', compact('patients', 'doktors', 'rooms', 'clinic', 'queue'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function showNavigation()
    {
        // Mendapatkan peran pengguna yang sedang login
        $userRole = auth()->user()->role;

        // Array yang berisi konfigurasi navigasi berdasarkan peran pengguna
        $navigationConfig = [
            'Admin' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'users.index', 'text' => 'Users', 'icon' => 'users'],
                ['route' => 'queue.index', 'text' => 'Queue', 'icon' => 'ticket-alt'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
                ['route' => 'clinics.index', 'text' => 'Clinics', 'icon' => 'hospital'],
                ['route' => 'doctors.index', 'text' => 'Doctors', 'icon' => 'user-md'],
                ['route' => 'inpatients.index', 'text' => 'Inpatients', 'icon' => 'bed'],
                ['route' => 'outpatients.index', 'text' => 'Outpatients', 'icon' => 'user-nurse'],
                ['route' => 'medical_examinations.index', 'text' => 'Medical Examinations', 'icon' => 'stethoscope'],
                ['route' => 'medical_histories.index', 'text' => 'Medical Histories', 'icon' => 'file-medical'],
            ],
            'Doctor' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
                ['route' => 'medical_examinations.index', 'text' => 'Medical Examinations', 'icon' => 'stethoscope'],
                ['route' => 'medical_histories.index', 'text' => 'Medical Histories', 'icon' => 'file-medical'],
            ],
            'Petugas Administrasi' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
                ['route' => 'queue.index', 'text' => 'Queue', 'icon' => 'ticket-alt'],
            ],
            'Perawat' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
            ],
            'Farmasis' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'medical_examinations.index', 'text' => 'Medical Examinations', 'icon' => 'stethoscope'],
            ],
            'Manajemen' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'inpatients.index', 'text' => 'Inpatients', 'icon' => 'bed'],
                ['route' => 'outpatients.index', 'text' => 'Outpatients', 'icon' => 'user-nurse'],
            ],
        ];

        $navigation = $navigationConfig[$userRole] ?? [];

        return view('layouts.navigation', compact('navigation'));
    }
}

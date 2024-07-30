@if(auth()->check())
    @php
        $userRole = auth()->user()->role;
        $navigationConfig = [
            'Admin' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'users.index', 'text' => 'User', 'icon' => 'users'],
                ['route' => 'queue.index', 'text' => 'Antrian', 'icon' => 'ticket-alt'],
                ['route' => 'patients.index', 'text' => 'Pasien', 'icon' => 'user'],
                ['route' => 'clinics.index', 'text' => 'Klinik', 'icon' => 'hospital'],
                ['route' => 'doctors.index', 'text' => 'Dokter', 'icon' => 'user-md'],
                ['route' => 'inpatients.index', 'text' => 'Rawat Inap', 'icon' => 'bed'],
                ['route' => 'outpatients.index', 'text' => 'Rawat Jalan', 'icon' => 'user-nurse'],
                ['route' => 'medicines.index', 'text' => 'Obat', 'icon' => 'pills'],
                ['route' => 'rooms.index', 'text' => 'Kamar', 'icon' => 'bed'],
            ],
            'Doctor' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Pasien', 'icon' => 'user'],
            ],
            'Petugas Administrasi' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Pasien', 'icon' => 'user'],
                ['route' => 'queue.index', 'text' => 'Antrian', 'icon' => 'ticket-alt'],
            ],
            'Petugas Spesialis' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Pasien', 'icon' => 'user'],
            ],
            'Petugas Poliklinik Umum' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Pasien', 'icon' => 'user'],
            ],
            'Operator Rawat Inap' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                
                ['route' => 'inpatients.index', 'text' => 'Rawat Inap', 'icon' => 'bed'],
            ],
            'Operator Rawat Jalan' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'queue.index', 'text' => 'Antrian', 'icon' => 'ticket-alt'],
                ['route' => 'outpatients.index', 'text' => 'Rawat Jalan', 'icon' => 'user-nurse'],
            ],
            'Manajemen' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'outpatients.index', 'text' => 'Rawat Jalan', 'icon' => 'user-nurse'],
                ['route' => 'clinics.index', 'text' => 'Klinik', 'icon' => 'hospital'],
                ['route' => 'doctors.index', 'text' => 'Dokter', 'icon' => 'user-md'],
            ],
        ];
        $navigation = $navigationConfig[$userRole] ?? [];
    @endphp

    <ul>
        @foreach($navigation as $navItem)
            <li class="nav-item @if(request()->routeIs($navItem['route'])) active @endif">
                <a href="{{ route($navItem['route']) }}">
		    <span class="icon">
                <i class="fas fa-{{ $navItem['icon'] }} text-primary"></i>  
            </span>
                    <span class="text">{{ $navItem['text'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
@endif

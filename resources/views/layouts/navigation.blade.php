@if(auth()->check())
    @php
        $userRole = auth()->user()->role;
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
                ['route' => 'medicines.index', 'text' => 'Medicine', 'icon' => 'pills'],
                ['route' => 'rooms.index', 'text' => 'Rooms', 'icon' => 'bed'],
            ],
            'Doctor' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
            ],
            'Petugas Administrasi' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
                ['route' => 'queue.index', 'text' => 'Queue', 'icon' => 'ticket-alt'],
                ['route' => 'inpatients.index', 'text' => 'Inpatients', 'icon' => 'bed'],
            ],
            'Perawat' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'patients.index', 'text' => 'Patients', 'icon' => 'user'],
            ],
            'Farmasis' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'medicines.index', 'text' => 'Medicine', 'icon' => 'pills'],
            ],
            'Manajemen' => [
                ['route' => 'home', 'text' => 'Dashboard', 'icon' => 'home'],
                ['route' => 'outpatients.index', 'text' => 'Outpatients', 'icon' => 'user-nurse'],
                ['route' => 'clinics.index', 'text' => 'Clinics', 'icon' => 'hospital'],
                ['route' => 'doctors.index', 'text' => 'Doctors', 'icon' => 'user-md'],
                ['route' => 'medicines.index', 'text' => 'Medicine', 'icon' => 'pills'],
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

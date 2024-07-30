@extends('layouts.app') 

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Dashboard</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#0">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon purple"><i class="lni lni-cart-full"></i></div>
                <div class="content">
                    <h6 class="mb-10">Total Poli</h6>
                    <h3 class="text-bold mb-10">{{ $clinics->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success"><i class="lni lni-dollar"></i></div>
                <div class="content">
                    <h6 class="mb-10">Total Room</h6>
                    <h3 class="text-bold mb-10">{{ $rooms }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary"><i class="lni lni-credit-cards"></i></div>
                <div class="content">
                    <h6 class="mb-10">Total Doctor</h6>
                    <h3 class="text-bold mb-10">{{ $doctors }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon orange"><i class="lni lni-user"></i></div>
                <div class="content">
                    <h6 class="mb-10">Total Pasien</h6>
                    <h3 class="text-bold mb-10">{{ $patients }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($clinics as $clinic)
            <div class="col-md-12 col-lg-6 order-0 mb-4">
                <div class="card p-4">
                    <div class="card-body">
                        <div>
                            <h5 class="card-title m-0 me-2 fw-bold mb-2" style="font-family: poppins; font-size:1rem;">
                                Data Antrian {{$clinic->name}}
                            </h5>
                            <small class="text-muted" style="font-family: poppins; font-size:12px; color:rgb(86, 106, 127) !important;">
                                Berikut daftar nomor antrian pasien hari ini untuk klinik {{$clinic->name}}
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($queuesByClinic[$clinic->id]) && !$queuesByClinic[$clinic->id]->isEmpty())
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="mb-2 fw-bold" style="color:#566a7f;">{{$currentQueueNumbers[$clinic->id]}}</h2>
                                    <span>Nomor Antrian Sekarang</span>
                                    <form action="{{ route('home.updateQueue') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="clinic_id" value="{{ $clinic->id }}">
                                        <button type="submit" class="btn btn-primary">Antrian Selanjutnya</button>
                                    </form>
                                </div>
                                @php
                                    $maleQueuesClinic = $queuesByClinic[$clinic->id]->filter(function($queue) {
                                        return $queue->patient->gender == 'Male';
                                    })->count();
                                    $femaleQueuesClinic = $queuesByClinic[$clinic->id]->filter(function($queue) {
                                        return $queue->patient->gender == 'Female';
                                    })->count();
                                @endphp
                                <div id="usersChart-{{ $clinic->id }}" data-laki-laki="{{ $maleQueuesClinic }}" data-perempuan="{{ $femaleQueuesClinic }}"></div>
                            </div>
                            <ul class="p-0 m-0">
                                @foreach($queuesByClinic[$clinic->id] as $queue)
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            @if($queue->patient->gender == 'Male')
                                                <img src="{{ asset('assets/img/profil-images-default/man.jpeg') }}" alt="Profile Image" class="rounded">
                                            @else
                                                <img src="{{ asset('assets/img/profil-images-default/girl.jpeg') }}" alt="Profile Image" class="rounded">
                                            @endif
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-1 text-capitalize">{{ $queue->patient->full_name }}</h6>
                                                <small class="text-muted d-block">{{ $queue->created_at->locale('id')->diffForHumans() }}</small>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <span class="badge badge-center bg-info rounded-pill">{{ $queue->queue_number }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center"><i class="bx bx-info-circle fs-6" style="margin-bottom: 2px;"></i>&nbsp;Belum ada antrian</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <style>
        /* Add your styles here */
    </style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        @foreach($clinics as $clinic)
            (function() {
                const dataLakiLaki = $("#usersChart-{{ $clinic->id }}").data("laki-laki");
                const dataPerempuan = $("#usersChart-{{ $clinic->id }}").data("perempuan");

                const usersChart = document.querySelector("#usersChart-{{ $clinic->id }}");
                const orderChartConfig = {
                    chart: {
                        height: 165,
                        width: 130,
                        type: "donut",
                    },
                    labels: ["Laki-Laki", "Perempuan"],
                    series: [dataLakiLaki, dataPerempuan],
                    colors: ['#7367f0', "#ff6384"],
                    stroke: {
                        width: 5,
                        colors: '#fff',
                    },
                    dataLabels: {
                        enabled: false,
                        formatter: function(val, opt) {
                            return parseInt(val) + "%";
                        },
                    },
                    legend: {
                        show: false,
                    },
                    grid: {
                        padding: {
                            top: 0,
                            bottom: 0,
                            right: 15,
                        },
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "75%",
                                labels: {
                                    show: true,
                                    value: {
                                        fontSize: "1.5rem",
                                        fontFamily: "Poppins",
                                        color: "#566a7f",
                                        offsetY: -15,
                                        formatter: function(val) {
                                            return parseInt(val);
                                        },
                                    },
                                    name: {
                                        offsetY: 20,
                                        fontFamily: "Poppins",
                                    },
                                    total: {
                                        show: true,
                                        fontSize: "0.8125rem",
                                        label: "Total",
                                        color: "#566a7f",
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce(function(a, b) {
                                                return a + b;
                                            }, 0);
                                        },
                                    },
                                },
                            },
                        },
                    },
                };
                if (typeof usersChart !== undefined && usersChart !== null) {
                    const usersChartInstance = new ApexCharts(usersChart, orderChartConfig);
                    usersChartInstance.render();
                }
            })();
        @endforeach
    });
</script>
@endpush
@push('styles')
    <style>
        .avatar {
  position: relative;
  width: 2.375rem;
  height: 2.375rem;
  cursor: pointer;
}
.avatar img {
  width: 100%;
  height: 100%;
}
.avatar .avatar-initial {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  background-color: #8592a3;
  font-weight: 700;
}
.avatar.avatar-online:after,
.avatar.avatar-offline:after,
.avatar.avatar-away:after,
.avatar.avatar-busy:after {
  content: "";
  position: absolute;
  bottom: 0;
  right: 3px;
  width: 8px;
  height: 8px;
  border-radius: 100%;
  box-shadow: 0 0 0 2px #fff;
}
.avatar.avatar-online:after {
  background-color: #71dd37;
}
.avatar.avatar-offline:after {
  background-color: #8592a3;
}
.avatar.avatar-away:after {
  background-color: #ffab00;
}
.avatar.avatar-busy:after {
  background-color: #ff3e1d;
}

.pull-up {
  transition: all 0.25s ease;
}
.pull-up:hover {
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45);
  z-index: 30;
  border-radius: 50%;
}

.avatar-xs {
  width: 1.625rem;
  height: 1.625rem;
}
.avatar-xs .avatar-initial {
  font-size: 0.625rem;
}
.avatar-xs.avatar-online:after,
.avatar-xs.avatar-offline:after,
.avatar-xs.avatar-away:after,
.avatar-xs.avatar-busy:after {
  width: 0.325rem;
  height: 0.325rem;
  right: 1px;
}

.avatar-sm {
  width: 2rem;
  height: 2rem;
}
.avatar-sm .avatar-initial {
  font-size: 0.75rem;
}
.avatar-sm.avatar-online:after,
.avatar-sm.avatar-offline:after,
.avatar-sm.avatar-away:after,
.avatar-sm.avatar-busy:after {
  width: 0.4rem;
  height: 0.4rem;
  right: 2px;
}

.avatar-md {
  width: 3rem;
  height: 3rem;
}
.avatar-md .avatar-initial {
  font-size: 1.125rem;
}
.avatar-md.avatar-online:after,
.avatar-md.avatar-offline:after,
.avatar-md.avatar-away:after,
.avatar-md.avatar-busy:after {
  width: 0.6rem;
  height: 0.6rem;
  right: 4px;
}

.avatar-lg {
  width: 4rem;
  height: 4rem;
}
.avatar-lg .avatar-initial {
  font-size: 1.5rem;
}
.avatar-lg.avatar-online:after,
.avatar-lg.avatar-offline:after,
.avatar-lg.avatar-away:after,
.avatar-lg.avatar-busy:after {
  width: 0.8rem;
  height: 0.8rem;
  right: 5px;
}

.avatar-xl {
  width: 4.5rem;
  height: 4.5rem;
}
.avatar-xl .avatar-initial {
  font-size: 1.875rem;
}
.avatar-xl.avatar-online:after,
.avatar-xl.avatar-offline:after,
.avatar-xl.avatar-away:after,
.avatar-xl.avatar-busy:after {
  width: 0.9rem;
  height: 0.9rem;
  right: 6px;
}

.avatar-group .avatar {
  transition: all 0.25s ease;
}
.avatar-group .avatar img,
.avatar-group .avatar .avatar-initial {
  border: 2px solid #fff;
}
.avatar-group .avatar .avatar-initial {
  background-color: #9da8b5;
}
.avatar-group .avatar:hover {
  z-index: 30;
  transition: all 0.25s ease;
}
.avatar-group .avatar {
  margin-left: -0.8rem;
}
.avatar-group .avatar:first-child {
  margin-left: 0;
}
.avatar-group .avatar-xs {
  margin-left: -0.65rem;
}
.avatar-group .avatar-sm {
  margin-left: -0.75rem;
}
.avatar-group .avatar-md {
  margin-left: -0.9rem;
}
.avatar-group .avatar-lg {
  margin-left: -1.5rem;
}
.avatar-group .avatar-xl {
  margin-left: -1.75rem;
}

    </style>
@endpush
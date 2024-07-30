@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Daftar Antrian') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createQueueModal">
        Tambah Antrian
    </button>

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <h4 class="alert-heading">Sorry</h4>
                        <p class="text-medium">
                            {{ session('error') }}
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                    
                <h3>{{ __('Rawat Jalan') }}</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Nomor Antrian</th>
                        <th>Tanggal</th>
                        <th>Poli</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queuesRawatJalan as $queue)
                        <tr>
                            <td>{{ $queue->patient->full_name }}</td>
                            <td>{{ $queue->queue_code }}</td>
                            <td>{{ $queue->created_at }}</td>
                            <td>{{ $queue->clinic->name }}</td>
                            <td>
                                <a href="{{ route('queue.print', $queue->id) }}" class="btn btn-primary">Cetak Nomor Antrian</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <h4 class="alert-heading">Sorry</h4>
                        <p class="text-medium">
                            {{ session('error') }}
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            <h3>{{ __('Rawat Inap') }}</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Nomor Antrian</th>
                        <th>Tanggal</th>
                        <th>Poli</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queuesRawatInap as $queue)
                        <tr>
                            <td>{{ $queue->patient->full_name }}</td>
                            <td>{{ $queue->queue_code }}</td>
                            <td>{{ $queue->created_at }}</td>
                            <td>{{ $queue->clinic->name }}</td>
                            <td>
                                <a href="{{ route('queue.print', $queue->id) }}" class="btn btn-primary">Cetak Nomor Antrian</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createQueueModal" tabindex="-1" aria-labelledby="createQueueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createQueueModalLabel">Buat Antrian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('queue.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="patient_id" class="form-label">Pilih Pasien</label>
                            <select class="form-control"  name="patient_id">
                                @forelse ($patients as $patient )
                                    <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                                @empty
                                    <option value="-">data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="clinic_id" class="form-label">Pilih Poli</label>
                            <select class="form-control"  name="clinic_id">
                                <!-- Option pasien akan diisi menggunakan JavaScript -->
                                @forelse ($clinics as $clinic )
                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                @empty
                                    <option value="-">data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Pilih Doctor</label>
                            <select class="form-control"  name="doctor_id">
                                <!-- Option pasien akan diisi menggunakan JavaScript -->
                                @forelse ($doctors as $doctor )
                                    <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                                @empty
                                    <option value="-">data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Pilih Layanan</label>
                            <select class="form-control" name="status" id="status" onchange="toggleRoomSelection()">
                                <option value="rawat jalan">Rawat Jalan</option>
                                <option value="rawat inap">Rawat Inap</option>
                            </select>
                        </div>
                        <div class="mb-3" id="roomSelection" style="display: none;">
                            <label for="room_id" class="form-label">Pilih Kamar</label>
                            <select class="form-control" name="room_id">
                                @forelse ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @empty
                                    <option value="-">data not found</option>
                                @endforelse
                            </select>
                        </div>                                                
                        <button type="submit" class="btn btn-primary">Buat Antrian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script>
    function toggleRoomSelection() {
        var status = document.getElementById('status').value;
        var roomSelection = document.getElementById('roomSelection');
        if (status === 'rawat inap') {
            roomSelection.style.display = 'block';
        } else {
            roomSelection.style.display = 'none';
        }
    }
</script>

@endpush
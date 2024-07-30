@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pasien Rawat Inap') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <div class="row">
                    

                    <form action="{{ route('inpatients.index') }}" method="GET" class="mb-4 mt-3">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                <a href="{{ route('inpatients.index') }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Nama Kamar</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inpatients as $data)
                            <tr>
                                <td>{{ $data->patient->full_name }}</td>
                                <td>{{ $data->room->name }}</td>
                                <td>{{ date('d-M-Y H:i', strtotime($data->admitted_at)) }}</td>
                                <td>{{ $data->discharged_at ?? 'Belum Keluar' }}</td>
                                <td >
                                    <a href="{{ route('patients.show', $data->patient->id) }}" class="btn btn-primary">Show</a>
                                    <a href="{{ route('inpatients.printBracelet', $data->id) }}" class="btn btn-success">Cetak Gelang</a>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editQueueModal-{{ $data->id }}">Edit</button>
                                    <form action="{{ route('inpatients.destroy', $data->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="editQueueModal-{{ $data->id }}" tabindex="-1" aria-labelledby="editQueueModalLabel-{{ $data->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editQueueModalLabel-{{ $data->id }}">Edit Rawat Inap</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('inpatients.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="patient_id" class="form-label">Pilih Pasien</label>
                                                    <select class="form-control" name="patient_id">
                                                        @foreach ($patients as $patient)
                                                            <option value="{{ $patient->id }}" {{ $patient->id == $data->patient_id ? 'selected' : '' }}>{{ $patient->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="doctor_id" class="form-label">Pilih Pasien</label>
                                                    <select class="form-control" name="doctor_id">
                                                        @foreach ($doctors as $doctor)
                                                            <option value="{{ $doctor->id }}" {{ $doctor->id == $data->doctor_id ? 'selected' : '' }}>{{ $doctor->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="room_number" class="form-label">Pilih Kamar</label>
                                                    <select name="room_number" id="room_number" class="form-control">
                                                        @foreach ($rooms as $data )
                                                            <option value="{{ $data->name }}" {{ $data->name == $data->room_number ? 'selected' : '' }}>{{ $data->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="admitted_at" class="form-label">Waktu Masuk</label>
                                                    <input type="datetime-local" class="form-control" id="admitted_at" name="admitted_at" value="{{ \Carbon\Carbon::parse($data->admitted_at)->format('Y-m-d\TH:i') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discharged_at" class="form-label">Waktu Keluar</label>
                                                    <input type="datetime-local" class="form-control" id="discharged_at" name="discharged_at">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="modal-title" id="createQueueModalLabel">Buat data rawat inap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('inpatients.store') }}" method="POST">
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
                            <label for="doctor_id" class="form-label">Pilih Doctor</label>
                            <select class="form-control"  name="doctor_id">
                                @forelse ($doctors as $data )
                                    <option value="{{ $data->id }}">{{ $data->full_name }}</option>
                                @empty
                                    <option value="-">data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="room_number" class="form-label">Pilih Kamar</label>
                            <select name="room_number" id="room_number" class="form-control">
                                @forelse ($rooms as $data )
                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                @empty
                                    <option value="-">data not found</option>
                                @endforelse
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

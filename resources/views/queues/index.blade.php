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
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQueueModal">
                    Tambah Antrian
                </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Nomor Antrian</th>
                            <th>Tanggal</th>
                            <th>Poli</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($queues as $queue)
                            <tr>
                                <td>{{ $queue->patient->full_name }}</td>
                                <td>{{ $queue->queue_code }}</td>
                                <td>{{ $queue->created_at }}</td>
                                <td>{{ $queue->clinic->name }}</td>
                                <td>{{ $queue->status }}</td>
                                <td >
                                    <a href="{{ route('queue.print', $queue->id) }}" class="btn btn-primary">Cetak Nomor Antrian</a>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changeStatusModal{{ $queue->id }}">
                                        Change Status
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="changeStatusModal{{ $queue->id }}" tabindex="-1" aria-labelledby="changeStatusModal{{ $queue->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="changeStatusModal{{ $queue->id }}Label">Change Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('queue.updateStatus', $queue->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="status{{ $queue->id }}" class="form-label">Status</label>
                                                            <select class="form-control" id="status{{ $queue->id }}" name="status">
                                                                <option value="pending" @if($queue->status == 'pending') selected @endif>Pending</option>
                                                                <option value="completed" @if($queue->status == 'completed') selected @endif>Completed</option>
                                                                <option value="cancelled" @if($queue->status == 'cancelled') selected @endif>Cancelled</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                <!-- Option pasien akan diisi menggunakan JavaScript -->
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
                        <button type="submit" class="btn btn-primary">Buat Antrian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

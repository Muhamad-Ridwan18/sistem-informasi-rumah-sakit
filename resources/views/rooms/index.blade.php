@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Daftar Kamar') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQueueModal">
                    Tambah Kamar
                </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kamar</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->jenis }}</td>
                                <td>{{ "Rp ". number_format($data->tarif, 0, ',', '.') ?? 'Belum Keluar' }}</td>
                                <td >
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editQueueModal-{{ $data->id }}">Edit</button>
                                    <form action="{{ route('rooms.destroy', $data->id) }}" method="POST" class="d-inline">
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
                                            <h5 class="modal-title" id="editQueueModalLabel-{{ $data->id }}">Edit Kamar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('rooms.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Obat</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $data->name) }}">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tarif" class="form-label">tarif</label>
                                                    <input type="text" class="form-control" id="tarif" name="tarif" value="{{ old('tarif', $data->tarif) }}">
                                                    @error('tarif')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">Jenis</label>
                                                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis', $data->jenis) }}">
                                                    @error('jenis')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                    <h5 class="modal-title" id="createQueueModalLabel">Buat data Kamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kamar</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="tarif" class="form-label">Tarif</label>
                            <input type="text" class="form-control" id="tarif" name="tarif">
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

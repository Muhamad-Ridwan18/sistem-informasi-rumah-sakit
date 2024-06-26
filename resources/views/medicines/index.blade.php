@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Daftar Obat') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQueueModal">
                    Tambah Obat
                </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Kode</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->code }}</td>
                                <td>{{ $data->jenis }}</td>
                                <td>Rp. {{ number_format($data->price, 0, ',', '.') ?? '-' }}</td>
                                <td >
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editQueueModal-{{ $data->id }}">Edit</button>
                                    <form action="{{ route('medicines.destroy', $data->id) }}" method="POST" class="d-inline">
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
                                            <h5 class="modal-title" id="editQueueModalLabel-{{ $data->id }}">Edit Obat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('medicines.update', $data->id) }}" method="POST">
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
                                                    <label for="price" class="form-label">Harga</label>
                                                    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $data->price) }}">
                                                    @error('price')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">Jenis</label>
                                                    <select class="form-select" id="jenis" name="jenis">
                                                        <option value="">Pilih Jenis Obat</option>
                                                        <option value="Tablet" {{ old('jenis', $data->jenis) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                                        <option value="Kapsul" {{ old('jenis', $data->jenis) == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                                        <option value="Sirup" {{ old('jenis', $data->jenis) == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                                                        <option value="Salep" {{ old('jenis', $data->jenis) == 'Salep' ? 'selected' : '' }}>Salep</option>
                                                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                                    </select>
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
                    <h5 class="modal-title" id="createQueueModalLabel">Buat data obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('medicines.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select" id="jenis" name="jenis">
                                <option value="">Pilih Jenis Obat</option>
                                <option value="Tablet" >Tablet</option>
                                <option value="Kapsul" >Kapsul</option>
                                <option value="Sirup" >Sirup</option>
                                <option value="Salep" >Salep</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                            @error('jenis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Tambah data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

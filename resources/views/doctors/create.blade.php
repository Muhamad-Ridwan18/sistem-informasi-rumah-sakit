@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Tambah Dokter') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <form action="{{ route('doctors.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label">{{ __('Nama Lengkap') }}</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}">
                        @error('full_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="specialization" class="form-label">{{ __('spesialis') }}</label>
                        <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization') }}">
                        @error('specialization')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">{{ __('Jenis Kelamin') }}</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="Male">Laki-laki</option>
                            <option value="Female">Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tarif" class="form-label">{{ __('tarif') }}</label>
                        <input type="text" class="form-control" id="tarif" name="tarif" value="{{ old('tarif') }}">
                        @error('tarif')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Nomor Telepon') }}</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

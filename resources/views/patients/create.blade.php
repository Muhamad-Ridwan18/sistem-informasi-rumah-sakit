@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Tambah Pasien') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <form action="{{ route('patients.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label">{{ __('Nama Lengkap') }}</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}">
                        @error('full_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">{{ __('NIK') }}</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
                        @error('nik')
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
                        <label for="address" class="form-label">{{ __('Alamat') }}</label>
                        <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">{{ __('Tanggal Lahir') }}</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                        @error('birth_date')
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

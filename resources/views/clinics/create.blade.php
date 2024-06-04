@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Tambah Doctor') }}</h2>
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
                        <label for="name" class="form-label">{{ __('Nama Clinics') }}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
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
                    
                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

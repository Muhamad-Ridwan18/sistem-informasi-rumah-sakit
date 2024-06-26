@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Users') }}</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQueueModal">
                    Tambah User
                </button>
                {{-- <div class="alert-box primary-alert">
                    <div class="alert">
                        <p class="text-medium">
                            Users
                        </p>
                    </div>
                </div> --}}

                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
                        <thead>
                        <tr>
                            <th><h6>Name</h6></th>
                            <th><h6>Role</h6></th>
                            <th><h6>Email</h6></th>
                            <th><h6>Action</h6></th>
                        </tr>
                        <!-- end table row-->
                        </thead>
                        <tbody>
                        @foreach($users as $data)
                            <tr>
                                <td>
                                    <p>{{ $data->name }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->role }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->email }}</p>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editQueueModal-{{ $data->id }}">Edit</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editQueueModal-{{ $data->id }}" tabindex="-1" aria-labelledby="editQueueModalLabel-{{ $data->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editQueueModalLabel-{{ $data->id }}">Edit Data User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('users.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama User</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $data->name) }}">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select name="role" id="role" class="form-select">
                                                        <option value="Admin">Admin</option>
                                                        <option value="Doctor">Doctor</option>
                                                        <option value="Petugas Administrasi">Petugas Administrasi</option>
                                                        <option value="Petugas Spesialis">Petugas Spesialis</option>
                                                        <option value="Petugas Poliklinik Umum">Petugas Poliklinik Umum</option>
                                                        <option value="Farmasi">Farmasi</option>
                                                        <option value="Perawat">Perawat</option>
                                                        <option value="Manajemen">Manajemen</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $data->email) }}">
                                                    @error('email')
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
                        <!-- end table row -->
                        </tbody>
                    </table>
                    <!-- end table -->

                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="createQueueModal" tabindex="-1" aria-labelledby="createQueueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createQueueModalLabel">Buat data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama User</label>
                            <input type="text" class="form-control" @error('name')  @enderror name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="Admin">Admin</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Petugas Administrasi">Petugas Administrasi</option>
                                <option value="Petugas Spesialis">Petugas Spesialis</option>
                                <option value="Petugas Poliklinik Umum">Petugas Poliklinik Umum</option>
                                <option value="Farmasi">Farmasi</option>
                                <option value="Perawat">Perawat</option>
                                <option value="Manajemen">Manajemen</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input @error('email') @enderror class="form-control" type="email" name="email" id="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" @error('password')  @enderror class="form-control" name="password" id="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" @error('password')  @enderror class="form-control" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pasien') }}</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    
    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">

               <div class="alert-box primary-alert">
                    @if (session('success'))
                        <div class="alert">
                            <h4 class="alert-heading">Success</h4>
                            <p class="text-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                    @endif
               </div>

                <div class="alert-box primary-alert">
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">+ Pasien</a>
                </div>
                <form action="{{ route('patients.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" name="search" class="form-control" placeholder="Search by name or NO RM" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="gender" class="form-control">
                                <option value="">Filter by Gender</option>
                                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                        </div>
                    </div>
                </form>
                
                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
                        <thead>
                        <tr>
                            <th><h6>NO RM</h6></th>
                            <th><h6>Name</h6></th>
                            <th><h6>Jenis Kelamin</h6></th>
                            <th><h6>Tanggal Lahir</h6></th>
                            <th><h6>alamat</h6></th>
                            <th><h6>tanggal masuk</h6></th>
                            <th><h6>Action</h6></th>
                        </tr>
                        <!-- end table row-->
                        </thead>
                        <tbody>
                        @foreach($patients as $data)
                            <tr>
                              <td>
                                   <p>{{ $data->medical_record_number }}</p>
                              </td>
                                <td>
                                    <p>{{ $data->full_name }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->gender }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->birth_date }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->address }}</p>
                                </td>
                                <td>
                                    <p>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, h:i A') }}</p>
                                </td>
                                <td>
                                    <a href="{{ route('patients.show', $data) }}" class="btn btn-primary">Show</a>
                                    <a href="{{ route('patients.edit', $data) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('patients.destroy', $data) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <!-- end table row -->
                        </tbody>
                    </table>
                    <!-- end table -->

                    {{ $patients->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

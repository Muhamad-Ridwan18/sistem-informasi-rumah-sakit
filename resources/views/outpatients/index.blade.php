@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pasien Rawat Jalan') }}</h2>
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
               <form action="{{ route('outpatients.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                        <a href="{{ route('outpatients.index') }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                    </div>
                </div>
            </form>

                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
                        <thead>
                        <tr>
                            <th><h6>NO</h6></th>
                            <th><h6>Name</h6></th>
                            <th><h6>No Rekam Medis</h6></th>
                            <th><h6>Poliklinik</h6></th>
                            <th><h6>tanggal masuk</h6></th>
                            
                        </tr>
                        <!-- end table row-->
                        </thead>
                        <tbody>
                        @foreach($outpatients as $data)
                            <tr>
                              <td>
                                   <p>{{ $loop->iteration }}</p>
                              </td>
                              <td>
                                   <p>{{ $data->patient->full_name }}</p>
                              </td>
                                <td>
                                    <p>{{ $data->patient->medical_record_number }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->clinic->name }}</p>
                                </td>
                                <td>
                                    <p>{{ date('d M Y', strtotime($data->created_at)) }}</p>
                                </td>
                                {{-- <td>
                                    <a href="{{ route('patients.show', $data) }}" class="btn btn-primary">Show</a>
                                    <a href="{{ route('patients.edit', $data) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('outpatients.destroy', $data->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td> --}}
                            </tr>
                        @endforeach
                        <!-- end table row -->
                        </tbody>
                    </table>
                    <!-- end table -->

                    {{ $outpatients->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

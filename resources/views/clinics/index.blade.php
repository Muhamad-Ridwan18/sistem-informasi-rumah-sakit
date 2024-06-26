@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Klinik') }}</h2>
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
                    <a href="{{ route('clinics.create') }}" class="btn btn-primary">+ Clinics</a>
                </div>

                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
                        <thead>
                        <tr>
                            <th><h6>No</h6></th>
                            <th><h6>Name</h6></th>
                            <th><h6>Tarif</h6></th>
                            <th><h6>Action</h6></th>
                        </tr>
                        <!-- end table row-->
                        </thead>
                        <tbody>
                        @foreach($clinics  as $data)
                            <tr>
                                <td>
                                    <p>{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p>{{ $data->name }}</p>
                                </td>
                                <td>
                                    <p>Rp. {{ number_format($data->tarif, 0, ',', '.') ?? '-' }}</p>
                                </td>
                                <td>
                                    <a href="{{ route('clinics.edit', $data) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('clinics.destroy', $data) }}" method="POST" class="d-inline">
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

                    {{ $clinics->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

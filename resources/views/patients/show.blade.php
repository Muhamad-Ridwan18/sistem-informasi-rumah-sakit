@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Detail Pasien') }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
          <div class="col-md-8">
               <div class="card-styles">
                   <div class="card-style-3 mb-30">
                       <div class="card-content">
                           <h2 class="mb-3">{{ __('Informasi Pasien') }}</h2>
                           <h4>{{ $patient->full_name }}</h4>
                           <p>NIK: {{ $patient->nik }}</p>
                           <p>Jenis Kelamin: {{ $patient->gender }}</p>
                           <p>Alamat: {{ $patient->address }}</p>
                           <p>Tanggal Lahir: {{ $patient->birth_date }}</p>
                           <p>Nomor Telepon: {{ $patient->phone }}</p>
                           <p>Email: {{ $patient->email }}</p>
                           <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3 mb-3">Back to Patients</a>
                           <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary mt-3 mb-3">Edit Patient</a>
                       </div>
                   </div>
               </div>
          </div>
          <div class="col-md-4">
               <div class="card-styles">
                   <div class="card-style-3 mb-30">
                       <div class="card-content">
                            <div> 
                                <h3 class="mb-3">{{ __('Kartu Pasien') }}</h3>
                                <div class="credit-card"> 
                                    <div class="circle1"></div> 
                                    <div class="circle2"></div> 
                                    <div class="head"> 
                                        <div> 
                                            <i class="fa-solid fa-credit-card fa-2xl"></i> 
                                        </div> 
                                        <div>Rumah Sakit Upaya Sehat</div> 
                                    </div> 
                                    <div class="number"> 
                                        <div>{{ $patient->medical_record_number }}</div> 
                                    </div> 
                                    <div class="tail"> 
                                        <div>{{ $patient->full_name }}</div> 
                                        
                                    </div> 
                                </div> 
                            </div> 
                       </div>
                   </div>
               </div>
          </div>
          @if (in_array(auth()->user()->role, ['Doctor', 'Admin', 'Perawat']))
            <div class="col-md-7">
                <div class="card-styles">
                    <div class="card-style-3 mb-30">
                        <div class="card-content">
                        <div class="mb-4">
                            <h2>Medical Histories</h2>
                            <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Doctor</th>
                                                <th>Diagnosis</th>
                                                <th>Tanggal Pemeriksaan</th>
                                                <th>poliklinik</th>
                                                <th>Resep</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($medicalExaminations as $medicalExamination)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $medicalExamination->doctor->full_name }}</td>
                                                    <td>{{ $medicalExamination->diagnosis }}</td>
                                                    <td>{{ $medicalExamination->examination_datetime }}</td>
                                                    <td>{{ $medicalExamination->clinic->name }}</td>
                                                    <td>{{ $medicalExamination->prescription ?: '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No medical examination available.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-5">
                <div class="card-styles">
                    <div class="card-style-3 mb-30">
                        <div class="card-content">
                        <!-- Medical Examinations -->
                        <div class="mb-4">
                            <h2>Medical Examinations</h2>
                                
                            <form action="{{ route('patients.medicalExaminations.store', $patient) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="outpatient_id" value="{{ $patient->id }}">
                                    <label for="doctor_id" class="form-label">Doctor</label>
                                    <select class="form-control" id="doctor_id" name="doctor_id">
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="examination_datetime" class="form-label">Examination Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="examination_datetime" name="examination_datetime" value="{{ old('examination_datetime') }}">
                                    @error('examination_datetime')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="diagnosis" class="form-label">Diagnosis</label>
                                    <input type="text" class="form-control" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}">
                                    @error('diagnosis')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="prescription" class="form-label">Prescription</label>
                                    <textarea class="form-control" id="prescription" name="prescription">{{ old('prescription') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Medical Examination</button>
                            </form>
                            
                        </div>
                        </div>
                    </div>
                </div>
            </div>
          @else
            <div class="col-md-12">
                <div class="card-styles">
                    <div class="card-style-3 mb-30">
                        <div class="card-content">
                        <div class="mb-4">
                            <h2>Medical Histories</h2>
                            <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Doctor</th>
                                                <th>Diagnosis</th>
                                                <th>Tanggal Pemeriksaan</th>
                                                <th>poliklinik</th>
                                                <th>Resep</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($medicalExaminations as $medicalExamination)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $medicalExamination->doctor->full_name }}</td>
                                                    <td>{{ $medicalExamination->diagnosis }}</td>
                                                    <td>{{ $medicalExamination->examination_datetime }}</td>
                                                    <td>{{ $medicalExamination->clinic->name }}</td>
                                                    <td>{{ $medicalExamination->prescription ?: '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No medical examination available.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
          @endif
    </div>
@endsection

@push('styles')
    <style>
        .credit-card { 
    background-color: #40A578; 
    color: #a1a1aa; 
    padding: 30px 30px; 
    border-radius: 0.5rem; 
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); 
    width: 450px; 
    height: 250px; 
    display: flex; 
    flex-direction: column; 
    position: relative; 
    overflow: hidden; 
    transition: all 0.5s ease-in-out; 
} 
  
.credit-card:hover { 
    scale: 1.1; 
} 
  
.head, 
.number, 
.tail { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    font-weight: 600; 
    z-index: 10; 

} 
  
.head { 
    font-size: 1.3rem; 
    font-weight: bold;
    color: #ffffff; 
} 
.tail {
    color: #ffffff;
    margin-bottom: 0.5rem;
}
.number { 
    margin-top: auto; 
    font-size: 2.1rem; 
    font-weight: bold;  
    color: #ffffff; 
} 
  
.exp { 
    font-size: 0.8rem; 
} 
  
.exp-date { 
    color: #d4d4d8; 
    font-size: 1.3rem; 
} 
  
.circle1 { 
    position: absolute; 
    width: 250px; 
    height: 250px; 
    background-color: #9DDE8B; 
    border-radius: 100%; 
    transform: translateY(-60%) translateX(100%); 
} 
  
.circle2 { 
    position: absolute; 
    width: 100px; 
    height: 100px; 
    background-color: #E6FF94; 
    border-radius: 100%; 
    transform: translateY(190%); 
}
    </style>
@endpush



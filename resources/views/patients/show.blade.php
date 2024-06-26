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
                           <h4 class="mb-2">{{ $patient->full_name }}</h4>
                           <p>NIK: {{ $patient->nik }}</p>
                           <p>Jenis Kelamin: {{ $patient->gender }}</p>
                           <p>Alamat: {{ $patient->address }}</p>
                           <p>Tanggal Lahir: {{ $patient->birth_date }}</p>
                           <p>Nomor Telepon: {{ $patient->phone }}</p>
                           <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-4 mb-4">Kembali Ke menu Pasien</a>
                           <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary mt-4 mb-4">Edit Pasien</a>
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
          <div class="col-md-12">
            <div class="card-styles">
                <div class="card-style-3 mb-30">
                    <div class="card-content">
                    <!-- Medical Examinations -->
                    <div class="mb-4">
                        <h2>Pemeriksaan Kesehatan</h2>
                        <div class="alert-box primary-alert">
                            @if (session('error'))
                                <div class="alert">
                                    <h4 class="alert-heading">Error</h4>
                                    <p class="text-medium">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            @endif
                       </div>
                            
                        <form action="{{ route('patients.medicalExaminations.store', $patient) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="outpatient_id" value="{{ $patient->id }}">
                                <label for="doctor_id" class="form-label">Dokter</label>
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
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <input type="text" class="form-control" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}">
                                @error('diagnosis')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="medicines" class="form-label">Obat</label>
                                <select class="select2 form-control" id="medicines" name="medicines[]" multiple>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}" data-name="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                    @endforeach
                                </select>
                                @error('medicines')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="medicine-dosages" class="mb-3"></div>
                            <div class="mb-3">
                                <label for="prescription" class="form-label">Resep</label>
                                <textarea rows="5" class="form-control" id="prescription" name="prescription">{{ old('prescription') }}</textarea>
                            </div>
                                                            
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="card-styles">
                    <div class="card-style-3 mb-30">
                        <div class="card-content">
                        <div class="mb-4">
                            <h2>Rekam Medis</h2>
                            <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Dokter</th>
                                                <th>Diagnosis</th>
                                                <th>Tanggal Pemeriksaan</th>
                                                <th>poliklinik</th>
                                                <th>Resep</th>
                                                <th>Biaya Pemeriksaan</th>
                                                <th>Rician Biaya</th>
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
                                                    @php
                                                        $clinicPrice = $medicalExamination->clinic->tarif;
                                                        $doctorPrice = $medicalExamination->doctor->tarif;
                                                        $medicinePrice = $medicalExamination->medicines->sum('price');
                                                        $medicineList = $medicalExamination->medicines->pluck('name')->implode(', ');
                                                        $total = $clinicPrice + $doctorPrice + $medicinePrice;
                                                        // format tarif indonesia
                                                        $total = number_format($total, 0, ',', '.');                                              
                                                    @endphp
                                                    <td>Rp {{  $total }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col">
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $loop->iteration }}">
                                                                    Show Details
                                                                </button>
                                                            </div>
                                                            <div class="col">
                                                                <a href="{{ route('patients.print-resep', $medicalExamination->id)}}" class="btn btn-success"> Print resep</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <div class="modal fade" id="detailModal-{{ $loop->iteration }}" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailModalLabel">Detail Biaya</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Isi modal dengan rincian biaya -->
                                                                    <p>Clinic Price: Rp {{ $clinicPrice }}</p>
                                                                    <p>Doctor Price: Rp {{ $doctorPrice }}</p>
                                                                    <p>Medicine: {{ $medicineList }}</p>
                                                                    <p>Medicine Price: Rp {{ $medicinePrice }}</p>
                                                                    <p>Total Price: Rp {{ $total }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="{{ route('patients.print', $medicalExamination->id) }}" class="btn btn-primary">Cetak Invoice</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No medical examination available.</td>
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

@push('scripts')

<script>
    $(document).ready(function() {
        $('#medicines').select2();

        $('#medicines').on('change', function () {
            const medicineDosagesContainer = $('#medicine-dosages');
            medicineDosagesContainer.empty();
            $(this).find('option:selected').each(function () {
                const medicineId = $(this).val();
                const medicineName = $(this).data('name');

                const dosageDiv = $('<div>').addClass('mb-3');
                const dosageLabel = $('<label>').addClass('form-label').text(`Dosage for ${medicineName}`);
                const dosageInput = $('<input>').attr({
                    type: 'text',
                    class: 'form-control',
                    name: `dosages[${medicineId}]`,
                    'data-medicine-id': medicineId,
                    'data-medicine-name': medicineName
                });

                dosageInput.on('input', updatePrescription);

                dosageDiv.append(dosageLabel).append(dosageInput);
                medicineDosagesContainer.append(dosageDiv);
            });
            updatePrescription();
        });

        function updatePrescription() {
            const prescriptionTextarea = $('#prescription');
            let prescriptionText = '';

            $('#medicines').find('option:selected').each(function() {
                const medicineId = $(this).val();
                const medicineName = $(this).data('name');
                const dosage = $(`input[name='dosages[${medicineId}]']`).val();

                if (medicineName && dosage) {
                    prescriptionText += `${medicineName}: ${dosage}\n`;
                }
            });

            prescriptionTextarea.val(prescriptionText.trim());
        }
    });
</script>
@endpush

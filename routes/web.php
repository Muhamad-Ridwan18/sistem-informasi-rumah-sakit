<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::resource('users', App\Http\Controllers\UserController::class);


    

    // Routes for Patient
    Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [App\Http\Controllers\PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [App\Http\Controllers\PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [App\Http\Controllers\PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [App\Http\Controllers\PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [App\Http\Controllers\PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('/patients/{patient}/medical-histories', [App\Http\Controllers\PatientController::class, 'addMedicalHistory'])->name('patients.medicalHistories.store');
    Route::post('/patients/{patient}/medical-examinations', [App\Http\Controllers\PatientController::class, 'addMedicalExamination'])->name('patients.medicalExaminations.store');
    Route::get('patients/search', [App\Http\Controllers\PatientController::class, 'search'])->name('patients.search');
    Route::get('patients/{id}/print-billing', [App\Http\Controllers\PatientController::class, 'printBilling'])->name('patients.print');
    Route::get('patients/{id}/print-resep', [App\Http\Controllers\PatientController::class, 'printResep'])->name('patients.print-resep');

    // Routes for Doctor
    Route::get('/doctors', [App\Http\Controllers\DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/create', [App\Http\Controllers\DoctorController::class, 'create'])->name('doctors.create');
    Route::post('/doctors', [App\Http\Controllers\DoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}', [App\Http\Controllers\DoctorController::class, 'show'])->name('doctors.show');
    Route::get('/doctors/{doctor}/edit', [App\Http\Controllers\DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [App\Http\Controllers\DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [App\Http\Controllers\DoctorController::class, 'destroy'])->name('doctors.destroy');

    // Routes for clinics
    Route::get('/clinics', [App\Http\Controllers\ClinicController::class, 'index'])->name('clinics.index');
    Route::get('/clinics/create', [App\Http\Controllers\ClinicController::class, 'create'])->name('clinics.create');
    Route::post('/clinics', [App\Http\Controllers\ClinicController::class, 'store'])->name('clinics.store');
    Route::get('/clinics/{clinic}', [App\Http\Controllers\ClinicController::class, 'show'])->name('clinics.show');
    Route::get('/clinics/{clinic}/edit', [App\Http\Controllers\ClinicController::class, 'edit'])->name('clinics.edit');
    Route::put('/clinics/{clinic}', [App\Http\Controllers\ClinicController::class, 'update'])->name('clinics.update');
    Route::delete('/clinics/{clinic}', [App\Http\Controllers\ClinicController::class, 'destroy'])->name('clinics.destroy');

    // Routes for Inpatient
    Route::get('/inpatients', [App\Http\Controllers\InpatientController::class, 'index'])->name('inpatients.index');
    Route::get('/inpatients/create', [App\Http\Controllers\InpatientController::class, 'create'])->name('inpatients.create');
    Route::post('/inpatients', [App\Http\Controllers\InpatientController::class, 'store'])->name('inpatients.store');
    Route::get('/inpatients/{inpatient}', [App\Http\Controllers\InpatientController::class, 'show'])->name('inpatients.show');
    Route::get('/inpatients/{inpatient}/edit', [App\Http\Controllers\InpatientController::class, 'edit'])->name('inpatients.edit');
    Route::put('/inpatients/{inpatient}', [App\Http\Controllers\InpatientController::class, 'update'])->name('inpatients.update');
    Route::delete('/inpatients/{inpatient}', [App\Http\Controllers\InpatientController::class, 'destroy'])->name('inpatients.destroy');
    Route::get('/inpatients/{inpatient}/print-bracelet', [App\Http\Controllers\InpatientController::class, 'printBracelet'])->name('inpatients.printBracelet');

    // Routes for Outpatient
    Route::resource('outpatients', App\Http\Controllers\OutpatientController::class);

    // Routes for MedicalExaminationController
    Route::get('/medical-examinations', [App\Http\Controllers\MedicalExaminationController::class, 'index'])->name('medical_examinations.index');
    Route::get('/medical-examinations/create', [App\Http\Controllers\MedicalExaminationController::class, 'create'])->name('medical_examinations.create');
    Route::post('/medical-examinations', [App\Http\Controllers\MedicalExaminationController::class, 'store'])->name('medical_examinations.store');
    Route::get('/medical-examinations/{medical_examination}', [App\Http\Controllers\MedicalExaminationController::class, 'show'])->name('medical_examinations.show');
    Route::get('/medical-examinations/{medical_examination}/edit', [App\Http\Controllers\MedicalExaminationController::class, 'edit'])->name('medical_examinations.edit');
    Route::put('/medical-examinations/{medical_examination}', [App\Http\Controllers\MedicalExaminationController::class, 'update'])->name('medical_examinations.update');
    Route::delete('/medical-examinations/{medical_examination}', [App\Http\Controllers\MedicalExaminationController::class, 'destroy'])->name('medical_examinations.destroy');

    // Routes for MedicalHistoryController
    Route::get('/medical-histories', [App\Http\Controllers\MedicalHistoryController::class, 'index'])->name('medical_histories.index');
    Route::get('/medical-histories/create', [App\Http\Controllers\MedicalHistoryController::class, 'create'])->name('medical_histories.create');
    Route::post('/medical-histories', [App\Http\Controllers\MedicalHistoryController::class, 'store'])->name('medical_histories.store');
    Route::get('/medical-histories/{medical_history}', [App\Http\Controllers\MedicalHistoryController::class, 'show'])->name('medical_histories.show');
    Route::get('/medical-histories/{medical_history}/edit', [App\Http\Controllers\MedicalHistoryController::class, 'edit'])->name('medical_histories.edit');
    Route::put('/medical-histories/{medical_history}', [App\Http\Controllers\MedicalHistoryController::class, 'update'])->name('medical_histories.update');
    Route::delete('/medical-histories/{medical_history}', [App\Http\Controllers\MedicalHistoryController::class, 'destroy'])->name('medical_histories.destroy');

    // Routes for Queue
    Route::get('/queue', [App\Http\Controllers\QueueController::class, 'index'])->name('queue.index');
    Route::post('/queue/create', [App\Http\Controllers\QueueController::class, 'create'])->name('queue.create');
    Route::delete('/queues/{id}/call', [App\Http\Controllers\QueueController::class, 'callNextPatient'])->name('queues.callNext');
    Route::get('/queue/print/{id}', [App\Http\Controllers\QueueController::class, 'printQueueNumber'])->name('queue.print');
    Route::put('/queue/{queue}/update-status', [App\Http\Controllers\QueueController::class, 'updateStatus'])->name('queue.updateStatus');


    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('medicines', App\Http\Controllers\MedicineController::class);
    Route::resource('rooms', App\Http\Controllers\RoomController::class);

    Route::post('/update-queue', [App\Http\Controllers\HomeController::class, 'updateQueue'])->name('home.updateQueue');

});

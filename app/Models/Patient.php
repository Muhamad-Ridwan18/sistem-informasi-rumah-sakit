<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'nik',
        'gender',
        'address',
        'birth_date',
        'phone',
        'medical_record_number',
    ];

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }

    public function inpatients()
    {
        return $this->hasMany(Inpatient::class);
    }

    public function outpatients()
    {
        return $this->hasMany(Outpatient::class);
    }

    public function medicalExaminations()
    {
        return $this->hasMany(MedicalExamination::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function visitHistories()
    {
        return $this->hasMany(VisitHistory::class);
    }

    public function latestClinic()
    {
        return $this->hasOne(VisitHistory::class)->latest('created_at');
    }

    // get clinic name for patient from last visit
    public function latestClinicName()
    {
        return $this->latestClinic()->first()->clinic->name;
    }

    // get docter name for patient from last visit
    public function latestDoctorName()
    {
        return $this->latestClinic()->first()->doctor->name;
    }

}

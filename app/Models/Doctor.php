<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'specialization',
        'phone',
        'email',
        'gender',
        'tarif'
    ];

    public function outpatients()
    {
        return $this->hasMany(Outpatient::class);
    }

    public function medicalExaminations()
    {
        return $this->hasMany(MedicalExamination::class);
    }

    public function visitHistories()
    {
        return $this->hasMany(VisitHistory::class);
    }
}

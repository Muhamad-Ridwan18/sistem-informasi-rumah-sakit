<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tarif',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function visitHistories()
    {
        return $this->hasMany(VisitHistory::class);
    }

    public function inpatients()
    {
        return $this->hasMany(Inpatient::class);
    }
    


}

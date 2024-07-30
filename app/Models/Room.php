<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'jenis',
        'tarif'
    ];

    public function patients() 
    {
        return $this->hasMany(Patient::class);
    }

    public function inpatients() 
    {
        return $this->hasMany(Inpatient::class);
    }

    public function queue()  
    {
        return $this->hasMany(Queue::class);    
    }
}

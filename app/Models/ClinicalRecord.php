<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalRecord extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'blood_type', 'allergies', 'chronic_diseases', 'notes'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'serial_number',
        'doctor_id',
        'patient_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function invoice()
{
    return $this->hasOne(Invoice::class);
}
}
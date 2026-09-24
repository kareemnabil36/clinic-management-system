<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
    ];
    public function appointments()
{
    return $this->hasMany(Appointment::class);
}

public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}
public function invoices()
{
    return $this->hasMany(Invoice::class);
}
}

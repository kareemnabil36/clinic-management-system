<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with(['doctor', 'patient'])->latest()->get();

        return view('medical_records.index', compact('medicalRecords'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        $appointments = Appointment::where('status', 'completed')->get();

        return view('medical_records.create', compact('doctors', 'patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'record_date' => 'required|date',
        ]);

        MedicalRecord::create($validated);

        return redirect()->route('medical-records.index')->with('success', 'تم تسجيل السجل الطبي بنجاح');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['doctor', 'patient', 'appointment']);

        return view('medical_records.show', compact('medicalRecord'));
    }
}
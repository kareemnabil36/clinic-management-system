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
        $user = auth()->user();

        if ($user->role === 'admin') {
            $medicalRecords = MedicalRecord::with(['doctor', 'patient'])->latest()->get();
        } elseif ($user->role === 'doctor') {
            $medicalRecords = MedicalRecord::with(['doctor', 'patient'])
                ->where('doctor_id', $user->doctor->id)
                ->latest()->get();
        } else { // patient
            $medicalRecords = MedicalRecord::with(['doctor', 'patient'])
                ->where('patient_id', $user->patient->id)
                ->latest()->get();
        }

        return view('medical_records.index', compact('medicalRecords'));
    }

  public function create()
{
    $user = auth()->user();

    if ($user->role === 'patient') {
        abort(403, 'غير مصرح لك بإضافة سجل طبي.');
    }

    if ($user->role === 'doctor') {
        // الدكتور يشوف بس المرضى اللي حجزوا معاه
        $patients = \App\Models\Patient::whereHas('appointments', function ($query) use ($user) {
            $query->where('doctor_id', $user->doctor->id);
        })->get();

        $appointments = Appointment::where('doctor_id', $user->doctor->id)
            ->where('status', 'completed')
            ->get();

        return view('medical_records.create', compact('patients', 'appointments'));
    }

    // Admin
    $doctors = Doctor::all();
    $patients = Patient::all();
    $appointments = Appointment::where('status', 'completed')->get();

    return view('medical_records.create', compact('doctors', 'patients', 'appointments'));
}
    public function store(Request $request)
    {
        if (auth()->user()->role === 'patient') {
            abort(403, 'غير مصرح لك بإضافة سجل طبي.');
        }

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
        $user = auth()->user();

        // التأكد إن المريض بيشوف بس سجله، والدكتور بيشوف بس سجل مريضه
        if ($user->role === 'patient' && $medicalRecord->patient_id !== $user->patient->id) {
            abort(403);
        }
        if ($user->role === 'doctor' && $medicalRecord->doctor_id !== $user->doctor->id) {
            abort(403);
        }

        $medicalRecord->load(['doctor', 'patient', 'appointment']);

        return view('medical_records.show', compact('medicalRecord'));
    }
}
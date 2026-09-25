<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; 
use App\Models\Doctor;
use App\Models\Patient;
class AppointmentController extends Controller
{
    
 public function index()
    {
       $user = auth()->user();

    if ($user->role === 'admin') {
        $appointments = Appointment::with(['doctor', 'patient'])->latest()->get();
    } elseif ($user->role === 'doctor') {
        $appointments = Appointment::with(['doctor', 'patient'])
            ->where('doctor_id', $user->doctor->id)
            ->latest()
            ->get();
    } else { // patient
        $appointments = Appointment::with(['doctor', 'patient'])
            ->where('patient_id', $user->patient->id)
            ->latest()
            ->get();
    }

    return view('appointments.index', compact('appointments'));
    }

    public function create()
{
    if (auth()->user()->role === 'doctor') {
        abort(403, 'غير مصرح لك بحجز المواعيد.');
    }


    $user = auth()->user();
    $doctors = Doctor::all();
    $patients = Patient::all();
    

    return view('appointments.create', compact('doctors', 'patients', 'user'));
}

   
   public function store(Request $request)
{
    if (auth()->user()->role === 'doctor') {
        abort(403, 'غير مصرح لك بحجز المواعيد.');
    }

    $user = auth()->user();

    $rules = [
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
        'notes' => 'nullable|string|max:500',
    ];

    // لو المستخدم مش Patient، لازم يختار المريض من الفورم
    if ($user->role !== 'patient') {
        $rules['patient_id'] = 'required|exists:patients,id';
    }

    $validated = $request->validate($rules);

    // لو المستخدم Patient، نحدد الـ patient_id تلقائيًا من حسابه
    if ($user->role === 'patient') {
        $validated['patient_id'] = $user->patient->id;
    }

    // التحقق من عدم وجود تعارض في المواعيد
    $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
        ->where('appointment_date', $validated['appointment_date'])
        ->where('appointment_time', $validated['appointment_time'])
        ->where('status', '!=', 'cancelled')
        ->exists();

    if ($conflict) {
        return back()->withErrors(['appointment_time' => 'هذا الدكتور لديه موعد آخر في نفس التاريخ والوقت.'])->withInput();
    }

    $year = date('Y');
    $lastAppointment = Appointment::where('serial_number', 'like', "APT-{$year}-%")
        ->orderBy('id', 'desc')
        ->first();

    $newNumber = $lastAppointment ? ((int) substr($lastAppointment->serial_number, -4)) + 1 : 1;
    $validated['serial_number'] = 'APT-' . $year . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    Appointment::create($validated);

    return redirect()->route('appointments.index')->with('success', 'تم حجز الموعد بنجاح، رقم الكشف: ' . $validated['serial_number']);
}
    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }
    public function update(Request $request, Appointment $appointment)
{
    $validated = $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'patient_id' => 'required|exists:patients,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
        'status' => 'required|in:pending,confirmed,cancelled,completed',
        'notes' => 'nullable|string|max:500',
    ]);

    $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
        ->where('appointment_date', $validated['appointment_date'])
        ->where('appointment_time', $validated['appointment_time'])
        ->where('status', '!=', 'cancelled')
        ->where('id', '!=', $appointment->id)
        ->exists();

    if ($conflict) {
        return back()->withErrors(['appointment_time' => 'هذا الدكتور لديه موعد آخر في نفس التاريخ والوقت.'])->withInput();
    }

    $appointment->update($validated);

    return redirect()->route('appointments.index')->with('success', 'تم تعديل الموعد بنجاح');
}

public function destroy(Appointment $appointment)
{
    $appointment->delete();

    return redirect()->route('appointments.index')->with('success', 'تم حذف الموعد بنجاح');
}
}

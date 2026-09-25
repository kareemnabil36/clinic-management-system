<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;   
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $unpaidInvoices = Invoice::where('payment_status', 'unpaid')->count();
        $totalAppointments = Appointment::count();

        return view('dashboard', compact('totalDoctors', 'totalPatients', 'todayAppointments', 'unpaidInvoices', 'totalAppointments'));

    } elseif ($user->role === 'doctor') {

        if (!$user->doctor) {
            return redirect()->route('login')->withErrors(['email' => 'حسابك غير مربوط ببيانات دكتور. برجاء التواصل مع الإدارة.']);
        }

        $myAppointmentsToday = Appointment::where('doctor_id', $user->doctor->id)
            ->whereDate('appointment_date', today())
            ->count();
        $myTotalAppointments = Appointment::where('doctor_id', $user->doctor->id)->count();

        return view('dashboard-doctor', compact('myAppointmentsToday', 'myTotalAppointments'));

    } else { // patient

        if (!$user->patient) {
            return redirect()->route('login')->withErrors(['email' => 'حسابك غير مربوط ببيانات مريض. برجاء التواصل مع الإدارة.']);
        }

        $myAppointments = Appointment::where('patient_id', $user->patient->id)->count();
        $myUpcoming = Appointment::where('patient_id', $user->patient->id)
            ->where('appointment_date', '>=', today())
            ->count();

        return view('dashboard-patient', compact('myAppointments', 'myUpcoming'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

    // Doctor Accounts
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/doctors/create-account', [DoctorController::class, 'createAccount'])->name('doctors.create-account');
    Route::post('/doctors/create-account', [DoctorController::class, 'storeAccount'])->name('doctors.store-account');
});

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Medical Records
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
});

require __DIR__.'/auth.php';
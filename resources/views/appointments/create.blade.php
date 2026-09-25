@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-primary">حجز موعد جديد</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('appointments.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="doctor_id" class="form-label">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            <option value="">-- اختر الدكتور --</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
            @endforeach
        </select>
    </div>

    @if($user->role !== 'patient')
    <div class="mb-3">
        <label for="patient_id" class="form-label">Patient</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            <option value="">-- اختر المريض --</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="mb-3">
        <label for="appointment_date" class="form-label">Date</label>
        <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="appointment_time" class="form-label">Time</label>
        <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">Notes</label>
        <textarea name="notes" id="notes" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Book Appointment</button>
</form>

@endsection
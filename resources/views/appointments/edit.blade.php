@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-primary">تعديل الموعد</h2>

<form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="doctor_id" class="form-label">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->name }} ({{ $doctor->specialization }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="patient_id" class="form-label">Patient</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                    {{ $patient->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="appointment_date" class="form-label">Date</label>
        <input type="date" name="appointment_date" id="appointment_date" class="form-control"
               value="{{ $appointment->appointment_date }}" required>
    </div>

    <div class="mb-3">
        <label for="appointment_time" class="form-label">Time</label>
        <input type="time" name="appointment_time" id="appointment_time" class="form-control"
               value="{{ $appointment->appointment_time }}" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control" required>
            @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                <option value="{{ $status }}" {{ $appointment->status == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">Notes</label>
        <textarea name="notes" id="notes" class="form-control">{{ $appointment->notes }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Appointment</button>
</form>

@endsection
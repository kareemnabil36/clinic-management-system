@extends('layouts.app')

@section('content')

<h2 class="mb-3">تسجيل سجل طبي جديد</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('medical-records.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="patient_id" class="form-label">المريض</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            <option value="">-- اختر المريض --</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="doctor_id" class="form-label">الدكتور</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            <option value="">-- اختر الدكتور --</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="appointment_id" class="form-label">الموعد المرتبط (اختياري)</label>
        <select name="appointment_id" id="appointment_id" class="form-control">
            <option value="">-- بدون ربط بموعد --</option>
            @foreach($appointments as $appointment)
                <option value="{{ $appointment->id }}">
                    {{ $appointment->serial_number }} - {{ $appointment->doctor->name }} / {{ $appointment->patient->name }} ({{ $appointment->appointment_date }})
                </option>
            @endforeach
        </select>
        <small class="text-muted">بتظهر هنا بس المواعيد اللي حالتها "completed"</small>
    </div>

    <div class="mb-3">
        <label for="record_date" class="form-label">تاريخ السجل</label>
        <input type="date" name="record_date" id="record_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="diagnosis" class="form-label">التشخيص</label>
        <textarea name="diagnosis" id="diagnosis" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label for="treatment" class="form-label">العلاج</label>
        <textarea name="treatment" id="treatment" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="prescription" class="form-label">الروشتة</label>
        <textarea name="prescription" id="prescription" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-warning">حفظ السجل</button>
</form>

@endsection
@extends('layouts.app')

@section('content')

<h2 class="mb-3">تفاصيل السجل الطبي</h2>

<div class="card">
    <div class="card-body">
        <p><strong>المريض:</strong> {{ $medicalRecord->patient->name }}</p>
        <p><strong>الدكتور:</strong> {{ $medicalRecord->doctor->name }} ({{ $medicalRecord->doctor->specialization }})</p>

        @if($medicalRecord->appointment)
            <p><strong>رقم الكشف المرتبط:</strong> {{ $medicalRecord->appointment->serial_number }}</p>
        @endif

        <p><strong>تاريخ السجل:</strong> {{ $medicalRecord->record_date }}</p>

        <hr>

        <p><strong>التشخيص:</strong><br>{{ $medicalRecord->diagnosis }}</p>

        @if($medicalRecord->treatment)
            <p><strong>العلاج:</strong><br>{{ $medicalRecord->treatment }}</p>
        @endif

        @if($medicalRecord->prescription)
            <p><strong>الروشتة:</strong><br>{{ $medicalRecord->prescription }}</p>
        @endif

        @if($medicalRecord->notes)
            <p><strong>ملاحظات:</strong><br>{{ $medicalRecord->notes }}</p>
        @endif
    </div>
</div>

<a href="{{ route('medical-records.index') }}" class="btn btn-secondary mt-3">رجوع للقائمة</a>

@endsection
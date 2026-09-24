@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-warning">السجلات الطبية</h2>

<a href="{{ route('medical-records.create') }}" class="btn btn-warning mb-3">إضافة سجل طبي جديد</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>المريض</th>
            <th>الدكتور</th>
            <th>التشخيص</th>
            <th>تاريخ السجل</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicalRecords as $record)
        <tr>
            <td>{{ $record->patient->name }}</td>
            <td>{{ $record->doctor->name }}</td>
            <td>{{ \Illuminate\Support\Str::limit($record->diagnosis, 50) }}</td>
            <td>{{ $record->record_date }}</td>
            <td>
                <a href="{{ route('medical-records.show', $record->id) }}" class="btn btn-sm btn-warning">عرض التفاصيل</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
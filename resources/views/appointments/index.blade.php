@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-primary">قائمة المواعيد</h2>

@if(auth()->user()->role !== 'doctor')
<a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">حجز موعد جديد</a>
@endif

<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>الدكتور</th>
            <th>المريض</th>
            <th>التاريخ</th>
            <th>الوقت</th>
            <th>الحالة</th>
            @if(auth()->user()->role === 'admin')
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $appointment)
        <tr>
            <td>{{ $appointment->doctor->name }}</td>
            <td>{{ $appointment->patient->name }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->appointment_time }}</td>
            <td>{{ $appointment->status }}</td>
            @if(auth()->user()->role === 'admin')
            <td>
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('متأكد إنك عايز تحذف الموعد ده؟')">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
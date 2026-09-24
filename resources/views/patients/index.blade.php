@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-danger">قائمة المرضى</h2>

<a href="{{ route('patients.create') }}" class="btn btn-danger mb-3">إضافة مريض جديد</a>

<table class="table table-bordered">
    <thead class="table-danger">
        <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>تاريخ الميلاد</th>
            <th>الجنس</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $patient)
        <tr>
            <td>{{ $patient->name }}</td>
            <td>{{ $patient->email }}</td>
            <td>{{ $patient->phone }}</td>
            <td>{{ $patient->date_of_birth }}</td>
            <td>{{ $patient->gender }}</td>
            <td>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-danger">Edit</a>
                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('متأكد إنك عايز تحذف المريض ده؟')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
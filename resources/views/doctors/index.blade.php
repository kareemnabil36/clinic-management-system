@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-success">قائمة الدكاترة</h2>

<a href="{{ route('doctors.create') }}" class="btn btn-success mb-3">إضافة دكتور جديد</a>

<table class="table table-bordered">
    <thead class="table-success">
        <tr>
            <th>الاسم</th>
            <th>التخصص</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
        <tr>
            <td>{{ $doctor->name }}</td>
            <td>{{ $doctor->specialization }}</td>
            <td>{{ $doctor->email }}</td>
            <td>{{ $doctor->phone }}</td>
            <td>
                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-success">Edit</a>
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('متأكد إنك عايز تحذف الدكتور ده؟')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
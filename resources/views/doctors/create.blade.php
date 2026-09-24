@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-success">إضافة دكتور جديد</h2>

<form action="{{ route('doctors.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label"> الدكتور</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="specialization" class="form-label">التخصص</label>
        <input type="text" name="specialization" id="specialization" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">الهاتف</label>
        <input type="text" name="phone" id="phone" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Create Doctor</button>
</form>

@endsection
@extends('layouts.app')

@section('content')

<h2 class="mb-4">لوحة تحكم الدكتور</h2>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h6 class="card-title">مواعيدي اليوم</h6>
                <h2 class="mb-0">{{ $myAppointmentsToday }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h6 class="card-title">إجمالي مواعيدي</h6>
                <h2 class="mb-0">{{ $myTotalAppointments }}</h2>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('appointments.index') }}" class="btn btn-primary mt-4">عرض كل مواعيدي</a>

@endsection
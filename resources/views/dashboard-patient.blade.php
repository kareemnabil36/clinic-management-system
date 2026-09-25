@extends('layouts.app')

@section('content')

<h2 class="mb-4">لوحة تحكم المريض</h2>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-white bg-danger shadow-sm">
            <div class="card-body">
                <h6 class="card-title">إجمالي مواعيدي</h6>
                <h2 class="mb-0">{{ $myAppointments }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-info shadow-sm">
            <div class="card-body">
                <h6 class="card-title">مواعيدي القادمة</h6>
                <h2 class="mb-0">{{ $myUpcoming }}</h2>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('appointments.create') }}" class="btn btn-danger mt-4">احجز موعد جديد</a>

@endsection
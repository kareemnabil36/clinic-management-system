@extends('layouts.app')

@section('content')

<h2 class="mb-4">لوحة التحكم</h2>

<div class="row g-3">

    <div class="col-md-3">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h6 class="card-title">عدد الدكاترة</h6>
                <h2 class="mb-0">{{ $totalDoctors }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-danger shadow-sm">
            <div class="card-body">
                <h6 class="card-title">عدد المرضى</h6>
                <h2 class="mb-0">{{ $totalPatients }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h6 class="card-title">مواعيد اليوم</h6>
                <h2 class="mb-0">{{ $todayAppointments }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info shadow-sm">
            <div class="card-body">
                <h6 class="card-title">فواتير غير مدفوعة</h6>
                <h2 class="mb-0">{{ $unpaidInvoices }}</h2>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted">إجمالي المواعيد المسجلة</h6>
                <h3>{{ $totalAppointments }}</h3>
            </div>
        </div>
    </div>
</div>

@endsection
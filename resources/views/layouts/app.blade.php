<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>نظام حجز المواعيد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('doctors.index') }}">نظام حجز المواعيد</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link text-success fw-bold" href="{{ route('doctors.index') }}">الدكاترة</a>
                <a class="nav-link text-danger fw-bold" href="{{ route('patients.index') }}">المرضى</a>
                <a class="nav-link text-primary fw-bold" href="{{ route('appointments.index') }}">المواعيد</a>
                <a class="nav-link text-warning fw-bold" href="{{ route('medical-records.index') }}">السجلات الطبية</a>
                <a class="nav-link text-info fw-bold" href="{{ route('invoices.index') }}">الفواتير</a>
            </div>

            @auth
            <div class="navbar-nav">
                <span class="nav-link text-white">مرحبًا، {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">تسجيل الخروج</button>
                </form>
            </div>
            @endauth

        </div>
    </nav>

    <div class="container">

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-info">إنشاء فاتورة جديدة</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('invoices.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="appointment_id" class="form-label">الموعد</label>
        <select name="appointment_id" id="appointment_id" class="form-control" required>
            <option value="">-- اختر الموعد --</option>
            @foreach($appointments as $appointment)
                <option value="{{ $appointment->id }}">
                    {{ $appointment->serial_number }} - {{ $appointment->doctor->name }} / {{ $appointment->patient->name }} ({{ $appointment->appointment_date }})
                </option>
            @endforeach
        </select>
        <small class="text-muted">بتظهر هنا بس المواعيد المكتملة اللي لسه ما اتعملهاش فاتورة</small>
    </div>

    <div class="mb-3">
        <label for="amount" class="form-label">المبلغ</label>
        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="payment_status" class="form-label">حالة الدفع</label>
        <select name="payment_status" id="payment_status" class="form-control" required>
            <option value="unpaid">لم يتم الدفع</option>
            <option value="partial">دفع جزئي</option>
            <option value="paid">تم الدفع بالكامل</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label">طريقة الدفع</label>
        <input type="text" name="payment_method" id="payment_method" class="form-control" placeholder="كاش، فيزا، تحويل...">
    </div>

    <div class="mb-3">
        <label for="invoice_date" class="form-label">تاريخ الفاتورة</label>
        <input type="date" name="invoice_date" id="invoice_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-info text-white">حفظ الفاتورة</button>
</form>

@endsection
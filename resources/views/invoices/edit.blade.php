@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-info">تعديل الفاتورة</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">الموعد المرتبط</label>
        <input type="text" class="form-control" value="{{ $invoice->appointment->serial_number }}" disabled>
    </div>

    <div class="mb-3">
        <label for="amount" class="form-label">المبلغ</label>
        <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $invoice->amount }}" required>
    </div>

    <div class="mb-3">
        <label for="payment_status" class="form-label">حالة الدفع</label>
        <select name="payment_status" id="payment_status" class="form-control" required>
            <option value="unpaid" {{ $invoice->payment_status == 'unpaid' ? 'selected' : '' }}>لم يتم الدفع</option>
            <option value="partial" {{ $invoice->payment_status == 'partial' ? 'selected' : '' }}>دفع جزئي</option>
            <option value="paid" {{ $invoice->payment_status == 'paid' ? 'selected' : '' }}>تم الدفع بالكامل</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label">طريقة الدفع</label>
        <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ $invoice->payment_method }}">
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control">{{ $invoice->notes }}</textarea>
    </div>

    <button type="submit" class="btn btn-info text-white">تحديث الفاتورة</button>
</form>

@endsection
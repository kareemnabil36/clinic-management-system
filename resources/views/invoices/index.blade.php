@extends('layouts.app')

@section('content')

<h2 class="mb-3 text-info">الفواتير</h2>

@if(auth()->user()->role === 'admin')
<a href="{{ route('invoices.create') }}" class="btn btn-info text-white mb-3">إنشاء فاتورة جديدة</a>
@endif

<table class="table table-bordered">
    <thead class="table-info">
        <tr>
            <th>رقم الكشف</th>
            <th>المريض</th>
            <th>الدكتور</th>
            <th>المبلغ</th>
            <th>حالة الدفع</th>
            <th>تاريخ الفاتورة</th>
            @if(auth()->user()->role === 'admin')
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->appointment->serial_number }}</td>
            <td>{{ $invoice->patient->name }}</td>
            <td>{{ $invoice->appointment->doctor->name }}</td>
            <td>{{ $invoice->amount }} جنيه</td>
            <td>
                @if($invoice->payment_status == 'paid')
                    <span class="badge bg-success">تم الدفع</span>
                @elseif($invoice->payment_status == 'partial')
                    <span class="badge bg-warning text-dark">دفع جزئي</span>
                @else
                    <span class="badge bg-danger">لم يتم الدفع</span>
                @endif
            </td>
            <td>{{ $invoice->invoice_date }}</td>
            @if(auth()->user()->role === 'admin')
            <td>
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('متأكد إنك عايز تحذف الفاتورة دي؟')">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
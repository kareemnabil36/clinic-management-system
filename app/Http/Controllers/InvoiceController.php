<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['appointment.doctor', 'patient'])->latest()->get();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        // بنجيب بس المواعيد اللي مفيهاش فاتورة متسجلة لها بالفعل
        $appointments = Appointment::whereDoesntHave('invoice')
            ->where('status', 'completed')
            ->get();

        return view('invoices.create', compact('appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:unpaid,paid,partial',
            'payment_method' => 'nullable|string|max:100',
            'invoice_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // بنجيب الـ patient_id تلقائيًا من الموعد نفسه
        $appointment = Appointment::findOrFail($validated['appointment_id']);
        $validated['patient_id'] = $appointment->patient_id;

        Invoice::create($validated);

        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:unpaid,paid,partial',
            'payment_method' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
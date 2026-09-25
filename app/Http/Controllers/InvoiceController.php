<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $invoices = Invoice::with(['appointment.doctor', 'patient'])->latest()->get();
        } elseif ($user->role === 'patient') {
            $invoices = Invoice::with(['appointment.doctor', 'patient'])
                ->where('patient_id', $user->patient->id)
                ->latest()->get();
        } else {
            // الدكتور مالوش دعوة بالفواتير
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $appointments = Appointment::whereDoesntHave('invoice')
            ->where('status', 'completed')
            ->get();

        return view('invoices.create', compact('appointments'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:unpaid,paid,partial',
            'payment_method' => 'nullable|string|max:100',
            'invoice_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($validated['appointment_id']);
        $validated['patient_id'] = $appointment->patient_id;

        Invoice::create($validated);

        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function edit(Invoice $invoice)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

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
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
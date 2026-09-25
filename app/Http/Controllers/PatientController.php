<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('patients.index', compact('patients', 'doctors'));

    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('patients.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string|max:255',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'تم إضافة المريض بنجاح');
    }

    public function edit(Patient $patient)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string|max:255',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'تم تعديل بيانات المريض بنجاح');
    }

    public function destroy(Patient $patient)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'تم حذف المريض بنجاح');
    }
}
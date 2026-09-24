<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
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
    return view('patients.edit', compact('patient'));
}

public function update(Request $request, Patient $patient)
{
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
    $patient->delete();

    return redirect()->route('patients.index')->with('success', 'تم حذف المريض بنجاح');
}
}


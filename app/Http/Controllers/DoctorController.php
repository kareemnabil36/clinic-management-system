<?php

namespace App\Http\Controllers;
use App\Models\Doctor;


use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));

        
    }
    public function create()
    {
        return view ('doctors.create');
    }
    public function store(Request $request) 
    {
       $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable|string|max:20',
        ]);

        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'تم إضافة الدكتور بنجاح');
    }
    public function edit(Doctor $doctor)
{
    return view('doctors.edit', compact('doctor'));
}

public function update(Request $request, Doctor $doctor)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'specialization' => 'required|string|max:255',
        'email' => 'required|email|unique:doctors,email,' . $doctor->id,
        'phone' => 'nullable|string|max:20',
    ]);

    $doctor->update($validated);

    return redirect()->route('doctors.index')->with('success', 'تم تعديل بيانات الدكتور بنجاح');
}

public function destroy(Doctor $doctor)
{
    $doctor->delete();

    return redirect()->route('doctors.index')->with('success', 'تم حذف الدكتور بنجاح');
}

}

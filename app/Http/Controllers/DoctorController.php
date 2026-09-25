<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        $doctors = Doctor::all();

        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        return view('doctors.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'تم حذف الدكتور بنجاح');
    }

    public function createAccount()
    {
        return view('doctors.create-account');
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('doctors.index')->with('success', 'تم إنشاء حساب الدكتور بنجاح');
    }
}
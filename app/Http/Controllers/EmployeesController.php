<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'polytechnic_name' => 'required',
            'fathers_name' => 'required',
            'mothers_name' => 'required',
            'roll' => 'required',
            'registration_number' => 'required',
            'image' => 'nullable|image',
            'status' => 'required|boolean',
        ]);

        $employee = new Employee($validated);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $employee->image = $imagePath;
        }

        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required',
            'polytechnic_name' => 'required',
            'fathers_name' => 'required',
            'mothers_name' => 'required',
            'roll' => 'required',
            'registration_number' => 'required',
            'image' => 'nullable|image',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $employee->image = $imagePath;
        }

        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}

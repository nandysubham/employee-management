<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $departments = Department::orderBy('name')->get();

        $employees = Employee::with('department')
            ->search($request->search)
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->where('department_id', $request->department_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', (bool) $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create(): View
    {
        $departments = Department::active()
            ->orderBy('name')
            ->get();

        return view('employees.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'employee_code' => 'required|string|max:100|unique:employees,employee_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'joining_date' => 'required|date',
            'designation' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')
                ->store('employees', 'public');
        }

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee): View
    {
        $employee->load([
            'department',
            'leaves' => fn ($query) => $query->latest(),
        ]);

        $leaveStats = [
            'total' => $employee->leaves->count(),
            'pending' => $employee->leaves->where('status', 'pending')->count(),
            'approved' => $employee->leaves->where('status', 'approved')->count(),
            'rejected' => $employee->leaves->where('status', 'rejected')->count(),
        ];

        return view('employees.show', compact('employee', 'leaveStats'));
    }

    public function edit(Employee $employee): View
    {
        $departments = Department::active()
            ->orderBy('name')
            ->get();

        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'employee_code' => 'required|string|max:100|unique:employees,employee_code,'.$employee->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255|unique:employees,email,'.$employee->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'joining_date' => 'required|date',
            'designation' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($employee->profile_photo && Storage::disk('public')->exists($employee->profile_photo)) {
                Storage::disk('public')->delete($employee->profile_photo);
            }

            $validated['profile_photo'] = $request->file('profile_photo')
                ->store('employees', 'public');
        }

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        if ($employee->profile_photo && Storage::disk('public')->exists($employee->profile_photo)) {
            Storage::disk('public')->delete($employee->profile_photo);
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}

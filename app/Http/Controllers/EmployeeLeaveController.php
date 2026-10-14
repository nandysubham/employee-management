<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeLeaveController extends Controller
{
    public function index(Request $request): View
    {
        $leaves = EmployeeLeave::with(['employee.department', 'approver'])
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('employee_id'), function ($query) use ($request) {
                $query->where('employee_id', $request->employee_id);
            })
            ->when($request->filled('leave_type'), function ($query) use ($request) {
                $query->where('leave_type', $request->leave_type);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statusCounts = [
            'all' => EmployeeLeave::count(),
            'pending' => EmployeeLeave::where('status', 'pending')->count(),
            'approved' => EmployeeLeave::where('status', 'approved')->count(),
            'rejected' => EmployeeLeave::where('status', 'rejected')->count(),
        ];

        $employees = Employee::orderBy('first_name')->get();

        return view('leaves.index', compact('leaves', 'statusCounts', 'employees'));
    }

    public function create(Request $request): View
    {
        $employees = Employee::active()
            ->orderBy('first_name')
            ->get();

        $selectedEmployeeId = $request->query('employee_id');

        return view('leaves.create', compact('employees', 'selectedEmployeeId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|max:100',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'nullable|string|max:1000',
        ]);

        $validated['status'] = 'pending';

        EmployeeLeave::create($validated);

        return redirect()
            ->route('leaves.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function show(EmployeeLeave $leave): View
    {
        $leave->load(['employee.department', 'approver']);

        return view('leaves.show', compact('leave'));
    }

    public function updateStatus(Request $request, EmployeeLeave $leave): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $approverId = null;
        if (in_array($validated['status'], ['approved', 'rejected'])) {
            $approverId = auth()->id() ?? User::first()?->id;
        }

        $leave->update([
            'status' => $validated['status'],
            'approved_by' => $approverId,
        ]);

        $statusLabel = ucfirst($validated['status']);

        return back()->with('success', "Leave request {$statusLabel} successfully.");
    }

    public function destroy(EmployeeLeave $leave): RedirectResponse
    {
        $leave->delete();

        return redirect()
            ->route('leaves.index')
            ->with('success', 'Leave request deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', true)->count();
        $inactiveEmployees = $totalEmployees - $activeEmployees;

        $totalDepartments = Department::count();
        $activeDepartments = Department::where('status', true)->count();

        $pendingLeavesCount = EmployeeLeave::where('status', 'pending')->count();
        $approvedLeavesCount = EmployeeLeave::where('status', 'approved')->count();
        $rejectedLeavesCount = EmployeeLeave::where('status', 'rejected')->count();

        $recentEmployees = Employee::with('department')
            ->latest()
            ->limit(5)
            ->get();

        $recentLeaves = EmployeeLeave::with(['employee.department'])
            ->latest()
            ->limit(5)
            ->get();

        $departmentsWithCount = Department::withCount('employees')
            ->orderByDesc('employees_count')
            ->limit(6)
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'totalDepartments',
            'activeDepartments',
            'pendingLeavesCount',
            'approvedLeavesCount',
            'rejectedLeavesCount',
            'recentEmployees',
            'recentLeaves',
            'departmentsWithCount'
        ));
    }
}

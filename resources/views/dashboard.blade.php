@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header / Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-indigo-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-500/30 text-indigo-200 border border-indigo-400/20 mb-3">
                Overview & Operations
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Admin Overview Dashboard</h1>
            <p class="mt-2 text-indigo-100 text-sm sm:text-base leading-relaxed">
                Welcome back! Monitor workforce staffing, track department allocations, and quickly process pending employee leave requests.
            </p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('employees.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-white text-indigo-900 hover:bg-indigo-50 shadow transition">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    New Employee
                </a>
                <a href="{{ route('departments.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-700/60 hover:bg-indigo-700 text-white border border-indigo-500/30 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Department
                </a>
                <a href="{{ route('leaves.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-700/60 hover:bg-indigo-700 text-white border border-indigo-500/30 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Request Leave
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Employees -->
        <a href="{{ route('employees.index') }}" class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Employees</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalEmployees }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500 space-x-2">
                <span class="inline-flex items-center font-medium text-emerald-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                    {{ $activeEmployees }} Active
                </span>
                <span>•</span>
                <span class="text-slate-500">{{ $inactiveEmployees }} Inactive</span>
            </div>
        </a>

        <!-- Total Departments -->
        <a href="{{ route('departments.index') }}" class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Departments</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalDepartments }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <span class="text-slate-600 font-medium">{{ $activeDepartments }} active departments</span>
            </div>
        </a>

        <!-- Pending Leave Requests -->
        <a href="{{ route('leaves.index', ['status' => 'pending']) }}" class="bg-white rounded-2xl p-5 border {{ $pendingLeavesCount > 0 ? 'border-amber-300 ring-2 ring-amber-100' : 'border-slate-200/80' }} shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Leaves</p>
                    <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $pendingLeavesCount }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                @if ($pendingLeavesCount > 0)
                    <span class="inline-flex items-center font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">
                        Requires admin review
                    </span>
                @else
                    <span class="text-slate-400 font-medium">All caught up</span>
                @endif
            </div>
        </a>

        <!-- Approved Leaves -->
        <a href="{{ route('leaves.index', ['status' => 'approved']) }}" class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Approved Leaves</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $approvedLeavesCount }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <span>{{ $rejectedLeavesCount }} rejected requests</span>
            </div>
        </a>
    </div>

    <!-- Main Content 2-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Recent Leave Requests (Takes 2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Recent Leave Requests</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Latest leave applications requiring attention or approved</p>
                </div>
                <a href="{{ route('leaves.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition flex items-center">
                    View all
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50/80 text-xs text-slate-500 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-5 py-3">Employee</th>
                            <th class="px-4 py-3">Leave Type</th>
                            <th class="px-4 py-3">Dates</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentLeaves as $leave)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $leave->employee->profile_photo_url }}" alt="{{ $leave->employee->full_name }}" class="w-8 h-8 rounded-full object-cover ring-1 ring-slate-200">
                                        <div>
                                            <a href="{{ route('employees.show', $leave->employee) }}" class="font-semibold text-slate-900 hover:text-indigo-600 transition block">
                                                {{ $leave->employee->full_name }}
                                            </a>
                                            <span class="text-xs text-slate-500">{{ $leave->employee->department->name ?? 'General' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $leave->leave_type }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-xs text-slate-600 whitespace-nowrap">
                                    <div>{{ $leave->from_date->format('M d') }} - {{ $leave->to_date->format('M d, Y') }}</div>
                                    <span class="text-[11px] text-slate-400 font-medium">({{ $leave->days_count }} {{ Str::plural('day', $leave->days_count) }})</span>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    @if ($leave->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Approved
                                        </span>
                                    @elseif ($leave->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    @if ($leave->status === 'pending')
                                        <div class="inline-flex items-center space-x-1">
                                            <!-- Approve Form -->
                                            <form action="{{ route('leaves.update-status', $leave) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" title="Approve" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <!-- Reject Form -->
                                            <form action="{{ route('leaves.update-status', $leave) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" title="Reject" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="{{ route('leaves.show', $leave) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Details</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-sm">
                                    No recent leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Recent Hires & Department Breakdown (1 Column) -->
        <div class="space-y-6">
            <!-- Recent Employees -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Recent Employees</h2>
                        <p class="text-xs text-slate-500">Newly registered team members</p>
                    </div>
                    <a href="{{ route('employees.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        View all
                    </a>
                </div>

                <div class="divide-y divide-slate-100 mt-2">
                    @forelse ($recentEmployees as $emp)
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $emp->profile_photo_url }}" alt="{{ $emp->full_name }}" class="w-9 h-9 rounded-full object-cover ring-1 ring-slate-200">
                                <div>
                                    <a href="{{ route('employees.show', $emp) }}" class="font-semibold text-sm text-slate-900 hover:text-indigo-600 transition block">
                                        {{ $emp->full_name }}
                                    </a>
                                    <p class="text-xs text-slate-500">{{ $emp->designation ?? 'Member' }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-medium text-slate-400">
                                {{ $emp->joining_date->format('M d') }}
                            </span>
                        </div>
                    @empty
                        <div class="py-6 text-center text-sm text-slate-400">
                            No employees registered yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Department Distribution -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Departments</h2>
                        <p class="text-xs text-slate-500">Staff distribution by department</p>
                    </div>
                    <a href="{{ route('departments.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        Manage
                    </a>
                </div>

                <div class="space-y-3.5 mt-3.5">
                    @forelse ($departmentsWithCount as $dept)
                        @php
                            $percentage = $totalEmployees > 0 ? round(($dept->employees_count / $totalEmployees) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1">
                                <a href="{{ route('departments.show', $dept) }}" class="font-semibold text-slate-800 hover:text-indigo-600">
                                    {{ $dept->name }}
                                </a>
                                <span class="text-slate-500 font-medium">{{ $dept->employees_count }} staff ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-sm text-slate-400">
                            No departments found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

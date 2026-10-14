@extends('layouts.app')

@section('title', 'Profile: ' . $employee->full_name)

@section('content')
<div class="space-y-6">
    <!-- Profile Hero Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-indigo-700 via-indigo-600 to-purple-600"></div>
        <div class="px-6 sm:px-8 pb-6 sm:pb-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between -mt-14 sm:-mt-16 mb-4 gap-4">
                <div class="flex items-end space-x-5">
                    <img src="{{ $employee->profile_photo_url }}" alt="{{ $employee->full_name }}" class="w-24 sm:w-28 h-24 sm:h-28 rounded-2xl object-cover ring-4 ring-white shadow-md bg-white">
                    <div class="mb-1">
                        <div class="flex items-center space-x-2.5">
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $employee->full_name }}</h1>
                            @if ($employee->status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                    Inactive
                                </span>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-slate-600 mt-0.5 flex items-center space-x-2">
                            <span>{{ $employee->designation ?: 'Staff Member' }}</span>
                            <span>•</span>
                            @if ($employee->department)
                                <a href="{{ route('departments.show', $employee->department) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    {{ $employee->department->name }}
                                </a>
                            @else
                                <span class="text-slate-400">No Department</span>
                            @endif
                            <span>•</span>
                            <span class="font-mono text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-700 font-medium">{{ $employee->employee_code }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('employees.pdf', $employee) }}" target="_blank" class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 shadow-sm transition" title="Download Official Dossier as PDF">
                        <svg class="w-4 h-4 mr-1.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF
                    </a>
                    <a href="{{ route('leaves.create', ['employee_id' => $employee->id]) }}" class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/60 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Apply Leave
                    </a>
                    <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Details & Employment (1 Column) -->
        <div class="space-y-6">
            <!-- Personal Info Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 pb-3 border-b border-slate-100">Personal Information</h2>
                <dl class="divide-y divide-slate-100 text-sm mt-1">
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Email</dt>
                        <dd class="font-medium text-slate-800">
                            <a href="mailto:{{ $employee->email }}" class="text-indigo-600 hover:underline">{{ $employee->email }}</a>
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Phone</dt>
                        <dd class="font-medium text-slate-800">
                            {{ $employee->phone ?: 'Not provided' }}
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Gender</dt>
                        <dd class="font-medium text-slate-800">{{ $employee->gender ?: 'Not specified' }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Date of Birth</dt>
                        <dd class="font-medium text-slate-800">
                            @if ($employee->date_of_birth)
                                {{ $employee->date_of_birth->format('M d, Y') }} ({{ $employee->date_of_birth->age }} yrs)
                            @else
                                Not provided
                            @endif
                        </dd>
                    </div>
                    <div class="py-3">
                        <dt class="text-slate-500 text-xs mb-1">Residential Address</dt>
                        <dd class="font-medium text-slate-700 text-xs leading-relaxed">{{ $employee->address ?: 'No address on file' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Job & Compensation Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 pb-3 border-b border-slate-100">Employment & Role</h2>
                <dl class="divide-y divide-slate-100 text-sm mt-1">
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Department</dt>
                        <dd class="font-semibold text-slate-800">
                            {{ $employee->department->name ?? 'Unassigned' }}
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Job Title</dt>
                        <dd class="font-medium text-slate-800">{{ $employee->designation ?: 'Staff Member' }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Joining Date</dt>
                        <dd class="font-medium text-slate-800">
                            {{ $employee->joining_date->format('M d, Y') }}
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Tenure / Service</dt>
                        <dd class="font-semibold text-indigo-600 text-xs">
                            {{ $employee->joining_date->diffForHumans(null, true) }}
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-slate-500 text-xs">Base Salary (CTC)</dt>
                        <dd class="font-extrabold text-slate-900 text-sm">
                            {{ $employee->salary ? '₹' . number_format($employee->salary, 2) : 'Confidential' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Right Column: Leave Summary & Leave History (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Leave Statistics Widgets -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm text-center">
                    <span class="text-xs text-slate-500 font-medium uppercase tracking-wider block">Total Leaves</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $leaveStats['total'] }}</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm text-center">
                    <span class="text-xs text-amber-600 font-medium uppercase tracking-wider block">Pending</span>
                    <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $leaveStats['pending'] }}</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm text-center">
                    <span class="text-xs text-emerald-600 font-medium uppercase tracking-wider block">Approved</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $leaveStats['approved'] }}</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm text-center">
                    <span class="text-xs text-rose-600 font-medium uppercase tracking-wider block">Rejected</span>
                    <span class="text-2xl font-extrabold text-rose-600 mt-1 block">{{ $leaveStats['rejected'] }}</span>
                </div>
            </div>

            <!-- Leave History Table -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Leave History & Requests</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Track all recorded time off and leave requests</p>
                    </div>
                    <a href="{{ route('leaves.create', ['employee_id' => $employee->id]) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                        + Request Leave
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/80 text-xs text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3">Leave Type</th>
                                <th class="px-5 py-3">Period & Duration</th>
                                <th class="px-5 py-3">Reason</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($employee->leaves as $leave)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-800">
                                            {{ $leave->leave_type }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-600 whitespace-nowrap">
                                        <div>{{ $leave->from_date->format('M d') }} - {{ $leave->to_date->format('M d, Y') }}</div>
                                        <span class="text-[11px] text-slate-400 font-medium">({{ $leave->days_count }} {{ Str::plural('day', $leave->days_count) }})</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-600 max-w-xs truncate">
                                        {{ $leave->reason ?: 'No reason specified' }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
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
                                                <form action="{{ route('leaves.update-status', $leave) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" title="Approve" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('leaves.update-status', $leave) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" title="Reject" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        No leave records found for this employee.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

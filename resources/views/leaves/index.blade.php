@extends('layouts.app')

@section('title', 'Leave Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Leave Management</h1>
            <p class="text-sm text-slate-500 mt-1">Review staff time-off applications, manage approvals, and track leave trends.</p>
        </div>
        <a href="{{ route('leaves.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Request Leave
        </a>
    </div>

    <!-- Status Tabs -->
    <div class="flex border-b border-slate-200 overflow-x-auto">
        <a href="{{ route('leaves.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}" 
           class="py-3 px-4 text-sm font-semibold border-b-2 whitespace-nowrap transition {{ !request('status') || request('status') === 'all' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
            All Leaves
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ !request('status') || request('status') === 'all' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                {{ $statusCounts['all'] }}
            </span>
        </a>
        <a href="{{ route('leaves.index', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
           class="py-3 px-4 text-sm font-semibold border-b-2 whitespace-nowrap transition {{ request('status') === 'pending' ? 'border-amber-500 text-amber-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
            Pending Requests
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ request('status') === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-amber-50 text-amber-600' }}">
                {{ $statusCounts['pending'] }}
            </span>
        </a>
        <a href="{{ route('leaves.index', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}" 
           class="py-3 px-4 text-sm font-semibold border-b-2 whitespace-nowrap transition {{ request('status') === 'approved' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
            Approved
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ request('status') === 'approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-emerald-50 text-emerald-600' }}">
                {{ $statusCounts['approved'] }}
            </span>
        </a>
        <a href="{{ route('leaves.index', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
           class="py-3 px-4 text-sm font-semibold border-b-2 whitespace-nowrap transition {{ request('status') === 'rejected' ? 'border-rose-500 text-rose-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
            Rejected
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ request('status') === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-rose-50 text-rose-600' }}">
                {{ $statusCounts['rejected'] }}
            </span>
        </a>
    </div>

    <!-- Filter Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm">
        <form action="{{ route('leaves.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Employee Filter -->
            <div>
                <select name="employee_id" class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Filter by Employee (All)</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->full_name }} ({{ $emp->employee_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Leave Type Filter -->
            <div>
                <select name="leave_type" class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Filter by Type (All)</option>
                    @foreach (['Annual Leave', 'Sick Leave', 'Casual Leave', 'Maternity Leave', 'Unpaid Leave'] as $type)
                        <option value="{{ $type }}" {{ request('leave_type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="w-full px-4 py-2 rounded-xl text-sm font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                    Filter
                </button>
                @if (request()->hasAny(['employee_id', 'leave_type']))
                    <a href="{{ route('leaves.index', ['status' => request('status', 'all')]) }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-500 hover:text-slate-700 transition" title="Clear Filters">
                        ✕
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Leaves Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-xs text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Employee</th>
                        <th class="px-6 py-3.5">Type</th>
                        <th class="px-6 py-3.5">Leave Dates</th>
                        <th class="px-6 py-3.5">Reason</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($leaves as $leave)
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Employee Details -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $leave->employee->profile_photo_url }}" alt="{{ $leave->employee->full_name }}" class="w-10 h-10 rounded-full object-cover ring-1 ring-slate-200 shadow-sm">
                                    <div>
                                        <a href="{{ route('employees.show', $leave->employee) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition block">
                                            {{ $leave->employee->full_name }}
                                        </a>
                                        <span class="text-xs text-slate-500">{{ $leave->employee->department->name ?? 'General' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Leave Type -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-800">
                                    {{ $leave->leave_type }}
                                </span>
                            </td>

                            <!-- Leave Dates & Total Days -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-600">
                                <div class="font-medium text-slate-800">
                                    {{ $leave->from_date->format('M d, Y') }} — {{ $leave->to_date->format('M d, Y') }}
                                </div>
                                <span class="text-[11px] text-indigo-600 font-semibold mt-0.5 block">
                                    {{ $leave->days_count }} {{ Str::plural('day', $leave->days_count) }} total
                                </span>
                            </td>

                            <!-- Reason -->
                            <td class="px-6 py-4 text-xs text-slate-600 max-w-xs truncate">
                                {{ $leave->reason ?: 'No reason provided' }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                        Pending Review
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right whitespace-nowrap space-x-1.5">
                                @if ($leave->status === 'pending')
                                    <!-- Approve Button -->
                                    <form action="{{ route('leaves.update-status', $leave) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition" title="Approve">
                                            Approve
                                        </button>
                                    </form>

                                    <!-- Reject Button -->
                                    <form action="{{ route('leaves.update-status', $leave) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white transition" title="Reject">
                                            Reject
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('leaves.pdf', $leave) }}" target="_blank" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition inline-block" title="Download PDF Slip">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>

                                <a href="{{ route('leaves.show', $leave) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition inline-block" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this leave record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-medium text-slate-600">No leave requests found.</p>
                                <p class="text-xs text-slate-400 mt-1">Try switching tabs or submit a new leave request.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($leaves->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $leaves->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

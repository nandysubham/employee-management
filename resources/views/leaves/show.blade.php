@extends('layouts.app')

@section('title', 'Leave Details #' . $leave->id)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('leaves.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-white border border-slate-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Leave Request Details</h1>
                <p class="text-sm text-slate-500 mt-0.5">Application #{{ $leave->id }} filed on {{ $leave->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            @if ($leave->status === 'approved')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    ● Approved
                </span>
            @elseif ($leave->status === 'rejected')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                    ● Rejected
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    ● Pending Review
                </span>
            @endif

            <a href="{{ route('leaves.pdf', $leave) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 shadow-sm transition" title="Download Official Slip as PDF">
                <svg class="w-3.5 h-3.5 mr-1 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                PDF Slip
            </a>
        </div>
    </div>

    <!-- Employee Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <img src="{{ $leave->employee->profile_photo_url }}" alt="{{ $leave->employee->full_name }}" class="w-14 h-14 rounded-2xl object-cover ring-2 ring-slate-200 shadow-sm">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $leave->employee->full_name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $leave->employee->designation ?: 'Staff' }} • {{ $leave->employee->department->name ?? 'General' }} • 
                    <span class="font-mono text-slate-600">{{ $leave->employee->employee_code }}</span>
                </p>
            </div>
        </div>

        <a href="{{ route('employees.show', $leave->employee) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">
            View Profile →
        </a>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pb-6 border-b border-slate-100">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block">Leave Category</span>
                <span class="text-base font-bold text-slate-900 mt-1 block">{{ $leave->leave_type }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block">Duration</span>
                <span class="text-base font-bold text-indigo-600 mt-1 block">{{ $leave->days_count }} {{ Str::plural('Day', $leave->days_count) }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block">Date Range</span>
                <span class="text-base font-bold text-slate-900 mt-1 block">{{ $leave->from_date->format('M d') }} - {{ $leave->to_date->format('M d, Y') }}</span>
            </div>
        </div>

        <!-- Reason -->
        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 block">Reason for Absence</span>
            <div class="mt-2 bg-slate-50 rounded-xl p-4 text-sm text-slate-700 leading-relaxed border border-slate-100">
                {{ $leave->reason ?: 'No specific reason provided for this request.' }}
            </div>
        </div>

        <!-- Approval / Audit Info -->
        @if ($leave->approver)
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Action processed by: <strong class="text-slate-800">{{ $leave->approver->name }}</strong></span>
                <span>Last updated: {{ $leave->updated_at->format('M d, Y H:i') }}</span>
            </div>
        @endif

        <!-- Actions Toolbar -->
        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <!-- Left: Delete -->
            <form action="{{ route('leaves.destroy', $leave) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this leave record?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs font-medium text-rose-600 hover:text-rose-800 transition">
                    Delete this record
                </button>
            </form>

            <!-- Right: Approve / Reject Controls -->
            <div class="flex items-center space-x-2">
                @if ($leave->status !== 'approved')
                    <form action="{{ route('leaves.update-status', $leave) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve Leave
                        </button>
                    </form>
                @endif

                @if ($leave->status !== 'rejected')
                    <form action="{{ route('leaves.update-status', $leave) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Leave
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

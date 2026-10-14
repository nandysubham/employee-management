@extends('layouts.app')

@section('title', 'Submit Leave Request')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Request Leave</h1>
            <p class="text-sm text-slate-500 mt-1">Submit a new time-off or absence request on behalf of an employee.</p>
        </div>
        <a href="{{ route('leaves.index') }}" class="inline-flex items-center px-3.5 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Leaves
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('leaves.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Employee Selection -->
            <div>
                <label for="employee_id" class="block text-sm font-semibold text-slate-700">Employee <span class="text-rose-500">*</span></label>
                <div class="mt-1.5">
                    <select id="employee_id" name="employee_id" required 
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('employee_id') ? 'border-rose-300 ring-rose-100' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select an employee</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id', $selectedEmployeeId) == $emp->id ? 'selected' : '' }}>
                                {{ $emp->full_name }} ({{ $emp->employee_code }}) — {{ $emp->department->name ?? 'Staff' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('employee_id')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Leave Type -->
            <div>
                <label for="leave_type" class="block text-sm font-semibold text-slate-700">Leave Type <span class="text-rose-500">*</span></label>
                <div class="mt-1.5">
                    <select id="leave_type" name="leave_type" required 
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('leave_type') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select leave category</option>
                        <option value="Annual Leave" {{ old('leave_type') === 'Annual Leave' ? 'selected' : '' }}>Annual Leave (Paid)</option>
                        <option value="Sick Leave" {{ old('leave_type') === 'Sick Leave' ? 'selected' : '' }}>Sick Leave (Medical)</option>
                        <option value="Casual Leave" {{ old('leave_type', 'Casual Leave') === 'Casual Leave' ? 'selected' : '' }}>Casual Leave (Personal)</option>
                        <option value="Maternity Leave" {{ old('leave_type') === 'Maternity Leave' ? 'selected' : '' }}>Maternity / Paternity Leave</option>
                        <option value="Unpaid Leave" {{ old('leave_type') === 'Unpaid Leave' ? 'selected' : '' }}>Unpaid Leave</option>
                    </select>
                </div>
                @error('leave_type')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date Range (From & To) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="from_date" class="block text-sm font-semibold text-slate-700">From Date <span class="text-rose-500">*</span></label>
                    <div class="mt-1.5">
                        <input type="date" id="from_date" name="from_date" value="{{ old('from_date', date('Y-m-d')) }}" required
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('from_date') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    @error('from_date')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="to_date" class="block text-sm font-semibold text-slate-700">To Date <span class="text-rose-500">*</span></label>
                    <div class="mt-1.5">
                        <input type="date" id="to_date" name="to_date" value="{{ old('to_date', date('Y-m-d')) }}" required
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('to_date') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    @error('to_date')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Reason -->
            <div>
                <label for="reason" class="block text-sm font-semibold text-slate-700">Reason / Comments</label>
                <div class="mt-1.5">
                    <textarea id="reason" name="reason" rows="3" placeholder="Provide details or context regarding the requested time off..."
                              class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('reason') }}</textarea>
                </div>
                @error('reason')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('leaves.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

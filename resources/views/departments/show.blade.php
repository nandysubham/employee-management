@extends('layouts.app')

@section('title', 'Department: ' . $department->name)

@section('content')
<div class="space-y-6">
    <!-- Header with Back & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('departments.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-white border border-slate-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $department->name }}</h1>
                    @if ($department->status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                            Inactive
                        </span>
                    @endif
                </div>
                <p class="text-sm text-slate-500 mt-0.5">Department details and team roster</p>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('departments.edit', $department) }}" class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('employees.create', ['department_id' => $department->id]) }}" class="inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Employee
            </a>
        </div>
    </div>

    <!-- Overview Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400">About Department</h2>
        <p class="mt-2 text-slate-700 text-sm leading-relaxed">
            {{ $department->description ?: 'No detailed description provided for this department.' }}
        </p>

        <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block font-medium">Department ID</span>
                <span class="font-bold text-slate-800 text-sm mt-0.5 block">#{{ $department->id }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Total Staff Assigned</span>
                <span class="font-bold text-indigo-600 text-sm mt-0.5 block">{{ $department->employees->count() }} members</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Created On</span>
                <span class="font-bold text-slate-800 text-sm mt-0.5 block">{{ $department->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Last Updated</span>
                <span class="font-bold text-slate-800 text-sm mt-0.5 block">{{ $department->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>

    <!-- Assigned Employees Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-base font-bold text-slate-900">Department Team Members</h3>
                <p class="text-xs text-slate-500 mt-0.5">Employees currently reporting under {{ $department->name }}</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                {{ $department->employees->count() }} {{ Str::plural('member', $department->employees->count()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 text-xs text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Employee</th>
                        <th class="px-6 py-3.5">Code</th>
                        <th class="px-6 py-3.5">Designation</th>
                        <th class="px-6 py-3.5">Contact</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($department->employees as $employee)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $employee->profile_photo_url }}" alt="{{ $employee->full_name }}" class="w-9 h-9 rounded-full object-cover ring-1 ring-slate-200">
                                    <div>
                                        <a href="{{ route('employees.show', $employee) }}" class="font-semibold text-slate-900 hover:text-indigo-600 transition block">
                                            {{ $employee->full_name }}
                                        </a>
                                        <span class="text-xs text-slate-500">{{ $employee->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-600 whitespace-nowrap">
                                {{ $employee->employee_code }}
                            </td>
                            <td class="px-6 py-4 text-slate-700 text-xs font-medium whitespace-nowrap">
                                {{ $employee->designation ?: 'Staff Member' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600 whitespace-nowrap">
                                {{ $employee->phone ?: '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($employee->status)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('employees.show', $employee) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                    View Profile →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                <p class="text-sm font-medium text-slate-600">No employees assigned to this department yet.</p>
                                <a href="{{ route('employees.create', ['department_id' => $department->id]) }}" class="mt-2 inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    + Add first employee to this department
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

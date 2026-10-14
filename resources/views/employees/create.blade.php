@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add New Employee</h1>
            <p class="text-sm text-slate-500 mt-1">Register a new team member into the organization system.</p>
        </div>
        <a href="{{ route('employees.index') }}" class="inline-flex items-center px-3.5 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Directory
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section 1: Personal Details -->
            <div>
                <div class="border-b border-slate-100 pb-3 mb-5">
                    <h2 class="text-base font-bold text-slate-900">1. Personal Information</h2>
                    <p class="text-xs text-slate-500">Contact and demographic information of the employee.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-slate-700">First Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('first_name') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('first_name')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-slate-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('email') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+91 98301 23456"
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-semibold text-slate-700">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-semibold text-slate-700">Gender</label>
                        <select id="gender" name="gender" class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-slate-700">Residential Address</label>
                        <textarea id="address" name="address" rows="2" class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 2: Employment & Compensation -->
            <div>
                <div class="border-b border-slate-100 pb-3 mb-5">
                    <h2 class="text-base font-bold text-slate-900">2. Job & Position Details</h2>
                    <p class="text-xs text-slate-500">Organizational hierarchy, role, compensation, and active status.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-semibold text-slate-700">Department <span class="text-rose-500">*</span></label>
                        <select id="department_id" name="department_id" required
                                class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('department_id') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', request('department_id')) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee Code -->
                    <div>
                        <label for="employee_code" class="block text-sm font-semibold text-slate-700">Employee Code / ID <span class="text-rose-500">*</span></label>
                        <input type="text" id="employee_code" name="employee_code" value="{{ old('employee_code', 'EMP-' . rand(1000, 9999)) }}" required
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm font-mono rounded-xl border {{ $errors->has('employee_code') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('employee_code')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Designation -->
                    <div>
                        <label for="designation" class="block text-sm font-semibold text-slate-700">Job Title / Designation</label>
                        <input type="text" id="designation" name="designation" value="{{ old('designation') }}" placeholder="e.g. Senior Backend Engineer"
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Joining Date -->
                    <div>
                        <label for="joining_date" class="block text-sm font-semibold text-slate-700">Joining Date <span class="text-rose-500">*</span></label>
                        <input type="date" id="joining_date" name="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}" required
                               class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('joining_date') ? 'border-rose-300' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('joining_date')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div>
                        <label for="salary" class="block text-sm font-semibold text-slate-700">Annual CTC / Salary (₹)</label>
                        <div class="relative mt-1.5">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-semibold">₹</div>
                            <input type="number" step="0.01" min="0" id="salary" name="salary" value="{{ old('salary') }}" placeholder="0.00"
                                   class="w-full pl-8 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700">Employment Status</label>
                        <select id="status" name="status" class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive / On Leave</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 3: Profile Photo -->
            <div>
                <div class="border-b border-slate-100 pb-3 mb-5">
                    <h2 class="text-base font-bold text-slate-900">3. Profile Picture</h2>
                    <p class="text-xs text-slate-500">Upload a professional headshot for directory identification.</p>
                </div>

                <div class="max-w-md">
                    <label for="profile_photo" class="block text-sm font-semibold text-slate-700">Employee Photo</label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                           class="mt-1.5 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-slate-400">Accepted formats: JPG, PNG, WEBP up to 2MB. Leave blank for an auto-generated avatar.</p>
                    @error('profile_photo')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('employees.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                    Register Employee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
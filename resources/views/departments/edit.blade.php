@extends('layouts.app')

@section('title', 'Edit Department - ' . $department->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Department</h1>
            <p class="text-sm text-slate-500 mt-1">Update details for <span class="font-semibold text-slate-700">{{ $department->name }}</span>.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('departments.show', $department) }}" class="inline-flex items-center px-3.5 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                View Department
            </a>
            <a href="{{ route('departments.index') }}" class="inline-flex items-center px-3.5 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('departments.update', $department) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700">Department Name <span class="text-rose-500">*</span></label>
                <div class="mt-1.5">
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $department->name) }}" 
                           required 
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('name') ? 'border-rose-300 ring-rose-100' : 'border-slate-200' }} focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                @error('name')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700">Description</label>
                <div class="mt-1.5">
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description', $department->description) }}</textarea>
                </div>
                @error('description')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-slate-700">Operational Status</label>
                <div class="mt-1.5">
                    <select id="status" 
                            name="status" 
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="1" {{ old('status', $department->status ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $department->status ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('departments.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                    Update Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
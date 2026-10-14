@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add Department</h1>
            <p class="text-sm text-slate-500 mt-1">Create a new organizational department or division.</p>
        </div>
        <a href="{{ route('departments.index') }}" class="inline-flex items-center px-3.5 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700">Department Name <span class="text-rose-500">*</span></label>
                <div class="mt-1.5">
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="e.g. Engineering, Human Resources, Marketing" 
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
                              placeholder="Brief overview of department's scope, responsibilities and objectives..." 
                              class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description') }}</textarea>
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
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active (Available for employee assignment)</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive (Archived / Hidden from active intake)</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('departments.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                    Save Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
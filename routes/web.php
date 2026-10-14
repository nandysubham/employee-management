<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\PdfExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('leaves', EmployeeLeaveController::class)
    ->parameters(['leaves' => 'leave']);

Route::patch('leaves/{leave}/status', [EmployeeLeaveController::class, 'updateStatus'])
    ->name('leaves.update-status');

// PDF Generation & Exports
Route::get('employees/{employee}/pdf', [PdfExportController::class, 'employeeProfile'])
    ->name('employees.pdf');
Route::get('leaves/{leave}/pdf', [PdfExportController::class, 'leaveSlip'])
    ->name('leaves.pdf');

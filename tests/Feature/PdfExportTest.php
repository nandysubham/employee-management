<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\User;

test('can download employee profile as pdf', function () {
    $dept = Department::factory()->create(['name' => 'Engineering']);
    $employee = Employee::factory()->create([
        'department_id' => $dept->id,
        'first_name' => 'Subham',
        'last_name' => 'Nandy',
        'employee_code' => 'EMP-1001',
    ]);

    EmployeeLeave::factory()->create([
        'employee_id' => $employee->id,
        'status' => 'approved',
    ]);

    $response = $this->get(route('employees.pdf', $employee));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('employee-profile-emp-1001-subham-nandy.pdf');
});

test('can stream employee profile as pdf', function () {
    $employee = Employee::factory()->create();

    $response = $this->get(route('employees.pdf', ['employee' => $employee, 'stream' => 1]));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('inline');
});

test('can download leave slip as pdf', function () {
    $admin = User::factory()->create(['name' => 'HR Manager']);
    $dept = Department::factory()->create();
    $employee = Employee::factory()->create(['department_id' => $dept->id]);
    $leave = EmployeeLeave::factory()->create([
        'employee_id' => $employee->id,
        'status' => 'approved',
        'approved_by' => $admin->id,
        'reason' => 'Durga Puja celebrations',
    ]);

    $response = $this->get(route('leaves.pdf', $leave));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('leave-slip-'.$leave->id);
});

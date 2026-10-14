<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeLeave;

test('dashboard page renders successfully with metrics', function () {
    $dept = Department::factory()->create(['name' => 'Technology', 'status' => true]);
    $emp = Employee::factory()->create([
        'department_id' => $dept->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'status' => true,
    ]);
    EmployeeLeave::factory()->create([
        'employee_id' => $emp->id,
        'status' => 'pending',
    ]);

    $response = $this->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Admin Overview Dashboard')
        ->assertSee('Technology')
        ->assertSee('John Doe');
});

test('dashboard displays pending leaves count accurately', function () {
    $emp = Employee::factory()->create();
    EmployeeLeave::factory()->count(3)->create([
        'employee_id' => $emp->id,
        'status' => 'pending',
    ]);
    EmployeeLeave::factory()->count(2)->create([
        'employee_id' => $emp->id,
        'status' => 'approved',
    ]);

    $response = $this->get('/');

    $response->assertOk()
        ->assertViewHas('pendingLeavesCount', 3)
        ->assertViewHas('approvedLeavesCount', 2);
});

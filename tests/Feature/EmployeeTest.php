<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('can list employees', function () {
    Employee::factory()->count(3)->create();

    $response = $this->get(route('employees.index'));

    $response->assertOk();
});

test('can search employees by query term', function () {
    $dept = Department::factory()->create();
    Employee::factory()->create([
        'department_id' => $dept->id,
        'first_name' => 'Alexander',
        'last_name' => 'Wright',
        'employee_code' => 'EMP-7701',
    ]);
    Employee::factory()->create([
        'department_id' => $dept->id,
        'first_name' => 'Brenda',
        'last_name' => 'Smith',
        'employee_code' => 'EMP-7702',
    ]);

    $response = $this->get(route('employees.index', ['search' => 'Alexander']));

    $response->assertOk()
        ->assertSee('Alexander')
        ->assertDontSee('Brenda');
});

test('can filter employees by department', function () {
    $dept1 = Department::factory()->create(['name' => 'Product Team']);
    $dept2 = Department::factory()->create(['name' => 'QA Team']);

    $emp1 = Employee::factory()->create(['department_id' => $dept1->id, 'first_name' => 'ProductHero']);
    $emp2 = Employee::factory()->create(['department_id' => $dept2->id, 'first_name' => 'TesterHero']);

    $response = $this->get(route('employees.index', ['department_id' => $dept1->id]));

    $response->assertOk()
        ->assertSee('ProductHero')
        ->assertDontSee('TesterHero');
});

test('can create employee with photo upload', function () {
    Storage::fake('public');
    $dept = Department::factory()->create();

    $photo = UploadedFile::fake()->image('avatar.jpg');

    $data = [
        'department_id' => $dept->id,
        'employee_code' => 'EMP-9999',
        'first_name' => 'Clark',
        'last_name' => 'Kent',
        'email' => 'clark.kent@dailyplanet.com',
        'phone' => '1234567890',
        'date_of_birth' => '1990-01-01',
        'gender' => 'Male',
        'address' => 'Metropolis',
        'joining_date' => '2023-01-01',
        'designation' => 'Investigative Reporter',
        'salary' => 85000,
        'profile_photo' => $photo,
        'status' => 1,
    ];

    $response = $this->post(route('employees.store'), $data);

    $response->assertRedirect(route('employees.index'))
        ->assertSessionHas('success');

    $employee = Employee::where('employee_code', 'EMP-9999')->first();
    expect($employee)->not->toBeNull();
    expect($employee->profile_photo)->not->toBeNull();

    Storage::disk('public')->assertExists($employee->profile_photo);
});

test('can view employee profile with leave statistics', function () {
    $dept = Department::factory()->create();
    $employee = Employee::factory()->create([
        'department_id' => $dept->id,
        'first_name' => 'Bruce',
        'last_name' => 'Wayne',
    ]);

    EmployeeLeave::factory()->create([
        'employee_id' => $employee->id,
        'status' => 'approved',
        'leave_type' => 'Annual Leave',
    ]);

    $response = $this->get(route('employees.show', $employee));

    $response->assertOk()
        ->assertSee('Bruce Wayne')
        ->assertSee('Annual Leave')
        ->assertViewHas('leaveStats');
});

test('can update employee details', function () {
    $dept = Department::factory()->create();
    $employee = Employee::factory()->create(['department_id' => $dept->id, 'first_name' => 'Peter']);

    $response = $this->put(route('employees.update', $employee), [
        'department_id' => $dept->id,
        'employee_code' => $employee->employee_code,
        'first_name' => 'Spider',
        'last_name' => 'Parker',
        'email' => $employee->email,
        'joining_date' => '2024-01-01',
        'status' => 1,
    ]);

    $response->assertRedirect(route('employees.index'));

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'first_name' => 'Spider',
    ]);
});

test('can delete employee and removes photo', function () {
    Storage::fake('public');
    $dept = Department::factory()->create();

    $photoPath = UploadedFile::fake()->image('test.jpg')->store('employees', 'public');

    $employee = Employee::factory()->create([
        'department_id' => $dept->id,
        'profile_photo' => $photoPath,
    ]);

    Storage::disk('public')->assertExists($photoPath);

    $response = $this->delete(route('employees.destroy', $employee));

    $response->assertRedirect(route('employees.index'));

    $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    Storage::disk('public')->assertMissing($photoPath);
});

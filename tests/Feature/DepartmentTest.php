<?php

use App\Models\Department;
use App\Models\Employee;

test('can list departments', function () {
    Department::factory()->count(3)->create();

    $response = $this->get(route('departments.index'));

    $response->assertOk();
});

test('can search departments by keyword', function () {
    Department::factory()->create(['name' => 'Design & Creative']);
    Department::factory()->create(['name' => 'Data Science']);

    $response = $this->get(route('departments.index', ['search' => 'Design']));

    $response->assertOk()
        ->assertSee('Design & Creative')
        ->assertDontSee('Data Science');
});

test('can create a department', function () {
    $data = [
        'name' => 'Customer Success',
        'description' => 'Dedicated to client onboarding and retention',
        'status' => 1,
    ];

    $response = $this->post(route('departments.store'), $data);

    $response->assertRedirect(route('departments.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('departments', [
        'name' => 'Customer Success',
    ]);
});

test('validates department name is required and unique', function () {
    Department::factory()->create(['name' => 'Legal']);

    $response = $this->post(route('departments.store'), [
        'name' => 'Legal',
        'status' => 1,
    ]);

    $response->assertSessionHasErrors('name');
});

test('can show department and its employees', function () {
    $dept = Department::factory()->create(['name' => 'Human Resources']);
    $emp = Employee::factory()->create([
        'department_id' => $dept->id,
        'first_name' => 'Jane',
        'last_name' => 'Doe',
    ]);

    $response = $this->get(route('departments.show', $dept));

    $response->assertOk()
        ->assertSee('Human Resources')
        ->assertSee('Jane Doe');
});

test('can update department', function () {
    $dept = Department::factory()->create(['name' => 'Original Name']);

    $response = $this->put(route('departments.update', $dept), [
        'name' => 'Updated Name',
        'description' => 'Updated description text',
        'status' => 1,
    ]);

    $response->assertRedirect(route('departments.index'));

    $this->assertDatabaseHas('departments', [
        'id' => $dept->id,
        'name' => 'Updated Name',
    ]);
});

test('can delete department without employees', function () {
    $dept = Department::factory()->create();

    $response = $this->delete(route('departments.destroy', $dept));

    $response->assertRedirect(route('departments.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('departments', [
        'id' => $dept->id,
    ]);
});

test('prevents deleting department with assigned employees', function () {
    $dept = Department::factory()->create();
    Employee::factory()->create(['department_id' => $dept->id]);

    $response = $this->delete(route('departments.destroy', $dept));

    $response->assertRedirect(route('departments.index'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('departments', [
        'id' => $dept->id,
    ]);
});

<?php

use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\User;

test('can list all leave records', function () {
    $emp = Employee::factory()->create();
    EmployeeLeave::factory()->count(3)->create(['employee_id' => $emp->id]);

    $response = $this->get(route('leaves.index'));

    $response->assertOk();
});

test('can filter leaves by status', function () {
    $emp = Employee::factory()->create();
    $pending = EmployeeLeave::factory()->create([
        'employee_id' => $emp->id,
        'status' => 'pending',
        'reason' => 'Pending unique reason',
    ]);
    $approved = EmployeeLeave::factory()->create([
        'employee_id' => $emp->id,
        'status' => 'approved',
        'reason' => 'Approved unique reason',
    ]);

    $response = $this->get(route('leaves.index', ['status' => 'pending']));

    $response->assertOk()
        ->assertSee('Pending unique reason')
        ->assertDontSee('Approved unique reason');
});

test('can submit a leave request', function () {
    $emp = Employee::factory()->create();

    $data = [
        'employee_id' => $emp->id,
        'leave_type' => 'Sick Leave',
        'from_date' => now()->toDateString(),
        'to_date' => now()->addDays(2)->toDateString(),
        'reason' => 'Flu symptoms',
    ];

    $response = $this->post(route('leaves.store'), $data);

    $response->assertRedirect(route('leaves.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('employee_leaves', [
        'employee_id' => $emp->id,
        'leave_type' => 'Sick Leave',
        'status' => 'pending',
    ]);
});

test('validates to_date is not earlier than from_date', function () {
    $emp = Employee::factory()->create();

    $response = $this->post(route('leaves.store'), [
        'employee_id' => $emp->id,
        'leave_type' => 'Annual Leave',
        'from_date' => now()->toDateString(),
        'to_date' => now()->subDay()->toDateString(),
    ]);

    $response->assertSessionHasErrors('to_date');
});

test('can approve a pending leave request', function () {
    $admin = User::factory()->create();
    $emp = Employee::factory()->create();
    $leave = EmployeeLeave::factory()->create([
        'employee_id' => $emp->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->patch(route('leaves.update-status', $leave), [
            'status' => 'approved',
        ]);

    $response->assertRedirect();

    $leave->refresh();
    expect($leave->status)->toBe('approved');
    expect($leave->approved_by)->toBe($admin->id);
});

test('can reject a pending leave request', function () {
    $admin = User::factory()->create();
    $emp = Employee::factory()->create();
    $leave = EmployeeLeave::factory()->create([
        'employee_id' => $emp->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->patch(route('leaves.update-status', $leave), [
            'status' => 'rejected',
        ]);

    $response->assertRedirect();

    $leave->refresh();
    expect($leave->status)->toBe('rejected');
    expect($leave->approved_by)->toBe($admin->id);
});

test('can show leave details', function () {
    $emp = Employee::factory()->create();
    $leave = EmployeeLeave::factory()->create([
        'employee_id' => $emp->id,
        'reason' => 'Annual family vacation',
    ]);

    $response = $this->get(route('leaves.show', $leave));

    $response->assertOk()
        ->assertSee('Annual family vacation');
});

test('can delete a leave record', function () {
    $emp = Employee::factory()->create();
    $leave = EmployeeLeave::factory()->create(['employee_id' => $emp->id]);

    $response = $this->delete(route('leaves.destroy', $leave));

    $response->assertRedirect(route('leaves.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('employee_leaves', ['id' => $leave->id]);
});

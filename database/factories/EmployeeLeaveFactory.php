<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeLeave>
 */
class EmployeeLeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-2 months', '+1 month');
        $from = Carbon::instance($startDate);
        $to = (clone $from)->addDays(fake()->numberBetween(1, 7));

        $reasons = [
            'Attending Durga Puja celebrations and family gatherings in hometown.',
            'Down with seasonal viral flu and fever; physician advised rest.',
            'Attending sister\'s wedding ceremony in Burdwan.',
            'Personal emergency and urgent family commitments at native residence.',
            'Undergoing dental procedure and post-operative recovery.',
            'Kali Puja and Diwali family festivities in Siliguri.',
            'Parent\'s medical consultation and health checkup at AMRI Hospital, Kolkata.',
            'Annual vacation with family to Darjeeling.',
            'Attending brother\'s Upanayana ceremony in Howrah.',
            'Personal relocation and domestic documentation at municipal office.',
        ];

        return [
            'employee_id' => Employee::factory(),
            'leave_type' => fake()->randomElement([
                'Annual Leave',
                'Sick Leave',
                'Casual Leave',
                'Maternity Leave',
                'Unpaid Leave',
            ]),
            'from_date' => $from->toDateString(),
            'to_date' => $to->toDateString(),
            'reason' => fake()->randomElement($reasons),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'approved_by' => null,
        ];
    }
}

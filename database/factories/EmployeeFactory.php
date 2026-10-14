<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['Male', 'Female']);
        $maleNames = ['Subham', 'Sourav', 'Debabrata', 'Pritam', 'Sayan', 'Tanmoy', 'Abhishek', 'Indranil', 'Arijit', 'Rajarshi', 'Anirban', 'Sayantan'];
        $femaleNames = ['Arpita', 'Ananya', 'Puja', 'Riya', 'Sneha', 'Moumita', 'Rituparna', 'Debolina', 'Ishita', 'Priyanka', 'Sarmistha', 'Madhurima'];
        $lastNames = ['Nandy', 'Banerjee', 'Mukherjee', 'Chatterjee', 'Sengupta', 'Roy', 'Das', 'Ghosh', 'Chakraborty', 'Bhattacharya', 'Dutta', 'Majumder', 'Basu', 'Mitra', 'Bose', 'Sarkar', 'Paul'];

        $firstName = $gender === 'Male' ? fake()->randomElement($maleNames) : fake()->randomElement($femaleNames);
        $lastName = fake()->randomElement($lastNames);

        $kolkataAddresses = [
            'Salt Lake, Sector V, Bidhannagar, Kolkata - 700091',
            'Action Area 1, New Town, Rajarhat, Kolkata - 700156',
            'Ballygunge Circular Road, Kolkata - 700019',
            'Southern Avenue, Lake Market, Kolkata - 700029',
            'Park Street, Kolkata - 700016',
            'Shibpur, Mandirtala, Howrah - 711102',
            'Jadavpur Central Road, Kolkata - 700032',
            'Garia Main Road, Kolkata - 700084',
            'Behala Chowrasta, Diamond Harbour Road, Kolkata - 700034',
            'Dum Dum Cantonment, Kolkata - 700065',
            'Bidhan Sarani, Shyambazar, Kolkata - 700004',
            'City Centre, Matigara, Siliguri - 734010',
            'City Centre, Durgapur, Paschim Bardhaman - 713216',
        ];

        return [
            'department_id' => Department::factory(),
            'employee_code' => 'EMP-'.fake()->unique()->numberBetween(1001, 9999),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName.'.'.$lastName.rand(10, 999).'@example.com'),
            'phone' => '+91 '.fake()->numberBetween(7000000000, 9999999999),
            'date_of_birth' => fake()->dateTimeBetween('-45 years', '-22 years')->format('Y-m-d'),
            'gender' => $gender,
            'address' => fake()->randomElement($kolkataAddresses),
            'joining_date' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'designation' => fake()->randomElement([
                'Software Engineer',
                'Senior Fullstack Developer',
                'HR Specialist',
                'Product Manager',
                'UI/UX Designer',
                'DevOps Engineer',
                'Chartered Accountant',
                'Marketing Lead',
            ]),
            'salary' => fake()->numberBetween(35000, 180000),
            'profile_photo' => null,
            'status' => true,
        ];
    }
}

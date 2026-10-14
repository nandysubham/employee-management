<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
            ]
        );

        $departmentData = [
            [
                'name' => 'Engineering',
                'description' => 'Software engineering, cloud infrastructure, and technical operations.',
                'status' => true,
            ],
            [
                'name' => 'Human Resources',
                'description' => 'Talent acquisition, employee welfare, performance, and workplace culture.',
                'status' => true,
            ],
            [
                'name' => 'Marketing',
                'description' => 'Brand management, digital marketing, content strategy, and public relations.',
                'status' => true,
            ],
            [
                'name' => 'Finance & Accounting',
                'description' => 'Financial planning, corporate payroll, audits, and fiscal compliance.',
                'status' => true,
            ],
            [
                'name' => 'Operations',
                'description' => 'Operational efficiency, vendor management, and internal services.',
                'status' => true,
            ],
        ];

        $departments = collect();
        foreach ($departmentData as $data) {
            $departments->push(Department::create($data));
        }

        $sampleEmployees = [
            [
                'department_id' => $departments[0]->id, // Engineering
                'employee_code' => 'EMP-1001',
                'first_name' => 'Subham',
                'last_name' => 'Nandy',
                'email' => 'subham.nandy@techcorp.in',
                'phone' => '+91 98301 23456',
                'date_of_birth' => '1993-04-14',
                'gender' => 'Male',
                'address' => 'Flat 4B, Greenwood Park, Action Area 1, New Town, Kolkata - 700156',
                'joining_date' => '2021-02-15',
                'designation' => 'Principal Software Architect',
                'salary' => 1650000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[0]->id, // Engineering
                'employee_code' => 'EMP-1002',
                'first_name' => 'Arpita',
                'last_name' => 'Banerjee',
                'email' => 'arpita.banerjee@techcorp.in',
                'phone' => '+91 98312 34567',
                'date_of_birth' => '1995-08-22',
                'gender' => 'Female',
                'address' => '42/1, Salt Lake Sector II, Block CJ, Bidhannagar, Kolkata - 700091',
                'joining_date' => '2022-05-10',
                'designation' => 'Senior Fullstack Engineer',
                'salary' => 1250000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[1]->id, // Human Resources
                'employee_code' => 'EMP-1003',
                'first_name' => 'Debabrata',
                'last_name' => 'Mukherjee',
                'email' => 'debabrata.mukherjee@techcorp.in',
                'phone' => '+91 98305 67890',
                'date_of_birth' => '1988-11-05',
                'gender' => 'Male',
                'address' => '18B, Southern Avenue, Lake Market, Kolkata - 700029',
                'joining_date' => '2020-08-01',
                'designation' => 'Head of Human Resources',
                'salary' => 1400000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[1]->id, // Human Resources
                'employee_code' => 'EMP-1004',
                'first_name' => 'Ananya',
                'last_name' => 'Sengupta',
                'email' => 'ananya.sengupta@techcorp.in',
                'phone' => '+91 98741 23450',
                'date_of_birth' => '1996-03-19',
                'gender' => 'Female',
                'address' => '88, Ballygunge Circular Road, Kolkata - 700019',
                'joining_date' => '2023-01-16',
                'designation' => 'Senior HR Business Partner',
                'salary' => 820000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[2]->id, // Marketing
                'employee_code' => 'EMP-1005',
                'first_name' => 'Souvik',
                'last_name' => 'Roy',
                'email' => 'souvik.roy@techcorp.in',
                'phone' => '+91 98360 89123',
                'date_of_birth' => '1994-06-25',
                'gender' => 'Male',
                'address' => '14, Park Street, Park Street Area, Kolkata - 700016',
                'joining_date' => '2022-09-01',
                'designation' => 'Brand & Growth Marketing Lead',
                'salary' => 950000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[2]->id, // Marketing
                'employee_code' => 'EMP-1006',
                'first_name' => 'Sneha',
                'last_name' => 'Bhattacharya',
                'email' => 'sneha.bhattacharya@techcorp.in',
                'phone' => '+91 98319 76543',
                'date_of_birth' => '1997-12-04',
                'gender' => 'Female',
                'address' => '75, Bidhan Sarani, Shyambazar, Kolkata - 700004',
                'joining_date' => '2023-06-15',
                'designation' => 'Digital Campaign Strategist',
                'salary' => 700000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[3]->id, // Finance & Accounting
                'employee_code' => 'EMP-1007',
                'first_name' => 'Puja',
                'last_name' => 'Chakraborty',
                'email' => 'puja.chakraborty@techcorp.in',
                'phone' => '+91 98309 45123',
                'date_of_birth' => '1992-10-12',
                'gender' => 'Female',
                'address' => '56/2A, Jadavpur Central Road, Kolkata - 700032',
                'joining_date' => '2021-11-20',
                'designation' => 'Chartered Accountant & Finance Manager',
                'salary' => 1350000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[3]->id, // Finance & Accounting
                'employee_code' => 'EMP-1008',
                'first_name' => 'Pritam',
                'last_name' => 'Dutta',
                'email' => 'pritam.dutta@techcorp.in',
                'phone' => '+91 98303 12987',
                'date_of_birth' => '1996-01-28',
                'gender' => 'Male',
                'address' => 'City Centre, Matigara, Siliguri - 734010',
                'joining_date' => '2023-03-01',
                'designation' => 'Senior Financial Analyst',
                'salary' => 880000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[4]->id, // Operations
                'employee_code' => 'EMP-1009',
                'first_name' => 'Tanmoy',
                'last_name' => 'Ghosh',
                'email' => 'tanmoy.ghosh@techcorp.in',
                'phone' => '+91 97482 34561',
                'date_of_birth' => '1994-02-08',
                'gender' => 'Male',
                'address' => '24/A, Mandirtala, Shibpur, Howrah - 711102',
                'joining_date' => '2022-12-05',
                'designation' => 'Operations & Logistics Lead',
                'salary' => 820000.00,
                'status' => true,
            ],
            [
                'department_id' => $departments[0]->id, // Engineering
                'employee_code' => 'EMP-1010',
                'first_name' => 'Sayan',
                'last_name' => 'Das',
                'email' => 'sayan.das@techcorp.in',
                'phone' => '+91 98307 89012',
                'date_of_birth' => '1998-07-30',
                'gender' => 'Male',
                'address' => '12, Diamond Harbour Road, Behala Chowrasta, Kolkata - 700034',
                'joining_date' => '2023-10-15',
                'designation' => 'Cloud DevOps Engineer',
                'salary' => 920000.00,
                'status' => true,
            ],
        ];

        $createdEmployees = collect();
        foreach ($sampleEmployees as $empData) {
            $createdEmployees->push(Employee::create($empData));
        }

        // Realistic regional leave scenarios
        $leaveScenarios = [
            [
                'emp_index' => 0, // Subham Nandy
                'leave_type' => 'Annual Leave',
                'days_ago' => 5,
                'duration' => 4,
                'reason' => 'Durga Puja celebrations and family homecoming at native residence in Bardhaman.',
                'status' => 'approved',
            ],
            [
                'emp_index' => 0, // Subham Nandy
                'leave_type' => 'Casual Leave',
                'days_ago' => -10, // Upcoming
                'duration' => 2,
                'reason' => 'Attending international developer conference remotely and urgent house registration work.',
                'status' => 'pending',
            ],
            [
                'emp_index' => 1, // Arpita Banerjee
                'leave_type' => 'Sick Leave',
                'days_ago' => 2,
                'duration' => 3,
                'reason' => 'Suffering from seasonal viral flu and fever; doctor advised bed rest.',
                'status' => 'pending',
            ],
            [
                'emp_index' => 1, // Arpita Banerjee
                'leave_type' => 'Annual Leave',
                'days_ago' => 35,
                'duration' => 5,
                'reason' => 'Annual family vacation trip to Darjeeling and Mirik hills.',
                'status' => 'approved',
            ],
            [
                'emp_index' => 2, // Debabrata Mukherjee
                'leave_type' => 'Casual Leave',
                'days_ago' => 12,
                'duration' => 2,
                'reason' => 'Attending cousin sister\'s wedding ceremony in Kalyani.',
                'status' => 'approved',
            ],
            [
                'emp_index' => 3, // Ananya Sengupta
                'leave_type' => 'Sick Leave',
                'days_ago' => 1,
                'duration' => 2,
                'reason' => 'Severe migraine and physician consultation at AMRI Hospital Dhakuria.',
                'status' => 'pending',
            ],
            [
                'emp_index' => 4, // Souvik Roy
                'leave_type' => 'Annual Leave',
                'days_ago' => 18,
                'duration' => 3,
                'reason' => 'Kali Puja & Diwali celebrations with family in Cooch Behar.',
                'status' => 'approved',
            ],
            [
                'emp_index' => 5, // Sneha Bhattacharya
                'leave_type' => 'Casual Leave',
                'days_ago' => 4,
                'duration' => 1,
                'reason' => 'Passport renewal appointment and document verification at Regional Passport Office, Ruby.',
                'status' => 'approved',
            ],
            [
                'emp_index' => 6, // Puja Chakraborty
                'leave_type' => 'Annual Leave',
                'days_ago' => 25,
                'duration' => 4,
                'reason' => 'Family pilgrimage trip to Mayapur and Nabadwip.',
                'status' => 'approved',
            ],
            [
                'emp_index' => 7, // Pritam Dutta
                'leave_type' => 'Sick Leave',
                'days_ago' => 7,
                'duration' => 2,
                'reason' => 'Dental surgery and post-operative recovery.',
                'status' => 'rejected',
            ],
            [
                'emp_index' => 8, // Tanmoy Ghosh
                'leave_type' => 'Casual Leave',
                'days_ago' => -3, // upcoming
                'duration' => 2,
                'reason' => 'Brother\'s Upanayana (sacred thread ceremony) rituals in Howrah.',
                'status' => 'pending',
            ],
            [
                'emp_index' => 9, // Sayan Das
                'leave_type' => 'Unpaid Leave',
                'days_ago' => 40,
                'duration' => 7,
                'reason' => 'Personal sabbatical for AWS Cloud Architecture certifications.',
                'status' => 'approved',
            ],
        ];

        foreach ($leaveScenarios as $scenario) {
            $emp = $createdEmployees[$scenario['emp_index']];
            $fromDate = Carbon::now()->subDays($scenario['days_ago']);
            $toDate = (clone $fromDate)->addDays($scenario['duration'] - 1);

            EmployeeLeave::create([
                'employee_id' => $emp->id,
                'leave_type' => $scenario['leave_type'],
                'from_date' => $fromDate->toDateString(),
                'to_date' => $toDate->toDateString(),
                'reason' => $scenario['reason'],
                'status' => $scenario['status'],
                'approved_by' => $scenario['status'] !== 'pending' ? $admin->id : null,
            ]);
        }
    }
}

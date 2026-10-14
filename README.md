# StaffFlow - Employee Management System (EMS)

A modern, full-featured **Employee Management System** built with **Laravel 12**, **Tailwind CSS**, and **MySQL**, designed with authentic regional context (West Bengal, India), complete employee lifecycle tracking, leave workflows, and official PDF generation.

---

## 🚀 Key Features

### 1. 📊 Executive Dashboard
- **Real-time Metrics**: Total staff count, active/inactive ratio, active departments, pending leave requests, approved/rejected tallies.
- **Quick Action Bar**: Shortcuts to add employees, create departments, and apply for leaves.
- **Recent Activities**: Interactive recent leaves table with one-click inline **Approve** / **Reject** buttons and recent employee rosters.
- **Department Distribution**: Live visual staffing breakdown across departments.

### 2. 👥 Employee Management (CRUD & Profile)
- **Directory & Multi-Filter**: Search by name, employee code, email, designation; filter by department and status.
- **Comprehensive Profile**: Personal particulars, contact numbers, residential address, service tenure calculation, live age calculation, and annual compensation (₹ CTC).
- **Profile Photo Upload**: Secure storage handling with dynamic UI-avatars fallback and automatic storage cleanup.
- **Downloadable PDF Dossier**: Download official, certified Employee Profile & Service Record PDF (`/employees/{id}/pdf`).

### 3. 🏢 Department Management
- **Full Department Lifecycle**: Create, edit, list with active staff counts (`withCount('employees')`).
- **Department Roster View**: View all team members reporting under a department.
- **Safe Deletion**: Guard preventing accidental deletion of departments that have assigned employees.

### 4. 📅 Leave Management & Approval Workflow
- **Application Workflow**: Apply for Annual, Sick, Casual, Maternity/Paternity, and Unpaid leaves with date range validation.
- **Approval Processing**: Dedicated status filters (*All, Pending, Approved, Rejected*).
- **Audit Tracking**: Automatic recording of approving admin and timestamp.
- **Downloadable PDF Slip**: Official Leave Application & Approval Slip with color-coded status badges and signature sections (`/leaves/{id}/pdf`).

### 5. 🌏 Authentic Regional Context
- Pre-seeded with realistic Bengali names, Kolkata & West Bengal addresses, Indian phone numbers, and cultural leave reasons (Durga Puja, Kali Puja, Darjeeling trips, medical consultations).
- Formatted in Indian Rupees (**₹ INR**).

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade, Tailwind CSS v4, Vite
- **Database**: MySQL (compatible with SQLite for testing)
- **PDF Generation**: `barryvdh/laravel-dompdf` (Dompdf)
- **Testing**: Pest PHP (30 automated feature tests)
- **Code Style**: Laravel Pint

---

## 📦 Installation & Setup

### Prerequisites
- PHP >= 8.2 with PDO, OpenSSL, Mbstring, and GD extensions
- Composer
- Node.js & npm
- MySQL / MariaDB (e.g., via XAMPP)

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/nandysubham/employee-management.git
   cd employee-management
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Update your `.env` database configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=employee_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

5. **Build Frontend Assets**:
   ```bash
   npm run build
   ```

6. **Start Development Server**:
   ```bash
   php artisan serve
   ```
   Access the app at: `http://localhost:8000`

---

## 🔐 Default Credentials

- **Admin Email**: `admin@example.com`
- **Password**: `password`

---

## 🧪 Running Automated Tests

Run the complete test suite with **Pest**:
```bash
php artisan test --compact
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

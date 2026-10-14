<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Profile - {{ $employee->employee_code }}</title>
    <style>
        @page {
            margin: 30px 35px;
        }
        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .company-logo {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
            letter-spacing: -0.5px;
        }
        .company-sub {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h1 {
            margin: 0;
            font-size: 16px;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            margin: 2px 0 0;
            font-size: 9px;
            color: #64748b;
        }

        /* Profile Card */
        .profile-summary {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 12px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-active {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-inactive {
            background-color: #f1f5f9;
            color: #475569;
        }

        /* Section Headings */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .data-table th, .data-table td {
            padding: 7px 10px;
            text-align: left;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .data-label {
            width: 25%;
            font-weight: bold;
            color: #475569;
            font-size: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #f1f5f9;
        }
        .data-value {
            width: 75%;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Leave Stats Grid Table */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .stats-table td {
            width: 25%;
            text-align: center;
            padding: 10px 5px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            border-radius: 4px;
        }
        .stats-number {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            display: block;
        }
        .stats-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 2px;
            display: block;
        }

        /* Footer & Signatures */
        .footer-table {
            width: 100%;
            margin-top: 35px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
        }
        .sig-block {
            width: 45%;
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid #0f172a;
        }
        .footer-note {
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            margin-top: 25px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="company-logo">STAFFFLOW EMS</div>
                <div class="company-sub">Personnel Management & Corporate Operations • Kolkata, West Bengal</div>
            </td>
            <td class="doc-title" style="vertical-align: middle;">
                <h1>Employee Dossier</h1>
                <p>Ref: {{ $employee->employee_code }} • Generated on {{ date('d M, Y') }}</p>
            </td>
        </tr>
    </table>

    <!-- Profile Summary Box -->
    <table class="profile-summary">
        <tr>
            <td style="width: 70%; vertical-align: middle;">
                <div style="font-size: 16px; font-weight: bold; color: #0f172a;">{{ $employee->full_name }}</div>
                <div style="font-size: 11px; color: #4f46e5; font-weight: bold; margin-top: 2px;">
                    {{ $employee->designation ?: 'Staff Member' }}
                </div>
                <div style="font-size: 10px; color: #64748b; margin-top: 3px;">
                    Department: <strong>{{ $employee->department->name ?? 'Unassigned' }}</strong> &nbsp;|&nbsp; 
                    Code: <strong style="font-family: monospace;">{{ $employee->employee_code }}</strong>
                </div>
            </td>
            <td style="width: 30%; text-align: right; vertical-align: middle;">
                @if ($employee->status)
                    <span class="badge badge-active">ACTIVE EMPLOYEE</span>
                @else
                    <span class="badge badge-inactive">INACTIVE / ON LEAVE</span>
                @endif
                <div style="font-size: 9px; color: #64748b; margin-top: 6px;">
                    Tenure: {{ $employee->joining_date ? $employee->joining_date->diffForHumans(null, true) : 'N/A' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Section 1: Employment Details -->
    <div class="section-title">1. Employment & Organizational Information</div>
    <table class="data-table">
        <tr>
            <td class="data-label">Department</td>
            <td class="data-value">{{ $employee->department->name ?? 'General / Unassigned' }}</td>
        </tr>
        <tr>
            <td class="data-label">Designation / Role</td>
            <td class="data-value">{{ $employee->designation ?: 'Not Specified' }}</td>
        </tr>
        <tr>
            <td class="data-label">Joining Date</td>
            <td class="data-value">{{ $employee->joining_date ? $employee->joining_date->format('d F, Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <td class="data-label">Service Length</td>
            <td class="data-value">{{ $employee->joining_date ? $employee->joining_date->diffForHumans(null, true) : 'N/A' }}</td>
        </tr>
        <tr>
            <td class="data-label">Annual CTC / Salary</td>
            <td class="data-value" style="font-weight: bold; color: #0f172a;">
                {{ $employee->salary ? '₹ ' . number_format($employee->salary, 2) : 'Confidential' }}
            </td>
        </tr>
    </table>

    <!-- Section 2: Personal & Contact Information -->
    <div class="section-title">2. Personal & Contact Particulars</div>
    <table class="data-table">
        <tr>
            <td class="data-label">Full Name</td>
            <td class="data-value">{{ $employee->full_name }}</td>
        </tr>
        <tr>
            <td class="data-label">Email Address</td>
            <td class="data-value">{{ $employee->email }}</td>
        </tr>
        <tr>
            <td class="data-label">Contact Number</td>
            <td class="data-value">{{ $employee->phone ?: 'Not provided' }}</td>
        </tr>
        <tr>
            <td class="data-label">Gender</td>
            <td class="data-value">{{ $employee->gender ?: 'Not specified' }}</td>
        </tr>
        <tr>
            <td class="data-label">Date of Birth</td>
            <td class="data-value">
                {{ $employee->date_of_birth ? $employee->date_of_birth->format('d M, Y') . ' (Age: ' . $employee->date_of_birth->age . ' yrs)' : 'N/A' }}
            </td>
        </tr>
        <tr>
            <td class="data-label">Residential Address</td>
            <td class="data-value">{{ $employee->address ?: 'No address on file' }}</td>
        </tr>
    </table>

    <!-- Section 3: Leave Record Summary -->
    <div class="section-title">3. Leave Ledger Summary</div>
    <table class="stats-table">
        <tr>
            <td>
                <span class="stats-number">{{ $leaveStats['total'] ?? $employee->leaves()->count() }}</span>
                <span class="stats-label">Total Applied</span>
            </td>
            <td>
                <span class="stats-number" style="color: #15803d;">{{ $leaveStats['approved'] ?? $employee->leaves()->where('status', 'approved')->count() }}</span>
                <span class="stats-label">Approved</span>
            </td>
            <td>
                <span class="stats-number" style="color: #d97706;">{{ $leaveStats['pending'] ?? $employee->leaves()->where('status', 'pending')->count() }}</span>
                <span class="stats-label">Pending</span>
            </td>
            <td>
                <span class="stats-number" style="color: #b91c1c;">{{ $leaveStats['rejected'] ?? $employee->leaves()->where('status', 'rejected')->count() }}</span>
                <span class="stats-label">Rejected</span>
            </td>
        </tr>
    </table>

    <!-- Footer Signatures -->
    <table class="footer-table">
        <tr>
            <td class="sig-block">
                <strong>{{ $employee->full_name }}</strong><br>
                <span style="font-size: 9px; color: #64748b;">Employee Signature</span>
            </td>
            <td style="width: 10%;"></td>
            <td class="sig-block">
                <strong>Authorized Signatory</strong><br>
                <span style="font-size: 9px; color: #64748b;">HR & Operations Department</span>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        This document is an authentic electronic personnel record produced by StaffFlow EMS on {{ date('Y-m-d H:i:s') }}. Verification ID: {{ md5($employee->id . $employee->employee_code) }}
    </div>

</body>
</html>

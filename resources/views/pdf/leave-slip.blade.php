<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Slip #{{ $leave->id }} - {{ $leave->employee->full_name ?? 'Employee' }}</title>
    <style>
        @page {
            margin: 35px 40px;
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
            margin-bottom: 25px;
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

        /* Status Stamp Box */
        .status-box {
            width: 100%;
            margin-bottom: 20px;
            border-radius: 6px;
            padding: 12px 16px;
        }
        .status-approved {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        .status-pending {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }
        .status-rejected {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .status-pill {
            display: inline-block;
            padding: 4px 10px;
            font-weight: bold;
            font-size: 11px;
            border-radius: 4px;
            text-transform: uppercase;
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
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .data-label {
            width: 30%;
            font-weight: bold;
            color: #475569;
            font-size: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #f1f5f9;
        }
        .data-value {
            width: 70%;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Reason Box */
        .reason-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #4f46e5;
            padding: 12px;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        /* Footer & Signatures */
        .footer-table {
            width: 100%;
            margin-top: 50px;
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
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="company-logo">STAFFFLOW EMS</div>
                <div class="company-sub">HR Leave Administration Department • Kolkata Office</div>
            </td>
            <td class="doc-title" style="vertical-align: middle;">
                <h1>Leave Record Slip</h1>
                <p>Application #{{ $leave->id }} • Date: {{ $leave->created_at ? $leave->created_at->format('d M, Y') : date('d M, Y') }}</p>
            </td>
        </tr>
    </table>

    <!-- Status Banner -->
    <table class="status-box {{ $leave->status === 'approved' ? 'status-approved' : ($leave->status === 'rejected' ? 'status-rejected' : 'status-pending') }}">
        <tr>
            <td style="vertical-align: middle;">
                <span style="font-size: 13px; font-weight: bold;">
                    STATUS: {{ strtoupper($leave->status) }}
                </span>
                <div style="font-size: 9px; margin-top: 3px;">
                    @if ($leave->status === 'approved')
                        This leave request has been officially approved and recorded in the attendance ledger.
                    @elseif ($leave->status === 'rejected')
                        This leave request has been reviewed and rejected by the HR department.
                    @else
                        This leave request is currently awaiting review and authorization by HR management.
                    @endif
                </div>
            </td>
            <td style="text-align: right; vertical-align: middle; font-size: 10px;">
                @if ($leave->approver)
                    Processed by: <strong>{{ $leave->approver->name }}</strong><br>
                    Updated: {{ $leave->updated_at->format('d M, Y H:i') }}
                @else
                    Pending HR Processing
                @endif
            </td>
        </tr>
    </table>

    <!-- Section 1: Employee Particulars -->
    <div class="section-title">1. Employee Information</div>
    <table class="data-table">
        <tr>
            <td class="data-label">Employee Name</td>
            <td class="data-value" style="font-weight: bold; font-size: 12px;">{{ $leave->employee->full_name }}</td>
        </tr>
        <tr>
            <td class="data-label">Employee Code</td>
            <td class="data-value" style="font-family: monospace; font-weight: bold;">{{ $leave->employee->employee_code }}</td>
        </tr>
        <tr>
            <td class="data-label">Department</td>
            <td class="data-value">{{ $leave->employee->department->name ?? 'Unassigned' }}</td>
        </tr>
        <tr>
            <td class="data-label">Designation / Role</td>
            <td class="data-value">{{ $leave->employee->designation ?: 'Staff Member' }}</td>
        </tr>
        <tr>
            <td class="data-label">Contact Email & Phone</td>
            <td class="data-value">{{ $leave->employee->email }} &bull; {{ $leave->employee->phone ?: 'N/A' }}</td>
        </tr>
    </table>

    <!-- Section 2: Leave Application Details -->
    <div class="section-title">2. Leave Schedule & Duration</div>
    <table class="data-table">
        <tr>
            <td class="data-label">Leave Category</td>
            <td class="data-value" style="font-weight: bold; color: #4f46e5;">{{ $leave->leave_type }}</td>
        </tr>
        <tr>
            <td class="data-label">Duration Period</td>
            <td class="data-value">
                <strong>{{ $leave->from_date->format('d F, Y') }}</strong> to <strong>{{ $leave->to_date->format('d F, Y') }}</strong>
            </td>
        </tr>
        <tr>
            <td class="data-label">Total Days Requested</td>
            <td class="data-value" style="font-weight: bold; font-size: 12px; color: #0f172a;">
                {{ $leave->days_count }} {{ $leave->days_count == 1 ? 'Day' : 'Days' }}
            </td>
        </tr>
        <tr>
            <td class="data-label">Application Filing Date</td>
            <td class="data-value">{{ $leave->created_at ? $leave->created_at->format('d F, Y H:i:s') : 'N/A' }}</td>
        </tr>
    </table>

    <!-- Section 3: Reason / Remarks -->
    <div class="section-title">3. Stated Reason / Justification</div>
    <div class="reason-box">
        <div style="font-size: 11px; color: #0f172a;">
            {{ $leave->reason ?: 'No statement or reason provided by applicant.' }}
        </div>
    </div>

    <!-- Signatures -->
    <table class="footer-table">
        <tr>
            <td class="sig-block">
                <strong>{{ $leave->employee->full_name }}</strong><br>
                <span style="font-size: 9px; color: #64748b;">Applicant Signature</span>
            </td>
            <td style="width: 10%;"></td>
            <td class="sig-block">
                <strong>{{ $leave->approver ? $leave->approver->name : 'HR / Approving Authority' }}</strong><br>
                <span style="font-size: 9px; color: #64748b;">Authorized Signature & Seal</span>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Official Record Slip &bull; StaffFlow EMS &bull; Generated on {{ date('Y-m-d H:i:s') }} &bull; Document Reference: SLIP-LEAVE-{{ $leave->id }}-{{ $leave->employee->employee_code }}
    </div>

</body>
</html>

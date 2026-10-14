<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PdfExportController extends Controller
{
    /**
     * Generate and download the official Employee Profile Dossier as a PDF.
     */
    public function employeeProfile(Request $request, Employee $employee): Response
    {
        $employee->load(['department', 'leaves']);

        $leaveStats = [
            'total' => $employee->leaves->count(),
            'approved' => $employee->leaves->where('status', 'approved')->count(),
            'pending' => $employee->leaves->where('status', 'pending')->count(),
            'rejected' => $employee->leaves->where('status', 'rejected')->count(),
        ];

        $pdf = Pdf::loadView('pdf.employee-profile', [
            'employee' => $employee,
            'leaveStats' => $leaveStats,
        ])->setPaper('a4', 'portrait');

        $filename = 'employee-profile-'.Str::slug($employee->employee_code.'-'.$employee->full_name).'.pdf';

        if ($request->boolean('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    /**
     * Generate and download the official Leave Application & Approval Slip as a PDF.
     */
    public function leaveSlip(Request $request, EmployeeLeave $leave): Response
    {
        $leave->load(['employee.department', 'approver']);

        $pdf = Pdf::loadView('pdf.leave-slip', [
            'leave' => $leave,
        ])->setPaper('a4', 'portrait');

        $filename = 'leave-slip-'.$leave->id.'-'.Str::slug($leave->employee->full_name ?? 'record').'.pdf';

        if ($request->boolean('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}

<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmDeal;
use App\Models\Crm\CrmPayment;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmFollowup;

class CrmReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->get('type', 'leads');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $employeeId = $request->get('employee_id');

        $employees = CrmEmployee::where('status', 'Active')->get();
        $reportData = [];

        switch ($reportType) {
            case 'revenue':
            case 'payments':
                $q = CrmPayment::with('customer')->whereBetween('payment_date', [$startDate, $endDate]);
                $reportData = $q->latest()->get();
                break;
            case 'deals':
            case 'sales':
                $q = CrmDeal::with(['customer', 'assignedEmployee'])->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                if ($employeeId) $q->where('assigned_to', $employeeId);
                $reportData = $q->latest()->get();
                break;
            case 'customers':
                $q = CrmCustomer::with('assignedEmployee')->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                if ($employeeId) $q->where('assigned_to', $employeeId);
                $reportData = $q->latest()->get();
                break;
            case 'leads':
            default:
                $q = CrmLead::with(['assignedEmployee', 'source'])->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                if ($employeeId) $q->where('assigned_to', $employeeId);
                $reportData = $q->latest()->get();
                break;
        }

        // Summary Cards
        $totalLeadsCount = CrmLead::whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])->count();
        $totalDealsWon = CrmDeal::where('stage', 'Won')->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])->sum('value');
        $totalCollected = CrmPayment::where('status', 'Paid')->whereBetween('payment_date', [$startDate, $endDate])->sum('amount');
        $totalTasksDone = CrmTask::where('status', 'Completed')->count();

        return view('crm.admin.reports.index', compact(
            'reportType', 'startDate', 'endDate', 'employeeId', 'employees',
            'reportData', 'totalLeadsCount', 'totalDealsWon', 'totalCollected', 'totalTasksDone'
        ));
    }

    public function export(Request $request)
    {
        $reportType = $request->get('type', 'leads');
        $filename = "crm_report_{$reportType}_" . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($reportType) {
            $file = fopen('php://output', 'w');

            if ($reportType === 'leads') {
                fputcsv($file, ['ID', 'Code', 'Name', 'Company', 'Email', 'Phone', 'Status', 'Priority', 'Expected Value (INR)', 'Date']);
                foreach (CrmLead::latest()->get() as $r) {
                    fputcsv($file, [$r->id, $r->lead_code, $r->name, $r->company, $r->email, $r->phone, $r->status, $r->priority, $r->expected_value, $r->created_at->format('Y-m-d')]);
                }
            } elseif ($reportType === 'payments' || $reportType === 'revenue') {
                fputcsv($file, ['Payment No', 'Amount (INR)', 'Method', 'Date', 'Status', 'Transaction Ref', 'Notes']);
                foreach (CrmPayment::latest()->get() as $p) {
                    fputcsv($file, [$p->payment_no, $p->amount, $p->payment_method, $p->payment_date, $p->status, $p->transaction_ref, $p->notes]);
                }
            } else {
                fputcsv($file, ['Title', 'Stage', 'Value (INR)', 'Probability (%)', 'Closing Date']);
                foreach (CrmDeal::latest()->get() as $d) {
                    fputcsv($file, [$d->title, $d->stage, $d->value, $d->probability, $d->expected_closing_date]);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

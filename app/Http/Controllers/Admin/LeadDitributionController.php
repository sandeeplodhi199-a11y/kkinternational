<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\TeamLeader;
use App\Models\Manager;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Exports\TeamLeaderExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LeadDitributionController extends Controller
{
  


    

 public function bulk_lead_distribute()
 {
    $data['menu']    = 'bulk_uploads';
    $data['submenu'] = 'bulk_lead_distribute';

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();
                          
   

        return view('backend.leadbulkupload.bulk_lead_distribute', compact('data', 'branches'));
    }

public function Savebulkdistribute(Request $request)
{
    $request->validate([
        'branch_id'  => 'required|exists:tbl_branch,id',
        'manager_id' => 'required|exists:tbl_manager,manager_id',
        'tl_id'      => 'nullable|exists:tbl_team_leader,tl_id',
        'csv_file'   => 'required|mimes:csv,txt',
    ]);

    $path = $request->file('csv_file')->getRealPath();
    $data = array_map('str_getcsv', file($path));

    // Remove header
    if (isset($data[0][0]) && strcasecmp(trim($data[0][0]), 'Name') === 0) {
        array_shift($data);
    }

    $insertedCount = 0;
    $skippedCount  = 0;
    $skippedRows   = [];

    $user = Auth::user();

    $inprocessLeadStatusId = LeadStatus::where('status', 'Need CB')
        ->where('name', 'Inprocess')
        ->value('id');

    foreach ($data as $index => $row) {

        $rowNumber = $index + 2;

        $name            = trim($row[0] ?? '');
        $email           = trim($row[1] ?? null);
        $phone           = trim($row[2] ?? '');
        $gender          = trim($row[3] ?? null);
        $class           = trim($row[4] ?? null);
        $school_name     = trim($row[5] ?? null);
        $gaurdian_phone  = trim($row[6] ?? null);
        $course_id       = trim($row[7] ?? null); // ✅ COURSE

        // Required check
        if (empty($name) || empty($phone)) {
            $skippedCount++;
            $skippedRows[] = "Row {$rowNumber}: Name or Phone missing";
            continue;
        }

        // Duplicate phone check
        if (Lead::where('phone', $phone)->exists()) {
            $skippedCount++;
            $skippedRows[] = "Row {$rowNumber}: Phone already exists ({$phone})";
            continue;
        }

        // Manager user
        $getManagerid = DB::table('users')
            ->where('manager_id', $request->manager_id)
            ->where('type', 'manager')
            ->value('id');

        if (!$getManagerid) {
            $skippedCount++;
            $skippedRows[] = "Row {$rowNumber}: Manager user not found";
            continue;
        }

        // TL user
        $getTLid = null;
        if (!empty($request->tl_id)) {
            $getTLid = DB::table('users')
                ->where('tl_id', $request->tl_id)
                ->where('type', 'tl')
                ->value('id');

            if (!$getTLid) {
                $skippedCount++;
                $skippedRows[] = "Row {$rowNumber}: TL user not found";
                continue;
            }
        }

        $leadAssignId = $getTLid ?? $getManagerid;

        // Lead ID
        $lastLead = Lead::orderBy('id', 'desc')->first();
        $lastNumber = $lastLead ? (int) str_replace('LEAD', '', $lastLead->lead_id) : 0;
        $newLeadId = 'LEAD' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Save Lead
        $lead = new Lead();
        $lead->id_hash        = md5(uniqid(rand(), true));
        $lead->lead_id        = $newLeadId;
        $lead->branch_id      = $request->branch_id;
        $lead->manager_id     = $request->manager_id;
        $lead->tl_id          = $request->tl_id;
        $lead->status_id      = $inprocessLeadStatusId;
        $lead->lead_assign_id = $leadAssignId;

        $lead->name           = $name;
        $lead->email          = $email;
        $lead->phone          = $phone;
        $lead->gender         = $gender ?: null;
        $lead->class          = $class ?: null;
        $lead->school_name    = $school_name ?: null;
        $lead->gaurdian_phone = $gaurdian_phone ?: null;

        // ✅ COURSE SAVE
        $lead->course_id      = !empty($course_id) ? $course_id : null;

        $lead->status         = 'Active';
        $lead->add_id         = $user->id;

        $lead->save();

        $insertedCount++;
    }

    return redirect()->back()->with([
        'success' => "Bulk upload completed. Inserted: {$insertedCount}, Skipped: {$skippedCount}",
        'skipped_rows' => $skippedRows
    ]);
}




}
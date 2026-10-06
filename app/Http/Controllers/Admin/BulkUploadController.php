<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BulkUpload;
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

class BulkUploadController extends Controller
{
  

public function bulk_upload()
{
    $data['menu']    = 'bulk_uploads';
    $data['submenu'] = 'bulk_upload';

        $branches = Branch::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();
                          
   

        return view('backend.bulkupload.bulk_upload', compact('data', 'branches'));
    }


public function SaveBulkData(Request $request)
{
    $request->validate([
        'branch_id'    => 'required|exists:tbl_branch,id',
        'manager_id'   => 'required|exists:tbl_manager,manager_id',
        'csv_file'     => 'required|mimes:csv,txt,csv',
    ]);

    $path = $request->file('csv_file')->getRealPath();
    $data = array_map('str_getcsv', file($path));

    $header = ['Name', 'Email', 'Phone'];
    if ($data[0] === $header) {
        array_shift($data);
    }

    $insertedCount = 0;
    $skippedCount  = 0;
    $user         = Auth::user();

    foreach ($data as $row) {
        $name  = trim($row[0] ?? null);
        $email = trim($row[1] ?? null);
        $phone = trim($row[2] ?? null);

        // Skip if all fields are empty
        if (empty($name) && empty($email) && empty($phone)) {
            $skippedCount++;
            continue;
        }

        // Skip if phone is missing
        if (!$phone) {
            $skippedCount++;
            continue;
        }

        // Skip if phone already exists
        $exists = BulkUpload::where('phone', $phone)->exists();
        if ($exists) {
            $skippedCount++;
            continue;
        }

        // Save new record
        $bulkupload = new BulkUpload();
        $bulkupload->id_hash     = md5(uniqid(rand(), true));
        $bulkupload->manager_id  = $request->manager_id;
        $bulkupload->branch_id   = $request->branch_id;
        $bulkupload->name        = $name;
        $bulkupload->email       = $email;
        $bulkupload->phone       = $phone;
        $bulkupload->status      = 'Active';
        $bulkupload->add_id      = $user->id;
        $bulkupload->save();

        $insertedCount++;
    }

    $message = "Bulk data upload completed. New records inserted: {$insertedCount}, Skipped (existing/missing phone/empty): {$skippedCount}.";

    return redirect()->back()->with('success', $message);
}


     public function bulk_data_list()
{
   $data['menu']    = 'bulk_uploads';
    $data['submenu'] = 'bulk_data_list';

   
    $bulkData = BulkUpload::where('is_deleted', 0)
                    ->where('status', 'Active')
                    ->orderBy('id', 'desc')
                    ->paginate(25);

    return view('backend.bulkupload.bulk_data_list', compact('data','bulkData'));
}


}
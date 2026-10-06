<?php

namespace App\Imports;

use App\Models\Admission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $session_id;

    public $inserted = 0;
    public $skipped  = 0;

    private $rollCounter = 0;

    public function __construct($session_id)
    {
        $this->session_id = $session_id;

        $lastRoll = DB::table('tbl_admission')->max('roll_number');
        $this->rollCounter = $lastRoll ? (int)$lastRoll : 0;
    }

    public function model(array $row)
    {
        if (empty($row['first_name'])) {
            return null;
        }

        // ✅ Excel से grade & section
        $grade_id   = $row['grade_id'] ?? null;
        $section_id = $row['section_id'] ?? null;

        if (!$grade_id || !$section_id) {
            $this->skipped++;
            return null;
        }

        $dob_ad = $this->formatDate($row['dob_ad'] ?? null);
        $dob_bs = $this->formatDate($row['dob_bs'] ?? null);

        // ✅ DUPLICATE CHECK
        $exists = DB::table('tbl_admission')
            ->where('first_name', trim($row['first_name']))
            ->where('last_name', trim($row['last_name'] ?? ''))
            ->where('dob_ad', $dob_ad)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            $this->skipped++;
            return null;
        }

        DB::beginTransaction();

        try {

            // ✅ Admission No
            $general = DB::table('tbl_general')
                ->where('id', 1)
                ->lockForUpdate()
                ->first();

            $alpha   = $general->textable_enrollment_alpha ?? 'ENR';
            $numeric = $general->textable_enrollment_numeric ?? '0001';

            $admission_no = $alpha . $numeric;

            DB::table('tbl_general')->where('id', 1)->update([
                'textable_enrollment_numeric' =>
                    str_pad((int)$numeric + 1, strlen($numeric), '0', STR_PAD_LEFT)
            ]);

            // ✅ Roll No
            $this->rollCounter++;
            $roll = str_pad($this->rollCounter, 4, '0', STR_PAD_LEFT);

            // ✅ Insert
            DB::table('tbl_admission')->insert([
                'first_name'    => $row['first_name'] ?? '',
                'middle_name'   => $row['middle_name'] ?? '',
                'last_name'     => $row['last_name'] ?? '',
                'phone'         => (string)($row['phone'] ?? ''),
                'email'         => $row['email'] ?? '',

                'session_id'    => $this->session_id,
                'grade_id'      => $grade_id,
                'section_id'    => $section_id,

                'dob_bs'        => $dob_bs,
                'dob_ad'        => $dob_ad,

                'state'         => $row['state'] ?? '',
                'city'          => $row['city'] ?? '',
                'address'       => $row['address'] ?? '',
                'pincode'       => $row['pincode'] ?? '',

                'iemis_no'      => $row['iemis_no'] ?? '',
                'nickname'      => $row['nickname'] ?? '',
                'gender'        => $row['gender'] ?? '',
                'blood_group'   => $row['blood_group'] ?? '',
                'nationality'   => $row['nationality'] ?? 'Nepali',

                'photo'         => null,
                'ethnicity'     => $row['ethnicity'] ?? '',
                'mother_tongue' => $row['mother_tongue'] ?? '',
                'contact'       => (string)($row['contact'] ?? ''),
                'religion'      => $row['religion'] ?? '',

                'roll_number'   => $roll,
                'admission_no'  => $admission_no,

                'status'        => 'Active',
                'is_deleted'    => 0,

                'admission_date'=> now(),
                'add_id'        => Auth::id() ?? 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            DB::commit();
            $this->inserted++;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->skipped++;
        }

        return null;
    }

    private function formatDate($value)
    {
        if (empty($value)) return null;

        try {
            return is_numeric($value)
                ? Date::excelToDateTimeObject($value)->format('Y-m-d')
                : date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }
}
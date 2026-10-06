<?php

namespace App\Exports;

use App\Models\PatientCase;
use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientExportCase implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
       $patients = PatientCase::query();


        if ($this->request->filled('name')) {
            $patients->where('name', 'like', '%' . $this->request->name . '%');
        }
        if ($this->request->filled('phone')) {
            $patients->where('phone', 'like', '%' . $this->request->phone . '%');
        }
        if ($this->request->filled('gender')) {
            $patients->where('gender', $this->request->gender);
        }
        if ($this->request->filled('langauge')) {
            $patients->where('langauge', 'like', '%' . $this->request->langauge . '%');
        }
        if ($this->request->filled('age_from')) {
            $patients->where('age', '>=', $this->request->age_from);
        }
        if ($this->request->filled('age_to')) {
            $patients->where('age', '<=', $this->request->age_to);
        }
        if ($this->request->filled('dob_from')) {
            $patients->whereDate('dob', '>=', $this->request->dob_from);
        }
        if ($this->request->filled('dob_to')) {
            $patients->whereDate('dob', '<=', $this->request->dob_to);
        }
        if ($this->request->filled('date_from')) {
            $patients->whereDate('created_at', '>=', $this->request->date_from);
        }
        if ($this->request->filled('date_to')) {
            $patients->whereDate('created_at', '<=', $this->request->date_to);
        }

        $branches = Branch::pluck('name', 'id');

        return $patients->orderBy('id', 'DESC')->get()->map(function ($patient) use ($branches) {
            $branchIds = explode(',', $patient->branch_id ?? '');
            $branchNames = collect($branchIds)->map(function ($id) use ($branches) {
                return $branches[$id] ?? null;
            })->filter()->implode(', ');

            $dietary = $patient->dietary ? implode(', ', explode(',', $patient->dietary)) : '';
            $perspirationName = \DB::table('tbl_perspiration')->where('id', $patient->perspiration)->value('name') ?? '';
            $diseaseName = \DB::table('tbl_disease')->where('id', $patient->disease_type)->value('name') ?? '';

            return [
                $patient->patient_id,
                $patient->case_id,
                $patient->name,
                $patient->phone,
                $patient->image,
                $patient->gender,
                $patient->age,
                // $branchNames,
                $dietary,
                $patient->stool,
                $patient->urine,
                $patient->thermal,
                $patient->sleep,
                $patient->mental_general,
                $patient->diagnosis,
                $patient->thirst,
                $patient->appetite,
                $perspirationName,
                $patient->male_female,
                $patient->desire_aversion,
                $patient->knowndisease == 'on' ? 'Yes' : 'No',
                $patient->quarantine == 'on' ? 'Yes' : 'No',
                $patient->d_d,
                $patient->all_examination,
                $patient->bp,
                $patient->pulse,
                $diseaseName,
                $patient->observation,
                \Carbon\Carbon::parse($patient->created_at)->format('d M, Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Patient ID',
            'Case ID',
            'Name',
            'Phone',
            'Image',
            'Gender',
            'Age',
            // 'Branch',
            'Dietary',
            'Stool',
            'Urine',
            'Thermal',
            'Sleep',
            'Mental',
            'Diagnosis',
            'Thirst',
            'Appetite',
            'Perspiration',
            'Male/Female',
            'Desire/Aversion',
            'Known Disease',
            'Quarantine',
            'D/D',
            'Examination',
            'BP',
            'Pulse',
            'Disease Type',
            'Observation',
            'Date',
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Telecaller;
use App\Models\TeamLeader;
use App\Models\Manager;
use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TelecallerExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $telecallers = Telecaller::where('is_deleted', 0);

        if ($this->request->filled('name')) {
            $telecallers->where('name', 'like', '%' . $this->request->name . '%');
        }
        if ($this->request->filled('phone')) {
            $telecallers->where('phone', 'like', '%' . $this->request->phone . '%');
        }
        if ($this->request->filled('email')) {
            $telecallers->where('email', 'like', '%' . $this->request->email . '%');
        }
        if ($this->request->filled('gender')) {
            $telecallers->where('gender', $this->request->gender);
        }

        if ($this->request->filled('dob_from')) {
            $telecallers->whereDate('dob', '>=', $this->request->dob_from);
        }
        if ($this->request->filled('dob_to')) {
            $telecallers->whereDate('dob', '<=', $this->request->dob_to);
        }
        if ($this->request->filled('date_from')) {
            $telecallers->whereDate('created_at', '>=', $this->request->date_from);
        }
        if ($this->request->filled('date_to')) {
            $telecallers->whereDate('created_at', '<=', $this->request->date_to);
        }

        $branches = Branch::pluck('name', 'id');

        return $telecallers->orderBy('id', 'DESC')->get()->map(function ($telecaller) use ($branches) {
            // Get branch names
            $branchIds = explode(',', $telecaller->branch_id ?? '');
            $branchNames = collect($branchIds)->map(function ($id) use ($branches) {
                return $branches[$id] ?? null;
            })->filter()->implode(', ');

           $manager = Manager::where('manager_id', $telecaller->manager_id)->first();
           $teamleader = TeamLeader::where('tl_id', $telecaller->tl_id)->first();


            return [
                'Manager ID'       => $telecaller->manager_id,
                'Manager Name'     => $manager->name ?? 'N/A',
                'Manager Email'    => $manager->email ?? 'N/A',
                'Manager Phone'    => $manager->phone ?? 'N/A',
                'TL ID'           => $teamleader->tl_id,
                'TL Name'         => $teamleader->name,
                'TL Email'        => $teamleader->email,
                'TL Phone'        => $teamleader->phone,
                'Telecaller ID'           => $telecaller->telecaller_id,
                'Telecaller Name'         => $telecaller->name,
                'Telecaller Email'        => $telecaller->email,
                'Telecaller Phone'        => $telecaller->phone,
                'Gender'          => $telecaller->gender,
                'State'           => $telecaller->state,
                'City'            => $telecaller->city,
                'DOB'             => $telecaller->dob,
                'Branch'          => $branchNames,
                'Status'          => $telecaller->status,
                'Created At'      => $telecaller->created_at->format('d M, Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Manager ID',
            'Manager Name',
            'Manager Email',
            'Manager Phone',
            'TL ID',
            'TL Name',
            'TL Email',
            'TL Phone',
            'Telecaller ID',
            'Telecaller Name',
            'Telecaller Email',
            'Telecaller Phone',
            'Gender',
            'State',
            'City',
            'DOB',
            'Branch',
            'Status',
            'Created At',
        ];
    }
}

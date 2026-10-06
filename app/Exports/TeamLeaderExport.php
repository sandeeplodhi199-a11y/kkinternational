<?php

namespace App\Exports;

use App\Models\TeamLeader;
use App\Models\Manager;
use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeamLeaderExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $tls = TeamLeader::where('is_deleted', 0);

        if ($this->request->filled('name')) {
            $tls->where('name', 'like', '%' . $this->request->name . '%');
        }
        if ($this->request->filled('phone')) {
            $tls->where('phone', 'like', '%' . $this->request->phone . '%');
        }
        if ($this->request->filled('email')) {
            $tls->where('email', 'like', '%' . $this->request->email . '%');
        }
        if ($this->request->filled('gender')) {
            $tls->where('gender', $this->request->gender);
        }

        if ($this->request->filled('dob_from')) {
            $tls->whereDate('dob', '>=', $this->request->dob_from);
        }
        if ($this->request->filled('dob_to')) {
            $tls->whereDate('dob', '<=', $this->request->dob_to);
        }
        if ($this->request->filled('date_from')) {
            $tls->whereDate('created_at', '>=', $this->request->date_from);
        }
        if ($this->request->filled('date_to')) {
            $tls->whereDate('created_at', '<=', $this->request->date_to);
        }

        $branches = Branch::pluck('name', 'id');

        return $tls->orderBy('id', 'DESC')->get()->map(function ($tl) use ($branches) {
            // Get branch names
            $branchIds = explode(',', $tl->branch_id ?? '');
            $branchNames = collect($branchIds)->map(function ($id) use ($branches) {
                return $branches[$id] ?? null;
            })->filter()->implode(', ');

           $manager = Manager::where('manager_id', $tl->manager_id)->first();


            return [
                'Manager ID'       => $tl->manager_id,
                'Manager Name'     => $manager->name ?? 'N/A',
                'Manager Email'    => $manager->email ?? 'N/A',
                'Manager Phone'    => $manager->phone ?? 'N/A',
                'TL ID'           => $tl->tl_id,
                'TL Name'         => $tl->name,
                'TL Email'        => $tl->email,
                'TL Phone'        => $tl->phone,
                'Gender'          => $tl->gender,
                'State'           => $tl->state,
                'City'            => $tl->city,
                'DOB'             => $tl->dob,
                'Branch'          => $branchNames,
                'Status'          => $tl->status,
                'Created At'      => $tl->created_at->format('d M, Y'),
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

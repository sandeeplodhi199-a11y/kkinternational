<?php

namespace App\Exports;

use App\Models\Manager;
use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ManagerExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $managers = Manager::where('is_deleted', 0);

        if ($this->request->filled('name')) {
            $managers->where('name', 'like', '%' . $this->request->name . '%');
        }
        if ($this->request->filled('phone')) {
            $managers->where('phone', 'like', '%' . $this->request->phone . '%');
        }
        if ($this->request->filled('email')) {
            $managers->where('email', 'like', '%' . $this->request->email . '%');
        }
        if ($this->request->filled('gender')) {
            $managers->where('gender', $this->request->gender);
        }

        if ($this->request->filled('dob_from')) {
            $managers->whereDate('dob', '>=', $this->request->dob_from);
        }
        if ($this->request->filled('dob_to')) {
            $managers->whereDate('dob', '<=', $this->request->dob_to);
        }
        if ($this->request->filled('date_from')) {
            $managers->whereDate('created_at', '>=', $this->request->date_from);
        }
        if ($this->request->filled('date_to')) {
            $managers->whereDate('created_at', '<=', $this->request->date_to);
        }

        $branches = Branch::pluck('name', 'id');

        return $managers->orderBy('id', 'DESC')->get()->map(function ($manager) use ($branches) {
            $branchIds = explode(',', $manager->branch_id ?? '');
            $branchNames = collect($branchIds)->map(function ($id) use ($branches) {
                return $branches[$id] ?? null;
            })->filter()->implode(', ');

            return [
                'Manager ID'    => $manager->manager_id,
                'Name'          => $manager->name,
                'Email'         => $manager->email,
                'Phone'         => $manager->phone,
                'Gender'        => $manager->gender,
                'State'         => $manager->state,
                'City'          => $manager->city,
                'DOB'           => $manager->dob,
                'Branch'        => $branchNames,
                'Status'        => $manager->status,
                'Created At'    => $manager->created_at->format('d M, Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Manager ID', 'Name', 'Email', 'Phone', 'Gender', 'State', 'City', 
            'DOB', 'Branch', 'Status', 'Created At'
        ];
    }
}

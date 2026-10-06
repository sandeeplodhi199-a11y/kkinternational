<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Purpose;
use App\Models\Manager;
use App\Models\FollowUp;
use App\Models\Course;
use App\Models\Branch;
use App\Models\InstallmentPaymentAdmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Exports\LeadExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Models\TeamLeader;
use App\Models\Telecaller;
use App\Models\Admission;
use App\Models\Session;
use App\Models\Grade;
use Carbon\Carbon;


use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;


use App\Imports\StudentsImport;

class LeadController extends Controller
{
   public function lead(Request $request)
{

    $user = Auth::user();

    $data['menu']    = 'leads';
    $data['submenu'] = 'lead';

    $r_page = $request->get('r_page', 25);
    $data['r_page'] = $r_page;

    if($user->type == 'admin'){

    $leads = Lead::where('tbl_lead.is_deleted', 0)
    ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
    ->whereNotIn('tbl_lead_status.status', ['Done', 'Cancel'])
    ->where(function ($q) {
        $q->whereNull('tbl_lead.admission_id')
          ->orWhere('tbl_lead.admission_id', '');
    })
    ->select('tbl_lead.*');
    }else{
        $leads = Lead::where('tbl_lead.is_deleted', 0)
        ->where('tbl_lead.lead_assign_id', $user->id)
        ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
        ->whereNotIn('tbl_lead_status.status', ['Done', 'Cancel'])
        ->where(function ($q) {
            $q->whereNull('tbl_lead.admission_id')
            ->orWhere('tbl_lead.admission_id', '');
        })
        ->select('tbl_lead.*');
    }
            


    if ($request->filled('name')) {
        $leads->where('tbl_lead.name', 'like', '%' . $request->name . '%');
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $leads->where('tbl_lead.email', 'like', '%' . $request->email . '%');
        $data['email'] = $request->email;
    }

    if ($request->filled('phone')) {
        $leads->where('tbl_lead.phone', 'like', '%' . $request->phone . '%');
        $data['phone'] = $request->phone;
    }

    if ($request->filled('gender')) {
        $leads->where('tbl_lead.gender', $request->gender);
        $data['gender'] = $request->gender;
    }


    if ($request->filled('followup_date')) {
        $leads->whereDate('tbl_lead.next_followup_date', '>=', $request->followup_date);
        $data['followup_date'] = $request->followup_date;
    }

    if ($request->filled('date_from')) {
        $leads->whereDate('tbl_lead.created_at', '>=', $request->date_from);
        $data['date_from'] = $request->date_from;
    }

    if ($request->filled('date_to')) {
        $leads->whereDate('tbl_lead.created_at', '<=', $request->date_to);
        $data['date_to'] = $request->date_to;
    }

    $leads = $leads->orderBy('tbl_lead.id', 'DESC')->paginate($r_page);
    $leads->appends($request->all());

   

    $sources = LeadSource::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $status = LeadStatus::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $purposes  = Purpose::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    return view('backend.lead.lead', compact('data', 'leads', 'sources','status','purposes'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}

public function todayfollowlead(Request $request)
{
    $user = Auth::user();
    $todaydate = date('Y-m-d'); 

    $data['menu']    = 'leads';
    $data['submenu'] = 'todayfollowlead';

    $r_page = $request->get('r_page', 25);
    $data['r_page'] = $r_page;

    if($user->type == 'admin'){

        $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
            ->whereNotIn('tbl_lead_status.status', ['Done', 'Cancel'])
            ->where(function ($q) {
                $q->whereNull('tbl_lead.admission_id')
                  ->orWhere('tbl_lead.admission_id', '');
            })
            ->where(function ($q) use ($todaydate) {
                $q->whereNull('tbl_lead.next_followup_date')
                  ->orWhere('tbl_lead.next_followup_date', '')
                  ->orWhereDate('tbl_lead.next_followup_date', $todaydate); // <- fixed
            })
            ->select('tbl_lead.*');

    } else {

        $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->where('tbl_lead.lead_assign_id', $user->id)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
           ->whereNotIn('tbl_lead_status.status', ['Done', 'Cancel'])
            ->where(function ($q) {
                $q->whereNull('tbl_lead.admission_id')
                  ->orWhere('tbl_lead.admission_id', '');
            })
            ->where(function ($q) use ($todaydate) {
                $q->whereNull('tbl_lead.next_followup_date')
                  ->orWhere('tbl_lead.next_followup_date', '')
                  ->orWhereDate('tbl_lead.next_followup_date', $todaydate); // <- fixed
            })
            ->select('tbl_lead.*');
    }

    // Filters
    if ($request->filled('name')) {
        $leads->where('tbl_lead.name', 'like', '%' . $request->name . '%');
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $leads->where('tbl_lead.email', 'like', '%' . $request->email . '%');
        $data['email'] = $request->email;
    }

    if ($request->filled('phone')) {
        $leads->where('tbl_lead.phone', 'like', '%' . $request->phone . '%');
        $data['phone'] = $request->phone;
    }

    if ($request->filled('gender')) {
        $leads->where('tbl_lead.gender', $request->gender);
        $data['gender'] = $request->gender;
    }

    if ($request->filled('date_from')) {
        $leads->whereDate('tbl_lead.created_at', '>=', $request->date_from);
        $data['date_from'] = $request->date_from;
    }

    if ($request->filled('date_to')) {
        $leads->whereDate('tbl_lead.created_at', '<=', $request->date_to);
        $data['date_to'] = $request->date_to;
    }

    $leads = $leads->orderBy('tbl_lead.id', 'DESC')->paginate($r_page);
    $leads->appends($request->all());

    $sources = LeadSource::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $status = LeadStatus::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $purposes  = Purpose::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    return view('backend.lead.todayfollowlead', compact('data', 'leads', 'sources','status','purposes'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}





public function todaycalllead(Request $request)
{
    $user = Auth::user();
    $todaydate = date('Y-m-d');

    $data['menu'] = 'leads';
    $data['submenu'] = 'todaycalllead';

    $r_page = $request->get('r_page', 25);
    $data['r_page'] = $r_page;

    if ($user->type == 'admin') {

        $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
            // ->whereNotIn('tbl_lead_status.status', ['Done', 'Cancel'])
            ->where(function ($q) {
                $q->whereNull('tbl_lead.admission_id')
                  ->orWhere('tbl_lead.admission_id', '');
            })
            ->whereDate('tbl_lead.next_followup_date', $todaydate)
            ->select('tbl_lead.*');

    } else {

        $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->where('tbl_lead.lead_assign_id', $user->id)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
            // ->whereNotIn('tbl_lead_status.status', ['Done', 'Cancel'])
            ->where(function ($q) {
                $q->whereNull('tbl_lead.admission_id')
                  ->orWhere('tbl_lead.admission_id', '');
            })
            ->whereDate('tbl_lead.next_followup_date', $todaydate)
            ->select('tbl_lead.*');
    }

    if ($request->filled('name')) {
        $leads->where('tbl_lead.name', 'like', '%' . $request->name . '%');
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $leads->where('tbl_lead.email', 'like', '%' . $request->email . '%');
        $data['email'] = $request->email;
    }

    if ($request->filled('phone')) {
        $leads->where('tbl_lead.phone', 'like', '%' . $request->phone . '%');
        $data['phone'] = $request->phone;
    }

    if ($request->filled('gender')) {
        $leads->where('tbl_lead.gender', $request->gender);
        $data['gender'] = $request->gender;
    }

    if ($request->filled('date_from')) {
        $leads->whereDate('tbl_lead.created_at', '>=', $request->date_from);
        $data['date_from'] = $request->date_from;
    }

    if ($request->filled('date_to')) {
        $leads->whereDate('tbl_lead.created_at', '<=', $request->date_to);
        $data['date_to'] = $request->date_to;
    }

    $leads = $leads->orderBy('tbl_lead.id', 'DESC')->paginate($r_page);
    $leads->appends($request->all());

    $sources = LeadSource::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

    $status = LeadStatus::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

    $purposes = Purpose::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

    return view('backend.lead.todaycalllead', compact(
        'data',
        'leads',
        'sources',
        'status',
        'purposes'
    ))->with('i', (request()->input('page', 1) - 1) * $r_page);
}


    public function view_lead_distribute(Request $request)
{
    $data['menu'] = "leads";
    $data['submenu'] = "view_lead_distribute";

    $keyword = $request->keyword;
    $manager_id = $request->manager_id;
    $tl_id = $request->tl_id;
    $telecaller_id = $request->telecaller_id;
    $r_page = $request->r_page ?? 25;

    $data['keyword'] = $keyword;
    $data['r_page'] = $r_page;

    $query = Lead::where('is_deleted', '0');

    if(!empty($keyword)){
        $query->where('name', 'like', '%'.$keyword.'%');
    }
    if(!empty($manager_id)){
        $query->where('add_id', $manager_id);
    }
    if(!empty($tl_id)){
        $query->where('add_id', $tl_id);
    }
    if(!empty($telecaller_id)){
        $query->where('add_id', $telecaller_id);
    }

    $page = $query->latest()->paginate($r_page);

    // Keep filters on pagination links
    $page->appends($request->all());

    $purposes  = Purpose::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

    $managers  = Manager::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();
         $tls  = TeamLeader::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();
         $telecallers  = Telecaller::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

    return view('backend.lead.assign_lead', compact('data', 'page','purposes','managers','tls','telecallers'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}



    public function add_lead()
    {
        $data['menu']    = 'leads';
        $data['submenu'] = 'add_lead';

        $sources = LeadSource::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();
        $purposes  = Purpose::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

        $status = LeadStatus::where('is_deleted', '0')
        ->orderBy('id', 'DESC')
        ->get();
        $courses = Course::where('status','Active')->where('is_deleted',0)->get();

        return view('backend.lead.add', compact('data', 'sources','status','purposes','courses'));
    }

   


    public function saveLead(Request $request)
{
   
    $request->validate([
        'name' => 'required',
    ]);

    $user = Auth::user();
    

     // $isUniqueEmail = $this->check_unique_email_edit('email', $request->email, $request->id);
        // if (!$isUniqueEmail) {
        //     return redirect()->back()->with('error', 'Lead email already exists.');
        // }

        // $isUniquePhone = $this->check_unique_phone_edit('phone', $request->phone, $request->id);
        // if (!$isUniquePhone) {
        //     return redirect()->back()->with('error', 'Lead phone already exists.');
        // }

    
    $lastLead = Lead::orderBy('id', 'desc')->first();
    $lastNumber  = $lastLead ? (int) str_replace('LEAD', '', $lastLead->lead_id) : 0;
    $newLeadId = 'LEAD' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);


    $manager_id    = $user->manager_id ? $user->manager_id : '';
    $tl_id         = $user->tl_id ? $user->tl_id : '';
    $telecaller_id = $user->telecaller_id ? $user->telecaller_id : '';


    $lead = new Lead();
    $lead->lead_id = $newLeadId;
    $lead->name       = $request->name;
    $lead->email      = $request->email;
    $lead->phone      = $request->phone;
    $lead->gender     = $request->gender;
    $lead->gaurdian_phone = $request->gaurdian_phone;
    $lead->status     = 'Active';
    $lead->description = $request->description;
    $lead->address    = $request->address;
    $lead->visitied   = $request->visitied;
    $lead->add_id = $user->id;
    $lead->lead_assign_id = $user->id;
    $lead->is_deleted = '0';
    $lead->purpose_id  = $request->purpose_id;
    $lead->branch_id   = $request->branch_id;
    $lead->source_id   = $request->source_id;
    $lead->status_id   = $request->status_id;

    $lead->course_id   = $request->course_id;
    $lead->class   = $request->class;
    $lead->school_name   = $request->school_name;

    if ($manager_id && !$tl_id && !$telecaller_id) {
        $lead['manager_id']     = $manager_id;
        $lead['tl_id']          = null;
        $lead['telecaller_id']  = null;
    }
   
    elseif ($manager_id && $tl_id && !$telecaller_id) {
        $lead['manager_id']     = $manager_id;
        $lead['tl_id']          = $tl_id;
        $lead['telecaller_id']  = null;
    }
   
    elseif ($manager_id && $tl_id && $telecaller_id) {
        $lead['manager_id']     = $manager_id;
        $lead['tl_id']          = $tl_id;
        $lead['telecaller_id']  = $telecaller_id;
    }

    $lead->save();

    // Update id_hash
    $lead->id_hash = md5($lead->id);
    $lead->save();

    return redirect()->back()->with('success', 'Lead added successfully.');
}

    public function edit_lead($id_hash)
    {
         $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('6_3', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
        $data['menu']    = 'leads';
        $data['submenu'] = 'lead';

        $sources = LeadSource::where('is_deleted', '0')
                          ->where('status', 'Active')
                          ->orderBy('id', 'DESC')
                          ->get();

        $status = LeadStatus::where('is_deleted', '0')
        ->orderBy('id', 'DESC')
        ->get();

        $courses = Course::where('status','Active')->where('is_deleted',0)->get();

        $purposes  = Purpose::where('is_deleted', '0')
        ->where('status', 'Active')
        ->orderBy('id', 'DESC')
        ->get();

        $lead = Lead::where('id_hash', $id_hash)->first();

        return view('backend.lead.edit', compact('data', 'lead', 'sources','status','purposes','courses'));
    }

    public function updatelead(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();

        // $isUniqueEmail = $this->check_unique_email_edit('email', $request->email, $request->id);
        // if (!$isUniqueEmail) {
        //     return redirect()->back()->with('error', 'Lead email already exists.');
        // }

        // $isUniquePhone = $this->check_unique_phone_edit('phone', $request->phone, $request->id);
        // if (!$isUniquePhone) {
        //     return redirect()->back()->with('error', 'Lead phone already exists.');
        // }

        $lead = Lead::find($request->id);

        if ($lead) {
            $lead->name       = $request->name;
            $lead->email      = $request->email;
            $lead->phone      = $request->phone;
            $lead->gender     = $request->gender;
            $lead->gaurdian_phone        = $request->gaurdian_phone;
            $lead->description      = $request->description;
            $lead->address       = $request->address;
            $lead->visitied       = $request->visitied;
            $lead->updated_id = $user->id;
            $lead->purpose_id  = $request->purpose_id;
            $lead->branch_id  = $request->branch_id;
            $lead->source_id  = $request->source_id;
            $lead->status_id  = $request->status_id;

            $lead->course_id   = $request->course_id;
            $lead->class   = $request->class;
            $lead->school_name   = $request->school_name;

          

            $lead->save();

            return redirect()->back()->with('success', 'Lead updated successfully.');
        }

        return redirect()->back()->with('error', 'Lead not found.');
    }

    public function deleteLead($id)
    {

         $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    if (!in_array('6_4', $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
        $lead = Lead::find($id);
        if ($lead) {
            $lead->is_deleted = 1;
            $lead->save();
            return redirect()->back()->with('success', 'Lead deleted successfully.');
        }

        return redirect()->back()->with('error', 'Lead not found.');
    }

    public function updateleadStatus(Request $request, $id)
    {
        $lead = Lead::find($id);
        if ($lead) {
            $lead->status = $request->status;
            $lead->save();
            return redirect()->back()->with('success', 'Status updated successfully.');
        }

        return redirect()->back()->with('error', 'Lead not found.');
    }

  public function export(Request $request)
{
    return Excel::download(new LeadExport($request), 'leads.xlsx');
}




    // Helper functions
    public function check_unique_name($key, $value)
    {
        return !Lead::where($key, $value)->exists();
    }

    public function check_unique($key, $value)
    {
        $check = Lead::where($key, $value)->first();
        if (!empty($check)) {
            $value .= '1';
            return $this->check_unique($key, $value);
        }

        return $value;
    }

    public function check_unique_name_edit($key, $value, $id)
    {
        return !Lead::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_email_edit($key, $value, $id)
    {
        return !Lead::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_phone_edit($key, $value, $id)
    {
        return !Lead::where($key, $value)->where('id', '!=', $id)->exists();
    }



  public function getTl($manager_id)
    {
        
        $tls = TeamLeader::where('manager_id', $manager_id)->get();
        return response()->json($tls);
    }

    // TL के आधार पर Telecaller लाना
    public function getTelecaller($tl_id)
    {
        $telecallers = Telecaller::where('tl_id', $tl_id)->get();
        return response()->json($telecallers);
    }
    
  public function distributeLeads(Request $request)
{
    $manager_id     = $request->input('manager_id');
    $tl_id          = $request->input('tl_id');
    $telecaller_id  = $request->input('telecaller_id');
    $leadIds        = $request->input('lead_id');

    $updateData = [
        'assign_to' => 1, 
    ];

        $leadassignManagerId = DB::table('users')
        ->where('manager_id', $manager_id)
        ->where('type','manager')
        ->value('id');

        $leadassignTlId = DB::table('users')
            ->where('tl_id', $tl_id)
            ->where('type','tl')
            ->value('id');

        $leadassignTelecallerId = DB::table('users')
            ->where('telecaller_id', $telecaller_id)
            ->where('type','telecaller')
            ->value('id');

   
    if ($manager_id && !$tl_id && !$telecaller_id) {
        $updateData['lead_assign_id'] = $leadassignManagerId;
        $updateData['manager_id']     = $manager_id;
        $updateData['tl_id']          = null;
        $updateData['telecaller_id']  = null;
    }
   
    elseif ($manager_id && $tl_id && !$telecaller_id) {
        $updateData['lead_assign_id'] = $leadassignTlId;
        $updateData['manager_id']     = $manager_id;
        $updateData['tl_id']          = $tl_id;
        $updateData['telecaller_id']  = null;
    }
   
    elseif ($manager_id && $tl_id && $telecaller_id) {
        $updateData['lead_assign_id'] = $leadassignTelecallerId;
        $updateData['manager_id']     = $manager_id;
        $updateData['tl_id']          = $tl_id;
        $updateData['telecaller_id']  = $telecaller_id;
    }

   
    if (!empty($leadIds)) {
        DB::table('tbl_lead')
            ->whereIn('id', $leadIds)
            ->update($updateData);
    }

    return redirect()->back()->with('success', 'Leads Distributed Successfully.');
}



 public function cancel_lead(Request $request)
{
    $data['menu']    = 'leads';
    $data['submenu'] = 'cancel_lead';

    $r_page = $request->get('r_page', 25);
    $data['r_page'] = $r_page;

    $user = auth()->user(); 

    if($user->type == 'admin'){

   $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
            ->where('tbl_lead_status.status', 'Cancel')
            ->select('tbl_lead.*');
    }else{
        $leads = Lead::where('tbl_lead.is_deleted', 0)
                ->where('tbl_lead.lead_assign_id', $user->id)
                ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
                ->where('tbl_lead_status.status', 'Cancel')
                ->select('tbl_lead.*');
    }


    if ($request->filled('name')) {
        $leads->where('tbl_lead.name', 'like', '%' . $request->name . '%');
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $leads->where('tbl_lead.email', 'like', '%' . $request->email . '%');
        $data['email'] = $request->email;
    }

    if ($request->filled('phone')) {
        $leads->where('tbl_lead.phone', 'like', '%' . $request->phone . '%');
        $data['phone'] = $request->phone;
    }

    if ($request->filled('gender')) {
        $leads->where('tbl_lead.gender', $request->gender);
        $data['gender'] = $request->gender;
    }

    if ($request->filled('date_from')) {
        $leads->whereDate('tbl_lead.created_at', '>=', $request->date_from);
        $data['date_from'] = $request->date_from;
    }

    if ($request->filled('date_to')) {
        $leads->whereDate('tbl_lead.created_at', '<=', $request->date_to);
        $data['date_to'] = $request->date_to;
    }

    $leads = $leads->orderBy('tbl_lead.id', 'DESC')->paginate($r_page);
    $leads->appends($request->all());

    $sources = LeadSource::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $status = LeadStatus::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $purposes  = Purpose::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    return view('backend.lead.cancel_lead', compact('data', 'leads', 'sources','status','purposes'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}


 public function done_lead(Request $request)
{
    $data['menu']    = 'leads';
    $data['submenu'] = 'done_lead';

    $r_page = $request->get('r_page', 25);
    $data['r_page'] = $r_page;

  
    $user = auth()->user(); 

        if($user->type == 'admin'){

            $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
            ->where('tbl_lead_status.status', 'Done')
            ->whereNotNull('admission_id')
            ->where('admission_id', '!=', '')
            ->select('tbl_lead.*');
        }else{
           $leads = Lead::where('tbl_lead.is_deleted', 0)
            ->where('tbl_lead.lead_assign_id', $user->id)
            ->join('tbl_lead_status', 'tbl_lead.status_id', '=', 'tbl_lead_status.id')
            ->where('tbl_lead_status.status', 'Done')
            ->whereNotNull('admission_id')
            ->where('admission_id', '!=', '')
            ->select('tbl_lead.*'); 
        }
   


    if ($request->filled('name')) {
        $leads->where('tbl_lead.name', 'like', '%' . $request->name . '%');
        $data['name'] = $request->name;
    }

    if ($request->filled('email')) {
        $leads->where('tbl_lead.email', 'like', '%' . $request->email . '%');
        $data['email'] = $request->email;
    }

    if ($request->filled('phone')) {
        $leads->where('tbl_lead.phone', 'like', '%' . $request->phone . '%');
        $data['phone'] = $request->phone;
    }

    if ($request->filled('gender')) {
        $leads->where('tbl_lead.gender', $request->gender);
        $data['gender'] = $request->gender;
    }

    if ($request->filled('date_from')) {
        $leads->whereDate('tbl_lead.created_at', '>=', $request->date_from);
        $data['date_from'] = $request->date_from;
    }

    if ($request->filled('date_to')) {
        $leads->whereDate('tbl_lead.created_at', '<=', $request->date_to);
        $data['date_to'] = $request->date_to;
    }

    $leads = $leads->orderBy('tbl_lead.id', 'DESC')->paginate($r_page);
    $leads->appends($request->all());

    $sources = LeadSource::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $status = LeadStatus::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    $purposes  = Purpose::where('is_deleted', '0')
                        ->where('status', 'Active')
                        ->orderBy('id', 'DESC')
                        ->get();

    return view('backend.lead.done_lead', compact('data', 'leads', 'sources','status','purposes'))
        ->with('i', (request()->input('page', 1) - 1) * $r_page);
}





public function add_follow_up(Request $request, $id)
{
    $data['menu'] = "leads";
    $data['submenu'] = "lead";

    $leadStatus = LeadStatus::where('is_deleted', '0')->get();
     $lead = Lead::where('id', $id)->first(); 


   $followup = FollowUp::where('lead_id', $id)->where('is_deleted','0')->paginate(10); 

    return view('backend.lead.add_follow_up', compact("data", "leadStatus", "followup","lead"));
}

public function save_follow_up(Request $request)
{
    
    $data['menu'] = "leadstatus";
    $data['submenu'] = "lead_master";

    $user = Auth::user();

    
    $followUp = new FollowUp();
    $followUp->lead_id = $request->lead_id;
    $followUp->status = $request->status;
    $followUp->comment = $request->comment;
    $followUp->follow_date = $request->follow_date;
    $followUp->follow_by = $user->id;
    $followUp->save();

    
    $lead = Lead::find($request->lead_id);
    if ($lead) {
        $lead->status_id = $request->status;
        $lead->next_followup_date = $request->follow_date;
        $lead->save();
    }

    return redirect()->back()->with('success', 'Follow Up Added Successfully & Lead Updated.');
}



public function delete_followup($id){
    $followupleadUpd = FollowUp::find($id);
    $followupleadUpd->is_deleted = 1;
    $followupleadUpd->save();
    return redirect()->back()->with('success', 'Lead Follow Up has been Deleted successfully.');
  }



  public function add_admission(Request $request, $id)
{
    
  
    $data['menu'] = "leads";
    $data['submenu'] = "lead";

    $leadStatus = LeadStatus::where('is_deleted', '0')->get();
     $lead = Lead::where('id', $id)->first();
   
   

    $courses = Course::where('status','Active')->where('is_deleted',0)->get();
    $branches = Branch::where('status','Active')->where('is_deleted',0)->get();
    
    $admission = Admission::where('id', $lead->admission_id)->first();
    // dd($admission);

    $InstallmentPaymentAdmission = collect(); 

    if ($admission) {
        $InstallmentPaymentAdmission = InstallmentPaymentAdmission::where('admission_id', $admission->id)
            ->where('enrollment_no', $admission->enrollment_no)
            ->get()
            ->map(function ($item) {
                $details = explode(',', $item->installment_details);

                $item->amount = trim(str_replace('Amount:', '', $details[0] ?? ''));
                $item->date   = trim(str_replace('Date:', '', $details[1] ?? ''));
                $item->desc   = trim(str_replace('Desc:', '', $details[2] ?? ''));

                return $item;
            });
    }

                                 
    
    $followup = FollowUp::where('lead_id', $id)->where('is_deleted','0')->paginate(10); 

    return view('backend.lead.add_admission', compact("data", "leadStatus","lead", "followup","admission","courses","branches","InstallmentPaymentAdmission"));
}


public function getCourseDetails(Request $request)
{
    $course = \DB::table('tbl_course')
        ->where('id', $request->id)
        ->where('is_deleted', 0)
        ->first();

    if ($course) {
        return response()->json([
            'duration' => $course->duration,
            'amount' => $course->amount
        ]);
    } else {
        return response()->json(['error' => 'Course not found'], 404);
    }
}


public function getBatchesByBranch(Request $request)
{
    $branchId = $request->branch_id;

    $batches = \DB::table('tbl_batch')
        ->where('branch_id', $branchId)
        ->where('is_deleted', 0)
        ->where('status', 1)
        ->orderBy('name', 'asc')
        ->get(['id', 'name']);

    return response()->json($batches);
}




public function save_admission(Request $request)
{

   


    $data['menu'] = "leads";
    $data['submenu'] = "lead";

    $user = Auth::user();

   
    $admission = Admission::where('lead_id', $request->lead_id)
                          ->where('enrollment_no', $request->enrollment_no)
                          ->first();
    
    if (!$admission) {
        $admission = new Admission();

      
        $enrollmentGenerate = DB::table('tbl_general')->where('id',1)->first();

        $alpha   = $enrollmentGenerate->textable_enrollment_alpha;   
        $numeric = $enrollmentGenerate->textable_enrollment_numeric; 

        
        $enrollment_no = $alpha . $numeric;
        $admission->enrollment_no = $enrollment_no;

      
        $next_number = str_pad((int)$numeric + 1, strlen($numeric), '0', STR_PAD_LEFT);

        DB::table('tbl_general')
            ->where('id', 1)
            ->update(['textable_enrollment_numeric' => $next_number]);

        $admission->enrollment_no = $alpha . $numeric ;
        $admission->status = 'Active';
        $admission->is_deleted = 0;
        $admission->add_id = $user->id;



    } else {
       
        $admission->updated_id = $user->id;
    }

    
      $courseId = $request->course_id;
    $batchId = $request->batch_id;

   
    $courseCode = DB::table('tbl_course')->where('id', $courseId)->pluck('code')->first();

   
    $batchCode = str_pad($batchId, 2, '0', STR_PAD_LEFT);

   
    $lastRollNumber = DB::table('tbl_admission')
        ->where('batch_id', $batchId)
        ->where('course_id', $courseId)
        ->orderBy('id', 'desc')
        ->pluck('roll_number')
        ->first();

        if ($lastRollNumber) {
           
            $lastSerial = (int)substr($lastRollNumber, -4);
            $newSerial = str_pad($lastSerial + 1, 4, '0', STR_PAD_LEFT);
        } else {
           
            $newSerial = '0001';
        }

       
    $rollNumber = $batchCode . $courseCode . $newSerial;


    $admission->roll_number = $rollNumber;


    if (!empty($request->lead_id)) $admission->lead_id = $request->lead_id;
    if (!empty($request->name)) $admission->name = $request->name;
    if (!empty($request->phone)) $admission->phone = $request->phone;
    if (!empty($request->email)) $admission->email = $request->email;
    if (!empty($request->fathername)) $admission->fathername = $request->fathername;
    if (!empty($request->mother_name)) $admission->mother_name = $request->mother_name;
    if (!empty($request->father_phone)) $admission->father_phone = $request->father_phone;
    if (!empty($request->dob)) $admission->dob = $request->dob;
    if (!empty($request->aadhar)) $admission->aadhar = $request->aadhar;
    if (!empty($request->state)) $admission->state = $request->state;
    if (!empty($request->city)) $admission->city = $request->city;
    if (!empty($request->address)) $admission->address = $request->address;
    if (!empty($request->pincode)) $admission->pincode = $request->pincode;

   
    if (!empty($request->high_quali)) $admission->high_quali = $request->high_quali;
    if (!empty($request->board)) $admission->board = $request->board;
     if (!empty($request->session_start))$admission->session_start     = $request->session_start;
      if (!empty($request->session_end)) $admission->session_end       = $request->session_end;
   
    if (!empty($request->main_subject)) $admission->main_subject = $request->main_subject;
    if (!empty($request->mark_obtain)) $admission->mark_obtain = $request->mark_obtain;

   
    if (!empty($request->course_id)) $admission->course_id = $request->course_id;
    if (!empty($request->duration)) $admission->duration = $request->duration;
    if (!empty($request->course_fees)) $admission->course_fees = $request->course_fees;
    if (!empty($request->discount_fees)) $admission->discount_fees = $request->discount_fees;
    if (!empty($request->branch_id)) $admission->branch_id = $request->branch_id;
    if (!empty($request->batch_id)) $admission->batch_id = $request->batch_id;

   
    if (!empty($request->admission_date)) $admission->admission_date = $request->admission_date;
    if (!empty($request->net_chargeable_amount)) $admission->net_chargeable_amount = $request->net_chargeable_amount;
    if (!empty($request->initial_pay)) $admission->initial_pay = $request->initial_pay;
    if (!empty($request->initial_pay_mode)) $admission->initial_pay_mode = $request->initial_pay_mode;
    if (!empty($request->initial_pay_date)) $admission->initial_pay_date = $request->initial_pay_date;
    if (!empty($request->pay_initial_desc)) $admission->pay_initial_desc = $request->pay_initial_desc;
    if (!empty($request->balance_amount)) $admission->balance_amount = $request->balance_amount;


    
if ($request->hasFile('photo')) {
    $file = $request->file('photo');
    $filename = time() . '_photo.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads'), $filename);
    $admission->photo = $filename;
}


if ($request->hasFile('id_proof')) {
    $file = $request->file('id_proof');
    $filename = time() . '_idproof.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads'), $filename);
    $admission->id_proof = $filename;
}


if ($request->hasFile('certificate')) {
    $file = $request->file('certificate');
    $filename = time() . '_certificate.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads'), $filename);
    $admission->certificate = $filename;
}

  
    $admission->save();
    
        $doneStatus = DB::table('tbl_lead_status')->where('status', 'Done')->first();

               
    $lead = Lead::find($request->lead_id);
    if ($lead && $doneStatus) {
        $lead->status_id = $doneStatus->id; 
        $lead->admission_id = $admission->id; 
        $lead->save();
    }


   
    if (!empty($request->installment_amount)) {

       
        $oldInstallments = InstallmentPaymentAdmission::where('admission_id', $admission->id)->get();
        if ($oldInstallments) {
            foreach ($oldInstallments as $old) {
                $old->delete();
            }
        }

        foreach ($request->installment_amount as $key => $amount) {
            if (!empty($amount)) {
                $installment = new InstallmentPaymentAdmission();
                $installment->lead_id = $admission->lead_id;
                $installment->enrollment_no = $admission->enrollment_no;
                $installment->admission_id = $admission->id;
                $installment->installment_details = "Amount: ".$amount.
                                                    ", Date: ".$request->installment_date[$key].
                                                    ", Desc: ".$request->installment_desc[$key];
               
                $installment->installment_date = $request->installment_date[$key];                             
                $installment->add_id = $user->id;
                $installment->save();

               
                $doneStatus = DB::table('tbl_lead_status')->where('status', 'Done')->first();

               
                $lead = Lead::find($request->lead_id);
                if ($lead && $doneStatus) {
                    $lead->status_id = $doneStatus->id; 
                    $lead->admission_id = $admission->id; 
                    $lead->save();
                }
            }
        }
    }

   return redirect()->route('student_list')->with('success', 'Admission Saved Successfully');

}



public function studentIdCard($id)
{
    $student = Admission::findOrFail($id);

    
    $qrData = url('/verify-student/' . $student->id);

    
    $options = new QROptions([
        'version'     => QRCode::VERSION_AUTO, 
        'outputType'  => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel'    => QRCode::ECC_L,
        'scale'       => 5,
        'imageBase64' => true,
    ]);

    
    $qrCode = (new QRCode($options))->render($qrData);

     $id_card = DB::table('tbl_general')
    ->where('id', 1)
    ->value('id_card');

    $pdf = Pdf::loadView(
        'backend.lead.student_id_card',
        compact('student', 'qrCode','id_card')
    )->setPaper([0, 0, 360, 750]);

    return $pdf->download('ID_Card_'.$student->name.'.pdf');
}

 public function student_add(Request $request)
{
    $data['menu'] = "students";
    $data['submenu'] = "student_add";

 
    $session = Session::where('status','Active')->where('is_deleted',0)->get();
    $grade = Grade::where('status','Active')->where('is_deleted',0)->orderBy('orders_by')->get();

    return view('backend.lead.add_student', compact("data","session","grade"));
}

// Edit student - show form with existing data
public function student_edit($id)
{
    $data['menu'] = "students";
    $data['submenu'] = "student_add";

   
    $session = Session::where('status','Active')->where('is_deleted',0)->get();
    $grade = Grade::where('status','Active')->where('is_deleted',0)->orderBy('orders_by')->get();

    $student = Admission::where('id', $id)->where('is_deleted',0)->firstOrFail();

    return view('backend.lead.add_student', compact("data","session","grade","student"));
}



    public function getEnrollmentNo(Request $request)
{
    $enrollment = DB::table('tbl_general')->where('id', 1)->first();

    return response()->json([
        'enrollment_no' => $enrollment->textable_enrollment_alpha . $enrollment->textable_enrollment_numeric
    ]);
}

public function getSections($grade_id)
{
    $user = Auth::user();
    if ($user->type == 'teacher') {
        $teacher = DB::table('tbl_teacher')
            ->where('email', $user->email)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();
        if ($teacher) {
            $sections = DB::table('tbl_teacher_assign as ta')
                ->join('tbl_section as s', 's.id', '=', 'ta.section_id')
                ->select('s.id', 's.name')
                ->where('ta.teacher_id', $teacher->id)
                ->where('ta.grade_id', $grade_id)
                ->where('s.status', 'Active')
                ->where('s.is_deleted', 0)
                ->distinct()
                ->get();
            return response()->json($sections);
        }
    }
    $sections = DB::table('tbl_section')
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->whereRaw("FIND_IN_SET(?, grade_id)", [$grade_id])
        ->get();
    return response()->json($sections);
}

public function student_save(Request $request)
{
    $request->validate([
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'school_admission_no' => 'nullable|string|max:100',
        'admission_date' => 'nullable|date',
    ]);

    $user = Auth::user();

    if($request->id){ // Edit case
        $admission = Admission::findOrFail($request->id);

        // ✅ Updated By
        $admission->updated_id = $user->id;

    } else { // Add case

        $enrollmentGenerate = DB::table('tbl_general')->where('id', 1)->first();
        $alpha   = $enrollmentGenerate->textable_enrollment_alpha;
        $numeric = $enrollmentGenerate->textable_enrollment_numeric;
        $admission_no = $alpha . $numeric;

        $lastRollNumber = DB::table('tbl_admission')
            ->orderBy('id', 'desc')
            ->pluck('roll_number')
            ->first();

        if ($lastRollNumber) {
            $lastSerial = (int)substr($lastRollNumber, -4);
            $newSerial = str_pad($lastSerial + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSerial = '0001';
        }

        $rollNumber = $newSerial;

        $admission = new Admission();
        $admission->admission_no = $admission_no;
        $admission->roll_number  = $rollNumber;
        $admission->status       = 'Active';
        $admission->is_deleted   = 0;
        $admission->add_id       = $user->id;

        // 👉 Admission Date
        $admission->admission_date = Carbon::now();

        // Update next enrollment
        $next_number = str_pad((int)$numeric + 1, strlen($numeric), '0', STR_PAD_LEFT);
        DB::table('tbl_general')
            ->where('id', 1)
            ->update(['textable_enrollment_numeric' => $next_number]);
    }

    // Common fields
    $admission->first_name     = $request->first_name ?? null;
    $admission->middle_name    = $request->middle_name ?? null;
    $admission->last_name      = $request->last_name ?? null;
    $admission->father_name          = $request->father_name ?? null;
    $admission->mother_name          = $request->mother_name ?? null;
    $admission->phone          = $request->phone ?? null;
    $admission->email          = $request->email ?? null;
    $admission->session_id     = $request->session_id ?? null;
    $admission->grade_id       = $request->grade_id ?? null;
    $admission->section_id     = $request->section_id ?? null;
    $admission->dob_bs         = $request->dob_bs ?? null;
    $admission->dob_ad         = $request->dob_ad ?? null;
    $admission->iemis_no       = $request->iemis_no ?? null;
    $admission->state          = $request->state ?? null;
    $admission->city           = $request->city ?? null;
    $admission->address        = $request->address ?? null;
    $admission->pincode        = $request->pincode ?? null;
    $admission->nickname       = $request->nickname ?? null;
    $admission->gender         = $request->gender ?? null;
    $admission->blood_group    = $request->blood_group ?? null;
    $admission->nationality    = $request->nationality ?? null;
    $admission->ethnicity      = $request->ethnicity ?? null;
    $admission->mother_tongue  = $request->mother_tongue ?? null;
    $admission->contact        = $request->contact ?? null;
    $admission->religion       = $request->religion ?? null;
    $admission->school_admission_no = $request->school_admission_no ?? null;
    $admission->admission_date = $request->filled('admission_date')
        ? $request->admission_date
        : ($admission->admission_date ?? Carbon::now());

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_photo.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
        $admission->photo = $filename;
    }

    $admission->save();

    return redirect()->back()->with(
        'success',
        $request->id ? 'Admission Updated Successfully' : 'Admission Saved Successfully'
    );
}



public function student_bulk_upload_form()
{
    $data['menu'] = "students";
    $data['submenu'] = "student_bulk_upload";

    $session = Session::where('status','Active')->where('is_deleted',0)->get();
    $grade   = Grade::where('status','Active')->where('is_deleted',0)->orderBy('orders_by')->get();

    return view('backend.lead.bulk_upload_student', compact('data','session','grade'));
}


public function student_bulk_upload_save(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,csv',
        'session_id' => 'required',
    ]);

    try {

        $import = new StudentsImport(
            $request->session_id
        );

        Excel::import($import, $request->file('file'));

        return back()->with([
            'success'  => 'Upload Completed!',
            'inserted' => $import->inserted,
            'skipped'  => $import->skipped,
        ]);

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

public function student_list(Request $request)
{
    $data['menu'] = 'students';
    $data['submenu'] = 'student_list';

    $r_page = $request->input('r_page', 25);
    $user = auth()->user();

    $query = DB::table('tbl_admission')
        ->leftJoin('tbl_session', 'tbl_session.id', '=', 'tbl_admission.session_id')
        ->leftJoin('tbl_grade', 'tbl_grade.id', '=', 'tbl_admission.grade_id')
        ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_admission.section_id')
        ->leftJoin('users as added_by', 'added_by.id', '=', 'tbl_admission.add_id')
        ->leftJoin('users as updated_by', 'updated_by.id', '=', 'tbl_admission.updated_id')
        ->select(
            'tbl_admission.*',
            'tbl_session.name as session_name',
            'tbl_grade.name as grade_name',
            'tbl_section.name as section_name',
            'added_by.name as added_by_name',
            'updated_by.name as updated_by_name'
        )
        ->where('tbl_admission.status', 'Active')
        ->where('tbl_admission.is_deleted', 0);

    // Role check
    if (!empty($user) && $user->type != 'admin') {
        $query->where('tbl_admission.add_id', $user->id);
    }

    // Date filter
    if (!empty($request->date_from)) {
        $query->whereDate('tbl_admission.created_at', '>=', $request->date_from);
    }

    if (!empty($request->date_to)) {
        $query->whereDate('tbl_admission.created_at', '<=', $request->date_to);
    }

 $students = $query->orderByDesc('tbl_admission.id')->get();
 
 
 
$user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];

    return view('backend.lead.student_list', compact('students', 'data', 'permExplodesub'))
        ->with('i', ($request->input('page', 1) - 1) * $r_page);
}


public function student_list_transfer(Request $request)
{
    $data['menu'] = 'students';
    $data['submenu'] = 'student_list_transfer';

    $r_page = $request->input('r_page', 25);
    $user = auth()->user();

    $query = DB::table('tbl_admission')
        ->leftJoin('tbl_session', 'tbl_session.id', '=', 'tbl_admission.session_id')
        ->leftJoin('tbl_grade', 'tbl_grade.id', '=', 'tbl_admission.grade_id')
        ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_admission.section_id')
        ->leftJoin('users as added_by', 'added_by.id', '=', 'tbl_admission.add_id')
        ->leftJoin('users as updated_by', 'updated_by.id', '=', 'tbl_admission.updated_id')
        ->select(
            'tbl_admission.*',
            'tbl_session.name as session_name',
            'tbl_grade.name as grade_name',
            'tbl_section.name as section_name',
            'added_by.name as added_by_name',
            'updated_by.name as updated_by_name'
        )
        ->where('tbl_admission.status', 'Transfer')
        ->where('tbl_admission.is_deleted', 0);

    // Role check
    if (!empty($user) && $user->type != 'admin') {
        $query->where('tbl_admission.add_id', $user->id);
    }

    // Date filter
    if (!empty($request->date_from)) {
        $query->whereDate('tbl_admission.created_at', '>=', $request->date_from);
    }

    if (!empty($request->date_to)) {
        $query->whereDate('tbl_admission.created_at', '<=', $request->date_to);
    }

    $students = $query->orderByDesc('tbl_admission.id')->get();
    
    
$user = auth()->user();

    
    $permExplodesub = $user->permission_submenu 
        ? explode(",", $user->permission_submenu) 
        : [];

    return view('backend.lead.student_list_transfer', compact('students', 'data', 'permExplodesub'))
    
        ->with('i', ($request->input('page', 1) - 1) * $r_page);
}




public function transfer_certificate(Request $request)
{
    $data['menu'] = "transfer_certificate";
    $data['submenu'] = "transfer_certificate";

    $student = null;

    if ($request->has('id')) {
        $student = DB::table('tbl_admission')
            ->leftJoin('tbl_grade', 'tbl_grade.id', '=', 'tbl_admission.grade_id')
            ->select(
                'tbl_admission.*',
                'tbl_grade.name as grade_name'
            )
            ->where('tbl_admission.id', $request->id)
            ->first();

        if ($student) {
            DB::table('tbl_admission')
                ->where('id', $request->id)
                ->update([
                    'status' => 'Transfer',
                    'transfer_date' => now(), 
                    'updated_at' => now()
                ]);
        }
    }

    return view('backend.lead.transfer_certificate', compact('data', 'student'));
}


public function save_transfer_certificate(Request $request)
{
    try {

        \DB::table('tbl_transfer_certificate')->updateOrInsert(

           
            [
                'student_id' => $request->student_id ?? null,
                'serial_no'  => $request->serial_no
            ],

            [
                'student_id' => $request->student_id ?? null, 
                'serial_no' => $request->serial_no,
                'iemis_no' => $request->iemis_no,
                'principal_name' => $request->principal_name,
                'signature_text' => $request->signature_text,
                'admission_no' => $request->admission_no,
                'student_name' => $request->student_name,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,

                'admission_date_bs' => $request->admission_date_bs,
                'admission_date_ad' => $request->admission_date_ad,

                'dob_bs' => $request->dob_bs,
                'dob_ad' => $request->dob_ad,

                'last_grade' => $request->last_grade,
                'is_promoted' => $request->is_promoted,
                'promoted_grade' => $request->promoted_grade,
                'dues_paid' => $request->dues_paid,

                'eca' => $request->eca,
                'general_character' => $request->general_character,
                'reason' => $request->reason,

                'issue_date_bs' => $request->issue_date_bs,
                'issue_date_ad' => $request->issue_date_ad,

                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Saved Successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}



public function transfer_list(Request $request)
{
    $data['menu'] = 'transfer_certificate';
    $data['submenu'] = 'transfer_list';

    $r_page = $request->input('r_page', 25);

    $query = DB::table('tbl_transfer_certificate');

  
    if (!empty($request->date_from)) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if (!empty($request->date_to)) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $transfers = $query->orderByDesc('tbl_transfer_certificate.id')->get();
   
    $user = Auth::user();
    $permExplodesub = explode(',', $user->permission_submenu ?? '');

    
    return view('backend.lead.transfer_list', compact('transfers', 'data','permExplodesub'))
        ->with('i', ($request->input('page', 1) - 1) * $r_page);
}




public function transfer_edit($id)
{
    $data['menu'] = 'transfer_certificate';
    $data['submenu'] = 'transfer_list_edit';

    $transfer = DB::table('tbl_transfer_certificate')
        ->where('id', $id)
        ->first();

    if (!$transfer) {
        return redirect()->back()->with('error', 'Record not found');
    }

    return view('backend.lead.transfer_edit', compact('transfer', 'data'));
}

public function transfer_save(Request $request)
{
    // Prepare the data array
    $data = [
        'serial_no' => $request->serial_no,
        'admission_no' => $request->admission_no,
        'student_name' => $request->student_name,
        'father_name' => $request->father_name,
        'mother_name' => $request->mother_name,
        'admission_date_bs' => $request->admission_date_bs,
        'admission_date_ad' => $request->admission_date_ad,
        'dob_bs' => $request->dob_bs,
        'dob_ad' => $request->dob_ad,
        'last_grade' => $request->last_grade,
        'is_promoted' => $request->is_promoted,
        'promoted_grade' => $request->promoted_grade,
        'dues_paid' => $request->dues_paid,
        'eca' => $request->eca,
        'general_character' => $request->general_character,
        'reason' => $request->reason,
        'issue_date_bs' => $request->issue_date_bs,
        'issue_date_ad' => $request->issue_date_ad,
        'updated_at' => now()
    ];

    // Check if this is an update or insert
    if (!empty($request->id)) {
        // UPDATE existing record
        DB::table('tbl_transfer_certificate')
            ->where('id', $request->id)
            ->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Transfer Certificate Updated Successfully',
            'data' => ['id' => $request->id]
        ]);
    } 
    
    // INSERT new record
    // Generate a new student_id if not provided
    if (empty($request->student_id)) {
        // Get max student_id and increment
        $maxStudentId = DB::table('tbl_transfer_certificate')->max('student_id');
        $data['student_id'] = $maxStudentId + 1;
    } else {
        $data['student_id'] = $request->student_id;
    }
    
    $data['created_at'] = now();
    
    $insertId = DB::table('tbl_transfer_certificate')->insertGetId($data);

    return response()->json([
        'status' => true,
        'message' => 'Transfer Certificate Created Successfully',
        'data' => [
            'id' => $insertId,
            'student_id' => $data['student_id']
        ]
    ]);
}




public function transfer_certificate_10th(Request $request)
{
    $data['menu'] = "transfer_certificate";
    $data['submenu'] = "transfer_certificate_10th";
 
    $student = null;
 
    if ($request->has('id')) {
        $student = DB::table('tbl_admission')
            ->leftJoin('tbl_grade', 'tbl_grade.id', '=', 'tbl_admission.grade_id')
            ->select(
                'tbl_admission.*',
                'tbl_grade.name as grade_name'
            )
            ->where('tbl_admission.id', $request->id)
            ->first();
 
        if ($student) {
            DB::table('tbl_admission')
                ->where('id', $request->id)
                ->update([
                    'status'        => 'Transfer',
                    'transfer_date' => now(),
                    'updated_at'    => now()
                ]);
            // Re-fetch updated record
            $student = DB::table('tbl_admission')
                ->leftJoin('tbl_grade', 'tbl_grade.id', '=', 'tbl_admission.grade_id')
                ->select('tbl_admission.*', 'tbl_grade.name as grade_name')
                ->where('tbl_admission.id', $request->id)
                ->first();
        }
    }
 
    return view('backend.lead.transfer_certificate_10th', compact('data', 'student'));
}
 
/**
 * Save 10th Transfer Certificate
 */
public function save_transfer_certificate_10th(Request $request)
{
    try {
        \DB::table('tbl_transfer_certificate_10th')->updateOrInsert(
            [
                'student_id' => $request->student_id ?? null,
                'serial_no'  => $request->serial_no,
            ],
            [
                'student_id'      => $request->student_id ?? null,
                'serial_no'       => $request->serial_no,
                'admission_no'    => $request->admission_no,
                'student_name'    => $request->student_name,
                'father_name'     => $request->father_name,
                'mother_name'     => $request->mother_name,
                'gender'          => $request->gender,         
                'iemis_no' => $request->iemis_no,
                'ward_no'         => $request->ward_no,
                'city'            => $request->city,
                'district'        => $request->district,
                'province'        => $request->province,
                'country'         => $request->country ?? 'Nepal',
                'exam_year'       => $request->exam_year,
                'gpa'             => $request->gpa,
                'dob_bs'          => $request->dob_bs,
                'dob_ad'          => $request->dob_ad,
                'symbol_no'       => $request->symbol_no,
                'issue_date'      => $request->issue_date,
                'principal_name'  => $request->principal_name,
                'prepared_by'     => $request->prepared_by,
                'updated_at'      => now(),
                'created_at'      => now(),
            ]
        );
 
        return response()->json([
            'status'  => true,
            'message' => 'Saved Successfully'
        ]);
 
    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ]);
    }
}
 
/**
 * List of 10th Transfer Certificates
 */
public function transfer_list_10th(Request $request)
{
    $data['menu']    = 'transfer_certificate';
    $data['submenu'] = 'transfer_list_10th';
 
    $r_page = $request->input('r_page', 25);
 
    $query = DB::table('tbl_transfer_certificate_10th');
 
    if (!empty($request->date_from)) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    if (!empty($request->date_to)) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }
    if (!empty($request->search)) {
        $query->where(function($q) use ($request) {
            $q->where('student_name', 'like', '%'.$request->search.'%')
              ->orWhere('admission_no', 'like', '%'.$request->search.'%')
              ->orWhere('symbol_no', 'like', '%'.$request->search.'%');
        });
    }
 
    $transfers = $query->orderByDesc('id')->get();
 
    $user            = Auth::user();
    $permExplodesub  = explode(',', $user->permission_submenu ?? '');
 
    return view('backend.lead.transfer_list_10th', compact('transfers', 'data', 'permExplodesub'))
        ->with('i', ($request->input('page', 1) - 1) * $r_page);
}
 
/**
 * Edit form for 10th Transfer Certificate
 */
public function transfer_edit_10th($id)
{
    $data['menu']    = 'transfer_certificate';
    $data['submenu'] = 'transfer_list_10th';
 
    $transfer = DB::table('tbl_transfer_certificate_10th')
        ->where('id', $id)
        ->first();
 
    if (!$transfer) {
        return redirect()->back()->with('error', 'Record not found');
    }
 
    return view('backend.lead.transfer_certificate_10th', compact('transfer', 'data'));
}
 
/**
 * Save (update/insert) from Edit page
 */
public function transfer_save_10th(Request $request)
{
    $payload = [
        'serial_no'      => $request->serial_no,
        'admission_no'   => $request->admission_no,
        'student_name'   => $request->student_name,
        'father_name'    => $request->father_name,
        'mother_name'    => $request->mother_name,
        'gender'         => $request->gender,
        'ward_no'        => $request->ward_no,
        'city'           => $request->city,
        'district'       => $request->district,
        'province'       => $request->province,
        'country'        => $request->country ?? 'Nepal',
        'exam_year'      => $request->exam_year,
        'gpa'            => $request->gpa,
        'dob_bs'         => $request->dob_bs,
        'dob_ad'         => $request->dob_ad,
        'symbol_no'      => $request->symbol_no,
        'issue_date'     => $request->issue_date,
        'principal_name' => $request->principal_name,
        'prepared_by'    => $request->prepared_by,
        'updated_at'     => now(),
    ];
 
    if (!empty($request->id)) {
        DB::table('tbl_transfer_certificate_10th')
            ->where('id', $request->id)
            ->update($payload);
 
        return response()->json([
            'status'  => true,
            'message' => '10th Transfer Certificate Updated Successfully',
            'data'    => ['id' => $request->id]
        ]);
    }
 
    // INSERT
    if (empty($request->student_id)) {
        $maxStudentId       = DB::table('tbl_transfer_certificate_10th')->max('student_id');
        $payload['student_id'] = ($maxStudentId ?? 0) + 1;
    } else {
        $payload['student_id'] = $request->student_id;
    }
    $payload['created_at'] = now();
 
    $insertId = DB::table('tbl_transfer_certificate_10th')->insertGetId($payload);
 
    return response()->json([
        'status'  => true,
        'message' => '10th Transfer Certificate Created Successfully',
        'data'    => [
            'id'         => $insertId,
            'student_id' => $payload['student_id']
        ]
    ]);
}


public function promote()
{
    $data['menu'] = 'students';
    $data['submenu'] = 'student_promote';

    $students = DB::table('tbl_admission')
        ->where('status', 'Active')
        ->where('is_deleted', 0)
        ->get();

    $session = Session::where('status','Active')->where('is_deleted',0)->get();
    $grade = Grade::where('status','Active')->where('is_deleted',0)->orderBy('orders_by')->get();

    return view('backend.lead.promote', compact('students', 'data','session', 'grade'));
}

public function getStudents(Request $request)
{
    $query = DB::table('tbl_admission as a')
        ->leftJoin('tbl_grade as g', 'g.id', '=', 'a.grade_id')
        ->leftJoin('tbl_section as s', 's.id', '=', 'a.section_id')
        ->select(
            'a.id',
            'a.admission_no',
            'a.status',
            'g.name as grade_name',
            's.name as section_name',
            DB::raw("TRIM(CONCAT(a.first_name,' ',IFNULL(a.middle_name,''),' ',a.last_name)) as student_name")
        )
        ->where('a.session_id', $request->session_id)
        ->where('a.status', 'Active')
        ->where('a.is_deleted', 0);
 
    if ($request->grade_id !== 'all') {
        $query->where('a.grade_id', $request->grade_id);
        if ($request->section_id) {
            $query->where('a.section_id', $request->section_id);
        }
    }
    return response()->json($query->get());
}




public function getExamSubjectSummary(Request $request)
{
    $exam_id  = $request->exam_id;
    $grade_id = $request->grade_id;
 
    if (!$exam_id || !$grade_id) {
        return response()->json(['total' => 0, 'included' => 0, 'excluded' => 0, 'subjects' => []]);
    }
 
    $all = DB::table('tbl_exam_subject_marks as esm')
        ->join('tbl_subject as s', 's.id', '=', 'esm.subject_id')
        ->where('esm.exam_id', $exam_id)
        ->where('esm.grade_id', $grade_id)
        ->where('esm.is_deleted', 0)
        ->select(
            'esm.subject_id',
            's.name as subject_name',
            'esm.is_included',
            'esm.marks',
            'esm.practical_marks'
        )
        ->orderBy('esm.is_included', 'DESC')
        ->orderBy('s.name')
        ->get();
 
    return response()->json([
        'total'    => $all->count(),
        'included' => $all->where('is_included', 1)->count(),
        'excluded' => $all->where('is_included', 0)->count(),
        'subjects' => $all
    ]);
}
 

public function getStudentMarks(Request $request)
{
    $marks = DB::table('tbl_student_marks')
        ->where('exam_id', $request->exam_id)
        ->where('subject_id', $request->subject_id)
        ->where('session_id', $request->session_id)
        ->where('grade_id', $request->grade_id)
        ->where('section_id', $request->section_id)
        ->where('is_deleted', 0)
        ->get()
        ->keyBy('student_id')
        ->map(function($item) {
            return [
                'obtained_mark' => $item->obtained_mark,
                'obtained_practical_mark' => $item->obtained_practical_mark,
                'max_mark' => $item->max_mark,
                'max_practical_mark' => $item->max_practical_mark,
                'is_absent_theory' => $item->is_absent_theory == 1,
                'is_absent_practical' => $item->is_absent_practical == 1
            ];
        });
    return response()->json($marks);
}
public function storePromote(Request $request)
{
    
    $request->validate([
        'student_ids' => 'required|array',
        'session_id' => 'required',
        'grade_id' => 'required',
        'section_id' => 'required',
    ]);

    foreach ($request->student_ids as $student_id) {

        
        $student = DB::table('tbl_admission')->where('id', $student_id)->first();

        if ($student) {

            // 1. LOG SAVE
            DB::table('tbl_promotion_log')->insert([
                'student_id' => $student->id,
                'from_session_id' => $student->session_id,
                'from_grade_id' => $student->grade_id,
                'from_section_id' => $student->section_id,
                'to_session_id' => $request->session_id,
                'to_grade_id' => $request->grade_id,
                'to_section_id' => $request->section_id,
                'promoted_at' => now()
            ]);

            DB::table('tbl_admission')
                ->where('id', $student->id)
                ->update([
                    'session_id' => $request->session_id,
                    'grade_id' => $request->grade_id,
                    'section_id' => $request->section_id,
                    'updated_at' => now()
                ]);
        }
    }

    return redirect()->back()->with('success', 'Students promoted successfully 🚀');
}


public function generate_admitcard(Request $request)
{
    $data['menu'] = 'students';
    $data['submenu'] = 'generate_admitcard';

    $courses = DB::table('tbl_course')
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->orderBy('orders_by', 'DESC')
        ->get();

    return view('backend.lead.generate_admitcard', compact('data', 'courses'));
}




public function generate_result(Request $request)
{
  
    $data['menu'] = 'students';
    $data['submenu'] = 'generate_result';

    $courses = DB::table('tbl_course')
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->orderBy('orders_by', 'DESC')
        ->get();

    return view('backend.lead.generate_result', compact('data', 'courses'));
}





public function generate_final_result(Request $request)
{
  
    $data['menu'] = 'students';
    $data['submenu'] = 'generate_final_result';

    $courses = DB::table('tbl_course')
        ->where('is_deleted', 0)
        ->where('status', 'Active')
        ->orderBy('orders_by', 'DESC')
        ->get();

    return view('backend.lead.generate_final_result', compact('data', 'courses'));
}

public function save_generate_final_result(Request $request)
{
    $request->validate([
        'course_id'         => 'required',
        'session_start'     => 'required',
        'selected_students' => 'required|array|min:1',
    ]);

    $course_id = $request->course_id;
    $session   = $request->session_start;
    $students  = $request->selected_students;

    DB::beginTransaction();

    $alreadyGenerated = [];

    foreach ($students as $student_id) {

       
        $existing = DB::table('tbl_final_results')
            ->where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->where('session_start', $session)
            ->first();

        if ($existing) {
           
            $alreadyGenerated[] = $student_id;
            continue;
        }

        
        $sr = DB::table('tbl_general')
            ->where('id', 1)
            ->lockForUpdate()
            ->first();

       
        $final_marksheet_no =
            $sr->final_marksheet_alpha . $sr->final_marksheet_numeric;

        DB::table('tbl_general')->where('id', 1)->update([
            'final_marksheet_numeric' =>
                str_pad(
                    ((int)$sr->final_marksheet_numeric + 1),
                    strlen($sr->final_marksheet_numeric),
                    '0',
                    STR_PAD_LEFT
                )
        ]);

       
        $final_certificate_no =
            $sr->certificate_alpha . $sr->certificate_numeric;

        DB::table('tbl_general')->where('id', 1)->update([
            'certificate_numeric' =>
                str_pad(
                    ((int)$sr->certificate_numeric + 1),
                    strlen($sr->certificate_numeric),
                    '0',
                    STR_PAD_LEFT
                )
        ]);

      
        DB::table('tbl_final_results')->insert([
            'student_id'            => $student_id,
            'course_id'             => $course_id,
            'session_start'         => $session,
            'final_marksheet_no'    => $final_marksheet_no,
            'final_certificate_no'  => $final_certificate_no,
            'status'                => 'generated',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }

    DB::commit();

   
    if (count($alreadyGenerated) === count($students)) {
        return back()->with('warning',
            'Already you have regenerated the final result for selected student(s).'
        );
    }

    if (!empty($alreadyGenerated)) {
        return back()->with('info',
            'Some students were already generated, remaining generated successfully.'
        );
    }

    return back()->with('success', 'Final result generated successfully.');
}


public function downloadFinalMarksheet($student_id, $course_id, $session)
{
 
    $final = DB::table('tbl_final_results')
        ->where('student_id', $student_id)
        ->where('course_id', $course_id)
        ->where('session_start', $session)
        ->first();

    if (!$final) {
        return back()->with('error', 'Final result not generated for this student.');
    }

   
    $results = DB::table('tbl_results')
        ->join('tbl_exam', 'tbl_exam.id', '=', 'tbl_results.exam_id')
        ->join('tbl_subject', 'tbl_subject.id', '=', 'tbl_results.subject_id')
        ->where('tbl_results.student_id', $student_id)
        ->where('tbl_results.course_id', $course_id)
        ->where('tbl_results.session_start', $session)
        ->select(
            'tbl_exam.id as exam_id',
            'tbl_exam.name as exam_name',
            'tbl_subject.name as subject_name',
            'tbl_results.max_mark',
            'tbl_results.passing_mark',
            'tbl_results.obtained_mark'
        )
        ->orderBy('tbl_exam.id')
        ->get()
        ->groupBy('exam_id');

    if ($results->isEmpty()) {
        return back()->with('error', 'No exam results found for final marksheet.');
    }

   
    $grandMax = $results->flatten()->sum('max_mark');
    $grandObt = $results->flatten()->sum('obtained_mark');

    $percentage = $grandMax > 0
        ? round(($grandObt / $grandMax) * 100, 2)
        : 0;

    $grade = DB::table('tbl_grades')
        ->where('min_percent', '<=', $percentage)
        ->where('max_percent', '>=', $percentage)
        ->first();

  
    $student = DB::table('tbl_admission')->where('id', $student_id)->first();
    $course  = DB::table('tbl_course')->where('id', $course_id)->first();

     $marksheet = DB::table('tbl_general')
    ->where('id', 1)
    ->value('marksheet');
   
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'backend.lead.final-marksheet-pdf',
        compact(
            'final',
            'results',
            'student',
            'course',
            'grandMax',
            'grandObt',
            'percentage',
            'grade',
            'marksheet'
        )
    )->setPaper('A4', 'portrait');

    return $pdf->download(
        'Final-Marksheet-' . $final->final_marksheet_no . '.pdf'
    );
}

public function downloadCertificate($student_id, $course_id, $session)
{
    
    $final = DB::table('tbl_final_results')
        ->where([
            'student_id'    => $student_id,
            'course_id'     => $course_id,
            'session_start' => $session
        ])->first();

    if (!$final) {
        return back()->with('error', 'Certificate not available. Final result not completed.');
    }

  
    $results = DB::table('tbl_results')
        ->where([
            'student_id'    => $student_id,
            'course_id'     => $course_id,
            'session_start' => $session
        ])->get();

    if ($results->isEmpty()) {
        return back()->with('error', 'Marks not found.');
    }

  
    $grandMax = $results->sum('max_mark');
    $grandObt = $results->sum('obtained_mark');

    $percentage = $grandMax > 0
        ? round(($grandObt / $grandMax) * 100, 2)
        : 0;

    
    $grade = DB::table('tbl_grades')
        ->where('min_percent', '<=', $percentage)
        ->where('max_percent', '>=', $percentage)
        ->first();

   
    $student = DB::table('tbl_admission')
        ->where('id', $student_id)
        ->where('is_deleted', 0)
        ->first();

    $course = DB::table('tbl_course')
        ->where('id', $course_id)
        ->first();

   
    $certificate_no = $final->final_certificate_no
        ?? '' ;

  $certificate = DB::table('tbl_general')
    ->where('id', 1)
    ->value('certificate');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'backend.lead.certificate-pdf',
        compact(
            'student',
            'course',
            'final',
            'certificate_no',
            'grandMax',
            'grandObt',
            'percentage',
            'grade',
            'certificate'
        )
    )->setPaper('A4', 'portrait');

    return $pdf->download('Certificate-' . $student->enrollment_no . '.pdf');
}


public function getStudentsBySessionCourse(Request $request)
{
      $students = DB::table('tbl_admission')
                ->where('session_start', $request->session_start)
                ->where('course_id', $request->course_id)
                ->where('is_deleted', 0)
                ->get();

    return response()->json($students);

    
}
public function save_result(Request $request)
{
    $request->validate([
        'course_id' => 'required',
        'exam_id' => 'required',
        'session_start' => 'required',
        'selected_subjects' => 'required|array|min:1'
    ]);

    $course_id    = $request->course_id;
    $exam_id      = $request->exam_id;
    $session_year = $request->session_start;

    $selectedSubjects = $request->selected_subjects;  
    $subjects_max     = $request->max_mark;
    $subjects_pass    = $request->passing_mark;
    $students_marks   = $request->obtained_mark;

    foreach ($students_marks as $student_id => $obt_mark) {

      
        $existing = DB::table('tbl_results')
            ->where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->where('exam_id', $exam_id)
            ->first();

        if ($existing) {
            $marksheet_no = $existing->marksheet_no;
        } else {

            $sr = DB::table('tbl_general')->where('id', 1)->first();

            $marksheet_no = $sr->mid_term_alpha . $sr->mid_term_numeric;

            $next_number = str_pad(
                ((int)$sr->mid_term_numeric + 1),
                strlen($sr->mid_term_numeric),
                '0',
                STR_PAD_LEFT
            );

            DB::table('tbl_general')
                ->where('id', 1)
                ->update(['mid_term_numeric' => $next_number]);
        }

        
        foreach ($selectedSubjects as $subject_id) {

            $alreadyExists = DB::table('tbl_results')
                ->where('student_id', $student_id)
                ->where('course_id', $course_id)
                ->where('exam_id', $exam_id)
                ->where('subject_id', $subject_id)
                ->exists();

            if ($alreadyExists) {
                continue; 
            }

            DB::table('tbl_results')->insert([
                'student_id'    => $student_id,
                'course_id'     => $course_id,
                'exam_id'       => $exam_id,
                'subject_id'    => $subject_id,
                'max_mark'      => $subjects_max[$subject_id],
                'passing_mark'  => $subjects_pass[$subject_id],
                'obtained_mark' => $obt_mark,
                'session_start' => $session_year,
                'marksheet_no'  => $marksheet_no,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

    return back()->with('success', 'Result saved successfully!');
}
public function result_list(Request $request)
{
    $data['menu'] = 'students';
    $data['submenu'] = 'result_list';

    $r_page = $request->input('r_page', 25);

    $query = DB::table('tbl_admission as s')
        ->leftJoin('tbl_course as c', 'c.id', '=', 's.course_id')
        ->where('s.is_deleted', 0)
        ->select('s.*', 'c.name as course_name');

    if ($request->filled('date_from')) {
        $query->whereDate('s.created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('s.created_at', '<=', $request->date_to);
    }

    $students = $query->orderByDesc('s.id')->paginate($r_page);

    $studentIds = $students->pluck('id')->toArray();

   
    $results = DB::table('tbl_results as r')
        ->join('tbl_exam as e', 'e.id', '=', 'r.exam_id')
        ->whereIn('r.student_id', $studentIds)
        ->select(
            'r.student_id',
            'r.exam_id',
            'e.name as exam_name'
        )
        ->groupBy(
            'r.student_id',
            'r.exam_id',
            'e.name'
        )
        ->get()
        ->groupBy('student_id');

 
    $studentsWithResults = DB::table('tbl_results')
        ->select('student_id', 'course_id', 'session_start')
        ->groupBy('student_id', 'course_id', 'session_start')
        ->get()
        ->groupBy('student_id');

    
    $finalResults = DB::table('tbl_final_results')
        ->select('student_id', 'course_id', 'session_start')
        ->get()
        ->groupBy('student_id');

    return view(
        'backend.lead.result_list',
        compact(
            'students',
            'results',
            'studentsWithResults',
            'finalResults',
            'data'
        )
    )->with('i', ($request->input('page', 1) - 1) * $r_page);
}

   
   public function downloadResult($student_id, $exam_id, $marksheet_no)
{
   
    $student = DB::table('tbl_admission as s')
        ->join('tbl_course as c', 'c.id', '=', 's.course_id')
        ->select('s.id', 's.name', 's.fathername', 's.enrollment_no', 's.roll_number', 's.branch_id', 'c.name as course_name')
        ->where('s.id', $student_id)
        ->where('s.is_deleted', 0)
        ->first();

    if (!$student) {
        return back()->with('error', 'Student not found');
    }

    
    $results = DB::table('tbl_results as r')
        ->join('tbl_subject as sub', 'sub.id', '=', 'r.subject_id')
        ->join('tbl_exam as e', 'e.id', '=', 'r.exam_id')
        ->select(
            'sub.name as subject_name', 
            'r.max_mark', 
            'r.passing_mark', 
            'r.obtained_mark', 
            'e.name as exam_name', 
            'r.session_start', 
            'r.id as result_id',
            'r.marksheet_no'
        )
        ->where('r.student_id', $student_id)
        ->where('r.exam_id', $exam_id)
        ->where('r.marksheet_no', $marksheet_no) 
        ->orderBy('sub.orders_by')
        ->get();

    if ($results->isEmpty()) {
        return back()->with('error', 'Result not found');
    }

    $totalMax   = $results->sum('max_mark');
    $totalPass  = $results->sum('passing_mark');
    $totalObt   = $results->sum('obtained_mark');

    $resultStatus = $results->contains(fn($r) => $r->obtained_mark < $r->passing_mark) ? 'FAIL' : 'PASS';
    $percentage   = round(($totalObt / $totalMax) * 100, 2);
    
      $marksheet = DB::table('tbl_general')
        ->where('id', 1)
        ->value('marksheet');

    $pdf = Pdf::loadView('backend.lead.result_pdf', compact(
        'student', 'results', 'totalMax', 'totalPass', 'totalObt', 'percentage', 'resultStatus','marksheet'
    ));

    return $pdf->download($student->enrollment_no . '_' . $results->first()->exam_name . '.pdf');
}




public function getSubjectsByExam($exam_id)
{
   
    $exam = DB::table('tbl_exam')
                ->where('id', $exam_id)
                ->where('is_deleted', 0)
                ->first();

    if (!$exam) {
        return response()->json([]);
    }

    
    $subjects = DB::table('tbl_subject')
                    ->where('course_id', $exam->course_id)
                    ->where('is_deleted', 0)
                    ->where('status', 'Active')
                    ->orderBy('orders_by', 'ASC')
                    ->get();

    return response()->json($subjects);
}



public function saveAdmitcard(Request $request)
{
    $request->validate([
        'course_id' => 'required',
        'exam_id'   => 'required',
        'session_start' => 'required',
        'status' => 'required',
        'subject_date' => 'required|array'
    ]);

  
    $admitcard = DB::table('tbl_admitcard_master')
                    ->where('course_id', $request->course_id)
                    ->where('exam_id', $request->exam_id)
                    ->where('session_start', $request->session_start)
                    ->first();

    
    if (!$admitcard) {
        $admitcard_id = DB::table('tbl_admitcard_master')->insertGetId([
            'course_id' => $request->course_id,
            'exam_id' => $request->exam_id,
            'session_start' => $request->session_start,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
       
        $admitcard_id = $admitcard->id;

        DB::table('tbl_admitcard_master')
            ->where('id', $admitcard_id)
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        
        DB::table('tbl_admitcard_subjects')->where('admitcard_id', $admitcard_id)->delete();
    }

    
    foreach ($request->subject_date as $subject_id => $date) {
        DB::table('tbl_admitcard_subjects')->insert([
            'admitcard_id' => $admitcard_id,
            'subject_id' => $subject_id,
            'exam_date' => $date,
        ]);
    }

    return redirect()->back()->with('success', 'Admit card saved successfully!');
}


public function admitcard_list()
{

      $data['menu'] = 'students';
    $data['submenu'] = 'generate_admitcard_list';

    $admitcards = DB::table('tbl_admitcard_master AS ac')
        ->join('tbl_course AS c', 'c.id', '=', 'ac.course_id')
        ->join('tbl_exam AS e', 'e.id', '=', 'ac.exam_id')
        ->select('ac.*', 'c.name as course_name', 'e.name as exam_name')
        ->orderBy('ac.id', 'DESC')
        ->get();

    return view('backend.lead.admitcard_list', compact('admitcards','data'));
}


public function getAdmitcardSubjects($id)
{
    return DB::table('tbl_admitcard_subjects AS s')
        ->join('tbl_subject AS sub', 'sub.id', '=', 's.subject_id')
        ->where('s.admitcard_id', $id)
        ->select('sub.name as subject_name', 's.exam_date')
        ->get();
}


public function deleteAdmitcard($id)
{
   
    DB::table('tbl_admitcard_subjects')->where('admitcard_id', $id)->delete();

   
    DB::table('tbl_admitcard_master')->where('id', $id)->delete();

    return redirect()->back()->with('success', 'Admit Card Deleted Successfully');
}



public function viewadmitcard_studentwise(Request $request)
{
    $data['menu'] = 'categorys1';
    $data['submenu'] = 'generate_admitcard_list';

    $r_page = $request->input('r_page', 25);

    $query = DB::table('tbl_admission')
        ->where('is_deleted', 0);

  
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

  
 $students = $query->orderByDesc('id')->paginate($r_page);

foreach ($students as $stu) {

    
    $admit = DB::table('tbl_admitcard_master')
        ->where('course_id', $stu->course_id)
        ->where('status', 'Active')
        ->first();

    $admitId = $admit->id ?? null;

 
    $exam = null;
    if ($admit) {
        $exam = DB::table('tbl_exam')
            ->where('id', $admit->exam_id)
            ->where('status', 'Active')
            ->first();
    }

  
    $subjects = collect(); 
    if ($admitId) {
        $subjects = DB::table('tbl_admitcard_subjects AS acs')
            ->join('tbl_subject AS sub','sub.id','acs.subject_id')
            ->where('acs.admitcard_id',$admitId)
            ->select('sub.name','acs.exam_date')
            ->get();
    }

   
    
    $stu->hasAdmitCard = ($admit && $exam && $subjects->count() > 0);
    $stu->admit_id = $admitId;
  
    $stu->subjects = $subjects;
    $stu->exam = $exam;
}


    return view('backend.lead.viewadmitcard_studentwise', compact('students', 'data'))
        ->with('i', ($request->input('page', 1) - 1) * $r_page);
}

public function viewAdmitCard($id)
{
   
    $student = DB::table('tbl_admission')->where('id', $id)->first();
    if (!$student) {
        return back()->with('error', 'Student not found!');
    }

   
    $admit = DB::table('tbl_admitcard_master')
                ->where('course_id', $student->course_id)
                ->where('status', 'Active')
                ->first();

    if (!$admit) {
        return back()->with('error', 'Admit Card not assigned for this course!');
    }

   
    $subjects = DB::table('tbl_admitcard_subjects AS acs')
        ->join('tbl_subject AS s', 's.id', '=', 'acs.subject_id')
        ->where('acs.admitcard_id', $admit->id)
        ->select('s.name', 'acs.exam_date')
        ->orderBy('acs.id', 'ASC')
        ->get();

    if ($subjects->count() == 0) {
        return back()->with('error', 'Subjects not found for this admit card!');
    }

   
    $courseName = DB::table('tbl_course')->where('id',$student->course_id)->value('name');
    $examName   = DB::table('tbl_exam')->where('id',$admit->exam_id)->value('name');

     $admitcard = DB::table('tbl_general')
    ->where('id', 1)
    ->value('admitcard');

    return view('backend.lead.admitcard_view',
        compact('student','admit','subjects','courseName','examName','admitcard'));
}



public function getExams($grade_id)
{
    $exams = DB::table('tbl_exam')
        ->whereRaw('FIND_IN_SET(?, grade_id)', [$grade_id])
        ->where('status', 'Active')
        ->where('is_deleted', 0)
        ->orderBy('orders_by')
        ->get();
    return response()->json($exams);
}



public function getExamSubjects(Request $request)
{
    $exam_id  = $request->exam_id;
    $grade_id = $request->grade_id;

    if (!$exam_id || !$grade_id) {
        return response()->json([]);
    }

    $subjects = DB::table('tbl_exam_subject_marks as esm')
        ->join('tbl_subject as s', 's.id', '=', 'esm.subject_id')
        ->where('esm.exam_id', $exam_id)
        ->where('esm.grade_id', $grade_id)
        ->where('esm.is_deleted', 0)
        ->where('esm.is_included', 1)
        ->select(
            'esm.subject_id',
            's.name as subject_name',
            's.is_optional',
            's.orders_by',   
            'esm.marks',
            'esm.practical_marks',
            DB::raw('CASE WHEN esm.practical_marks > 0 THEN 1 ELSE 0 END as has_practical')
        )
        ->orderBy('s.orders_by', 'ASC')   
        ->get();

    return response()->json($subjects);
}
 
 
 
public function downloadAdmitCardPDF($id)
{
    $student = DB::table('tbl_admission')->where('id', $id)->first();
    if (!$student) return back()->with('error', 'Student not found!');

    $admit = DB::table('tbl_admitcard_master')
                ->where('course_id', $student->course_id)
                ->where('status', 'Active')
                ->first();
    if (!$admit) return back()->with('error', 'Admit Card not assigned for this course!');

    $subjects = DB::table('tbl_admitcard_subjects AS acs')
        ->join('tbl_subject AS s', 's.id', '=', 'acs.subject_id')
        ->where('acs.admitcard_id', $admit->id)
        ->select('s.name', 'acs.exam_date')
        ->orderBy('acs.id', 'ASC')
        ->get();

    if ($subjects->count() == 0)
        return back()->with('error', 'Subjects not found!');

    $courseName = DB::table('tbl_course')->where('id',$student->course_id)->value('name');
    $examName   = DB::table('tbl_exam')->where('id',$admit->exam_id)->value('name');

    $admitcard = DB::table('tbl_general')
    ->where('id', 1)
    ->value('admitcard');
 
    $pdf = Pdf::loadView('backend.lead.admitcard_pdf',
        compact('student','admit','subjects','courseName','examName','admitcard')
    )->setPaper([0, 0, 1748, 2480], 'portrait');

    return $pdf->download("Admit-Card-{$student->enrollment_no}.pdf");
}



  public function grades_index()
    {
         $data['menu']    = 'categorys';
         $data['submenu'] = 'add_grades';
        $grades = DB::table('tbl_grades')
        ->orderByDesc('min_percent')
        ->paginate(10);

        return view('backend.lead.grade_index', compact('grades','data'));
    }

    public function grades_store(Request $request)
    {
       
        $request->validate([
            'grade_name'  => 'required',
            'min_percent' => 'required|numeric',
            'max_percent' => 'required|numeric',
        ]);

        DB::table('tbl_grades')->insert([
            'grade_name'  => $request->grade_name,
            'min_percent' => $request->min_percent,
            'max_percent' => $request->max_percent,
            'remark'      => $request->remark,
        ]);

        return back()->with('success', 'Grade added successfully');
    }

    public function grades_edit($id)
    {
         $user = Auth::user();
            $permExplodesub = explode(',', $user->permission_submenu ?? '');

            if (!in_array('2_46', $permExplodesub)) {
                abort(403, 'Unauthorized Access');
            }
          $data['menu']    = 'categorys';
         $data['submenu'] = 'add_grades';
        $grade = DB::table('tbl_grades')->where('id', $id)->first();
        return view('backend.lead.grade_edit', compact('grade','data'));
    }

    public function grades_update(Request $request, $id)
    {
       
        DB::table('tbl_grades')->where('id', $id)->update([
            'grade_name'  => $request->grade_name,
            'min_percent' => $request->min_percent,
            'max_percent' => $request->max_percent,
            'remark'      => $request->remark,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully');
    }

    public function grades_destroy ($id)
    {
         $user = Auth::user();
            $permExplodesub = explode(',', $user->permission_submenu ?? '');

            if (!in_array('2_47', $permExplodesub)) {
                abort(403, 'Unauthorized Access');
            }
        DB::table('tbl_grades')->where('id', $id)->delete();
        return back()->with('success', 'Grade deleted successfully');
    }

}

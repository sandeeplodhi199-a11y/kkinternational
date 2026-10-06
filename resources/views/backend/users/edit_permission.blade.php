@extends('backend.layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">


<style>
.pw*{box-sizing:border-box}
.pw{padding:1.25rem 1.5rem}
.pw-topbar{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:2px solid #f0f0f0}
.pw-title{font-size:18px;font-weight:700;color:#1a1a2e;margin:0;margin-right:auto}
.pw-title span{color:#378ADD}
.pbtn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12.5px;font-weight:600;cursor:pointer;border:1.5px solid;text-decoration:none;transition:all .15s;white-space:nowrap}
.pbtn-blue{background:#E6F1FB;border-color:#378ADD;color:#0C447C}.pbtn-blue:hover{background:#B5D4F4}
.pbtn-amber{background:#FAEEDA;border-color:#BA7517;color:#633806}.pbtn-amber:hover{background:#FAC775}
.pbtn-out{background:#fff;border-color:#ccc;color:#444}.pbtn-out:hover{background:#f5f5f5}
.pw-sec{display:flex;align-items:center;gap:10px;margin:1.5rem 0 .75rem}
.pw-sec span{font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#888;white-space:nowrap;padding:4px 12px;background:#f0f0f0;border-radius:20px}
.pw-sec::before,.pw-sec::after{content:'';flex:1;height:1px;background:#e8e8e8}
.pw-card{background:#fff;border:1px solid #e8e8e8;border-radius:14px;margin-bottom:10px;overflow:hidden;transition:box-shadow .15s}
.pw-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.09)}
.pw-head{display:flex;align-items:center;gap:10px;padding:12px 16px;border-bottom:1px solid #f0f0f0}
.pw-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.pw-mlabel{font-size:13.5px;font-weight:700;color:#1a1a2e;display:flex;align-items:center;gap:7px;cursor:pointer;margin:0;flex:1}
.pw-mlabel input{accent-color:#378ADD;width:15px;height:15px;cursor:pointer;flex-shrink:0}
.pw-toggle{width:16px;height:16px;accent-color:#378ADD;cursor:pointer;flex-shrink:0}
.pw-body{padding:12px 16px;display:flex;flex-wrap:wrap;gap:7px}
.sp{display:inline-flex;align-items:center;gap:5px;border-radius:7px;padding:5px 12px;font-size:12px;font-weight:500;cursor:pointer;transition:all .13s;user-select:none;margin:0;border:1.5px solid}
.sp input{cursor:pointer;width:12px;height:12px}
/* default unselected */
.sp{background:#f6f7f9;border-color:#e2e4e9;color:#666}
.sp:hover{border-color:#378ADD;color:#0C447C;background:#EEF5FD}
/* selected states by action */
.sp.on-add   {background:#EAF3DE;border-color:#3B6D11;color:#27500A}
.sp.on-view  {background:#E6F1FB;border-color:#185FA5;color:#0C447C}
.sp.on-edit  {background:#FAEEDA;border-color:#BA7517;color:#633806}
.sp.on-del   {background:#FCEBEB;border-color:#A32D2D;color:#791F1F}
.sp.on-other {background:#EEEDFE;border-color:#534AB7;color:#3C3489}
.pw-save{margin-top:1.75rem;display:flex;justify-content:flex-end;padding-top:1rem;border-top:1px solid #f0f0f0}
.save-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 30px;background:#378ADD;color:#fff;border:none;border-radius:9px;font-size:14px;font-weight:700;cursor:pointer}
.save-btn:hover{background:#185FA5}
.pw-alert-s{padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:1rem;background:#EAF3DE;color:#27500A;border:1px solid #3B6D11}
.pw-alert-e{padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:1rem;background:#FCEBEB;color:#791F1F;border:1px solid #A32D2D}
</style>

<div class="content-wrapper">
<div class="pw">

@if(session('success'))
<div class="pw-alert-s"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="pw-alert-e"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
@endif

@php
$permExplode    = explode(',', $category->permission_menu    ?? '');
$permExplodeSub = explode(',', $category->permission_submenu ?? '');
@endphp

<form method="POST" action="{{ url('admin/updatePermission') }}">
@csrf
<input type="hidden" name="id" value="{{ $category->id }}">

<div class="pw-topbar">
    <h5 class="pw-title">Permissions &mdash; <span>{{ $category->name }}</span></h5>
    <button type="button" class="pbtn pbtn-blue"  onclick="toggleAllMenus()"><i class="ti ti-list-check"></i> All Main</button>
    <button type="button" class="pbtn pbtn-amber" onclick="toggleAllSubMenus()"><i class="ti ti-checkbox"></i> All Sub</button>
    <a href="{{ url('admin/users') }}" class="pbtn pbtn-out"><i class="ti ti-users"></i> Manage Users</a>
</div>

{{-- ====================================================
     CRM MANAGEMENT
===================================================== --}}
<div class="pw-sec"><span>CRM Management</span></div>

{{-- SETTINGS --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#EEF5FD,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#E6F1FB;color:#185FA5"><i class="ti ti-settings"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="1" class="main-cb"
                {{ in_array('1',$permExplode) ? 'checked' : '' }}>
            Settings
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('1_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="1_1" {{ in_array('1_1',$permExplodeSub)?'checked':'' }}> Website Data</label>
        <!--<label class="sp {{ in_array('1_6',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="1_6" {{ in_array('1_6',$permExplodeSub)?'checked':'' }}> View Home Page</label>-->
        <label class="sp {{ in_array('1_7',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="1_7" {{ in_array('1_7',$permExplodeSub)?'checked':'' }}> Social Media Links</label>
        <label class="sp {{ in_array('1_11',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="1_11" {{ in_array('1_11',$permExplodeSub)?'checked':'' }}> Master Setting</label>
    </div>
</div>

{{-- MASTER MANAGEMENT --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#F3F2FE,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#EEEDFE;color:#534AB7"><i class="ti ti-layout-grid"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="2" class="main-cb"
                {{ in_array('2',$permExplode) ? 'checked' : '' }}>
            Master Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('2_1',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_1" {{ in_array('2_1',$permExplodeSub)?'checked':'' }}> Add Level</label>
        <label class="sp {{ in_array('2_2',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_2" {{ in_array('2_2',$permExplodeSub)?'checked':'' }}> View Level</label>
        <label class="sp {{ in_array('2_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_3" {{ in_array('2_3',$permExplodeSub)?'checked':'' }}> Edit Level</label>
        <label class="sp {{ in_array('2_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_4" {{ in_array('2_4',$permExplodeSub)?'checked':'' }}> Delete Level</label>

        <label class="sp {{ in_array('2_5',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_5" {{ in_array('2_5',$permExplodeSub)?'checked':'' }}> Add Grade</label>
        <label class="sp {{ in_array('2_6',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_6" {{ in_array('2_6',$permExplodeSub)?'checked':'' }}> View Grade</label>
        <label class="sp {{ in_array('2_7',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_7" {{ in_array('2_7',$permExplodeSub)?'checked':'' }}> Edit Grade</label>
        <label class="sp {{ in_array('2_8',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_8" {{ in_array('2_8',$permExplodeSub)?'checked':'' }}> Delete Grade</label>

        <label class="sp {{ in_array('2_9',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_9" {{ in_array('2_9',$permExplodeSub)?'checked':'' }}> Add Section</label>
        <label class="sp {{ in_array('2_10',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_10" {{ in_array('2_10',$permExplodeSub)?'checked':'' }}> View Section</label>
        <label class="sp {{ in_array('2_11',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_11" {{ in_array('2_11',$permExplodeSub)?'checked':'' }}> Edit Section</label>
        <label class="sp {{ in_array('2_12',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_12" {{ in_array('2_12',$permExplodeSub)?'checked':'' }}> Delete Section</label>

        <label class="sp {{ in_array('2_13',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_13" {{ in_array('2_13',$permExplodeSub)?'checked':'' }}> Add Session</label>
        <label class="sp {{ in_array('2_14',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_14" {{ in_array('2_14',$permExplodeSub)?'checked':'' }}> View Session</label>
        <label class="sp {{ in_array('2_15',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_15" {{ in_array('2_15',$permExplodeSub)?'checked':'' }}> Edit Session</label>
        <label class="sp {{ in_array('2_16',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_16" {{ in_array('2_16',$permExplodeSub)?'checked':'' }}> Delete Session</label>

        <label class="sp {{ in_array('2_17',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_17" {{ in_array('2_17',$permExplodeSub)?'checked':'' }}> Add Subject</label>
        <label class="sp {{ in_array('2_18',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_18" {{ in_array('2_18',$permExplodeSub)?'checked':'' }}> View Subject</label>
        <label class="sp {{ in_array('2_19',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_19" {{ in_array('2_19',$permExplodeSub)?'checked':'' }}> Edit Subject</label>
        <label class="sp {{ in_array('2_20',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_20" {{ in_array('2_20',$permExplodeSub)?'checked':'' }}> Delete Subject</label>

        <label class="sp {{ in_array('2_25',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_25" {{ in_array('2_25',$permExplodeSub)?'checked':'' }}> Add Chapter</label>
        <label class="sp {{ in_array('2_26',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_26" {{ in_array('2_26',$permExplodeSub)?'checked':'' }}> View Chapter</label>
        <label class="sp {{ in_array('2_27',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_27" {{ in_array('2_27',$permExplodeSub)?'checked':'' }}> Edit Chapter</label>
        <label class="sp {{ in_array('2_28',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="2_28" {{ in_array('2_28',$permExplodeSub)?'checked':'' }}> Delete Chapter</label>
    </div>
</div>

{{-- STUDENT MANAGEMENT --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#EFF8EA,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#EAF3DE;color:#3B6D11"><i class="ti ti-users"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="3" class="main-cb"
                {{ in_array('3',$permExplode) ? 'checked' : '' }}>
            Student Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('3_1',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_1" {{ in_array('3_1',$permExplodeSub)?'checked':'' }}> Add Student</label>
        <label class="sp {{ in_array('3_2',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_2" {{ in_array('3_2',$permExplodeSub)?'checked':'' }}> Bulk Upload</label>
        <label class="sp {{ in_array('3_3',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_3" {{ in_array('3_3',$permExplodeSub)?'checked':'' }}> View Active Students</label>
        <label class="sp {{ in_array('3_4',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_4" {{ in_array('3_4',$permExplodeSub)?'checked':'' }}> Edit Student</label>
        <label class="sp {{ in_array('3_5',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_5" {{ in_array('3_5',$permExplodeSub)?'checked':'' }}> View Transfer Student</label>
        <label class="sp {{ in_array('3_6',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_6" {{ in_array('3_6',$permExplodeSub)?'checked':'' }}> Student ID Card</label>
        <label class="sp {{ in_array('3_7',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_7" {{ in_array('3_7',$permExplodeSub)?'checked':'' }}> Promotion Students</label>
        <label class="sp {{ in_array('3_8',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_8" {{ in_array('3_8',$permExplodeSub)?'checked':'' }}> Download Current Records</label>
        <label class="sp {{ in_array('3_9',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="3_9" {{ in_array('3_9',$permExplodeSub)?'checked':'' }}> Download Old Records</label>
    </div>
</div>

{{-- EXAM MANAGEMENT --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FEF6E9,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FAEEDA;color:#854F0B"><i class="ti ti-file-pencil"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="8" class="main-cb"
                {{ in_array('8',$permExplode) ? 'checked' : '' }}>
            Exam Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('8_1',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_1" {{ in_array('8_1',$permExplodeSub)?'checked':'' }}> Add Exam</label>
        <label class="sp {{ in_array('8_2',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_2" {{ in_array('8_2',$permExplodeSub)?'checked':'' }}> Manage Exam</label>
        <label class="sp {{ in_array('8_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_3" {{ in_array('8_3',$permExplodeSub)?'checked':'' }}> Edit Exam</label>
        <label class="sp {{ in_array('8_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_4" {{ in_array('8_4',$permExplodeSub)?'checked':'' }}> Delete Exam</label>
        <label class="sp {{ in_array('8_5',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_5" {{ in_array('8_5',$permExplodeSub)?'checked':'' }}> Download Admit Card</label>
        <label class="sp {{ in_array('8_6',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_6" {{ in_array('8_6',$permExplodeSub)?'checked':'' }}> View Mark Record Slip</label>
        <label class="sp {{ in_array('8_7',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_7" {{ in_array('8_7',$permExplodeSub)?'checked':'' }}> Consolidated Marks</label>
        <label class="sp {{ in_array('8_8',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_8" {{ in_array('8_8',$permExplodeSub)?'checked':'' }}> View Mark Evaluation</label>
        <label class="sp {{ in_array('8_9',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_9" {{ in_array('8_9',$permExplodeSub)?'checked':'' }}> View Marksheet 1</label>
        <label class="sp {{ in_array('8_10',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="8_10" {{ in_array('8_10',$permExplodeSub)?'checked':'' }}> View Marksheet 2</label>
    </div>
</div>

{{-- SYLLABUS TRACKER --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#E8F7F2,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#E1F5EE;color:#0F6E56"><i class="ti ti-book"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="9" class="main-cb"
                {{ in_array('9',$permExplode) ? 'checked' : '' }}>
            Syllabus Tracker
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('9_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="9_1" {{ in_array('9_1',$permExplodeSub)?'checked':'' }}>  Syllabus Tracker (Teacher Wise)</label>
        <label class="sp {{ in_array('9_2',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="9_2" {{ in_array('9_2',$permExplodeSub)?'checked':'' }}>  Exam Syllabus Coverage</label>
        <label class="sp {{ in_array('9_3',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="9_3" {{ in_array('9_3',$permExplodeSub)?'checked':'' }}>  Syllabus Tracker (Grade-wise)</label>
    </div>
</div>

{{-- TRANSFER CERTIFICATE --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FDF0EB,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FAECE7;color:#993C1D"><i class="ti ti-certificate"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="4" class="main-cb"
                {{ in_array('4',$permExplode) ? 'checked' : '' }}>
            Transfer Certificate Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('4_1',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="4_1" {{ in_array('4_1',$permExplodeSub)?'checked':'' }}> Transfer Certificate</label>
        <label class="sp {{ in_array('4_2',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="4_2" {{ in_array('4_2',$permExplodeSub)?'checked':'' }}> View Transfer Certificate</label>
        <label class="sp {{ in_array('4_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="4_3" {{ in_array('4_3',$permExplodeSub)?'checked':'' }}> Edit Transfer Certificate</label>
        <label class="sp {{ in_array('4_4',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="4_4" {{ in_array('4_4',$permExplodeSub)?'checked':'' }}> 10th Transfer Certificate</label>
        <label class="sp {{ in_array('4_5',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="4_5" {{ in_array('4_5',$permExplodeSub)?'checked':'' }}> View 10th Transfer Certificate</label>
        <label class="sp {{ in_array('4_6',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="4_6" {{ in_array('4_6',$permExplodeSub)?'checked':'' }}> Edit 10th Transfer Certificate</label>
    </div>
</div>

{{-- TEACHER MANAGEMENT --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#F3F2FE,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#EEEDFE;color:#3C3489"><i class="ti ti-user-check"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="5" class="main-cb"
                {{ in_array('5',$permExplode) ? 'checked' : '' }}>
            Teacher Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('5_1',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="5_1" {{ in_array('5_1',$permExplodeSub)?'checked':'' }}> Add Teacher</label>
        <label class="sp {{ in_array('5_2',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="5_2" {{ in_array('5_2',$permExplodeSub)?'checked':'' }}> View Teachers</label>
        <label class="sp {{ in_array('5_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="5_3" {{ in_array('5_3',$permExplodeSub)?'checked':'' }}> Edit Teacher</label>
        <label class="sp {{ in_array('5_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="5_4" {{ in_array('5_4',$permExplodeSub)?'checked':'' }}> Delete Teacher</label>
        <label class="sp {{ in_array('5_10',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="5_10" {{ in_array('5_10',$permExplodeSub)?'checked':'' }}> Chapter Status</label>
        <label class="sp {{ in_array('5_5',$permExplodeSub)?'on-other':'' }}"><input type="checkbox" name="permission_submenu[]" value="5_5" {{ in_array('5_5',$permExplodeSub)?'checked':'' }}> Mark Evaluation</label>
    </div>
</div>

{{-- USERS MANAGEMENT --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FDF0F5,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FBEAF0;color:#993556"><i class="ti ti-shield-lock"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="6" class="main-cb"
                {{ in_array('6',$permExplode) ? 'checked' : '' }}>
            Users Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('6_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="6_1" {{ in_array('6_1',$permExplodeSub)?'checked':'' }}> Users Management</label>
        <label class="sp {{ in_array('6_2',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="6_2" {{ in_array('6_2',$permExplodeSub)?'checked':'' }}> Edit Permission Users</label>
        <label class="sp {{ in_array('6_3',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="6_3" {{ in_array('6_3',$permExplodeSub)?'checked':'' }}> Delete Users</label>
        <label class="sp {{ in_array('6_4',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="6_4" {{ in_array('6_4',$permExplodeSub)?'checked':'' }}> Edit Users</label>
        <label class="sp {{ in_array('6_5',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="6_5" {{ in_array('6_5',$permExplodeSub)?'checked':'' }}> Deleted View Users</label>
    </div>
</div>

{{-- CHANGE PASSWORD --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#F5F5F3,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#F1EFE8;color:#5F5E5A"><i class="ti ti-lock"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="7" class="main-cb"
                {{ in_array('7',$permExplode) ? 'checked' : '' }}>
            Change Password
        </label>
    </div>
</div>

{{-- ====================================================
     WEBSITE MANAGEMENT
===================================================== --}}
<div class="pw-sec"><span>Website Management</span></div>


{{-- ENQUIRY --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#EEF5FD,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#E6F1FB;color:#185FA5"><i class="ti ti-photo"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="19" class="main-cb"
                {{ in_array('19',$permExplode) ? 'checked' : '' }}>
            Enquiry Management
        </label>
    </div>
   
</div>


{{-- SLIDER --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#EEF5FD,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#E6F1FB;color:#185FA5"><i class="ti ti-photo"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="10" class="main-cb"
                {{ in_array('10',$permExplode) ? 'checked' : '' }}>
            Slider Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('10_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="10_1" {{ in_array('10_1',$permExplodeSub)?'checked':'' }}> Slider Management</label>
        <label class="sp {{ in_array('10_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="10_2" {{ in_array('10_2',$permExplodeSub)?'checked':'' }}> Add Slider</label>
        <label class="sp {{ in_array('10_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="10_3" {{ in_array('10_3',$permExplodeSub)?'checked':'' }}> Edit Slider</label>
        <label class="sp {{ in_array('10_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="10_4" {{ in_array('10_4',$permExplodeSub)?'checked':'' }}> Delete Slider</label>
    </div>
</div>

{{-- TEAM --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#EFF8EA,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#EAF3DE;color:#3B6D11"><i class="ti ti-users-group"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="11" class="main-cb"
                {{ in_array('11',$permExplode) ? 'checked' : '' }}>
            Team Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('11_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="11_1" {{ in_array('11_1',$permExplodeSub)?'checked':'' }}> Team Management</label>
        <label class="sp {{ in_array('11_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="11_2" {{ in_array('11_2',$permExplodeSub)?'checked':'' }}> Add Team</label>
        <label class="sp {{ in_array('11_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="11_3" {{ in_array('11_3',$permExplodeSub)?'checked':'' }}> Edit Team</label>
        <label class="sp {{ in_array('11_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="11_4" {{ in_array('11_4',$permExplodeSub)?'checked':'' }}> Delete Team</label>
    </div>
</div>

{{-- TESTIMONIAL --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FEF6E9,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FAEEDA;color:#854F0B"><i class="ti ti-quote"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="12" class="main-cb"
                {{ in_array('12',$permExplode) ? 'checked' : '' }}>
            Testimonial Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('12_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="12_1" {{ in_array('12_1',$permExplodeSub)?'checked':'' }}> Testimonial Management</label>
        <label class="sp {{ in_array('12_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="12_2" {{ in_array('12_2',$permExplodeSub)?'checked':'' }}> Add Testimonial</label>
        <label class="sp {{ in_array('12_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="12_3" {{ in_array('12_3',$permExplodeSub)?'checked':'' }}> Edit Testimonial</label>
        <label class="sp {{ in_array('12_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="12_4" {{ in_array('12_4',$permExplodeSub)?'checked':'' }}> Delete Testimonial</label>
    </div>
</div>

{{-- FAQ --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#F3F2FE,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#EEEDFE;color:#534AB7"><i class="ti ti-help-circle"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="13" class="main-cb"
                {{ in_array('13',$permExplode) ? 'checked' : '' }}>
            FAQ Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('13_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="13_1" {{ in_array('13_1',$permExplodeSub)?'checked':'' }}> FAQ Management</label>
        <label class="sp {{ in_array('13_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="13_2" {{ in_array('13_2',$permExplodeSub)?'checked':'' }}> Add FAQ</label>
        <label class="sp {{ in_array('13_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="13_3" {{ in_array('13_3',$permExplodeSub)?'checked':'' }}> Edit FAQ</label>
        <label class="sp {{ in_array('13_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="13_4" {{ in_array('13_4',$permExplodeSub)?'checked':'' }}> Delete FAQ</label>
    </div>
</div>

{{-- GALLERY --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FDF0EB,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FAECE7;color:#993C1D"><i class="ti ti-photo-album"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="14" class="main-cb"
                {{ in_array('14',$permExplode) ? 'checked' : '' }}>
            Gallery Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('14_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="14_1" {{ in_array('14_1',$permExplodeSub)?'checked':'' }}> Gallery Management</label>
        <label class="sp {{ in_array('14_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="14_2" {{ in_array('14_2',$permExplodeSub)?'checked':'' }}> Add Gallery</label>
        <label class="sp {{ in_array('14_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="14_3" {{ in_array('14_3',$permExplodeSub)?'checked':'' }}> Edit Gallery</label>
        <label class="sp {{ in_array('14_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="14_4" {{ in_array('14_4',$permExplodeSub)?'checked':'' }}> Delete Gallery</label>
    </div>
</div>

{{-- VIDEO --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FEF0F0,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FCEBEB;color:#A32D2D"><i class="ti ti-player-play"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="15" class="main-cb"
                {{ in_array('15',$permExplode) ? 'checked' : '' }}>
            Video Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('15_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="15_1" {{ in_array('15_1',$permExplodeSub)?'checked':'' }}> Video Management</label>
        <label class="sp {{ in_array('15_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="15_2" {{ in_array('15_2',$permExplodeSub)?'checked':'' }}> Add Video</label>
        <label class="sp {{ in_array('15_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="15_3" {{ in_array('15_3',$permExplodeSub)?'checked':'' }}> Edit Video</label>
        <label class="sp {{ in_array('15_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="15_4" {{ in_array('15_4',$permExplodeSub)?'checked':'' }}> Delete Video</label>
    </div>
</div>

{{-- BLOG --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#E8F7F2,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#E1F5EE;color:#085041"><i class="ti ti-news"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="16" class="main-cb"
                {{ in_array('16',$permExplode) ? 'checked' : '' }}>
            Blog Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('16_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_1" {{ in_array('16_1',$permExplodeSub)?'checked':'' }}> Blog Category Management</label>
        <label class="sp {{ in_array('16_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_2" {{ in_array('16_2',$permExplodeSub)?'checked':'' }}> Add Blog Category</label>
        <label class="sp {{ in_array('16_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_3" {{ in_array('16_3',$permExplodeSub)?'checked':'' }}> Edit Blog Category</label>
        <label class="sp {{ in_array('16_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_4" {{ in_array('16_4',$permExplodeSub)?'checked':'' }}> Delete Blog Category</label>
        <label class="sp {{ in_array('16_5',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_5" {{ in_array('16_5',$permExplodeSub)?'checked':'' }}> Blog Management</label>
        <label class="sp {{ in_array('16_6',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_6" {{ in_array('16_6',$permExplodeSub)?'checked':'' }}> Add Blog</label>
        <label class="sp {{ in_array('16_7',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_7" {{ in_array('16_7',$permExplodeSub)?'checked':'' }}> Edit Blog</label>
        <label class="sp {{ in_array('16_8',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="16_8" {{ in_array('16_8',$permExplodeSub)?'checked':'' }}> Delete Blog</label>
    </div>
</div>

{{-- SERVICE --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#F3F2FE,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#EEEDFE;color:#3C3489"><i class="ti ti-briefcase"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="17" class="main-cb"
                {{ in_array('17',$permExplode) ? 'checked' : '' }}>
            Service Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('17_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="17_1" {{ in_array('17_1',$permExplodeSub)?'checked':'' }}> Service Management</label>
        <label class="sp {{ in_array('17_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="17_2" {{ in_array('17_2',$permExplodeSub)?'checked':'' }}> Add Service</label>
        <label class="sp {{ in_array('17_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="17_3" {{ in_array('17_3',$permExplodeSub)?'checked':'' }}> Edit Service</label>
        <label class="sp {{ in_array('17_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="17_4" {{ in_array('17_4',$permExplodeSub)?'checked':'' }}> Delete Service</label>
    </div>
</div>

{{-- EVENT --}}
<div class="pw-card" data-row>
    <div class="pw-head" style="background:linear-gradient(90deg,#FEF6E9,#fff)">
        <input type="checkbox" class="pw-toggle">
        <div class="pw-icon" style="background:#FAEEDA;color:#633806"><i class="ti ti-calendar-event"></i></div>
        <label class="pw-mlabel">
            <input type="checkbox" name="permission_menu[]" value="18" class="main-cb"
                {{ in_array('18',$permExplode) ? 'checked' : '' }}>
            Event Management
        </label>
    </div>
    <div class="pw-body">
        <label class="sp {{ in_array('18_1',$permExplodeSub)?'on-view':'' }}"><input type="checkbox" name="permission_submenu[]" value="18_1" {{ in_array('18_1',$permExplodeSub)?'checked':'' }}> Event Management</label>
        <label class="sp {{ in_array('18_2',$permExplodeSub)?'on-add':'' }}"><input type="checkbox" name="permission_submenu[]" value="18_2" {{ in_array('18_2',$permExplodeSub)?'checked':'' }}> Add Event</label>
        <label class="sp {{ in_array('18_3',$permExplodeSub)?'on-edit':'' }}"><input type="checkbox" name="permission_submenu[]" value="18_3" {{ in_array('18_3',$permExplodeSub)?'checked':'' }}> Edit Event</label>
        <label class="sp {{ in_array('18_4',$permExplodeSub)?'on-del':'' }}"><input type="checkbox" name="permission_submenu[]" value="18_4" {{ in_array('18_4',$permExplodeSub)?'checked':'' }}> Delete Event</label>
    </div>
</div>

<div class="pw-save">
    <button type="submit" class="save-btn"><i class="ti ti-device-floppy"></i> Save Permissions</button>
</div>

</form>
</div>
</div>

<script>
document.querySelectorAll('[data-row]').forEach(function(row){
    var toggle = row.querySelector('.pw-toggle');
    var main   = row.querySelector('.main-cb');
    var subs   = Array.from(row.querySelectorAll('input[name="permission_submenu[]"]'));
    var pills  = Array.from(row.querySelectorAll('.sp'));

    function syncStyles(){
        subs.forEach(function(cb, i){
            if(pills[i]) pills[i].classList.toggle('on', cb.checked);
        });
    }
    function updateToggle(){
        if(!main) return;
        toggle.checked = main.checked && (subs.length === 0 || subs.every(function(s){return s.checked}));
        syncStyles();
    }
    if(toggle && main){
        toggle.addEventListener('change', function(){
            main.checked = this.checked;
            subs.forEach(function(s){ s.checked = toggle.checked; });
            syncStyles();
        });
        main.addEventListener('change', function(){
            if(!this.checked) subs.forEach(function(s){ s.checked = false; });
            updateToggle();
        });
        subs.forEach(function(cb){
            cb.addEventListener('change', function(){
                main.checked = subs.some(function(s){return s.checked});
                updateToggle();
            });
        });
        updateToggle();
    }
});

function toggleAllMenus(){
    var all = Array.from(document.querySelectorAll('.main-cb'));
    var on  = all.every(function(c){return c.checked});
    all.forEach(function(c){ c.checked = !on; c.dispatchEvent(new Event('change')); });
}
function toggleAllSubMenus(){
    var all = Array.from(document.querySelectorAll('input[name="permission_submenu[]"]'));
    var on  = all.every(function(c){return c.checked});
    all.forEach(function(c){ c.checked = !on; c.dispatchEvent(new Event('change')); });
}
</script>

@endsection
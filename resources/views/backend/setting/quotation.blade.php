@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row mart10 padd"></div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">


                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                            @endif

                            <form method="post" action="{{url('admin/saveQuotation')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="1">

                                <!-- SECTION: School Information -->
                                <h4><i class="fas fa-building text-primary"></i> School Information</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label><i class="fas fa-building"></i> School Title</label>
                                        <input type="text" name="school_title" class="form-control"
                                            value="{{ $setting->school_title }}">
                                    </div>
                                     <div class="col-md-4">
                                        <label><i class="fas fa-building"></i> School Name</label>
                                        <input type="text" name="school_name" class="form-control"
                                            value="{{ $setting->school_name }}">
                                    </div>
                                     <div class="col-md-4">
                                        <label><i class="fas fa-building"></i> School Address</label>
                                        <input type="text" name="school_address" class="form-control"
                                            value="{{ $setting->school_address }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-phone"></i> Phone</label>
                                        <input type="text" name="company_phone" class="form-control"
                                            value="{{ $setting->company_phone }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-envelope"></i> Email</label>
                                        <input type="text" name="company_email" class="form-control"
                                            value="{{ $setting->company_email }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fab fa-whatsapp"></i> WhatsApp Number</label>
                                        <input type="text" name="company_whatsapp_numer" class="form-control"
                                            value="{{ $setting->company_whatsapp_numer }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label><i class="fas fa-map-marker-alt"></i> Address</label>
                                        <textarea name="company_address"
                                            class="form-control">{{ $setting->company_address }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-city"></i> City</label>
                                        <input type="text" name="company_city" class="form-control"
                                            value="{{ $setting->company_city }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-flag"></i> State</label>
                                        <input type="text" name="company_state" class="form-control"
                                            value="{{ $setting->company_state }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-map-pin"></i> Pincode</label>
                                        <input type="text" name="company_pincode" class="form-control"
                                            value="{{ $setting->company_pincode }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-receipt"></i> GST Number</label>
                                        <input type="text" name="company_gst_number" class="form-control"
                                            value="{{ $setting->company_gst_number }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label><i class="fas fa-globe"></i> Website</label>
                                        <input type="text" name="company_website" class="form-control"
                                            value="{{ $setting->company_website }}">
                                    </div>


                                    <div class="col-md-12">
                                        <label><i class="fas fa-scroll"></i> Terms & Conditions (Only For
                                            Invoice)</label>
                                        <textarea name="company_term_condition_invoice"
                                            class="form-control">{{ $setting->company_term_condition_invoice }}</textarea>
                                    </div>
                                </div>

                                <!-- SECTION: Logo & Signature -->
                                <h4 class="mt-4"><i class="fas fa-image text-primary"></i> Branding</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><i class="fas fa-image"></i> School Logo</label>
                                        <input type="file" name="company_logo" class="form-control">
                                        @if($setting->company_logo)
                                        <img src="{{ asset('public/uploads/'.$setting->company_logo) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label><i class="fas fa-pen-nib"></i> School Signature</label>
                                        <input type="file" name="company_signature" class="form-control">
                                        @if($setting->company_signature)
                                        <img src="{{ asset('public/uploads/'.$setting->company_signature) }}"
                                            width="100" class="img-thumbnail mt-2">
                                        @endif
                                    </div>
                                    
                                    
                                    
                                     <div class="col-md-6">
                                        <label><i class="fas fa-pen-nib"></i> Exam Controller Signature</label>
                                        <input type="file" name="exam_controller_sign" class="form-control">
                                        @if($setting->exam_controller_sign)
                                        <img src="{{ asset('public/uploads/'.$setting->exam_controller_sign) }}"
                                            width="100" class="img-thumbnail mt-2">
                                        @endif
                                    </div>
                                    
                                    
                                    
                                     <div class="col-md-6">
                                        <label><i class="fas fa-pen-nib"></i> Principal Signature</label>
                                        <input type="file" name="principal_sign" class="form-control">
                                        @if($setting->principal_sign)
                                        <img src="{{ asset('public/uploads/'.$setting->principal_sign) }}"
                                            width="100" class="img-thumbnail mt-2">
                                        @endif
                                    </div>
                                </div>


                                <!-- SECTION: Textable Settings -->
                                <h4 class="mt-4"><i class="fas fa-file-alt text-primary"></i> Textable Enrollment
                                    Settings</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><i class="fas fa-font"></i> Enrollment Alpha</label>
                                        <input type="text" name="textable_enrollment_alpha" class="form-control"
                                            value="{{ $setting->textable_enrollment_alpha }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><i class="fas fa-hashtag"></i> Enrollment Numeric</label>
                                        <input type="number" name="textable_enrollment_numeric" class="form-control"
                                            value="{{ $setting->textable_enrollment_numeric }}">
                                    </div>


                                </div>



                                <!-- SECTION: Textable Settings -->
                                <h4 class="mt-4"><i class="fas fa-file-alt text-primary"></i>
                                    Mid Term Marksheet Settings</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><i class="fas fa-font"></i> MidTerm Alpha</label>
                                        <input type="text" name="mid_term_alpha" class="form-control"
                                            value="{{ $setting->mid_term_alpha }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><i class="fas fa-hashtag"></i> MidTerm Numeric</label>
                                        <input type="number" name="mid_term_numeric" class="form-control"
                                            value="{{ $setting->mid_term_numeric }}">
                                    </div>

                                </div>

                                <!-- SECTION: certificate Textable -->
                                <h4 class="mt-4"><i class="fas fa-file text-primary"></i> Certificate
                                    Settings</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><i class="fas fa-font"></i> Certificate Alpha</label>
                                        <input type="text" name="certificate_alpha" class="form-control"
                                            value="{{ $setting->certificate_alpha }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><i class="fas fa-hashtag"></i> Certificate Numeric</label>
                                        <input type="number" name="certificate_numeric" class="form-control"
                                            value="{{ $setting->certificate_numeric }}">
                                    </div>

                                </div>


                                <!-- SECTION: Textable Settings -->
                                <h4 class="mt-4"><i class="fas fa-file-alt text-primary"></i>
                                    Final Marksheet Settings</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><i class="fas fa-font"></i> Final Marksheet Alpha</label>
                                        <input type="text" name="final_marksheet_alpha" class="form-control"
                                            value="{{ $setting->final_marksheet_alpha }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><i class="fas fa-hashtag"></i> Final Marksheet Numeric</label>
                                        <input type="number" name="final_marksheet_numeric" class="form-control"
                                            value="{{ $setting->final_marksheet_numeric }}">
                                    </div>

                                </div>



                                <h4 class="mt-4"><i class="fas fa-image text-primary"></i> Background Master</h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">
                                <div class="row">
                                    <div class="col-md-6">

                                        <label><i class="fas fa-image"></i> Id Card Background</label>
                                        <small class="text-danger d-block mb-1">
                                            ⚠️
                                            <b>Uploaded image Width: 649 px Height: 992 px</b>

                                        </small>
                                        <input type="file" name="id_card" class="form-control">
                                        @if($setting->id_card)
                                        <img src="{{ asset('public/uploads/'.$setting->id_card) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <i class="fas fa-image"></i> Admit Card Background
                                            <span class="badge badge-info ml-2">A5 Output</span>
                                        </label>

                                        <small class="text-danger d-block mb-1">
                                            ⚠️
                                            <b>Uploaded image size: 905 × 1280 px.</b>
                                            <b>Admit Card will be generated in A5 page size (handled by system).</b>
                                        </small>

                                        <input type="file" name="admitcard" class="form-control">

                                        @if($setting->admitcard)
                                        <img src="{{ asset('public/uploads/'.$setting->admitcard) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>


                                    <div class="col-md-6">
                                        <label>
                                            <i class="fas fa-image"></i> Marksheet Background
                                            <span class="badge badge-success ml-2">A4 Output</span>
                                        </label>

                                        <small class="text-primary d-block mb-1">
                                            ℹ️
                                            <b>Uploaded image size: 905 × 1280 px.</b>
                                            <b>Marksheet will be generated in A4 page size (handled by system).</b>
                                        </small>

                                        <input type="file" name="marksheet" class="form-control">

                                        @if($setting->marksheet)
                                        <img src="{{ asset('public/uploads/'.$setting->marksheet) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>


                                    <div class="col-md-6">
                                        <label>
                                            <i class="fas fa-image"></i> Certificate Background
                                            <span class="badge badge-success ml-2">A4 Output</span>
                                        </label>

                                        <small class="text-primary d-block mb-1">
                                            ℹ️
                                            <b>Uploaded image size: 905 × 1280 px.</b>
                                            <b>Certificate will be generated in A4 page size (handled by system).</b>
                                        </small>

                                        <input type="file" name="certificate" class="form-control">

                                        @if($setting->certificate)
                                        <img src="{{ asset('public/uploads/'.$setting->certificate) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label><i class="fas fa-image"></i>Pay Slip Background</label>
                                         <small class="text-danger d-block mb-1">
                                            ⚠️   
                                            <b>Uploaded image Width: 2000 px Height: 1414 px</b>
                                          
                                        </small>
                                        <input type="file" name="slip_payment" class="form-control">
                                        @if($setting->slip_payment)
                                        <img src="{{ asset('public/uploads/'.$setting->slip_payment) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label><i class="fas fa-pen-nib"></i> Payment History Background</label>
                                         <small class="text-danger d-block mb-1">
                                            ⚠️   
                                            <b>Uploaded image Width: 1414 px Height: 2000 px</b>
                                          
                                        </small>
                                        <input type="file" name="payment_history" class="form-control">
                                        @if($setting->payment_history)
                                        <img src="{{ asset('public/uploads/'.$setting->payment_history) }}" width="100"
                                            class="img-thumbnail mt-2">
                                        @endif
                                    </div>



                                </div>

                                <!-- SECTION: Bank Settings -->
                                <h4 class="mt-4">
                                    <i class="fas fa-university text-primary"></i> Bank Detail Settings
                                </h4>
                                <hr
                                    style="border: none; height: 3px; background: linear-gradient(to right, #000, #444, #000);">

                                <div class="row">
                                    <!-- Account Holder Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-user-circle text-info"></i> Account Holder
                                                Name</label>
                                            <input type="text" class="form-control" name="holder_name"
                                                value="{{ $setting->holder_name }}"
                                                placeholder="Enter account holder name">
                                        </div>
                                    </div>

                                    <!-- Bank Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-landmark text-success"></i> Bank Name</label>
                                            <input type="text" class="form-control" name="acc_name"
                                                value="{{ $setting->acc_name }}" placeholder="Enter bank name">
                                        </div>
                                    </div>

                                    <!-- Branch Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-code-branch text-warning"></i> Branch Name</label>
                                            <input type="text" class="form-control" name="branch"
                                                value="{{ $setting->branch }}" placeholder="Enter branch name">
                                        </div>
                                    </div>

                                    <!-- Account Type -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-file-invoice-dollar text-danger"></i> Bank
                                                Type</label>
                                            <select id="acc_type" name="acc_type" class="form-control">
                                                <option value="">Select Bank Type</option>
                                                <option value="Saving Account"
                                                    {{ $setting->acc_type == 'Saving Account' ? 'selected' : '' }}>
                                                    Saving Account</option>
                                                <option value="Current Account"
                                                    {{ $setting->acc_type == 'Current Account' ? 'selected' : '' }}>
                                                    Current Account</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-hashtag text-secondary"></i> Account Number</label>
                                            <input type="number" class="form-control" name="acc_num"
                                                value="{{ $setting->acc_num }}" placeholder="Enter account number">
                                        </div>
                                    </div>

                                    <!-- IFSC Code -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fas fa-key text-primary"></i> IFSC Code</label>
                                            <input type="text" class="form-control" name="ifsc_code"
                                                value="{{ $setting->ifsc_code }}" placeholder="Enter IFSC code">
                                        </div>
                                    </div>
                                </div>


                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Save Settings
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.styled-hr {
    border: none;
    height: 3px;
    background: linear-gradient(to right, #000, #444, #000);
}

.form-group label {
    font-weight: bold;
}
</style>
@endsection
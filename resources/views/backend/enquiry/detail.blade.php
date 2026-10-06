@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Enquiry Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/enquiry') }}">Enquiry</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        Enquiry #{{ str_pad($enquiry->id, 5, '0', STR_PAD_LEFT) }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ url('admin/enquiry') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Reference ID</th>
                            <td>#ENQ-{{ str_pad($enquiry->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td>{{ $enquiry->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td>{{ $enquiry->message }}</td>
                        </tr>
                        <tr>
                            <th>Received On</th>
                            <td>{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ url('admin/enquiry/delete/'.$enquiry->id) }}"
                       class="btn btn-danger"
                       onclick="return confirm('Delete this enquiry?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@extends('backend.layouts.app')
@section('content')

<style>
    /* Custom Styles for Comments Management */
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-card.total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card.pending {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .stats-card.approved {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stats-card.rejected {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    
    .stats-number {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .stats-label {
        font-size: 14px;
        opacity: 0.9;
    }
    
    .stats-icon {
        float: right;
        font-size: 40px;
        opacity: 0.3;
    }
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-approved {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .badge-rejected {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .badge-reply {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: white;
        font-size: 10px;
        padding: 3px 8px;
        margin-top: 5px;
        display: inline-block;
    }
    
    .comment-row {
        transition: all 0.3s;
    }
    
    .comment-row:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.01);
    }
    
    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .table-header th {
        color: white !important;
        font-weight: 600;
        padding: 15px;
    }
    
    .action-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .action-btn {
        cursor: pointer;
        padding: 8px 12px;
        background: #f3f4f6;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .action-btn:hover {
        background: #e5e7eb;
    }
    
    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 8px 20px;
        color: white;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.4);
    }
    
    .btn-secondary-custom {
        background: #6c757d;
        border: none;
        padding: 8px 20px;
        color: white;
        border-radius: 8px;
    }
    
    .pagination-custom {
        margin-top: 20px;
    }
    
    .pagination-custom .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
    }
    
    .pagination-custom .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }
    
    .modal-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .modal-header-custom .close {
        color: white;
    }
    
    .comment-content-full {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>

<div class="content-wrapper">
    <!-- Statistics Cards -->
    @php
        $totalComments = $comments->total();
        $pendingComments = DB::table('tbl_blog_comment')->where('is_deleted', 0)->where('status', 'Pending')->count();
        $approvedComments = DB::table('tbl_blog_comment')->where('is_deleted', 0)->where('status', 'Active')->count();
        $rejectedComments = DB::table('tbl_blog_comment')->where('is_deleted', 0)->where('status', 'Rejected')->count();
    @endphp
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card total">
                <div class="stats-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stats-number">{{ $totalComments }}</div>
                <div class="stats-label">Total Comments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card pending">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-number">{{ $pendingComments }}</div>
                <div class="stats-label">Pending Approval</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card approved">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-number">{{ $approvedComments }}</div>
                <div class="stats-label">Approved</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card rejected">
                <div class="stats-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stats-number">{{ $rejectedComments }}</div>
                <div class="stats-label">Rejected</div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="row">
            <div class="col-md-12">
                <form class="row" method="get" action="">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Search by name, email, comment" value="{{ $data['keyword'] ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Filter by Blog</label>
                            <select class="form-control" name="blog_id">
                                <option value="">All Blogs</option>
                                @foreach($blogs as $blog)
                                <option value="{{ $blog->id }}" {{ ($data['blog_id'] ?? '') == $blog->id ? 'selected' : '' }}>
                                    {{ $blog->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">All Status</option>
                                <option value="Pending" {{ ($data['status'] ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Active" {{ ($data['status'] ?? '') == 'Active' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ ($data['status'] ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Per Page</label>
                            <select class="form-control" name="r_page">
                                <option value="25" {{ ($data['r_page'] ?? 25) == 25 ? 'selected' : '' }}>25 Records</option>
                                <option value="50" {{ ($data['r_page'] ?? 25) == 50 ? 'selected' : '' }}>50 Records</option>
                                <option value="100" {{ ($data['r_page'] ?? 25) == 100 ? 'selected' : '' }}>100 Records</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ url('admin/blog-comments') }}" class="btn btn-secondary-custom">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-comments"></i> Blog Comments Management
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if (\Session::has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <i class="fas fa-check-circle"></i> {!! \Session::get('success') !!}
                                </div>
                            @endif
                            
                            @if (\Session::has('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <i class="fas fa-exclamation-circle"></i> {!! \Session::get('error') !!}
                                </div>
                            @endif
                            
                            @if($comments->total() > 0)
                            
                            <!-- Bulk Action Form -->
                            <form method="POST" action="{{ url('admin/bulk-comment-action') }}" id="bulkActionForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select name="action" class="form-control" required>
                                                <option value="">Bulk Actions</option>
                                                <option value="approve">✓ Approve Selected</option>
                                                <option value="reject">✗ Reject Selected</option>
                                                <option value="delete">🗑 Delete Selected</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary-custom" onclick="return confirm('Are you sure you want to perform this action?')">
                                                    Apply
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-header">
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="selectAll" style="transform: scale(1.2);">
                                                </th>
                                                <th width="50">#</th>
                                                <th width="200">Blog</th>
                                                <th width="200">Commenter</th>
                                                <th>Comment</th>
                                                <th width="120">Status</th>
                                                <th width="150">Date</th>
                                                <th width="100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($comments as $comment)
                                            <tr class="comment-row">
                                                <td>
                                                    <input type="checkbox" name="comment_ids[]" class="commentCheckbox" value="{{ $comment->id }}">
                                                </td>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <a href="{{ url('blog/'.$comment->blog_slug) }}" target="_blank" class="text-primary">
                                                        <i class="fas fa-blog"></i> 
                                                        {{ strlen($comment->blog_title) > 35 ? substr($comment->blog_title, 0, 35) . '...' : $comment->blog_title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong><i class="fas fa-user"></i> {{ $comment->name }}</strong><br>
                                                        <small class="text-muted"><i class="fas fa-envelope"></i> {{ $comment->email }}</small>
                                                        @if($comment->parent_id != 0 && $comment->parent_id != null)
                                                            <br><span class="badge-reply"><i class="fas fa-reply"></i> Reply</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="comment-text">
                                                        {{ strlen($comment->comment) > 100 ? substr($comment->comment, 0, 100) . '...' : $comment->comment }}
                                                        @if(strlen($comment->comment) > 100)
                                                            <br>
                                                            <a href="#" data-toggle="modal" data-target="#viewModal{{ $comment->id }}" class="text-primary">
                                                                <i class="fas fa-eye"></i> Read More
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($comment->status == 'Active')
                                                        <span class="badge-status badge-approved">
                                                            <i class="fas fa-check-circle"></i> Approved
                                                        </span>
                                                    @elseif($comment->status == 'Pending')
                                                        <span class="badge-status badge-pending">
                                                            <i class="fas fa-clock"></i> Pending
                                                        </span>
                                                    @elseif($comment->status == 'Rejected')
                                                        <span class="badge-status badge-rejected">
                                                            <i class="fas fa-times-circle"></i> Rejected
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar-alt"></i> {{ date('d M Y', strtotime($comment->created_at)) }}<br>
                                                    <small><i class="fas fa-clock"></i> {{ date('h:i A', strtotime($comment->created_at)) }}</small>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="action-btn dropdown-toggle" type="button" data-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @if($comment->status == 'Pending')
                                                                <a class="dropdown-item" href="{{ url('admin/blog-comment-status/'.$comment->id.'/Active') }}">
                                                                    <i class="fas fa-check-circle text-success"></i> Approve
                                                                </a>
                                                                <a class="dropdown-item" href="{{ url('admin/blog-comment-status/'.$comment->id.'/Rejected') }}">
                                                                    <i class="fas fa-times-circle text-danger"></i> Reject
                                                                </a>
                                                            @elseif($comment->status == 'Active')
                                                                <a class="dropdown-item" href="{{ url('admin/blog-comment-status/'.$comment->id.'/Rejected') }}">
                                                                    <i class="fas fa-thumbs-down text-danger"></i> Reject
                                                                </a>
                                                            @elseif($comment->status == 'Rejected')
                                                                <a class="dropdown-item" href="{{ url('admin/blog-comment-status/'.$comment->id.'/Active') }}">
                                                                    <i class="fas fa-thumbs-up text-success"></i> Approve
                                                                </a>
                                                            @endif
                                                            
                                                            <div class="dropdown-divider"></div>
                                                            
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewModal{{ $comment->id }}">
                                                                <i class="fas fa-eye text-info"></i> View Details
                                                            </a>
                                                            
                                                            <a class="dropdown-item" onclick="return confirm('Are you sure you want to delete this comment?');" href="{{ url('admin/blog-comment-delete/'.$comment->id) }}">
                                                                <i class="fas fa-trash text-danger"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- View Modal -->
                                            <div class="modal fade" id="viewModal{{ $comment->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header modal-header-custom">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-comment-dots"></i> Comment Details
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="info-box">
                                                                        <label>Blog:</label>
                                                                        <p><strong>{{ $comment->blog_title }}</strong></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="info-box">
                                                                        <label>Status:</label>
                                                                        <p>
                                                                            @if($comment->status == 'Active')
                                                                                <span class="badge-status badge-approved">Approved</span>
                                                                            @elseif($comment->status == 'Pending')
                                                                                <span class="badge-status badge-pending">Pending</span>
                                                                            @else
                                                                                <span class="badge-status badge-rejected">Rejected</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="info-box">
                                                                        <label>Name:</label>
                                                                        <p>{{ $comment->name }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="info-box">
                                                                        <label>Email:</label>
                                                                        <p>{{ $comment->email }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="info-box">
                                                                        <label>Comment:</label>
                                                                        <div class="comment-content-full">
                                                                            {{ $comment->comment }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="info-box">
                                                                        <label>Created At:</label>
                                                                        <p>{{ date('d M Y h:i A', strtotime($comment->created_at)) }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="info-box">
                                                                        <label>Last Updated:</label>
                                                                        <p>{{ date('d M Y h:i A', strtotime($comment->updated_at)) }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            
                            <div class="pagination-custom">
                                {!! $comments->links('pagination::bootstrap-4') !!}
                            </div>
                            
                            @else
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle"></i> No comments found!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Select All functionality
    document.getElementById('selectAll')?.addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.commentCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Update parent checkbox when individual checkboxes change
    document.querySelectorAll('.commentCheckbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let allChecked = document.querySelectorAll('.commentCheckbox:checked').length === document.querySelectorAll('.commentCheckbox').length;
            if(document.getElementById('selectAll')) {
                document.getElementById('selectAll').checked = allChecked;
            }
        });
    });
</script>

@endsection
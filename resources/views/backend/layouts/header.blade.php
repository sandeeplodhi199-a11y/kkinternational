@php
$user = Auth::user();

$permission_menu = $user->permission_menu ?? '';
$permExplode = $permission_menu ? explode(",", $permission_menu) : [];

$permission_submenu = $user->permission_submenu ?? '';
$permExplodesub = $permission_submenu ? explode(",", $permission_submenu) : [];



$permissionMap = [

    'admin/website/data' => '1_1',
    'admin/home' => '1_6',
    'admin/socialMedia' => '1_7',
    'admin/quotation' => '1_11',
    
    
    'admin/level'    => '2_2',
    'admin/add-level'   => '2_1',
    'admin/edit-level'   => '2_3',
    'admin/delete-level' => '2_4',

  
    'admin/grade'    => '2_6',
    'admin/add-grade'   => '2_5',
    'admin/edit-grade'   => '2_7',
    'admin/delete-grade' => '2_8',
    

   
    'admin/section'    => '2_10',
    'admin/add-section'   => '2_9',
    'admin/edit-section'   => '2_11',
    'admin/delete-section' => '2_12',

   
    'admin/session'    => '2_14',
    'admin/add-session'   => '2_13',
    'admin/edit-session'   => '2_15',
    'admin/delete-session' => '2_16',
    

   
    'admin/subject'    => '2_18',
    'admin/add-subject'   => '2_17',
    'admin/edit-subject'   => '2_19',
    'admin/delete-subject' => '2_20',

   
    'admin/exam'    => '8_2',
    'admin/add-exam'   => '8_1',
    'admin/edit-exam'   => '8_3',
    'admin/delete-exam' => '8_4',
    
     'admin/chapter'    => '2_26',
    'admin/add-chapter'   => '2_25',
    'admin/edit-chapter'   => '2_27',
    'admin/delete-chapter' => '2_28',
    
    
    
    'admin/student-add'    => '3_1',
    'admin/student-bulk-upload'   => '3_2',
    'admin/student-list'   => '3_3',
    'admin/student-edit'   => '3_4',
    'admin/student-list-transfer' => '3_5',
     'admin/student-id-card' => '3_6',
      'admin/student-promote' => '3_7',
      'admin/student-report' => '3_8',
      'admin/student-history-report' => '3_9',
      
    
     
     
     'admin/transfer-certificate'    => '4_1',
     'admin/transfer-list'    => '4_2',
     'admin/transfer-edit'    => '4_3',
     
     
      'admin/add-teacher'    => '5_1',
     'admin/teacher'    => '5_2',
     'admin/edit-teacher'    => '5_3',
     'admin/delete-teacher'    => '5_4',
     'admin/mark-evaluation'    => '5_5',
     'admin/student-marks-list'    => '8_8',
      'admin/student-marks-status'    => '5_7',
      'admin/teacher-chapter-progress'    => '9_1',
      'admin/syllabus-coverage'    => '9_2',
       'teacher/chapter-status-report'    => '9_3',
      
      
   
    

    'admin/users' => '6_1',
    'admin/edit-permission' => '6_2',
    'admin/edit-users' => '6_3',
    'admin/delete-users' => '6_4',
    'admin/del_users' => '6_5',
    

    
     'admin/add-blog-category'    => '16_2',
     'admin/blog-category'    => '16_1',
     'admin/edit-blog-category'    => '16_3',
     'admin/delete-blog-category'    => '16_4',
     
     
      'admin/add-blog-category'    => '16_6',
     'admin/blog-category'    => '16_5',
     'admin/edit-blog-category'    => '16_7',
     'admin/delete-blog'    => '16_8',
     
     
    'admin/add-service'    => '17_2',
     'admin/services'    => '17_1',
     'admin/edit-service'    => '17_3',
     'admin/delete-service'    => '17_4',
     
     
      'admin/add-events'    => '18_1',
     'admin/events'    => '18_2',
     'admin/edit-events'    => '18_3',
     'admin/delete-events'    => '18_4',
     
     
     'admin/add-video'    => '15_2',
     'admin/videos'    => '15_1',
     'admin/edit-video'    => '15_3',
     'admin/delete-video'    => '15_4',
     
     
      'admin/add-video'    => '15_2',
     'admin/videos'    => '14_2',
     'admin/edit-video'    => '15_3',
     'admin/delete-video'    => '15_4',
     
     
     
     'admin/add-slider'    => '10_2',
     'admin/slider'    => '10_1',
     'admin/edit-slider'    => '10_3',
     'admin/delete-slider'    => '10_4',
     
     
     'admin/add-team'    => '11_2',
     'admin/team'    => '11_1',
     'admin/edit-team'    => '11_3',
     'admin/delete-team'    => '11_4',
     
     
      'admin/add-testimonial'    => '12_2',
     'admin/testimonial'    => '12_1',
     'admin/edit-testimonial'    => '12_3',
     'admin/delete-testimonial'    => '12_4',
     
     
     'admin/student-marks-status'    => '8_9',
     'admin/student-marks-status-nursery'    => '8_10',
     
     
     'admin/student-data-list'    => '8_7',
     'admin/student-formate-list'    => '8_6',
     
     
     
    
    
    
];



$segments = request()->segments();

// build base path (first 2 segments)
$currentPath = '';
if (count($segments) >= 2) {
    $currentPath = $segments[0] . '/' . $segments[1];
} else {
    $currentPath = request()->path();
}



if (array_key_exists($currentPath, $permissionMap)) {

    $requiredPerm = $permissionMap[$currentPath];

    if (!in_array($requiredPerm, $permExplodesub)) {
        abort(403, 'Unauthorized Access');
    }
}
@endphp

<style>
.img-profile {
    vertical-align: middle;
    background-color: white;
    border-style: none;
    margin-top: -23px;
    border-radius: 40px;
}

/* ===================== GOLD DIVIDER (CRM Section) ===================== */
.nav-divider {
    border: none;
    height: 2.5px;
    margin: 3px 10px;
    list-style: none;
    background: linear-gradient(90deg,
            transparent,
            #d4af37,
            #ffd700,
            #d4af37,
            transparent);
    border-radius: 50px;
    box-shadow: 0 0 6px rgba(212, 175, 55, 0.7);
}

/* ===================== BLUE DIVIDER (Child items) ===================== */
.nav-sub-divider {
    border: none;
    height: 1.8px;
    margin: 3px 22px;
    list-style: none;
    background: linear-gradient(90deg,
            transparent,
            #4dafff,
            #007bff,
            #4dafff,
            transparent);
    border-radius: 50px;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
}

/* ===================== CRM MANAGEMENT LABEL BADGE ===================== */
.nav-crm-label {
    list-style: none;
    margin: 10px 14px 5px;
    padding: 0;
    display: block;
}
.nav-crm-label span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 99px;
    background: rgba(212, 175, 55, 0.18);
    color: #d4af37;
    border: 1px solid rgba(212, 175, 55, 0.45);
    box-shadow: 0 0 8px rgba(212, 175, 55, 0.2);
}

/* ===================== WEBSITE MANAGEMENT LABEL BADGE ===================== */
.nav-section-label {
    list-style: none;
    margin: 10px 14px 5px;
    padding: 0;
    display: block;
}
.nav-section-label span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 99px;
    background: rgba(77, 175, 255, 0.15);
    color: #4dafff;
    border: 1px solid rgba(77, 175, 255, 0.4);
    box-shadow: 0 0 8px rgba(77, 175, 255, 0.2);
}
</style>


<style>
.branch-link {
    text-decoration: none;
    color: #007bff;
    font-weight: 600;
}

.branch-link:hover {
    color: #007bff;
}

.branch-name {
    font-size: 21px;
    margin-top: 33px;
    margin-left: 15px;
}
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">



        <li class="nav-item dropdown" style="position: relative;"
            onmouseover="this.querySelector('.dropdown-menu').style.display='block';"
            onmouseout="this.querySelector('.dropdown-menu').style.display='none';">

           @php
                $user = Auth::user();
            
                if ($user->type === 'teacher') {
                    $folder = 'public/teacher/uploads/';
                } else {
                    $folder = null;
                }
            
                if ($folder) {
                    $imagePath = url($folder . $user->image);
                } else {
                    $imagePath = asset('public/default-user.png');
                }
            @endphp

            <a class="nav-link" href="#" id="userDropdown" role="button">
                <div style="display:flex; align-items:center;">
                    <img class="img-profile" src="{{ $imagePath }}" alt="user" width="40" height="35"
                        style="opacity:.8; margin-right:8px; border-radius:50%;">

                    <span class="user-name">{{ $user->name }}</span>
                    <i class="fa fa-angle-down" style="margin-left:5px;"></i>
                </div>
            </a>


            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown"
                style="display: none; position: absolute; top: 100%; right: 0; z-index: 1000;">
                <form action="{{ route('logout') }}" method="POST" style="margin-bottom: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item">Log Out</button>
                </form>
            </div>
        </li>


    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- branch Logo -->

    @php

    $companyProfile = DB::table('tbl_general')->where('id',1)->first();

    @endphp

    <a href="{{ route('dashboard')}}" class="branch-link d-flex align-items-center gap-2">

        <img src="{{ asset('public/uploads/'.$companyProfile->company_logo) }}" alt="{{ $companyProfile->school_name }}" height="60"
            width="60" class="img-circle elevation-3" style="opacity:0.8">
        <span class="branch-name">
            {{ $companyProfile->school_name }}
        </span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
           
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item <?php if($data['menu'] == 'dashboard') { echo 'menu-open'; } ?>">

                    <a href="{{ route('dashboard')}}"
                        class="nav-link <?php if($data['menu'] == 'dashboard'){ echo 'active'; } ?>">


                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>
                

                {{-- ==================== CRM MANAGEMENT SECTION ==================== --}}
                @php if( in_array('1', $permExplode)){ @endphp
                <li class="nav-divider"></li>

                <li class="nav-crm-label">
                    <span>
                        <i class="fas fa-briefcase" style="font-size:9px;"></i>
                        CRM Management
                    </span>
                </li>


                <!-- Settings -->
                <li class="nav-item has-treeview <?php if($data['menu'] == 'companies') { echo 'menu-open'; } ?>">

                    <a href="#" class="nav-link <?php if( $data['menu'] == 'companies' ) { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings<i class="fas fa-angle-left right"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                      
                           @php if (in_array('1_1', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/website/data') }}"
                                class="nav-link {{ $data['submenu'] == 'website_data' ? 'active' : '' }}">
                                <i class="fas fa-shoe-prints nav-icon"></i>
                                <p>View Website Data</p>
                            </a>
                        </li>
                        @php } @endphp
                        <li class="nav-sub-divider"></li>
                        
                       <!--  @php if( in_array('1_6', $permExplodesub)){ @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/home') }}"
                                class="nav-link <?php if($data['submenu'] == 'home') { echo 'active'; } ?>">
                                <i class="fas fa-home nav-icon"></i>
                                <p>View Home Management</p>
                            </a>
                        </li>
                        @php } @endphp -->
                        <li class="nav-sub-divider"></li> 
                        
                        @php if( in_array('1_7', $permExplodesub)){ @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/socialMedia') }}"
                                class="nav-link <?php if($data['submenu'] == 'social_gen') { echo 'active'; } ?>">
                                <i class="fab fa-facebook nav-icon"></i>
                                <p>View Social Media Links</p>
                            </a>
                        </li>
                        @php } @endphp
                        <li class="nav-sub-divider"></li>
                        
                        

                        @php if( in_array('1_11', $permExplodesub)){ @endphp
                        <li class="nav-item">
                            <a href="{{url('admin/quotation')}}"
                                class="nav-link <?php if($data['submenu'] == 'setting_quatation') { echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Master Settings</p>
                            </a>
                        </li>
                        @php } @endphp
                        <li class="nav-sub-divider"></li>

                    </ul>
                </li>

                @php } @endphp

                @php if(in_array('2', $permExplode)) { @endphp
                <li class="nav-divider"></li>


                <li class="nav-item has-treeview {{ $data['menu'] == 'categorys' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'categorys' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Master Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                     @php if( in_array('2_1', $permExplodesub)){ @endphp

                        <li class="nav-item">
                            <a href="{{ url('admin/add-level') }}"
                                class="nav-link {{ $data['submenu'] == 'level_add' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Add Level</p>
                            </a>
                        </li>

                @php } @endphp
                 @php if( in_array('2_2', $permExplodesub)){ @endphp

                        <li class="nav-item">
                            <a href="{{ url('admin/level') }}"
                                class="nav-link {{ $data['submenu'] == 'level_view' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Level</p>
                            </a>
                        </li>
                        
                            @php } @endphp


              @php if( in_array('2_5', $permExplodesub)){ @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/add-grade') }}"
                                class="nav-link {{ $data['submenu'] == 'grade_add' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Add Grade</p>
                            </a>
                        </li>

   @php } @endphp


              @php if( in_array('2_6', $permExplodesub)){ @endphp


                        <li class="nav-item">
                            <a href="{{ url('admin/grade') }}"
                                class="nav-link {{ $data['submenu'] == 'grade_view' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Grade</p>
                            </a>
                        </li>

 @php } @endphp


              @php if( in_array('2_9', $permExplodesub)){ @endphp



                        <li class="nav-item">
                            <a href="{{ url('admin/add-section') }}"
                                class="nav-link {{ $data['submenu'] == 'section_add' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Add Section</p>
                            </a>
                        </li>

 @php } @endphp


              @php if( in_array('2_10', $permExplodesub)){ @endphp


                        <li class="nav-item">
                            <a href="{{ url('admin/section') }}"
                                class="nav-link {{ $data['submenu'] == 'section_view' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Section</p>
                            </a>
                        </li>


 @php } @endphp


              @php if( in_array('2_13', $permExplodesub)){ @endphp


                        <li class="nav-item">
                            <a href="{{ url('admin/add-session') }}"
                                class="nav-link {{ $data['submenu'] == 'session_add' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Add Session</p>
                            </a>
                        </li>

 @php } @endphp


              @php if( in_array('2_14', $permExplodesub)){ @endphp



                        <li class="nav-item">
                            <a href="{{ url('admin/session') }}"
                                class="nav-link {{ $data['submenu'] == 'session_view' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Session</p>
                            </a>
                        </li>




                        @php } @endphp


              @php if( in_array('2_17', $permExplodesub)){ @endphp



                        <li class="nav-item">
                            <a href="{{url('admin/add-subject')}}" class="nav-link <?php if ($data['submenu'] == 'subject') {
                                                                    echo 'active';
                                                                  } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Subject </p>
                            </a>
                        </li>

 @php } @endphp


              @php if( in_array('2_18', $permExplodesub)){ @endphp


                        <li class="nav-item">
                            <a href="{{url('admin/subject')}}" class="nav-link <?php if ($data['submenu'] == 'subject1') {
                                                                    echo 'active';
                                                                  } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Subject</p>
                            </a>
                        </li>


 @php } @endphp


 

                         
                       @php  
if(in_array('2_25', $permExplodesub) && $user->type != 'teacher'){
@endphp

<li class="nav-item">
    <a href="{{url('admin/add-chapter')}}" class="nav-link <?php if ($data['submenu'] == 'add_chapter') { echo 'active'; } ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Chapter</p>
    </a>
</li>

@php } @endphp


@php  
if(in_array('2_26', $permExplodesub)){
@endphp

<li class="nav-item">
    <a href="{{url('admin/chapter')}}" class="nav-link <?php if ($data['submenu'] == 'view_chapter') { echo 'active'; } ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Manage Chapter</p>
    </a>
</li>

@php } @endphp

            

                        <li class="nav-sub-divider"></li>

                    </ul>
                </li>
                @php } @endphp




                @php if(in_array('3', $permExplode)) { @endphp
                <li class="nav-divider"></li>


                <li class="nav-item has-treeview {{ $data['menu'] == 'students' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'students' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Student Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        @php if(in_array('3_1', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/student-add') }}"
                                class="nav-link {{ $data['submenu'] == 'student_add' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Add Student</p>
                            </a>
                        </li>
                        @php } @endphp
                        
                          @php if(in_array('3_2', $permExplodesub)) { @endphp

                        <li class="nav-item">
                            <a href="{{ url('admin/student-bulk-upload') }}"
                                class="nav-link {{ $data['submenu'] == 'student_bulk_upload' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Bulk Upload </p>
                            </a>
                        </li>
                        @php } @endphp
                        
                        
                        
                          @php if(in_array('3_8', $permExplodesub)) { @endphp

                        <li class="nav-item">
                            <a href="{{ url('admin/student-report') }}"
                                class="nav-link {{ $data['submenu'] == 'student_report' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Download Current Records </p>
                            </a>
                        </li>
                        @php } @endphp
                        
                       
                       
                         @php if(in_array('3_9', $permExplodesub)) { @endphp

                        <li class="nav-item">
                            <a href="{{ url('admin/student-history-report') }}"
                                class="nav-link {{ $data['submenu'] == 'student_history_report' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Download Old Records </p>
                            </a>
                        </li>
                        @php } @endphp
                        
                        
                         
                       

                        @php if(in_array('3_3', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/student-list') }}"
                                class="nav-link {{ $data['submenu'] == 'student_list' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Active Students</p>
                            </a>
                        </li>
                        @php } @endphp
                        
                        
                      
                        
                        
                        
                         


                        @php if(in_array('3_5', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/student-list-transfer') }}"
                                class="nav-link {{ $data['submenu'] == 'student_list_transfer' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Transfer Students</p>
                            </a>
                        </li>
                        @php } @endphp



                        @php if(in_array('3_7', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/student-promote') }}"
                                class="nav-link {{ $data['submenu'] == 'student_promote' ? 'active' : '' }}">
                                <i class="fas fa-level-up-alt nav-icon"></i>
                                <p>Promote Students</p>
                            </a>
                        </li>
                        @php } @endphp




                        <li class="nav-sub-divider"></li>
                    </ul>
                </li>
                @php } @endphp
                
                
                
                 @php if(in_array('8', $permExplode)) { @endphp
                <li class="nav-divider"></li>


                <li class="nav-item has-treeview {{ $data['menu'] == 'categorys1' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'categorys1' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Exam Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                      
              @php if( in_array('8_1', $permExplodesub)){ @endphp


                        

                        <li class="nav-item">
                            <a href="{{url('admin/add-exam')}}" class="nav-link <?php if ($data['submenu'] == 'exam1') {
                                                                    echo 'active';
                                                                  } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Exam</p>
                            </a>
                        </li>
                        
                         @php } @endphp


              @php if( in_array('8_2', $permExplodesub)){ @endphp


                        <li class="nav-item">
                            <a href="{{url('admin/exam')}}" class="nav-link <?php if ($data['submenu'] == 'exam') {
                                                                    echo 'active';
                                                                  } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Exam</p>
                            </a>
                        </li>

 @php } @endphp
 
 
 
 
                      
                        @php if(in_array('8_5', $permExplodesub)) { @endphp

                        <li class="nav-item">
                            <a href="{{ url('admin/admit-card') }}"
                                class="nav-link {{ $data['submenu'] == 'admitcard' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Download Admit Card </p>
                            </a>
                        </li>
                        @php } @endphp
                          
                        
                      
   @php if(in_array('8_6', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/student-formate-list') }}"
                                class="nav-link {{ $data['submenu'] == 'student_formate_list' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Mark Record Slip</p>
                            </a>
                        </li>
                        @php } @endphp
                        
                        
                          @php if(in_array('8_7', $permExplodesub)) { @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/student-data-list') }}"
                                class="nav-link {{ $data['submenu'] == 'student_data_list' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Consolidated Marks</p>
                            </a>
                        </li>
                        @php } @endphp
                        
                        
                          @if(in_array('8_8', $permExplodesub))
                
                            
                            <li class="nav-item">
                                <a href="{{ url('admin/student-marks-list') }}"
                                    class="nav-link {{ $data['submenu'] == 'mark_evaluation_view' ? 'active' : '' }}">
                                    <i class="fas fa-eye nav-icon"></i>
                                    <p>View Mark Evaluation</p>
                                </a>
                            </li>
                            
                             @endif
                    
                        @if(in_array('8_9', $permExplodesub) && $user->type != 'teacher')
                    <li class="nav-item">
                        <a href="{{ url('admin/student-marks-status') }}"
                           class="nav-link {{ $data['submenu'] == 'show_mark_status' ? 'active' : '' }}">
                            <i class="fas fa-eye nav-icon"></i>
                            <p>View Marksheet 1 </p>
                        </a>
                    </li>
                    @endif
                    
                    
                      @if(in_array('8_10', $permExplodesub) && $user->type != 'teacher')
                    <li class="nav-item">
                        <a href="{{ url('admin/student-marks-status-nursery') }}"
                           class="nav-link {{ $data['submenu'] == 'show_mark_status_nursery' ? 'active' : '' }}">
                            <i class="fas fa-eye nav-icon"></i>
                            <p>View Marksheet 2</p>
                        </a>
                    </li>
                    @endif



                        <li class="nav-sub-divider"></li>
                    </ul>
                </li>
                @php } @endphp
                
                
                
                
                  @php if(in_array('9', $permExplode)) { @endphp
                <li class="nav-divider"></li>


                <li class="nav-item has-treeview {{ $data['menu'] == 'teachers1' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'teachers1' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Syllabus Tracker
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                      
             @if(in_array('9_1', $permExplodesub))
                    <li class="nav-item">
                        <a href="{{ url('admin/teacher-chapter-progress') }}"
                           class="nav-link {{ $data['submenu'] == 'teacher_chapter_progress' ? 'active' : '' }}">
                            <i class="fas fa-eye nav-icon"></i>
                            <p>Syllabus Tracker (Teacher-wise)</p>
                        </a>
                    </li>
                    @endif
                    @if(in_array('9_2', $permExplodesub))
                    <li class="nav-item">
                        <a href="{{ url('admin/syllabus-coverage') }}"
                           class="nav-link {{ $data['submenu'] == 'syllabus_coverage' ? 'active' : '' }}">
                            <i class="fas fa-book-reader nav-icon"></i>
                            <p>Exam Syllabus Coverage</p>
                        </a>
                    </li>
                       @endif
                    @if(in_array('9_3', $permExplodesub))
                    <li class="nav-item">
                        <a href="{{ url('teacher/chapter-status-report') }}"
                           class="nav-link {{ $data['submenu'] == 'teacher_chapter_status_report' ? 'active' : '' }}">
                            <i class="fas fa-eye nav-icon"></i>
                            <p>Syllabus Tracker (Grade-wise)</p>
                        </a>
                    </li>
                    @endif


                        <li class="nav-sub-divider"></li>
                    </ul>
                </li>
                @php } @endphp
                
                
                
                
                
                
                
     
                
                
                

             
               




                @if(in_array('4', $permExplode))

                <li class="nav-divider"></li>

                <li class="nav-item has-treeview {{ $data['menu'] == 'transfer_certificate' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'transfer_certificate' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Transfer Certificate
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        @if(in_array('4_1', $permExplodesub))
                        <li class="nav-item">
                            <a href="{{ url('admin/transfer-certificate') }}"
                                class="nav-link {{ $data['submenu'] == 'transfer_certificate' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Transfer Certificate</p>
                            </a>
                        </li>
                        @endif

                        @if(in_array('4_2', $permExplodesub))
                        <li class="nav-item">
                            <a href="{{ url('admin/transfer-list') }}"
                                class="nav-link {{ $data['submenu'] == 'transfer_list' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Transfer Certificate</p>
                            </a>
                        </li>
                        @endif
                        
                        
                        
                         @if(in_array('4_4', $permExplodesub))
                        <li class="nav-item">
                            <a href="{{ url('admin/transfer-certificate-10th') }}"
                                class="nav-link {{ $data['submenu'] == 'transfer_certificate_10th' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>10th Transfer Certificate</p>
                            </a>
                        </li>
                        @endif

                        @if(in_array('4_5', $permExplodesub))
                        <li class="nav-item">
                            <a href="{{ url('admin/transfer-list-10th') }}"
                                class="nav-link {{ $data['submenu'] == 'transfer_list_10th' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View 10th Transfer Certificate</p>
                            </a>
                        </li>
                        @endif

                        <li class="nav-sub-divider"></li>

                    </ul>
                </li>

                @endif

              @php
               $user = Auth::user();
              @endphp
              
              
                @if(in_array('5', $permExplode))
                
                <li class="nav-divider"></li>
                
                <li class="nav-item has-treeview {{ $data['menu'] == 'teachers' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'teachers' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Teacher Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                
                    <ul class="nav nav-treeview">
                
                   
                        @if(in_array('5_1', $permExplodesub) && $user->type != 'teacher')
                        <li class="nav-item">
                            <a href="{{ url('admin/add-teacher') }}"
                               class="nav-link {{ $data['submenu'] == 'teacher_add' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Add Teacher</p>
                            </a>
                        </li>
                        @endif
                    
               
                    
                    
                      @if(in_array('5_2', $permExplodesub))
                
                       
                        <li class="nav-item">
                            <a href="{{ url('admin/teacher') }}"
                                class="nav-link {{ $data['submenu'] == 'teacher_view' ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>View Teacher</p>
                            </a>
                        </li>
                        
                          @endif
                          
                          
                         
                    
                    
                      @if(in_array('5_5', $permExplodesub))
                
                        
                        <li class="nav-item">
                                <a href="{{ url('admin/mark-evaluation') }}"
                                    class="nav-link {{ $data['submenu'] == 'mark_evaluation' ? 'active' : '' }}">
                                    <i class="fas fa-chart-line nav-icon"></i>
                                    <p>Mark Evaluation</p>
                                </a>
                            </li>
                            
                             @endif
                    
                    
                    
                    
                    
                  
                    
                                            
                    </ul>
                </li>
                
                @endif



                @php if( in_array('6', $permExplode)){ @endphp

                <li class="nav-divider"></li>

                <li class="nav-item has-treeview <?php if ($data['menu'] == 'users') { echo 'menu-open'; } ?>">
                    <a href="#" class="nav-link <?php if ($data['menu'] == 'users') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Users Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @php if( in_array('6_1', $permExplodesub)){ @endphp

                        <li class="nav-item">
                            <a href="{{url('admin/users')}}"
                                class="nav-link <?php if ($data['submenu'] == 'users') { echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Users Management</p>
                            </a>
                        </li>
                        @php } @endphp

                        <li class="nav-sub-divider"></li>

                        @php if( in_array('6_5', $permExplodesub)){ @endphp


                        <li class="nav-item">
                            <a href="{{url('admin/del_users')}}"
                                class="nav-link <?php if ($data['submenu'] == 'del_users') {  echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Deleted View Users</p>
                            </a>
                        </li>

                        @php } @endphp
                        <li class="nav-sub-divider"></li>
                    </ul>

                </li>


                @php } @endphp

                @php if( in_array('7', $permExplode)){ @endphp

                <li class="nav-divider"></li>


                <li class="nav-item <?php if($data['submenu'] == 'forget_password') { echo 'active'; }  ?>">
                    <a href="{{ url('admin/forget-password') }}"
                        class="nav-link <?php if($data['submenu'] == 'forget_password') { echo 'active'; }  ?>">
                        <i class="fas fa-key nav-icon"></i>
                        <p>Change Password</p>
                    </a>
                </li>

                @php } @endphp
                
                
                
               

                <li class="nav-divider"></li>

                <li class="nav-section-label">
                    <span>
                        <i class="fas fa-globe" style="font-size:9px;"></i>
                        Website Management
                    </span>
                </li>
                
                 
                @php if( in_array('19', $permExplode)){ @endphp
                <li class="nav-item {{ $data['submenu'] == 'enquiry' ? 'active' : '' }}">
                    <a href="{{ url('admin/enquiry') }}"
                        class="nav-link {{ $data['submenu'] == 'enquiry' ? 'active' : '' }}">
                        <i class="fas fa-images nav-icon"></i>
                        <p>Enquiry Management</p>
                    </a>
                </li>
                 @php } @endphp
                    

 @php if( in_array('10', $permExplode)){ @endphp
                <li class="nav-item {{ $data['submenu'] == 'slider' ? 'active' : '' }}">
                    <a href="{{ url('admin/slider') }}"
                        class="nav-link {{ $data['submenu'] == 'slider' ? 'active' : '' }}">
                        <i class="fas fa-images nav-icon"></i>
                        <p>Slider</p>
                    </a>
                </li>
                 @php } @endphp
                 
                  @php if( in_array('11', $permExplode)){ @endphp
                
                <li class="nav-sub-divider"></li>

                <li class="nav-item {{ $data['submenu'] == 'team' ? 'active' : '' }}">
                    <a href="{{ url('admin/team') }}" class="nav-link {{ $data['submenu'] == 'team' ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Team</p>
                    </a>
                </li>
                
                 @php } @endphp
                 
                  @php if( in_array('12', $permExplode)){ @endphp
                <li class="nav-sub-divider"></li>

                <li class="nav-item {{ $data['submenu'] == 'testimonial' ? 'active' : '' }}">
                    <a href="{{ url('admin/testimonial') }}"
                        class="nav-link {{ $data['submenu'] == 'testimonial' ? 'active' : '' }}">
                        <i class="fas fa-comment-dots nav-icon"></i>
                        <p>Testimonial</p>
                    </a>
                </li>
                
                <li class="nav-sub-divider"></li>
                 @php } @endphp
                
                 @php if( in_array('13', $permExplode)){ @endphp

                <li class="nav-item {{ $data['submenu'] == 'faq' ? 'active' : '' }}">
                    <a href="{{ url('admin/faq') }}" class="nav-link {{ $data['submenu'] == 'faq' ? 'active' : '' }}">
                        <i class="fas fa-question-circle nav-icon"></i>
                        <p>Faq</p>
                    </a>
                </li>
                <li class="nav-sub-divider"></li>
                 @php } @endphp
                 
                   @php if( in_array('14', $permExplode) || in_array('15', $permExplode)){ @endphp
                <li class="nav-item has-treeview {{ in_array($data['submenu'], ['gallery_category', 'gallery', 'video_category', 'video']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ in_array($data['submenu'], ['gallery_category', 'gallery', 'video_category', 'video']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-photo-video"></i>
                        <p>Media<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php if( in_array('14', $permExplode)){ @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/gallery-categories') }}"
                                class="nav-link {{ $data['submenu'] == 'gallery_category' ? 'active' : '' }}">
                                <i class="fas fa-folder-open nav-icon"></i>
                                <p>Gallery Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/galleries') }}"
                                class="nav-link {{ $data['submenu'] == 'gallery' ? 'active' : '' }}">
                                <i class="fas fa-images nav-icon"></i>
                                <p>Gallery Images</p>
                            </a>
                        </li>
                        @php } @endphp

                        @php if( in_array('15', $permExplode)){ @endphp
                        <li class="nav-item">
                            <a href="{{ url('admin/video-categories') }}"
                                class="nav-link {{ $data['submenu'] == 'video_category' ? 'active' : '' }}">
                                <i class="fas fa-folder-open nav-icon"></i>
                                <p>Video Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/videos') }}"
                                class="nav-link {{ $data['submenu'] == 'video' ? 'active' : '' }}">
                                <i class="fas fa-video nav-icon"></i>
                                <p>Videos</p>
                            </a>
                        </li>
                        @php } @endphp
                    </ul>
                </li>
                <li class="nav-sub-divider"></li>
                 @php } @endphp
            
              @php if( in_array('16', $permExplode)){ @endphp
                <li class="nav-divider"></li>

                <li class="nav-item has-treeview {{ $data['menu'] == 'blog' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $data['menu'] == 'blog' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Blog Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

 @php if( in_array('16_1', $permExplodesub)){ @endphp
                        
                        <li class="nav-item">
                            <a href="{{ url('admin/blog-category') }}"
                                class="nav-link {{ $data['submenu'] == 'users' ? 'active' : '' }}">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>View Category Management</p>
                            </a>
                        </li>
                        
                         @php } @endphp
                         
                          @php if( in_array('16_2', $permExplodesub)){ @endphp
                      

                        <li class="nav-sub-divider"></li>

                      
                        <li class="nav-item">
                            <a href="{{ url('admin/blogs') }}"
                                class="nav-link {{ $data['submenu'] == 'blog' ? 'active' : '' }}">
                                <i class="fas fa-user-times nav-icon"></i>
                                <p>View Blog Management</p>
                            </a>
                        </li>
                        
                         @php } @endphp

                      

                        <li class="nav-sub-divider"></li>
                    </ul>
                </li>
                
                 @php } @endphp
                 
                  @php if( in_array('17', $permExplode)){ @endphp
  <li class="nav-sub-divider"></li>
  

                        <li class="nav-item {{ $data['submenu'] == 'service' ? 'active' : '' }}">
                            <a href="{{ url('admin/services') }}"
                                class="nav-link {{ $data['submenu'] == 'service' ? 'active' : '' }}">
                                <i class="fas fa-concierge-bell nav-icon"></i>
                                <p>Services</p>
                            </a>
                        </li>
                        
                         @php } @endphp
                         
                           @php if( in_array('18', $permExplode)){ @endphp

                        <li class="nav-sub-divider"></li>

                        <li class="nav-item {{ $data['submenu'] == 'events' ? 'active' : '' }}">
                            <a href="{{ url('admin/events') }}"
                                class="nav-link {{ $data['submenu'] == 'events' ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Events</p>
                            </a>
                        </li>
               @php } @endphp
    



                <!-- Logout link -->
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

                <li class="nav-divider"></li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
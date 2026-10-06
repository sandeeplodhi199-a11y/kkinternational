<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/clear-cache', function() {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return "ALL CACHE CLEARED ✅";
});



// Hisab Mittra Premium Business Management Platform Routes
require __DIR__.'/hisab_mittra.php';

// School Legacy Website (accessible via /school)
Route::get('/school', [App\Http\Controllers\HomeController::class, 'home'])->name('school.home');
Route::get('about-us',[App\Http\Controllers\HomeController::class, 'about_us']);
Route::get('team',[App\Http\Controllers\HomeController::class, 'team']);
Route::get('board-of-directors',[App\Http\Controllers\HomeController::class, 'board_of_directors']);
Route::get('goal',[App\Http\Controllers\HomeController::class, 'goal']);
Route::get('mission',[App\Http\Controllers\HomeController::class, 'mission']);
Route::get('chairman-message',[App\Http\Controllers\HomeController::class, 'director_message']);
Route::get('director-message',[App\Http\Controllers\HomeController::class, 'director_message']);
Route::get('principal-message',[App\Http\Controllers\HomeController::class, 'principal_message']);
Route::get('oath',[App\Http\Controllers\HomeController::class, 'oath']);
Route::get('accomplishment',[App\Http\Controllers\HomeController::class, 'accomplishment']);
Route::get('gallery',[App\Http\Controllers\HomeController::class, 'gallery']);
Route::get('gallery/{slug}',[App\Http\Controllers\HomeController::class, 'gallery_detail']);
Route::get('video',[App\Http\Controllers\HomeController::class, 'video']);
Route::get('video/{slug}',[App\Http\Controllers\HomeController::class, 'video_detail']);
Route::get('testimonial',[App\Http\Controllers\HomeController::class, 'testimonial']);
Route::get('faq',[App\Http\Controllers\HomeController::class, 'faq']);
Route::get('blogs',[App\Http\Controllers\HomeController::class, 'blogs']);
Route::get('blog/{slug}', [App\Http\Controllers\HomeController::class, 'blog_detail']);
Route::post('blog/{slug}/comment', [App\Http\Controllers\HomeController::class, 'store_comment']);
Route::get('/services', [App\Http\Controllers\HomeController::class, 'service'])->name('services');
Route::get('/day-boarding-programs', [App\Http\Controllers\HomeController::class, 'service'])->name('day.boarding.programs');
Route::get('/hostel-program', [App\Http\Controllers\HomeController::class, 'hostel_program'])->name('hostel.program');
Route::get('/kkis-yearly-program', [App\Http\Controllers\HomeController::class, 'kkis_yearly_program'])->name('kkis.yearly.program');
Route::get('/sop-of-kkis', [App\Http\Controllers\HomeController::class, 'sop_of_kkis'])->name('sop.of.kkis');
Route::get('/service/{slug}', [App\Http\Controllers\HomeController::class, 'service_detail'])->name('service.detail');
Route::get('/admission-procedures', [App\Http\Controllers\HomeController::class, 'admission_procedures'])->name('admission.procedures');
Route::get('/events', [App\Http\Controllers\HomeController::class, 'events'])->name('events');
Route::get('/event/{slug}', [App\Http\Controllers\HomeController::class, 'event_detail'])->name('event.detail');
Route::get('academics',[App\Http\Controllers\HomeController::class, 'academic']);
Route::get('academic',[App\Http\Controllers\HomeController::class, 'academic']);
Route::get('facility',[App\Http\Controllers\HomeController::class, 'facilities']);
Route::get('program',[App\Http\Controllers\HomeController::class, 'program']);
Route::get('download',[App\Http\Controllers\HomeController::class, 'download']);
Route::get('contact-us',[App\Http\Controllers\HomeController::class, 'contact_us']);
Route::get('term-condition',[App\Http\Controllers\HomeController::class, 'term_conditions']);
Route::get('privacy-policy',[App\Http\Controllers\HomeController::class, 'privacy_policy']);
Route::get('cancellation-refund',[App\Http\Controllers\HomeController::class, 'cancellation_refund']);
Route::get('facilities',[App\Http\Controllers\HomeController::class, 'facilities']);
Route::get('programs',[App\Http\Controllers\HomeController::class, 'programs']);




Route::post('/enquiry/submit', [App\Http\Controllers\HomeController::class, 'store'])->name('enquiry.store');


Route::get('/verify-student/{id}', function ($id) {
    $student = \App\Models\Admission::findOrFail($id);
    return view('verify-student', compact('student'));
});

// Login route handled via Auth routes







Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/voice-search', [App\Http\Controllers\Admin\DashboardController::class, 'voiceSearch']);


 
     // Settings
     Route::get('admin/company', [App\Http\Controllers\Admin\SettingsController::class, 'company']);
     Route::post('admin/saveCompany', [App\Http\Controllers\Admin\SettingsController::class, 'update']);

          // Quotation Setting
     Route::get('admin/quotation', [App\Http\Controllers\Admin\SettingsController::class, 'quotation']);
     Route::post('admin/saveQuotation', [App\Http\Controllers\Admin\SettingsController::class, 'quotation_update']);
 
     Route::get('admin/general', [App\Http\Controllers\Admin\SettingsController::class, 'general']);
     Route::post('admin/saveGeneral', [App\Http\Controllers\Admin\SettingsController::class, 'general_update']);

     Route::get('admin/socialMedia', [App\Http\Controllers\Admin\SettingsController::class, 'social']);
     Route::post('admin/saveMedia', [App\Http\Controllers\Admin\SettingsController::class, 'media_update']);

     Route::get('admin/home', [App\Http\Controllers\Admin\SettingsController::class, 'home']);
     Route::post('admin/saveHome', [App\Http\Controllers\Admin\SettingsController::class, 'home_update']);

     Route::get('admin/footer',[App\Http\Controllers\Admin\SettingsController::class,'footer']);
     Route::post('admin/saveFooter', [App\Http\Controllers\Admin\SettingsController::class,'save_foooter']);
     Route::get('admin/editFooter/{id}', [App\Http\Controllers\Admin\SettingsController::class,'edit_footer']);
     Route::post('admin/SaveeditFooter', [App\Http\Controllers\Admin\SettingsController::class,'edit_save_footer']);
     Route::get('admin/deleteFooter/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'del_footer']);
     Route::get('aadmin/update-footer-status/{id}', [App\Http\Controllers\Admin\BranchController::class, 'updatefooterStatus']);


     Route::get('admin/website/data', [App\Http\Controllers\Admin\SettingsController::class, 'website_data']);
    Route::post('admin/saveWebsitedata', [App\Http\Controllers\Admin\SettingsController::class, 'save_website_data']);
    Route::get('admin/editWebsitedata/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'edit_website_data']);
    Route::post('admin/SaveeditWebsitedata', [App\Http\Controllers\Admin\SettingsController::class, 'edit_save_website_data']);
    Route::get('admin/deleteWebsitedata/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'del_website_data']);
    Route::get('admin/update-website-data-status/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'updateWebsiteDataStatus']);

    //Page Management

    Route::get('admin/about-us-page',[App\Http\Controllers\Admin\PageController::class,'about_us_page']);
    Route::post('admin/saveAboutPage',[App\Http\COntrollers\Admin\PageController::class, 'save_about_us_page']); 

    Route::get('admin/pages',[App\Http\COntrollers\Admin\PageController::class, 'view']);
    Route::get('admin/add-page',[App\Http\Controllers\Admin\PageController::class, 'add']);
    Route::post('admin/savePage',[App\Http\Controllers\Admin\PageController::class, 'save']);
    Route::get('admin/editPage/{id}', [App\Http\Controllers\Admin\PageController::class, 'edit']);
    Route::post('admin/updatePage', [App\Http\Controllers\Admin\PageController::class, 'update']);
    Route::get('admin/delete-page/{id}',[App\Http\COntrollers\Admin\PageController::class, 'delete']);


    // Level 
    Route::get('admin/level', [App\Http\Controllers\Admin\LevelController::class, 'view']);
    Route::get('admin/add-level', [App\Http\Controllers\Admin\LevelController::class, 'add']);
    Route::post('admin/saveLevel', [App\Http\Controllers\Admin\LevelController::class, 'save']);
    Route::get('admin/edit-level/{id?}', [App\Http\Controllers\Admin\LevelController::class, 'edit']);
    Route::post('admin/updateLevel', [App\Http\Controllers\Admin\LevelController::class, 'update']);
    Route::get('admin/delete-level/{id?}', [App\Http\Controllers\Admin\LevelController::class, 'delete']);
    Route::get('admin/level/{id}', [App\Http\Controllers\Admin\LevelController::class, 'level'])->name('admin.lead.level');


     // Grade 
    Route::get('admin/grade', [App\Http\Controllers\Admin\GradeController::class, 'view']);
    Route::get('admin/add-grade', [App\Http\Controllers\Admin\GradeController::class, 'add']);
    Route::post('admin/saveGrade', [App\Http\Controllers\Admin\GradeController::class, 'save']);
    Route::get('admin/edit-grade/{id?}', [App\Http\Controllers\Admin\GradeController::class, 'edit']);
    Route::post('admin/updateGrade', [App\Http\Controllers\Admin\GradeController::class, 'update'])->name('grade.update');
    Route::get('admin/delete-grade/{id?}', [App\Http\Controllers\Admin\GradeController::class, 'delete']);
    Route::get('admin/grade/{id}', [App\Http\Controllers\Admin\GradeController::class, 'grade'])->name('admin.lead.grade');
    
    
    


    // Section 
    Route::get('admin/section', [App\Http\Controllers\Admin\SectionController::class, 'view']);
    Route::get('admin/add-section', [App\Http\Controllers\Admin\SectionController::class, 'add']);
    Route::post('admin/saveSection', [App\Http\Controllers\Admin\SectionController::class, 'save']);
    Route::get('admin/edit-section/{id?}', [App\Http\Controllers\Admin\SectionController::class, 'edit']);
    Route::post('admin/updateSection', [App\Http\Controllers\Admin\SectionController::class, 'update']);
    Route::get('admin/delete-section/{id?}', [App\Http\Controllers\Admin\SectionController::class, 'delete']);
    Route::get('admin/section/{id}', [App\Http\Controllers\Admin\SectionController::class, 'section'])->name('admin.lead.section');


     // Session 
    Route::get('admin/session', [App\Http\Controllers\Admin\SessionController::class, 'view']);
    Route::get('admin/add-session', [App\Http\Controllers\Admin\SessionController::class, 'add']);
    Route::post('admin/saveSession', [App\Http\Controllers\Admin\SessionController::class, 'save']);
    Route::get('admin/edit-session/{id?}', [App\Http\Controllers\Admin\SessionController::class, 'edit']);
    Route::post('admin/updateSession', [App\Http\Controllers\Admin\SessionController::class, 'update']);
    Route::get('admin/delete-session/{id?}', [App\Http\Controllers\Admin\SessionController::class, 'delete']);
    Route::get('admin/session/{id}', [App\Http\Controllers\Admin\SessionController::class, 'session'])->name('admin.lead.session');

    // Chapter 
  
  
    Route::get('admin/chapter', [App\Http\Controllers\Admin\ChapterController::class, 'view']);
    Route::get('admin/add-chapter', [App\Http\Controllers\Admin\ChapterController::class, 'add']);
    Route::post('admin/saveChapter', [App\Http\Controllers\Admin\ChapterController::class, 'save']);
    Route::get('admin/edit-chapter/{id?}', [App\Http\Controllers\Admin\ChapterController::class, 'edit']);
    Route::post('admin/updateChapter', [App\Http\Controllers\Admin\ChapterController::class, 'update'])->name('chapter.update');
    Route::get('admin/delete-chapter/{id?}', [App\Http\Controllers\Admin\ChapterController::class, 'delete']);
    Route::get('admin/chapter/{id}', [App\Http\Controllers\Admin\ChapterController::class, 'chapter'])->name('admin.lead.chapter');

  
    //teacher 
    Route::get('admin/teacher',[App\Http\Controllers\Admin\TeacherController::class, 'teacher'])->name('teacher');  
    Route::get('admin/add-teacher', [App\Http\Controllers\Admin\TeacherController::class, 'add_teacher'])->name('add_teacher');
    Route::post('admin/Saveteacher', [App\Http\Controllers\Admin\TeacherController::class, 'saveTeacher'])->name('saveTeacher');
    Route::get('admin/edit-teacher/{id_hash}', [App\Http\Controllers\Admin\TeacherController::class, 'edit_teacher'])->name('edit_teacher');
    Route::post('admin/Updateteacher', [App\Http\Controllers\Admin\TeacherController::class, 'Updateteacher'])->name('Updateteacher');
    Route::get('admin/delete-teacher/{id}', [App\Http\Controllers\Admin\TeacherController::class, 'deleteTeacher'])->name('deleteTeacher');
    Route::get('admin/update-teacher-status/{id}', [App\Http\Controllers\Admin\TeacherController::class, 'updateTeacherStatus']);
    Route::get('admin/teachers/export', [App\Http\Controllers\Admin\TeacherController::class, 'export'])->name('admin.teacher.export');
    
    
    Route::get('/admin/get-subjects/{grade_id}', [App\Http\Controllers\Admin\TeacherController::class, 'getSubjects']);
    
    

    Route::get('admin/mark-evaluation',[App\Http\Controllers\Admin\TeacherController::class, 'mark_evaluation'])->name('mark_evaluation');  
    
    Route::post('admin/save-student-marks', [App\Http\Controllers\Admin\TeacherController::class, 'saveStudentMarks']);
  
    Route::get('admin/student-marks-list', [App\Http\Controllers\Admin\TeacherController::class, 'studentMarksList'])->name('student-marks-list');
    
    
     Route::get('admin/get-sections-by-grade', [App\Http\Controllers\Admin\TeacherController::class, 'getSectionsByGrade'])->name('get-sections-by-grade');
      
       Route::get(
        'admin/student-marks-status',
        [App\Http\Controllers\Admin\TeacherController::class,'mark_status']
        )->name('student.marks.index');
        
        
       Route::get(
    'admin/student-marks-status-nursery',
    [App\Http\Controllers\Admin\TeacherController::class, 'mark_status_nursery']
)->name('student.marks.nursery.index');
 


Route::get('student-marksheet/nursery/bulk-print',
    [App\Http\Controllers\Admin\TeacherController::class, 'bulkPrintMarksheetNursery']
)->name('student.marksheet.nursery.bulk.print');

Route::get('student-marksheet/nursery/{student_id}/{exam_id}',
    [App\Http\Controllers\Admin\TeacherController::class, 'generateMarksheetNursery']
)->name('student.marksheet.nursery');

Route::get('student-marksheet/nursery/print/{student_id}/{exam_id}',
    [App\Http\Controllers\Admin\TeacherController::class, 'printMarksheetNursery']
)->name('student.marksheet.nursery.print');


Route::get ('admin/syllabus-coverage',                    [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'syllabus_coverage'])->name('syllabus_coverage');
Route::get ('admin/get-exams-syllabus/{grade_id}',        [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'getExams_syllabus']);
Route::get ('admin/get-teacher-grades-syllabus/{teacher_id}', [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'getTeacherGrades']);
Route::get ('admin/get-syllabus-coverage-subjects',       [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'getSyllabusCoverageSubjects']);
Route::get ('admin/get-syllabus-chapters',                [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'getChapters']);
Route::get ('admin/get-syllabus-coverage-existing',       [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'getSyllabusCoverageExisting']);
Route::post('admin/save-syllabus-coverage',               [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'saveSyllabusCoverage']);
Route::get ('admin/get-syllabus-coverage-report',         [App\Http\Controllers\Admin\TeacherSyllabusController::class, 'getSyllabusCoverageReport']);
 
 
Route::get('admin/student-formate-list',[App\Http\Controllers\Admin\TeacherController::class, 'student_formate_list'])->name('student_formate_list');  


 
Route::get('admin/student-data-list',[App\Http\Controllers\Admin\TeacherController::class, 'student_data_list'])->name('student_data_list');  



Route::get('admin/admit-card',                         [App\Http\Controllers\Admin\AdmitCardController::class, 'admit_card'])->name('admit_card');
Route::get('admin/get-grades/{sessionId}',             [App\Http\Controllers\Admin\AdmitCardController::class, 'getGrades'])->name('get_grades');
Route::get('admin/get-sections/{gradeId}',             [App\Http\Controllers\Admin\AdmitCardController::class, 'getSections'])->name('get_sections');
Route::get('admin/get-exams/{gradeId}',                [App\Http\Controllers\Admin\AdmitCardController::class, 'getExams'])->name('get_exams');
Route::post('admin/preview-students',                  [App\Http\Controllers\Admin\AdmitCardController::class, 'previewStudents'])->name('preview_students');
Route::post('admin/download-admit-cards',              [App\Http\Controllers\Admin\AdmitCardController::class, 'downloadAdmitCards'])->name('download_admit_cards');

Route::post('admin/preview-admit-cards', [App\Http\Controllers\Admin\AdmitCardController::class, 'previewAdmitCards'])->name('preview_admit_cards');
Route::get('admin/download-blank-admit-card', [App\Http\Controllers\Admin\AdmitCardController::class, 'downloadBlankTemplate'])->name('download_blank_admit_card');
 

   Route::get('admin/teacher/chapter-status/{id}', [App\Http\Controllers\Admin\TeacherController::class, 'edit_chapter_status']);
    Route::post('admin/teacher/save-chapter-status', [App\Http\Controllers\Admin\TeacherController::class, 'save_chapter_status']);
    Route::get('admin/teacher/get-chapters/{subject_id}/{grade_id}', [App\Http\Controllers\Admin\TeacherController::class, 'getChaptersBySubject']);
    Route::get('admin/teacher/get-chapter-status/{teacher_id}/{session_id}/{grade_id}/{section_id}/{subject_id}', [App\Http\Controllers\Admin\TeacherController::class, 'getChapterStatus']);
    Route::get('admin/teacher/get-chapter-logs/{teacher_id}/{session_id}/{grade_id}/{section_id}/{subject_id}/{chapter_id}', [App\Http\Controllers\Admin\TeacherController::class, 'getChapterLogs']);
    Route::get('admin/get-subjects-by-ids', [App\Http\Controllers\Admin\TeacherController::class, 'getSubjectsByIds']);
       
    
    // Teacher Chapter Progress Report Routes
Route::get('admin/teacher-chapter-progress', [App\Http\Controllers\Admin\TeacherController::class, 'chapterProgressReport']);
Route::get('admin/teacher-chapter-progress-data', [App\Http\Controllers\Admin\TeacherController::class, 'getChapterProgressData']);
Route::get('admin/teacher-chapter-progress-export', [App\Http\Controllers\Admin\TeacherController::class, 'exportChapterProgressReport']);


Route::get('student-marksheet/bulk-print', [App\Http\Controllers\Admin\TeacherController::class, 'bulkPrintMarksheet'])->name('student.marksheet.bulk.print');

Route::get('/teacher/chapter-status-report', [App\Http\Controllers\Admin\TeacherController::class, 'teacher_chapter_status_report'])->name('teacher.chapter-status.report');
   
    Route::get('student-marksheet/{student_id}/{exam_id}', [App\Http\Controllers\Admin\TeacherController::class, 'generateMarksheet'])->name('student.marksheet');
    Route::get('student-marksheet/print/{student_id}/{exam_id}', [App\Http\Controllers\Admin\TeacherController::class, 'printMarksheet'])->name('student.marksheet.print');
        

     Route::get('admin/exam', [App\Http\Controllers\Admin\ExamCategoryController::class, 'exam'])->name('exam');
     Route::get('admin/add-exam',
        [App\Http\Controllers\Admin\ExamCategoryController::class,'add_exam'])->name('add_exam');
        
        Route::post('admin/saveExam',
        [App\Http\Controllers\Admin\ExamCategoryController::class,'saveExam'])->name('saveExam');

     Route::get('admin/edit-exam/{id?}', [App\Http\Controllers\Admin\ExamCategoryController::class, 'editExam'])->name('editExam');
     Route::post('admin/updateExam', [App\Http\Controllers\Admin\ExamCategoryController::class, 'updateExam'])->name('updateExam');
     Route::get('admin/delete-exam/{id?}', [App\Http\Controllers\Admin\ExamCategoryController::class, 'deleteExam'])->name('deleteExam');
     Route::get('admin/get-subject-marks/{exam_id}/{grade_id}', [App\Http\Controllers\Admin\ExamCategoryController::class, 'getSubjectMarks']);

   
     Route::get('admin/users', [App\Http\Controllers\Admin\UserController::class, 'users'])->name('users');
     Route::get('admin/add-users', [App\Http\Controllers\Admin\UserController::class, 'add_users'])->name('add_users');
     Route::post('admin/saveUsers', [App\Http\Controllers\Admin\UserController::class, 'saveUsers'])->name('saveUsers');
     Route::get('admin/edit-users/{id?}', [App\Http\Controllers\Admin\UserController::class, 'editUsers'])->name('editUsers');
     Route::post('admin/updateUsers', [App\Http\Controllers\Admin\UserController::class, 'updateUsers'])->name('updateUsers');
     Route::get('admin/delete-users/{id?}', [App\Http\Controllers\Admin\UserController::class, 'deleteUsers'])->name('deleteuUers');
     Route::get('admin/del_users', [App\Http\Controllers\Admin\UserController::class, 'del_users'])->name('del_users');
     Route::get('admin/restore-users/{id?}', [App\Http\Controllers\Admin\UserController::class, 'restoreUsers'])->name('restoreUsers');
     Route::get('admin/edit-permission/{id?}', [App\Http\Controllers\Admin\UserController::class, 'editPermission'])->name('editPermission');
     Route::post('admin/updatePermission', [App\Http\Controllers\Admin\UserController::class, 'updatePermission'])->name('updatePermission');

     Route::get('admin/manager-users', [App\Http\Controllers\Admin\UserController::class, 'manager_users'])->name('manager_users');
     Route::get('admin/tl-users', [App\Http\Controllers\Admin\UserController::class, 'tl_users'])->name('tl_users');
     Route::get('admin/telecaller-users', [App\Http\Controllers\Admin\UserController::class, 'telecaller_users'])->name('telecaller_users');



    
       
    Route::get('admin/student-add', [App\Http\Controllers\Admin\LeadController::class, 'student_add'])->name('student_add'); 
    Route::get('/admin/get-sections/{grade_id}', [App\Http\Controllers\Admin\LeadController::class, 'getSections']); 
    Route::post('admin/student-save', [App\Http\Controllers\Admin\LeadController::class, 'student_save'])->name('student_save');  
    Route::get('admin/student-list', [App\Http\Controllers\Admin\LeadController::class, 'student_list'])->name('student_list');  
    Route::get('admin/student-list-transfer', [App\Http\Controllers\Admin\LeadController::class, 'student_list_transfer'])->name('student_list_transfer');  
    Route::get('admin/student-edit/{id}', [App\Http\Controllers\Admin\LeadController::class, 'student_edit'])->name('student_edit');
    Route::get('admin/student-bulk-upload', [App\Http\Controllers\Admin\LeadController::class, 'student_bulk_upload_form'])->name('student_bulk_upload_form');
    Route::post('admin/student-bulk-upload-save', [App\Http\Controllers\Admin\LeadController::class, 'student_bulk_upload_save'])->name('student_bulk_upload_save');
    Route::get('admin/get-enrollment-no', [App\Http\Controllers\Admin\LeadController::class, 'getEnrollmentNo']);
    Route::get('admin/student-id-card/{id}', [App\Http\Controllers\Admin\LeadController::class, 'studentIdCard']);



    Route::get('admin/transfer-certificate', [App\Http\Controllers\Admin\LeadController::class, 'transfer_certificate']);
    Route::post('/transfer-certificate-save',[App\Http\Controllers\Admin\LeadController::class, 'save_transfer_certificate'])->name('transfer.certificate.save');

    Route::get('admin/transfer-list', [App\Http\Controllers\Admin\LeadController::class, 'transfer_list']);
    
    Route::get('admin/transfer-edit/{id}', [App\Http\Controllers\Admin\LeadController::class, 'transfer_edit']);
   Route::post('admin/transfer-save', [App\Http\Controllers\Admin\LeadController::class, 'transfer_save'])
    ->name('transfer.certificate.update');
    
    
   Route::get('admin/transfer-certificate-10th', [App\Http\Controllers\Admin\LeadController::class, 'transfer_certificate_10th'])->name('transfer.certificate.10th');
Route::post('admin/transfer-certificate-10th-save', [App\Http\Controllers\Admin\LeadController::class, 'save_transfer_certificate_10th'])->name('transfer.certificate.10th.save');
Route::get('admin/transfer-list-10th', [App\Http\Controllers\Admin\LeadController::class, 'transfer_list_10th'])->name('transfer.list.10th');
Route::get('admin/transfer-edit-10th/{id}', [App\Http\Controllers\Admin\LeadController::class, 'transfer_edit_10th'])->name('transfer.edit.10th');
Route::post('admin/transfer-save-10th', [App\Http\Controllers\Admin\LeadController::class, 'transfer_save_10th'])->name('transfer.certificate.10th.update');
 
 
    //Enquriy Management
    Route::get('admin/enquiry', [App\Http\Controllers\Admin\EnquiryController::class, 'enquiry'])->name('enquiry');

// Yeh 2 naye add karo:
Route::get('admin/enquiry/{id}', [App\Http\Controllers\Admin\EnquiryController::class, 'show'])->name('enquiry.show');
Route::get('admin/enquiry/delete/{id}', [App\Http\Controllers\Admin\EnquiryController::class, 'delete'])->name('enquiry.delete');

    // Generate AdmitCard

    Route::get('admin/generate-admitcard',[App\Http\Controllers\Admin\LeadController::class, 'generate_admitcard'])->name('generate_admitcard');
   
    Route::get('get-subjects-by-exam/{exam_id}', [App\Http\Controllers\Admin\LeadController::class, 'getSubjectsByExam']);
    Route::post('admin/save-admitcard', [App\Http\Controllers\Admin\LeadController::class, 'saveAdmitcard'])->name('save_admitcard');
    Route::get('admin/admitcard-list', [App\Http\Controllers\Admin\LeadController::class, 'admitcard_list'])->name('admitcard_list');
    Route::get('admin/get-admitcard-subjects/{id}', [App\Http\Controllers\Admin\LeadController::class, 'getAdmitcardSubjects']);
    Route::get('admin/delete-admitcard/{id}',[App\Http\Controllers\Admin\LeadController::class, 'deleteAdmitcard']);
    Route::get('admin/view-admitcard-studentwise',[App\Http\Controllers\Admin\LeadController::class, 'viewadmitcard_studentwise'])->name('viewadmitcard_studentwise');  
    Route::get('admin/admit-card-view/{id}', [App\Http\Controllers\Admin\LeadController::class, 'viewAdmitCard']);
    Route::get('admin/admit-card-download/{id}', [App\Http\Controllers\Admin\LeadController::class, 'downloadAdmitCardPDF']);

    Route::get('admin/student-promote', [App\Http\Controllers\Admin\LeadController::class, 'promote'])->name('student.promote');

    Route::get('admin/get-students', [App\Http\Controllers\Admin\LeadController::class, 'getStudents']);
     Route::get('admin/get-student-marks', [App\Http\Controllers\Admin\LeadController::class, 'getStudentMarks']);
  Route::get('admin/get-exams/{grade_id}', [App\Http\Controllers\Admin\LeadController::class, 'getExams'])->name('get.exams');
    Route::get('admin/get-exam-subjects', [App\Http\Controllers\Admin\LeadController::class, 'getExamSubjects']);
    
    Route::get('admin/get-exam-subject-summary', [App\Http\Controllers\Admin\LeadController::class, 'getExamSubjectSummary']);

    Route::post('admin/student-promote', [App\Http\Controllers\Admin\LeadController::class, 'storePromote'])->name('student.promote.store');
    
    
    
   

    
    Route::get('admin/generate-result',[App\Http\Controllers\Admin\LeadController::class, 'generate_result'])->name('generate_result');
  
    Route::get('get-students-by-session-course', [App\Http\Controllers\Admin\LeadController::class, 'getStudentsBySessionCourse']);

    Route::post('admin/save-result', [App\Http\Controllers\Admin\LeadController::class, 'save_result'])->name('save_result');
    Route::get('admin/result-list',[App\Http\Controllers\Admin\LeadController::class, 'result_list'])->name('result_list');
    Route::get('admin/result-download/{student_id}/{exam_id}/{marksheet_no}', [App\Http\Controllers\Admin\LeadController::class, 'downloadResult'])->name('result.download');

Route::get('admin/student-history-report',          [App\Http\Controllers\Admin\StudentHistoryReportController::class, 'student_history_report'])          ->name('student-history-report');
Route::get('admin/student-history-report/download', [App\Http\Controllers\Admin\StudentHistoryReportController::class, 'student_history_report_download']) ->name('student-history-report.download');    




 
Route::get('admin/student-report',          [App\Http\Controllers\Admin\StudentReportController::class, 'student_report'])         ->name('student-report');
Route::get('admin/student-report/download', [App\Http\Controllers\Admin\StudentReportController::class, 'student_report_download'])->name('student-report.download');
 

    //Final Generate Result
    Route::get('admin/generate-final-result',[App\Http\Controllers\Admin\LeadController::class, 'generate_final_result'])->name('generate_final_result');
    Route::post('admin/generate-final-result',[App\Http\Controllers\Admin\LeadController::class, 'save_generate_final_result'])->name('save_generate_final_result');
    Route::get('final-marksheet/download/{student_id}/{course_id}/{session}',[App\Http\Controllers\Admin\LeadController::class, 'downloadFinalMarksheet'])->name('final.marksheet.download');


 
    // Download Certificate
    Route::get('certificate/download/{student_id}/{course_id}/{session}',[App\Http\Controllers\Admin\LeadController::class, 'downloadCertificate'])->name('certificate.download');

     //News Management
    Route::get('admin/news',[App\Http\COntrollers\Admin\NewsletterController::class,'news'])->name('news');
    Route::get('admin/update-news-status/{id}', [App\Http\Controllers\Admin\NewsletterController::class,'news_update']); 


   

   //forget password

    Route::get('admin/forget-password',[App\Http\Controllers\Admin\ForgetPasswordController::class, 'forget_password'])->name('forget_password');
    Route::post('admin/update-forget-password',[App\Http\Controllers\Admin\ForgetPasswordController::class, 'update_forget_password'])->name('update_forget_password');




      //Subject

    Route::get('admin/subject', [App\Http\Controllers\Admin\SubjectController::class, 'subject'])->name('subject');
    Route::get('admin/add-subject', [App\Http\Controllers\Admin\SubjectController::class, 'add_subject'])->name('add_subject');
    Route::post('admin/savesubject', [App\Http\Controllers\Admin\SubjectController::class, 'saveSubject'])->name('saveSubject');
    Route::get('admin/edit-subject/{id?}', [App\Http\Controllers\Admin\SubjectController::class, 'editSubject'])->name('editSubject');
    Route::post('admin/updateSubject', [App\Http\Controllers\Admin\SubjectController::class, 'updateSubject'])->name('updateSubject');
    Route::get('admin/delete-subject/{id?}', [App\Http\Controllers\Admin\SubjectController::class, 'deleteSubject'])->name('deleteSubject');
    Route::get('admin/del_subject', [App\Http\Controllers\Admin\SubjectController::class, 'del_subject'])->name('del_subject');
    Route::get('admin/restore-subject/{id?}', [App\Http\Controllers\Admin\SubjectController::class, 'restoreSubject'])->name('restoreSubject');
    
    
    
    
    
    
    
    // Slider
    Route::get('admin/slider', [App\Http\Controllers\Admin\SliderController::class, 'slider']);
    Route::get('admin/add-slider', [App\Http\Controllers\Admin\SliderController::class, 'add']);
    Route::post('admin/saveSlider', [App\Http\Controllers\Admin\SliderController::class, 'save']);
    Route::get('admin/edit-slider/{id?}', [App\Http\Controllers\Admin\SliderController::class, 'edit']);
    Route::post('admin/updateSlider', [App\Http\Controllers\Admin\SliderController::class, 'update']);
    Route::get('admin/delete-slider/{id?}', [App\Http\Controllers\Admin\SliderController::class, 'delete']);

    
    // Testimonial
    Route::get('admin/testimonial', [App\Http\Controllers\Admin\TestimonialController::class, 'view']);
    Route::get('admin/add-testimonial', [App\Http\Controllers\Admin\TestimonialController::class, 'add']);
    Route::post('admin/saveTestimonial', [App\Http\Controllers\Admin\TestimonialController::class, 'save']);
    Route::get('admin/edit-testimonial/{id?}', [App\Http\Controllers\Admin\TestimonialController::class, 'edit']);
    Route::post('admin/updateTestimonial', [App\Http\Controllers\Admin\TestimonialController::class, 'update']);
    Route::get('admin/delete-testimonial/{id?}', [App\Http\Controllers\Admin\TestimonialController::class, 'delete']);


      // Our Team
    Route::get('admin/team', [App\Http\Controllers\Admin\TeamController::class, 'view']);
    Route::get('admin/add-team', [App\Http\Controllers\Admin\TeamController::class, 'add']);
    Route::post('admin/saveTeam', [App\Http\Controllers\Admin\TeamController::class, 'save']);
    Route::get('admin/edit-team/{id?}', [App\Http\Controllers\Admin\TeamController::class, 'edit']);
    Route::post('admin/updateTeam', [App\Http\Controllers\Admin\TeamController::class, 'update']);
    Route::get('admin/delete-team/{id?}', [App\Http\Controllers\Admin\TeamController::class, 'delete']);


    // Faq
    Route::get('admin/faq', [App\Http\Controllers\Admin\FaqController::class, 'view']);
    Route::get('admin/add-faq', [App\Http\Controllers\Admin\FaqController::class, 'add']);
    Route::post('admin/saveFaq', [App\Http\Controllers\Admin\FaqController::class, 'save']);
    Route::get('admin/edit-faq/{id?}', [App\Http\Controllers\Admin\FaqController::class, 'edit']);
    Route::post('admin/updateFaq', [App\Http\Controllers\Admin\FaqController::class, 'update']);
    Route::get('admin/delete-faq/{id?}', [App\Http\Controllers\Admin\FaqController::class, 'delete']);
    Route::get('admin/faq_up/{count?}/{id?}', [App\Http\Controllers\Admin\FaqController::class, 'faq_up']);


    
     // Gallery
     Route::get('admin/gallery-categories', [App\Http\Controllers\Admin\GalleryCategoryController::class, 'index']);
     Route::get('admin/add-gallery-category', [App\Http\Controllers\Admin\GalleryCategoryController::class, 'add']);
     Route::post('admin/saveGalleryCategory', [App\Http\Controllers\Admin\GalleryCategoryController::class, 'save']);
     Route::get('admin/edit-gallery-category/{id?}', [App\Http\Controllers\Admin\GalleryCategoryController::class, 'edit']);
     Route::post('admin/updateGalleryCategory', [App\Http\Controllers\Admin\GalleryCategoryController::class, 'update']);
     Route::get('admin/delete-gallery-category/{id?}', [App\Http\Controllers\Admin\GalleryCategoryController::class, 'delete']);
     Route::get('admin/galleries', [App\Http\Controllers\Admin\GalleryController::class, 'galleries'])->name('galleries');
     Route::get('admin/add-gallery', [App\Http\Controllers\Admin\GalleryController::class, 'add_gallery'])->name('add_gallery');
     Route::post('admin/saveGallery', [App\Http\Controllers\Admin\GalleryController::class, 'saveGallery'])->name('saveGallery');
     Route::get('admin/edit-gallery/{id?}', [App\Http\Controllers\Admin\GalleryController::class, 'editGallery'])->name('editGallery');
     Route::post('admin/updateGallery', [App\Http\Controllers\Admin\GalleryController::class, 'updateGallery'])->name('updateGallery');
     Route::get('admin/delete-gallery/{id?}', [App\Http\Controllers\Admin\GalleryController::class, 'deleteGallery'])->name('deleteGallery');
     Route::get('admin/del_gallery', [App\Http\Controllers\Admin\GalleryController::class, 'del_gallery'])->name('del_gallery');
     Route::get('admin/restore-gallery/{id?}', [App\Http\Controllers\Admin\GalleryController::class, 'restoreGallery'])->name('restoreGallery');
     Route::get('admin/gallery-poular', [App\Http\Controllers\Admin\GalleryController::class, 'galleryPoular'])->name('galleryPoular');
     

     
    // Video    
    Route::get('admin/video-categories', [App\Http\Controllers\Admin\VideoCategoryController::class, 'index']);
    Route::get('admin/add-video-category', [App\Http\Controllers\Admin\VideoCategoryController::class, 'add']);
    Route::post('admin/saveVideoCategory', [App\Http\Controllers\Admin\VideoCategoryController::class, 'save']);
    Route::get('admin/edit-video-category/{id?}', [App\Http\Controllers\Admin\VideoCategoryController::class, 'edit']);
    Route::post('admin/updateVideoCategory', [App\Http\Controllers\Admin\VideoCategoryController::class, 'update']);
    Route::get('admin/delete-video-category/{id?}', [App\Http\Controllers\Admin\VideoCategoryController::class, 'delete']);
    Route::get('admin/videos', [App\Http\Controllers\Admin\VideoController::class, 'videos'])->name('videos');
    Route::get('admin/add-video', [App\Http\Controllers\Admin\VideoController::class, 'add_video'])->name('add_video');
    Route::post('admin/saveVideo', [App\Http\Controllers\Admin\VideoController::class, 'saveVideo'])->name('saveVideo');
    Route::get('admin/edit-video/{id?}', [App\Http\Controllers\Admin\VideoController::class, 'editVideo'])->name('editVideo');
    Route::post('admin/updateVideo', [App\Http\Controllers\Admin\VideoController::class, 'updateVideo'])->name('updateVideo');
    Route::get('admin/delete-video/{id?}', [App\Http\Controllers\Admin\VideoController::class, 'deletevideo'])->name('deletevideo');
    Route::get('admin/del_video', [App\Http\Controllers\Admin\VideoController::class, 'del_video'])->name('del_video');
    Route::get('admin/restore-video/{id?}', [App\Http\Controllers\Admin\VideoController::class, 'restoreVideo'])->name('restoreVideo');
    Route::get('admin/video-poular', [App\Http\Controllers\Admin\VideoController::class, 'videoPoular'])->name('videoPoular');
    

    

   

    // Blog Category
    Route::get('admin/blog-category', [App\Http\Controllers\Admin\BlogCategoryController::class, 'category'])->name('category');
    Route::get('admin/add-blog-category', [App\Http\Controllers\Admin\BlogCategoryController::class, 'add_category'])->name('add_category');
    Route::post('admin/saveBlogCategory', [App\Http\Controllers\Admin\BlogCategoryController::class, 'saveCategory'])->name('saveCategory');
    Route::get('admin/edit-blog-category/{id?}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'editCategory'])->name('editCategory');
    Route::post('admin/updateBlogCategory', [App\Http\Controllers\Admin\BlogCategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::get('admin/delete-blog-category/{id?}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'deleteCategory'])->name('deleteCategory');
    Route::get('admin/del_blog_category', [App\Http\Controllers\Admin\BlogCategoryController::class, 'del_category'])->name('del_category');
    Route::get('admin/restore-blog-category/{id?}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'restoreCategory'])->name('restoreCategory');
    Route::get('admin/category_up_blog/{count?}/{id?}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'category_up'])->name('category_up');
    
    


    // Blogs
    Route::get('admin/blogs', [App\Http\Controllers\Admin\BlogController::class, 'blogs'])->name('blogs');
    Route::get('admin/add-blog', [App\Http\Controllers\Admin\BlogController::class, 'add_blog'])->name('add_blog');
    Route::post('admin/saveBlog', [App\Http\Controllers\Admin\BlogController::class, 'saveBlog'])->name('saveBlog');
    Route::get('admin/edit-blog/{id?}', [App\Http\Controllers\Admin\BlogController::class, 'editBlog'])->name('editBlog');
    Route::post('admin/updateBlog', [App\Http\Controllers\Admin\BlogController::class, 'updateBlog'])->name('updateBlog');
    Route::get('admin/delete-blog/{id?}', [App\Http\Controllers\Admin\BlogController::class, 'deleteBlog'])->name('deleteBlog');
    Route::get('admin/del_blog', [App\Http\Controllers\Admin\BlogController::class, 'del_blog'])->name('del_blog');
    Route::get('admin/restore-blog/{id?}', [App\Http\Controllers\Admin\BlogController::class, 'restoreBlog'])->name('restoreBlog');
    Route::get('admin/blog-poular', [App\Http\Controllers\Admin\BlogController::class, 'blogPoular'])->name('blogPoular');
   
    
    // Service
    Route::get('admin/services', [App\Http\Controllers\Admin\ServiceController::class, 'services'])->name('services');
    Route::get('admin/add-service', [App\Http\Controllers\Admin\ServiceController::class, 'add_service'])->name('add_service');
    Route::post('admin/saveService', [App\Http\Controllers\Admin\ServiceController::class, 'saveService'])->name('saveService');
    Route::get('admin/edit-service/{id?}', [App\Http\Controllers\Admin\ServiceController::class, 'editService'])->name('editService');
    Route::post('admin/updateService', [App\Http\Controllers\Admin\ServiceController::class, 'updateService'])->name('updateService');
    Route::get('admin/delete-service/{id?}', [App\Http\Controllers\Admin\ServiceController::class, 'deleteService'])->name('deleteService');
    Route::get('admin/del_service', [App\Http\Controllers\Admin\ServiceController::class, 'del_service'])->name('del_service');
    Route::get('admin/restore-service/{id?}', [App\Http\Controllers\Admin\ServiceController::class, 'restoreService'])->name('restoreService');
    Route::get('admin/service-poular', [App\Http\Controllers\Admin\ServiceController::class, 'servicePoular'])->name('servicePoular');
    

    
    // Events
    Route::get('admin/events', [App\Http\Controllers\Admin\EventsController::class, 'view']);
    Route::get('admin/add-events', [App\Http\Controllers\Admin\EventsController::class, 'add']);
    Route::post('admin/saveEvents', [App\Http\Controllers\Admin\EventsController::class, 'save']);
    Route::get('admin/edit-events/{id?}', [App\Http\Controllers\Admin\EventsController::class, 'edit']);
    Route::post('admin/updateEvents', [App\Http\Controllers\Admin\EventsController::class, 'update']);
    Route::get('admin/delete-events/{id?}', [App\Http\Controllers\Admin\EventsController::class, 'delete']);



});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// CRM Web Application Routes
require __DIR__.'/crm.php';

Route::fallback(function () {
    abort(404);
});

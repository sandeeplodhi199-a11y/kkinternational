<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Session;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Exports\TeacherExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeacherController extends Controller
{
    
    
public function teacher(Request $request)
{
    $user = Auth::user();

    $data['menu']    = 'teachers';
    $data['submenu'] = 'teacher_view';

    $teachers = \DB::table('tbl_teacher')
        ->where('is_deleted', 0);

  
    if ($user->type == 'subadmin') {
        $teachers->where('add_id', $user->id);
    } elseif ($user->type == 'teacher') {
     
        $teachers->where('teacher_id', $user->teacher_id);
    }


    // FILTERS
    if ($request->filled('name')) {
        $teachers->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $teachers->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('phone')) {
        $teachers->where('phone', 'like', '%' . $request->phone . '%');
    }

    if ($request->filled('gender')) {
        $teachers->where('gender', $request->gender);
    }

    if ($request->filled('dob_from')) {
        $teachers->whereDate('dob', '>=', $request->dob_from);
    }

    if ($request->filled('dob_to')) {
        $teachers->whereDate('dob', '<=', $request->dob_to);
    }

    if ($request->filled('date_from')) {
        $teachers->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        
        $teachers->whereDate('created_at', '<=', $request->date_to);
    }

  
    $teachers = $teachers->orderBy('id', 'DESC')->get();




    $assignData = \DB::table('tbl_teacher_assign')
        ->leftJoin('tbl_grade', 'tbl_grade.id', '=', 'tbl_teacher_assign.grade_id')
        ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_teacher_assign.section_id')
        ->leftJoin('tbl_subject', 'tbl_subject.id', '=', 'tbl_teacher_assign.subject_id')
        ->select(
            'tbl_teacher_assign.teacher_id',
            'tbl_grade.name as grade_name',
            'tbl_section.name as section_name',
            'tbl_subject.name as subject_name'
        )
        ->get()
        ->groupBy('teacher_id');
        
        
        $user = auth()->user();

    
        $permExplodesub = $user->permission_submenu 
            ? explode(",", $user->permission_submenu) 
            : [];


    return view('backend.teacher.teacher', compact('teachers', 'assignData', 'data', 'permExplodesub'));
}




public function add_teacher()
{
$data['menu']='teachers';
$data['submenu']='teacher_add';

  $grade = DB::table('tbl_grade')
    ->where('is_deleted', 0)
    ->where('status', 'Active')
    ->orderBy('orders_by', 'ASC')
    ->get();
    
            
$session=Session::where('is_deleted',0)
            ->where('status','Active')
            ->orderBy('id','DESC')
            ->get();            
            
            
            
            

return view('backend.teacher.add',compact('data','grade','session'));
}



public function getSections($grade_id)
{

$sections=DB::table('tbl_section')
            ->where('status','Active')
            ->where('is_deleted',0)
            ->get();

$data=[];

foreach($sections as $sec)
{
$grades=explode(',',$sec->grade_id);

if(in_array($grade_id,$grades))
{
$data[]=$sec;
}
}

return response()->json($data);

}





public function getSubjects($grade_id)
{

$subjects=DB::table('tbl_subject')
            ->where('status','Active')
            ->where('is_deleted',0)
            ->get();

$data=[];

foreach($subjects as $sub)
{
$grades=explode(',',$sub->grade_id);

if(in_array($grade_id,$grades))
{
$data[]=$sub;
}
}

return response()->json($data);

}




/* ---------------- Save Teacher ----------------*/

public function saveTeacher(Request $request)
{

$user=Auth::user();

$lastTeacher=Teacher::orderBy('id','desc')->first();

$lastNumber=$lastTeacher
? (int) str_replace('TEACHER','',$lastTeacher->teacher_id)
:0;

$newTeacherId='TEACHER'.str_pad($lastNumber+1,4,'0',STR_PAD_LEFT);


$teacher=new Teacher();

$teacher->teacher_id=$newTeacherId;
$teacher->name=$request->name;
$teacher->email=$request->email;
$teacher->phone=$request->phone;
$teacher->gender=$request->gender;
$teacher->dob=$request->dob;
$teacher->password=Hash::make($request->password);
$teacher->city=$request->city;
$teacher->address=$request->address;
$teacher->session_id=$request->session_id;
$teacher->status='Active';
$teacher->add_id=$user->id;


if($request->hasFile('image'))
{
$file=$request->file('image');

$filename=date('YmdHis').$file->getClientOriginalName();

$path=public_path('teacher/uploads');

if(!is_dir($path)){
mkdir($path,0777,true);
}

$file->move($path,$filename);

$teacher->image=$filename;

}

$teacher->save();

$teacher->id_hash=md5($teacher->id);

$teacher->save();



/*
SECTION WISE SUBJECT MAPPING
*/

if(!empty($request->subject_id))
{

foreach($request->subject_id as $grade_id=>$sections)
{

foreach($sections as $section_id=>$subjects)
{

foreach($subjects as $subject_id)
{

DB::table('tbl_teacher_assign')->insert([
'teacher_id'=>$teacher->id,
'grade_id'=>$grade_id,
'section_id'=>$section_id,
'subject_id'=>$subject_id,
'created_at'=>now(),
'updated_at'=>now()
]);

}

}

}

}



/* user login create */

$u=new User();

$u->name=$teacher->name;
$u->email=$teacher->email;
$u->mobile=$teacher->phone;
$u->teacher_id=$teacher->teacher_id;
$u->permission_menu= '2,5';
$u->permission_submenu='2_26,2_27,5_2,5_3,5_10,5_5,5_8,5_9';
$u->password=Hash::make($request->password);
$u->type='teacher';
$u->is_deleted=0;
$u->add_id=$user->id;

if(!empty($filename))
{
$u->image=$filename;
}

$u->save();


return redirect()->back()
->with('success','Teacher Added Successfully');


}




public function edit_teacher($id_hash)
{
$data['menu']='teachers';
$data['submenu']='teacher_view';

$teacher=Teacher::where(
'id_hash',
$id_hash
)->first();

if(!$teacher){
return back()->with(
'error',
'Teacher not found'
);
}


$grade=Grade::where(
'is_deleted',0
)
->where(
'status','Active'
)
->orderBy('orders_by', 'ASC')
->get();

$session=Session::where('is_deleted',0)
            ->where('status','Active')
            ->orderBy('id','DESC')
            ->get();     


$assign=DB::table(
'tbl_teacher_assign'
)
->where(
'teacher_id',
$teacher->id
)
->get();


$selectedGrades=[];
$selectedMap=[];


foreach($assign as $row){

$selectedGrades[
$row->grade_id
]=$row->grade_id;

$selectedMap[
$row->grade_id
][
$row->section_id
][]=(int)$row->subject_id;

}


if(empty($selectedGrades)){
$selectedGrades[]='';
}


return view(
'backend.teacher.edit',
compact(
'teacher',
'grade',
'selectedGrades',
'selectedMap',
'data',
'session'
)

);

}


public function updateteacher(
Request $request
)
{

$teacher=Teacher::find(
$request->id
);

if(!$teacher){
return back()->with(
'error',
'Teacher not found'
);
}



$teacher->name=$request->name;
$teacher->email=$request->email;
$teacher->phone=$request->phone;
$teacher->gender=$request->gender;
$teacher->dob=$request->dob;
$teacher->city=$request->city;
$teacher->address=$request->address;
$teacher->session_id=$request->session_id;



if($request->password){
$teacher->password=
Hash::make(
$request->password
);
}


if(
$request->hasFile('image')
){

$file=$request->image;

$filename=
time().
$file
->getClientOriginalName();

$path=
public_path(
'teacher/uploads'
);

if(!is_dir($path)){
mkdir(
$path,
0777,
true
);
}

$file->move(
$path,
$filename
);

$teacher->image=
$filename;

}


$teacher->save();



DB::table(
'tbl_teacher_assign'
)
->where(
'teacher_id',
$teacher->id
)
->delete();



if(
!empty(
$request->subject_id
)
){

foreach(
$request->subject_id
as $grade_id=>$sections
){

foreach(
$sections
as $section_id=>$subjects
){

foreach(
$subjects
as $subject_id
){

DB::table(
'tbl_teacher_assign'
)->insert([

'teacher_id'=>$teacher->id,
'grade_id'=>$grade_id,
'section_id'=>$section_id,
'subject_id'=>$subject_id,
'created_at'=>now(),
'updated_at'=>now()

]);

}

}

}

}



/* sync users */

$user=User::where(
'teacher_id',
$teacher->teacher_id
)->first();

if($user){

$user->name=$teacher->name;
$user->email=$teacher->email;
$user->mobile=$teacher->phone;

if($request->password){
$user->password=
Hash::make(
$request->password
);
}

if(isset($filename)){
$user->image=$filename;
}

$user->save();

}



return back()->with(
'success',
'Teacher Updated Successfully'
);

}







  public function deleteTeacher($id)
{
   

    $teacher = Teacher::find($id);

    if (!$teacher) {
        return redirect()->back()->with('error', 'Teacher not found.');
    }

    DB::beginTransaction();

    try {

       
        $teacher->is_deleted = 1;
        $teacher->save();

       
        DB::table('tbl_teacher_assign')
            ->where('teacher_id', $teacher->id)
            ->delete();

        
        $userRecord = User::where('teacher_id', $teacher->teacher_id)
            ->where('type', 'teacher')
            ->first();

        if ($userRecord) {
            $userRecord->is_deleted = 1;
            $userRecord->save();
        }

        DB::commit();

        return redirect()->back()->with('success', 'Teacher deleted successfully.');

    } catch (\Exception $e) {

        DB::rollback();

        return redirect()->back()->with('error', 'Something went wrong.');
    }
}


    public function updateteacherStatus(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher->status = $request->status;
            $teacher->save();
            return redirect()->back()->with('success', 'Status updated successfully.');
        }

        return redirect()->back()->with('error', 'Teacher not found.');
    }

  public function export(Request $request)
{
    return Excel::download(new TeamLeaderExport($request), 'teachers.xlsx');
}




    // Helper functions
    public function check_unique_name($key, $value)
    {
        return !Teacher::where($key, $value)->exists();
    }

    public function check_unique($key, $value)
    {
        $check = Teacher::where($key, $value)->first();
        if (!empty($check)) {
            $value .= '1';
            return $this->check_unique($key, $value);
        }

        return $value;
    }

    public function check_unique_name_edit($key, $value, $id)
    {
        return !Teacher::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_email_edit($key, $value, $id)
    {
        return !Teacher::where($key, $value)->where('id', '!=', $id)->exists();
    }

    public function check_unique_phone_edit($key, $value, $id)
    {
        return !Teacher::where($key, $value)->where('id', '!=', $id)->exists();
    }
    
    
  

    
  public function mark_evaluation()
{
    
    $user  = Auth :: user();
    $data['menu'] = 'teachers';
    $data['submenu'] = 'mark_evaluation';

    $user = Auth::user();

    $session = Session::where('status','Active')
        ->where('is_deleted',0)
        ->get();

    $students = DB::table('tbl_admission')
        ->where('status','Active')
        ->where('is_deleted',0)
        ->get();

    
    $grade = Grade::where('status','Active')
        ->where('is_deleted',0)
        ->orderBy('orders_by', 'ASC')
        ->get();

    $teacherAssignments = [];

    if($user->type == 'teacher')
    {
        
        $teacher = DB::table('tbl_teacher')
                    ->where('email',$user->email)
                    ->where('status','Active')
                    ->where('is_deleted',0)
                    ->first();

        if($teacher)
        {
            $teacherAssignments = DB::table('tbl_teacher_assign')
                    ->where('teacher_id',$teacher->id)
                    ->get();

            $gradeIds = $teacherAssignments
                        ->pluck('grade_id')
                        ->unique()
                        ->toArray();


            $grade = Grade::whereIn('id',$gradeIds)
                        ->where('status','Active')
                        ->where('is_deleted',0)
                        ->orderBy('id','DESC')
                        ->get();

        
            $sectionIds = $teacherAssignments
                        ->pluck('section_id')
                        ->unique()
                        ->toArray();

            $students = DB::table('tbl_admission')
                    ->where('status','Active')
                    ->where('is_deleted',0)
                    ->whereIn('grade_id',$gradeIds)
                    ->whereIn('section_id',$sectionIds)
                    ->get();
        }
    }

    return view(
        'backend.teacher.mark_evaluation',
        compact(
            'students',
            'data',
            'session',
            'grade',
            'teacherAssignments'
        )
    );
}



    
public function saveStudentMarks(Request $request)
{
    try {
        $session_id = $request->selected_session;
        $grade_id   = $request->selected_grade;
        $section_id = $request->selected_section;
        $exam_id    = $request->selected_exam;
        $subject_id = $request->selected_subject;

        $subjectData = DB::table('tbl_exam_subject_marks')
            ->where('exam_id', $exam_id)
            ->where('grade_id', $grade_id)
            ->where('subject_id', $subject_id)
            ->where('is_deleted', 0)
            ->first();

        if (!$subjectData) {
            return response()->json([
                'success' => false,
                'message' => 'Subject marks configuration not found!'
            ], 400);
        }

        $max_theory_mark    = $subjectData->marks;
        $max_practical_mark = $subjectData->practical_marks ?? 0;
        $isOptionalSubject  = (bool) DB::table('tbl_subject')
            ->where('id', $subject_id)
            ->where('is_deleted', 0)
            ->value('is_optional');

        $absentTheory    = $request->absent_theory ?? [];
        $absentPractical = $request->absent_practical ?? [];
        $removeMarks     = $request->remove_marks ?? [];

        $successCount = 0;
        $removedCount = 0;
        $errorCount   = 0;
        $errors       = [];

        DB::beginTransaction();

        if (!empty($removeMarks)) {
            if (!$isOptionalSubject) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Marks can only be removed from an optional subject.'
                ], 422);
            }

            $studentIdsToRemove = array_keys(array_filter(
                $removeMarks,
                fn ($remove) => (string) $remove === '1'
            ));

            if (!empty($studentIdsToRemove)) {
                $removedCount = DB::table('tbl_student_marks')
                    ->whereIn('student_id', $studentIdsToRemove)
                    ->where('session_id', $session_id)
                    ->where('grade_id', $grade_id)
                    ->where('section_id', $section_id)
                    ->where('exam_id', $exam_id)
                    ->where('subject_id', $subject_id)
                    ->where('is_deleted', 0)
                    ->update([
                        'is_deleted' => 1,
                        'updated_at' => now(),
                    ]);
            }
        }

        $theoryMarks    = $request->obtain_mark ?? [];
        $practicalMarks = $request->obtain_practical_mark ?? [];

        $allStudentIds = [];

        foreach ($theoryMarks as $student_id => $mark) {
            if ($mark !== '' && $mark !== null) {
                $allStudentIds[] = $student_id;
            }
        }

        foreach ($practicalMarks as $student_id => $mark) {
            if ($mark !== '' && $mark !== null) {
                $allStudentIds[] = $student_id;
            }
        }

        foreach ($absentTheory as $student_id => $absent) {
            if ($absent == 1) {
                $allStudentIds[] = $student_id;
            }
        }

        foreach ($absentPractical as $student_id => $absent) {
            if ($absent == 1) {
                $allStudentIds[] = $student_id;
            }
        }

        $removedStudentIds = array_keys(array_filter(
            $removeMarks,
            fn ($remove) => (string) $remove === '1'
        ));

        $allStudentIds = array_values(array_diff(
            array_unique($allStudentIds),
            $removedStudentIds
        ));

        if (empty($allStudentIds) && $removedCount === 0) {
            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'No marks data to save. Please enter marks or mark attendance before saving.',
                'saved_count' => 0,
                'removed_count' => 0
            ]);
        }

        foreach ($allStudentIds as $student_id) {

            $hasTheoryData  = false;
            $theoryMark     = 0;
            $isAbsentTheory = false;

            if (isset($theoryMarks[$student_id]) && $theoryMarks[$student_id] !== '' && $theoryMarks[$student_id] !== null) {
                $theoryMark    = $theoryMarks[$student_id];
                $hasTheoryData = true;
            }

            if (isset($absentTheory[$student_id]) && $absentTheory[$student_id] == 1) {
                $isAbsentTheory = true;
                $hasTheoryData  = true;
                $theoryMark     = 0;
            }

            $hasPracticalData  = false;
            $practicalMark     = 0;
            $isAbsentPractical = false;

            if ($max_practical_mark > 0) {
                if (isset($practicalMarks[$student_id]) && $practicalMarks[$student_id] !== '' && $practicalMarks[$student_id] !== null) {
                    $practicalMark    = $practicalMarks[$student_id];
                    $hasPracticalData = true;
                }

                if (isset($absentPractical[$student_id]) && $absentPractical[$student_id] == 1) {
                    $isAbsentPractical = true;
                    $hasPracticalData  = true;
                    $practicalMark     = 0;
                }
            }

            if (!$hasTheoryData && !$hasPracticalData) {
                continue;
            }

            if (!$isAbsentTheory && $hasTheoryData && $theoryMark > $max_theory_mark) {
                $errorCount++;
                $errors[] = "Student ID {$student_id}: Theory marks ({$theoryMark}) cannot exceed {$max_theory_mark}";
                continue;
            }

            if (!$isAbsentTheory && $hasTheoryData && $theoryMark < 0) {
                $errorCount++;
                $errors[] = "Student ID {$student_id}: Theory marks cannot be negative";
                continue;
            }

            if ($max_practical_mark > 0 && $hasPracticalData) {
                if (!$isAbsentPractical && $practicalMark > $max_practical_mark) {
                    $errorCount++;
                    $errors[] = "Student ID {$student_id}: Practical marks ({$practicalMark}) cannot exceed {$max_practical_mark}";
                    continue;
                }

                if (!$isAbsentPractical && $practicalMark < 0) {
                    $errorCount++;
                    $errors[] = "Student ID {$student_id}: Practical marks cannot be negative";
                    continue;
                }
            }

            // ✅ updateOrInsert - found to UPDATE, not found to INSERT
            $matchCondition = [
                'student_id' => $student_id,
                'session_id' => $session_id,
                'exam_id'    => $exam_id,
                'subject_id' => $subject_id,
            ];

            $saveData = [
                'grade_id'   => $grade_id,
                'section_id' => $section_id,
                'is_deleted' => 0,
                'updated_at' => now(),
            ];

            if ($hasTheoryData) {
                $saveData['obtained_mark']    = $theoryMark;
                $saveData['max_mark']         = $max_theory_mark;
                $saveData['is_absent_theory'] = $isAbsentTheory ? 1 : 0;
            }

            if ($max_practical_mark > 0 && $hasPracticalData) {
                $saveData['obtained_practical_mark'] = $practicalMark;
                $saveData['max_practical_mark']      = $max_practical_mark;
                $saveData['is_absent_practical']     = $isAbsentPractical ? 1 : 0;
            }

            DB::table('tbl_student_marks')->updateOrInsert($matchCondition, $saveData);

            $successCount++;
        }

        DB::commit();

        $messageParts = [];

        if ($successCount > 0) {
            $messageParts[] = "{$successCount} student(s) marks saved successfully!";
        }

        if ($removedCount > 0) {
            $messageParts[] = "{$removedCount} optional subject record(s) removed successfully!";
        }

        $message = !empty($messageParts)
            ? implode(' ', $messageParts)
            : 'No marks data was submitted to save.';

        if ($errorCount > 0) {
            $message .= " {$errorCount} failed.";
        }

        return response()->json([
            'success'     => true,
            'message'     => $message,
            'errors'      => $errors,
            'saved_count' => $successCount,
            'removed_count' => $removedCount
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error saving marks: ' . $e->getMessage()
        ], 500);
    }
}


public function studentMarksList(Request $request)
{
    $data['menu']='categorys1';
    $data['submenu']='mark_evaluation_view';

    $user=Auth::user();

    $assignedGradeIds=[];
    $assignedSectionIds=[];
    $assignedSubjectIds=[];

    if($user->type=='teacher'){

        $teacher=DB::table('tbl_teacher')
            ->where('email',$user->email)
            ->where('is_deleted',0)
            ->first();

        if($teacher){

            $assignments=DB::table('tbl_teacher_assign')
                ->where('teacher_id',$teacher->id)
                ->get();

            $assignedGradeIds=$assignments->pluck('grade_id')->unique()->toArray();
            $assignedSectionIds=$assignments->pluck('section_id')->unique()->toArray();
            $assignedSubjectIds=$assignments->pluck('subject_id')->unique()->toArray();
        }
    }


    $sessions=DB::table('tbl_session')
        ->where('status','Active')
        ->where('is_deleted',0)
        ->get();



    $grades=DB::table('tbl_grade')
        ->where('status','Active')
        ->where('is_deleted',0)
        ->orderBy('orders_by', 'ASC')
        ->when($user->type=='teacher',function($q) use($assignedGradeIds){
            $q->whereIn('id',$assignedGradeIds);
        })
        ->get();



    $exams=DB::table('tbl_exam')
        ->where('status','Active')
        ->where('is_deleted',0)
        ->when($user->type=='teacher',function($q) use($assignedGradeIds){
            $q->whereIn('grade_id',$assignedGradeIds);
        })
        ->get();





    $subjectsQuery=DB::table('tbl_subject')
        ->where('status','Active')
        ->where('is_deleted',0);

    if($user->type=='teacher'){

        $assign=DB::table('tbl_teacher_assign')
            ->where('teacher_id',$teacher->id);

        if($request->filled('grade_id')){
            $assign->where('grade_id',$request->grade_id);
        }

        if($request->filled('section_id')){
            $assign->where('section_id',$request->section_id);
        }

        $subjectIds=$assign
            ->pluck('subject_id')
            ->unique()
            ->toArray();

        if(!empty($subjectIds)){
            $subjectsQuery->whereIn('id',$subjectIds);
        }else{
            $subjectsQuery->whereRaw('1=0');
        }

    }else{

        if($request->filled('grade_id')){
            $subjectsQuery->where('grade_id',$request->grade_id);
        }

    }

    $subjects=$subjectsQuery
        ->orderBy('name')
        ->get();



   

    $query=DB::table('tbl_student_marks as sm')
        ->join('tbl_admission as a','a.id','=','sm.student_id')
        ->join('tbl_session as sess','sess.id','=','sm.session_id')
        ->join('tbl_grade as g','g.id','=','sm.grade_id')
        ->leftJoin('tbl_section as sec','sec.id','=','sm.section_id')
        ->join('tbl_exam as e','e.id','=','sm.exam_id')
        ->join('tbl_subject as sub','sub.id','=','sm.subject_id')
        ->select(
            'sm.*',
            'a.admission_no',
            'a.roll_number',
            'a.first_name',
            'a.middle_name',
            'a.last_name',
            'sess.name as session_name',
            'g.name as grade_name',
            'sec.name as section_name',
            'e.exam_name',
            'sub.name as subject_name'
        )
        ->where('sm.is_deleted',0)
        ->where('a.is_deleted',0);



    if($user->type=='teacher'){
        $query->whereIn('sm.grade_id',$assignedGradeIds)
              ->whereIn('sm.section_id',$assignedSectionIds)
              ->whereIn('sm.subject_id',$assignedSubjectIds);
    }



    if($request->filled('session_id')){
        $query->where('sm.session_id',$request->session_id);
    }

    if($request->filled('grade_id')){
        $query->where('sm.grade_id',$request->grade_id);
    }

    if($request->filled('section_id')){
        $query->where('sm.section_id',$request->section_id);
    }

    if($request->filled('exam_id')){
        $query->where('sm.exam_id',$request->exam_id);
    }

    if($request->filled('subject_id')){
        $query->where('sm.subject_id',$request->subject_id);
    }



    $studentMarks=$query
        ->orderBy('sm.created_at','DESC')
        ->paginate(100000);



    $sectionsList=collect();

    if($request->filled('grade_id')){

        $sectionQuery=DB::table('tbl_section')
            ->where('status','Active')
            ->where('is_deleted',0)
            ->whereRaw(
              "FIND_IN_SET(?,grade_id)",
              [$request->grade_id]
            );

        if($user->type=='teacher'){
            $sectionQuery->whereIn(
                'id',
                $assignedSectionIds
            );
        }

        $sectionsList=$sectionQuery->get();
    }



    return view(
      'backend.teacher.student_marks_list',
      compact(
       'data',
       'sessions',
       'grades',
       'exams',
       'subjects',
       'studentMarks',
       'sectionsList'
      )
    );
}
   
   
  
public function getSectionsByGrade(Request $request)
{
    $user=Auth::user();

    $query = DB::table('tbl_section')
        ->where('status','Active')
        ->where('is_deleted',0)
        ->whereRaw("FIND_IN_SET(?,grade_id)",[$request->grade_id]);


    if($user->type=='teacher'){

        $teacher=DB::table('tbl_teacher')
            ->where('email',$user->email)
            ->first();

        $assignedSectionIds=DB::table('tbl_teacher_assign')
            ->where('teacher_id',$teacher->id)
            ->pluck('section_id')
            ->unique()
            ->toArray();

        $query->whereIn('id',$assignedSectionIds);
    }

    $sections=$query->orderBy('name')->get();

    return response()->json($sections);
}



  
public function mark_status(Request $request)
{
    $data['menu'] = 'categorys1';
    $data['submenu'] = 'show_mark_status';
 
    $session_id = $request->session_id;
    $grade_id   = $request->grade_id;
    $section_id = $request->section_id;
    $exam_id    = $request->exam_id;
 
    $sessions = DB::table('tbl_session')
        ->where('status', 'Active')->where('is_deleted', 0)->orderBy('orders_by')->get();
 
    $grades = DB::table('tbl_grade')
        ->where('status', 'Active')->where('is_deleted', 0)
        ->whereNotIn('id', [11, 12, 13, 14])->orderBy('orders_by', 'ASC')->get();
 
    $exams = DB::table('tbl_exam')
        ->where('status', 'Active')->where('is_deleted', 0)->orderBy('orders_by')->get();
 
    $sections = collect();
    if ($grade_id) {
        $sections = DB::table('tbl_section')
            ->where('status', 'Active')->where('is_deleted', 0)
            ->whereRaw("FIND_IN_SET(?, grade_id)", [$grade_id])
            ->orderBy('name', 'ASC')->get();
    }
 
    $studentsQuery = DB::table('tbl_admission')
        ->leftJoin('tbl_session', 'tbl_session.id', '=', 'tbl_admission.session_id')
        ->leftJoin('tbl_grade',   'tbl_grade.id',   '=', 'tbl_admission.grade_id')
        ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_admission.section_id')
        ->select(
            'tbl_admission.*',
            'tbl_session.name as session_name',
            'tbl_grade.name   as grade_name',
            'tbl_section.name as section_name'
        )
        ->where('tbl_admission.status', 'Active')
        ->where('tbl_admission.is_deleted', 0);
 
    if ($session_id) $studentsQuery->where('tbl_admission.session_id', $session_id);
    if ($grade_id)   $studentsQuery->where('tbl_admission.grade_id',   $grade_id);
    if ($section_id) $studentsQuery->where('tbl_admission.section_id', $section_id);
 
    $students     = $studentsQuery->get();
    $studentsData = [];
 
    if ($exam_id && count($students) > 0) {
        foreach ($students as $student) {
 
           
            $subjects = DB::table('tbl_subject as s')
                ->join('tbl_exam_subject_marks as esm', function($join) use ($exam_id, $student) {
                    $join->on('esm.subject_id', '=', 's.id')
                         ->where('esm.exam_id',    $exam_id)
                         ->where('esm.grade_id',   $student->grade_id)
                         ->where('esm.is_deleted', 0)
                         ->where('esm.is_included', 1);  // ← KEY CHANGE
                })
                ->whereRaw("FIND_IN_SET(?, s.grade_id)", [$student->grade_id])
                ->where('s.status', 'Active')
                ->where('s.is_deleted', 0)
                ->orderBy('s.orders_by')
                ->select('s.*')
                ->get();
 
            /* ── Also get excluded count for summary ── */
            $excludedSubjects = DB::table('tbl_subject as s')
                ->join('tbl_exam_subject_marks as esm', function($join) use ($exam_id, $student) {
                    $join->on('esm.subject_id', '=', 's.id')
                         ->where('esm.exam_id',    $exam_id)
                         ->where('esm.grade_id',   $student->grade_id)
                         ->where('esm.is_deleted', 0)
                         ->where('esm.is_included', 0);  // excluded
                })
                ->whereRaw("FIND_IN_SET(?, s.grade_id)", [$student->grade_id])
                ->where('s.status', 'Active')
                ->where('s.is_deleted', 0)
                ->select('s.name')
                ->get();
 
            $marks = DB::table('tbl_student_marks')
                ->where('student_id', $student->id)
                ->where('session_id', $student->session_id)
                ->where('grade_id',   $student->grade_id)
                ->where('section_id', $student->section_id)
                ->where('exam_id',    $exam_id)
                ->where('is_deleted', 0)
                ->get()->keyBy('subject_id');
 
            $completed = 0;
            $requiredPending = 0;
            $optionalPending = 0;
            $totalSubjects = [];
            $completedSubjects = [];
            $requiredPendingSubjects = [];
            $optionalPendingSubjects = [];
 
            foreach ($subjects as $subject) {
                $totalSubjects[] = $subject->name;
                $mark = $marks->get($subject->id);
                if ($mark && $mark->max_mark != null && $mark->obtained_mark != null) {
                    $completed++;
                    $completedSubjects[] = $subject->name;
                } elseif ((bool) ($subject->is_optional ?? false)) {
                    $optionalPending++;
                    $optionalPendingSubjects[] = $subject->name;
                } else {
                    $requiredPending++;
                    $requiredPendingSubjects[] = $subject->name;
                }
            }

            $pending = $requiredPending + $optionalPending;
            $pendingSubjects = array_merge($requiredPendingSubjects, $optionalPendingSubjects);
 
            $studentsData[$student->id] = [
                'total_subjects'       => count($subjects),
                'total_subject_names'  => $totalSubjects,
                'completed_count'      => $completed,
                'completed_subjects'   => $completedSubjects,
                'pending_count'        => $pending,
                'pending_subjects'     => $pendingSubjects,
                'is_complete'          => ($pending == 0),
                'can_generate_marksheet' => ($requiredPending == 0),
                'required_pending_count' => $requiredPending,
                'required_pending_subjects' => $requiredPendingSubjects,
                'optional_pending_count' => $optionalPending,
                'optional_pending_subjects' => $optionalPendingSubjects,
              
                'excluded_count'       => $excludedSubjects->count(),
                'excluded_subjects'    => $excludedSubjects->pluck('name')->toArray(),
            ];
        }
    }
 
 
 $general = DB::table('tbl_general')->where('id',1)->first();
 
    return view('backend.teacher.student-marks-status', compact(
        'students', 'studentsData', 'sessions', 'grades', 'exams',
        'sections', 'session_id', 'grade_id', 'section_id', 'exam_id', 'data','general'
    ));
}
 



private function getIncludedSubjectsForMarksheet($student_id, $exam_id, $session_id, $grade_id, $section_id)
{
    return DB::table('tbl_student_marks as sm')
        ->join('tbl_subject as sub', 'sub.id', '=', 'sm.subject_id')
        ->join('tbl_exam_subject_marks as esm', function($join) use ($exam_id, $grade_id) {
            $join->on('esm.subject_id', '=', 'sm.subject_id')
                 ->where('esm.exam_id',     $exam_id)
                 ->where('esm.grade_id',    $grade_id)
                 ->where('esm.is_deleted',  0)
                 ->where('esm.is_included', 1);   
        })
       ->select(
            'sub.id as subject_id',
            'sub.name as subject_name',
            'sub.orders_by',             
            'sm.obtained_mark',
            'sm.max_mark',
            'sm.obtained_practical_mark',
            'sm.max_practical_mark',
            'sm.is_absent_theory',
            'sm.is_absent_practical'
        )
        ->where('sm.student_id', $student_id)
        ->where('sm.exam_id',    $exam_id)
        ->where('sm.session_id', $session_id)
        ->where('sm.grade_id',   $grade_id)
        ->where('sm.section_id', $section_id)
        ->where('sm.is_deleted', 0)
        ->orderBy('sub.orders_by', 'ASC')  
        ->get();
}
 
 
/* ── Grade/fail calculation (extracted helper, same logic as before) ── */
private function processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent)
{
    $failedSubjects = collect();
 
    foreach ($subjects as $subject) {
        $theoryObtained    = $subject->obtained_mark ?? 0;
        $theoryMax         = $subject->max_mark ?? 0;
        $practicalObtained = $subject->obtained_practical_mark ?? 0;
        $practicalMax      = $subject->max_practical_mark ?? 0;
        $isTheoryAbsent    = (bool) ($subject->is_absent_theory ?? false);
        $isPracticalAbsent = $practicalMax > 0 && (bool) ($subject->is_absent_practical ?? false);
 
        $theoryPercentage    = $theoryMax    > 0 ? ($theoryObtained    / $theoryMax)    * 100 : 100;
        $practicalPercentage = $practicalMax > 0 ? ($practicalObtained / $practicalMax) * 100 : 100;
 
        $isTheoryFailed    = $isTheoryAbsent
            || ($theoryMax > 0 && $theoryPercentage < $theoryPassingPercent);
        $isPracticalFailed = $isPracticalAbsent
            || ($practicalMax > 0 && $practicalPercentage < $practicalPassingPercent);
        $isSubjectFailed   = $isTheoryFailed || $isPracticalFailed;
 
        $totalObtainedSubj = $theoryObtained   + $practicalObtained;
        $totalMaxSubj      = $theoryMax         + $practicalMax;
        $subjectPercentage = $totalMaxSubj > 0 ? ($totalObtainedSubj / $totalMaxSubj) * 100 : 0;
 
        if ($isSubjectFailed) {
            $subject->grade = 'NG'; $subject->grade_point = 0;
        } else {
            if      ($subjectPercentage >= 90) { $subject->grade = 'A+'; $subject->grade_point = 4.0; }
            elseif  ($subjectPercentage >= 80) { $subject->grade = 'A';  $subject->grade_point = 3.6; }
            elseif  ($subjectPercentage >= 70) { $subject->grade = 'B+'; $subject->grade_point = 3.2; }
            elseif  ($subjectPercentage >= 60) { $subject->grade = 'B';  $subject->grade_point = 2.8; }
            elseif  ($subjectPercentage >= 50) { $subject->grade = 'C+'; $subject->grade_point = 2.4; }
            elseif  ($subjectPercentage >= 40) { $subject->grade = 'C';  $subject->grade_point = 2.0; }
            elseif  ($subjectPercentage >= 33) { $subject->grade = 'D';  $subject->grade_point = 1.6; }
            else                                { $subject->grade = 'NG'; $subject->grade_point = 0;   }
        }
 
        $subject->theory_failed        = $isTheoryFailed;
        $subject->practical_failed     = $isPracticalFailed;
        $subject->theory_percentage    = $theoryPercentage;
        $subject->practical_percentage = $practicalPercentage;
        $subject->is_failed            = $isSubjectFailed;
        $subject->subject_percentage   = $subjectPercentage;
 
        if ($isSubjectFailed) $failedSubjects->push($subject);
    }
 
    return $failedSubjects;
}
 




   public function generateMarksheet($student_id, $exam_id)
{
    $data['menu']    = 'teachers';
    $data['submenu'] = 'show_mark_status';
 
    $student = DB::table('tbl_admission')
        ->select('id','admission_no','roll_number','first_name','middle_name','last_name',
                 'father_name','mother_name','gender','dob_ad','phone','email',
                 'address','photo','session_id','grade_id','section_id')
        ->where('id', $student_id)->where('is_deleted', 0)->where('status', 'Active')->first();
 
    if (!$student) return back()->with('error', 'Student not found');
 
    $session = DB::table('tbl_session')->select('name')->where('id', $student->session_id)->where('is_deleted', 0)->first();
    $grade   = DB::table('tbl_grade')->select('name')->where('id', $student->grade_id)->where('is_deleted', 0)->first();
    $section = DB::table('tbl_section')->select('name')->where('id', $student->section_id)->where('is_deleted', 0)->first();
 
    $exam = DB::table('tbl_exam')->where('id', $exam_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$exam) return back()->with('error', 'Exam not found');
 
    /* ✅ CHANGE: only included subjects */
    $subjects = $this->getIncludedSubjectsForMarksheet(
        $student_id, $exam_id, $student->session_id, $student->grade_id, $student->section_id
    );
 
    if ($subjects->isEmpty()) return back()->with('error', 'No marks found for this student in selected exam.');
 
    $theoryPassingPercent    = $exam->theory_passing_percent ?? 35;
    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
 
    $failedSubjects    = $this->processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent);
    $isPass            = $failedSubjects->count() == 0;
    $resultStatus      = $isPass ? 'PASS' : 'FAIL';
    $resultClass       = $isPass ? 'pass-result' : 'fail-result';
 
    $totalObtained          = $subjects->sum('obtained_mark');
    $totalMax               = $subjects->sum('max_mark');
    $totalPracticalObtained = $subjects->sum('obtained_practical_mark');
    $totalPracticalMax      = $subjects->sum('max_practical_mark');
    $overallPercentage      = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
 
    $gradeData    = $isPass ? $this->calculateGradeWithPoints($overallPercentage)
                             : ['grade' => 'NG', 'points' => 0, 'description' => 'Not Graded - Fail'];
    $positionData = $this->getClassPositionWithCount($student_id, $exam_id, $student->grade_id, $student->section_id);
    
    $general = DB::table('tbl_general')->where('id',1)->first();
 
    return view('backend.teacher.generate_marksheet', [
        'student'                 => $student, 'session' => $session, 'grade' => $grade,
        'section'                 => $section, 'exam'    => $exam,
        'subjects'                => $subjects,
        'totalObtained'           => $totalObtained, 'totalMax' => $totalMax,
        'totalPracticalObtained'  => $totalPracticalObtained, 'totalPracticalMax' => $totalPracticalMax,
        'overallPercentage'       => $overallPercentage,
        'resultStatus'            => $resultStatus, 'resultClass' => $resultClass,
        'gradeData'               => $gradeData, 'positionData' => $positionData,
        'failedSubjects'          => $failedSubjects, 'isPass' => $isPass,
        'theoryPassingPercent'    => $theoryPassingPercent,
        'practicalPassingPercent' => $practicalPassingPercent,
        'data'                    => $data,
        'general'                 => $general,
    ]);
}

   public function printMarksheet($student_id, $exam_id)
{
    $student = DB::table('tbl_admission')
        ->select('id','admission_no','roll_number','first_name','middle_name','last_name',
                 'father_name','mother_name','gender','dob_ad','phone','email',
                 'address','session_id','grade_id','section_id')
        ->where('id', $student_id)->where('is_deleted', 0)->where('status', 'Active')->first();
 
    if (!$student) return back()->with('error', 'Student not found');
 
    $session = DB::table('tbl_session')->select('name')->where('id', $student->session_id)->where('is_deleted', 0)->first();
    $grade   = DB::table('tbl_grade')->select('name')->where('id', $student->grade_id)->where('is_deleted', 0)->first();
    $section = DB::table('tbl_section')->select('name')->where('id', $student->section_id)->where('is_deleted', 0)->first();
 
    $exam = DB::table('tbl_exam')
        ->select('id','exam_name','theory_passing_percent','practical_passing_percent','marksheet_publish_date')
        ->where('id', $exam_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$exam) return back()->with('error', 'Exam not found');
 
    /* ✅ CHANGE: only included subjects */
    $subjects = $this->getIncludedSubjectsForMarksheet(
        $student_id, $exam_id, $student->session_id, $student->grade_id, $student->section_id
    );
 
    if ($subjects->isEmpty()) return back()->with('error', 'No marks found');
 
    $theoryPassingPercent    = $exam->theory_passing_percent ?? 35;
    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
 
    $failedSubjects = $this->processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent);
    $isPass         = $failedSubjects->count() == 0;
    $resultStatus   = $isPass ? 'PASS' : 'FAIL';
 
    $totalObtained          = $subjects->sum('obtained_mark');
    $totalMax               = $subjects->sum('max_mark');
    $totalPracticalObtained = $subjects->sum('obtained_practical_mark');
    $totalPracticalMax      = $subjects->sum('max_practical_mark');
    $overallPercentage      = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
 
    $gradeData    = $isPass ? $this->calculateGradeWithPoints($overallPercentage)
                             : ['grade' => 'NG', 'points' => 0, 'description' => 'Not Graded - Fail'];
    $positionData = $this->getClassPositionWithCount($student_id, $exam_id, $student->grade_id, $student->section_id);
    
    $general = DB::table('tbl_general')->where('id',1)->first();
    
   
 
    return view('backend.teacher.print_marksheet', [
        'student'                 => $student, 'session' => $session, 'grade' => $grade,
        'section'                 => $section, 'exam'    => $exam,
        'subjects'                => $subjects,
        'totalObtained'           => $totalObtained, 'totalMax' => $totalMax,
        'totalPracticalObtained'  => $totalPracticalObtained, 'totalPracticalMax' => $totalPracticalMax,
        'overallPercentage'       => $overallPercentage, 'resultStatus' => $resultStatus,
        'gradeData'               => $gradeData, 'positionData' => $positionData,
        'failedSubjects'          => $failedSubjects, 'isPass' => $isPass,
        'theoryPassingPercent'    => $theoryPassingPercent,
        'practicalPassingPercent' => $practicalPassingPercent,
        'general'                 => $general,
    ]);
}
 
 public function bulkPrintMarksheet(Request $request)
{
    $studentIds = explode(',', $request->student_ids);
    $exam_id    = $request->exam_id;
 
    if (empty($studentIds) || !$exam_id) return back()->with('error', 'Invalid request');
 
    $exam = DB::table('tbl_exam')
        ->select('id','exam_name','theory_passing_percent','practical_passing_percent','marksheet_publish_date')
        ->where('id', $exam_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$exam) return back()->with('error', 'Exam not found');
 
    $theoryPassingPercent    = $exam->theory_passing_percent    ?? 35;
    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
    $marksheets = [];
    
      $general = DB::table('tbl_general')->where('id', 1)->first();

 
    foreach ($studentIds as $student_id) {
        $student_id = trim($student_id);
 
        $student = DB::table('tbl_admission')
            ->select('id','admission_no','roll_number','first_name','middle_name','last_name',
                     'father_name','mother_name','gender','dob_ad','phone','email',
                     'address','session_id','grade_id','section_id')
            ->where('id', $student_id)->where('is_deleted', 0)->where('status', 'Active')->first();
        if (!$student) continue;
 
        $session = DB::table('tbl_session')->select('name')->where('id', $student->session_id)->where('is_deleted', 0)->first();
        $grade   = DB::table('tbl_grade')->select('name')->where('id', $student->grade_id)->where('is_deleted', 0)->first();
        $section = DB::table('tbl_section')->select('name')->where('id', $student->section_id)->where('is_deleted', 0)->first();
 
      
        $subjects = $this->getIncludedSubjectsForMarksheet(
            $student_id, $exam_id, $student->session_id, $student->grade_id, $student->section_id
        );
        if ($subjects->isEmpty()) continue;
 
        $failedSubjects = $this->processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent);
        $isPass         = $failedSubjects->count() == 0;
 
        $totalObtained          = $subjects->sum('obtained_mark');
        $totalMax_s             = $subjects->sum('max_mark');
        $totalPracticalObtained = $subjects->sum('obtained_practical_mark');
        $totalPracticalMax      = $subjects->sum('max_practical_mark');
        $overallPercentage      = $totalMax_s > 0 ? ($totalObtained / $totalMax_s) * 100 : 0;
 
        $gradeData    = $isPass ? $this->calculateGradeWithPoints($overallPercentage)
                                 : ['grade' => 'NG', 'points' => 0, 'description' => 'Not Graded - Fail'];
        $positionData = $this->getClassPositionWithCount($student_id, $exam_id, $student->grade_id, $student->section_id);
        
      
      
 
        $marksheets[] = [
            'student'                 => $student, 'session' => $session,
            'grade'                   => $grade,   'section' => $section,
            'subjects'                => $subjects,
            'totalObtained'           => $totalObtained, 'totalMax' => $totalMax_s,
            'totalPracticalObtained'  => $totalPracticalObtained, 'totalPracticalMax' => $totalPracticalMax,
            'overallPercentage'       => $overallPercentage,
            'resultStatus'            => $isPass ? 'PASS' : 'FAIL',
            'gradeData'               => $gradeData, 'positionData' => $positionData,
            'failedSubjects'          => $failedSubjects, 'isPass' => $isPass,
            'theoryPassingPercent'    => $theoryPassingPercent,
            'practicalPassingPercent' => $practicalPassingPercent,
           
        ];
    }
 
    if (empty($marksheets)) return back()->with('error', 'No valid marksheets found');
    return view('backend.teacher.bulk_print_marksheet', compact('marksheets', 'exam','general'));
    
}
 


 





public function mark_status_nursery(Request $request)
{
    $data['menu']    = 'categorys1';
    $data['submenu'] = 'show_mark_status_nursery';
 
    $session_id = $request->session_id;
    $grade_id   = $request->grade_id;
    $section_id = $request->section_id;
    $exam_id    = $request->exam_id;
 
    $sessions = DB::table('tbl_session')
        ->where('status', 'Active')->where('is_deleted', 0)->orderBy('orders_by')->get();
 
    $grades = DB::table('tbl_grade')
        ->where('status', 'Active')->where('is_deleted', 0)
        ->whereIn('id', [11, 12, 13, 14])->orderBy('orders_by', 'ASC')->get();
 
    $exams = DB::table('tbl_exam')
        ->where('status', 'Active')->where('is_deleted', 0)->orderBy('orders_by')->get();
 
    $sections = collect();
    if ($grade_id) {
        $sections = DB::table('tbl_section')
            ->where('status', 'Active')->where('is_deleted', 0)
            ->whereRaw("FIND_IN_SET(?, grade_id)", [$grade_id])
            ->orderBy('name', 'ASC')->get();
    }
 
    $studentsQuery = DB::table('tbl_admission')
        ->leftJoin('tbl_session', 'tbl_session.id', '=', 'tbl_admission.session_id')
        ->leftJoin('tbl_grade',   'tbl_grade.id',   '=', 'tbl_admission.grade_id')
        ->leftJoin('tbl_section', 'tbl_section.id', '=', 'tbl_admission.section_id')
        ->select(
            'tbl_admission.*',
            'tbl_session.name as session_name',
            'tbl_grade.name   as grade_name',
            'tbl_section.name as section_name'
        )
        ->where('tbl_admission.status',     'Active')
        ->where('tbl_admission.is_deleted', 0)
        ->whereIn('tbl_admission.grade_id', [11, 12, 13, 14]);
 
    if ($session_id) $studentsQuery->where('tbl_admission.session_id', $session_id);
    if ($grade_id)   $studentsQuery->where('tbl_admission.grade_id',   $grade_id);
    if ($section_id) $studentsQuery->where('tbl_admission.section_id', $section_id);
 
    $students     = $studentsQuery->get();
    $studentsData = [];
 
    if ($exam_id && count($students) > 0) {
        foreach ($students as $student) {
 
            /* ✅ CHANGE: only is_included=1 subjects */
            $subjects = DB::table('tbl_subject as s')
                ->join('tbl_exam_subject_marks as esm', function($join) use ($exam_id, $student) {
                    $join->on('esm.subject_id', '=', 's.id')
                         ->where('esm.exam_id',    $exam_id)
                         ->where('esm.grade_id',   $student->grade_id)
                         ->where('esm.is_deleted', 0)
                         ->where('esm.is_included', 1);
                })
                ->whereRaw("FIND_IN_SET(?, s.grade_id)", [$student->grade_id])
                ->where('s.status', 'Active')
                ->where('s.is_deleted', 0)
                ->orderBy('s.orders_by')
                ->select('s.*')
                ->get();
 
            $excludedSubjects = DB::table('tbl_subject as s')
                ->join('tbl_exam_subject_marks as esm', function($join) use ($exam_id, $student) {
                    $join->on('esm.subject_id', '=', 's.id')
                         ->where('esm.exam_id',    $exam_id)
                         ->where('esm.grade_id',   $student->grade_id)
                         ->where('esm.is_deleted', 0)
                         ->where('esm.is_included', 0);
                })
                ->whereRaw("FIND_IN_SET(?, s.grade_id)", [$student->grade_id])
                ->where('s.status', 'Active')
                ->where('s.is_deleted', 0)
                ->select('s.name')
                ->get();
 
            $marks = DB::table('tbl_student_marks')
                ->where('student_id', $student->id)
                ->where('session_id', $student->session_id)
                ->where('grade_id',   $student->grade_id)
                ->where('section_id', $student->section_id)
                ->where('exam_id',    $exam_id)
                ->where('is_deleted', 0)
                ->get()->keyBy('subject_id');
 
            $completed = 0; $pending = 0;
            $totalSubjects = []; $completedSubjects = []; $pendingSubjects = [];
 
            foreach ($subjects as $subject) {
                $totalSubjects[] = $subject->name;
                $mark = $marks->get($subject->id);
                if ($mark && $mark->max_mark != null && $mark->obtained_mark != null) {
                    $completed++;
                    $completedSubjects[] = $subject->name;
                } else {
                    $pending++;
                    $pendingSubjects[] = $subject->name;
                }
            }
            
            
 
            $studentsData[$student->id] = [
                'total_subjects'      => count($subjects),
                'total_subject_names' => $totalSubjects,
                'completed_count'     => $completed,
                'completed_subjects'  => $completedSubjects,
                'pending_count'       => $pending,
                'pending_subjects'    => $pendingSubjects,
                'is_complete'         => ($pending == 0),
                'excluded_count'      => $excludedSubjects->count(),
                'excluded_subjects'   => $excludedSubjects->pluck('name')->toArray(),
            ];
        }
    }
    
    
    
 
    return view('backend.teacher.student-marks-status-nursery', compact(
        'students', 'studentsData', 'sessions', 'grades', 'exams',
        'sections', 'session_id', 'grade_id', 'section_id', 'exam_id', 'data'
    ));
}

public function generateMarksheetNursery($student_id, $exam_id)
{
    $data['menu']    = 'teachers';
    $data['submenu'] = 'show_mark_status_nursery';
 
    $student = DB::table('tbl_admission')
        ->select('id','admission_no','roll_number','first_name','middle_name','last_name',
                 'father_name','mother_name','gender','dob_ad','phone','email',
                 'address','photo','session_id','grade_id','section_id')
        ->where('id', $student_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$student) return back()->with('error', 'Student not found');
 
    $session = DB::table('tbl_session')->select('name')->where('id', $student->session_id)->where('is_deleted', 0)->first();
    $grade   = DB::table('tbl_grade')->select('name')->where('id', $student->grade_id)->where('is_deleted', 0)->first();
    $section = DB::table('tbl_section')->select('name')->where('id', $student->section_id)->where('is_deleted', 0)->first();
 
    $exam = DB::table('tbl_exam')->where('id', $exam_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$exam) return back()->with('error', 'Exam not found');
 
    /* ✅ CHANGE: only included subjects */
    $subjects = $this->getIncludedSubjectsForMarksheet(
        $student_id, $exam_id, $student->session_id, $student->grade_id, $student->section_id
    );
    if ($subjects->isEmpty()) return back()->with('error', 'No marks found for this student in selected exam.');
 
    $theoryPassingPercent    = $exam->theory_passing_percent ?? 35;
    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
 
    $failedSubjects = $this->processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent);
    $isPass         = $failedSubjects->count() == 0;
    $resultStatus   = $isPass ? 'PASS' : 'FAIL';
 
    $totalObtained          = $subjects->sum('obtained_mark');
    $totalMax_s             = $subjects->sum('max_mark');
    $totalPracticalObtained = $subjects->sum('obtained_practical_mark');
    $totalPracticalMax      = $subjects->sum('max_practical_mark');
    $overallPercentage      = $totalMax_s > 0 ? ($totalObtained / $totalMax_s) * 100 : 0;
 
    $gradeData    = $isPass ? $this->calculateGradeWithPoints($overallPercentage)
                             : ['grade' => 'NG', 'points' => 0, 'description' => 'Not Graded - Fail'];
    $positionData = $this->getClassPositionWithCount($student_id, $exam_id, $student->grade_id, $student->section_id);
    
     $general = DB::table('tbl_general')->where('id',1)->first();
 
    return view('backend.teacher.generate_marksheet_nursery', [
        'student'                 => $student, 'session' => $session, 'grade' => $grade,
        'section'                 => $section, 'exam'    => $exam,
        'subjects'                => $subjects,
        'totalObtained'           => $totalObtained, 'totalMax' => $totalMax_s,
        'totalPracticalObtained'  => $totalPracticalObtained, 'totalPracticalMax' => $totalPracticalMax,
        'overallPercentage'       => $overallPercentage, 'resultStatus' => $resultStatus,
        'gradeData'               => $gradeData, 'positionData' => $positionData,
        'failedSubjects'          => $failedSubjects, 'isPass' => $isPass,
        'theoryPassingPercent'    => $theoryPassingPercent,
        'practicalPassingPercent' => $practicalPassingPercent,
        'data'                    => $data,
        'general'                 => $general,
    ]);
}
 
 
public function printMarksheetNursery($student_id, $exam_id)
{
    $student = DB::table('tbl_admission')
        ->select('id','admission_no','roll_number','first_name','middle_name','last_name',
                 'father_name','mother_name','gender','dob_ad','phone','email',
                 'address','session_id','grade_id','section_id')
        ->where('id', $student_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$student) return back()->with('error', 'Student not found');
 
    $session = DB::table('tbl_session')->select('name')->where('id', $student->session_id)->where('is_deleted', 0)->first();
    $grade   = DB::table('tbl_grade')->select('name')->where('id', $student->grade_id)->where('is_deleted', 0)->first();
    $section = DB::table('tbl_section')->select('name')->where('id', $student->section_id)->where('is_deleted', 0)->first();
 
    $exam = DB::table('tbl_exam')
        ->select('id','exam_name','theory_passing_percent','practical_passing_percent','marksheet_publish_date')
        ->where('id', $exam_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$exam) return back()->with('error', 'Exam not found');
 
    /* ✅ CHANGE: only included subjects */
    $subjects = $this->getIncludedSubjectsForMarksheet(
        $student_id, $exam_id, $student->session_id, $student->grade_id, $student->section_id
    );
    if ($subjects->isEmpty()) return back()->with('error', 'No marks found');
 
    $theoryPassingPercent    = $exam->theory_passing_percent ?? 35;
    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
 
    $totalObtained          = $subjects->sum('obtained_mark');
    $totalMax               = $subjects->sum('max_mark');
    $totalPracticalObtained = $subjects->sum('obtained_practical_mark');
    $totalPracticalMax      = $subjects->sum('max_practical_mark');
    $overallPercentage      = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
 
    $failedSubjects = $this->processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent);
    $isPass         = $failedSubjects->count() == 0;
    $resultStatus   = $isPass ? 'PASS' : 'FAIL';
    $gradeData      = $isPass ? $this->calculateGradeWithPoints($overallPercentage)
                               : ['grade' => 'NG', 'points' => 0, 'description' => 'Not Graded - Fail'];
    $positionData   = $this->getClassPositionWithCount($student_id, $exam_id, $student->grade_id, $student->section_id);
    
     $general = DB::table('tbl_general')->where('id',1)->first();
     
    
 
    return view('backend.teacher.print_marksheet_nursery', [
        'student'                 => $student, 'session' => $session, 'grade' => $grade,
        'section'                 => $section, 'exam'    => $exam,
        'subjects'                => $subjects,
        'totalObtained'           => $totalObtained, 'totalMax' => $totalMax,
        'totalPracticalObtained'  => $totalPracticalObtained, 'totalPracticalMax' => $totalPracticalMax,
        'overallPercentage'       => $overallPercentage, 'resultStatus' => $resultStatus,
        'gradeData'               => $gradeData, 'positionData' => $positionData,
        'failedSubjects'          => $failedSubjects, 'isPass' => $isPass,
        'theoryPassingPercent'    => $theoryPassingPercent,
        'practicalPassingPercent' => $practicalPassingPercent,
        
        'general'                 => $general,
    ]);
}
 
 
public function bulkPrintMarksheetNursery(Request $request)
{
    $studentIds = explode(',', $request->student_ids);
    $exam_id    = $request->exam_id;

    if (empty($studentIds) || !$exam_id) return back()->with('error', 'Invalid request');

    $exam = DB::table('tbl_exam')
        ->select('id','exam_name','theory_passing_percent','practical_passing_percent','marksheet_publish_date')
        ->where('id', $exam_id)->where('is_deleted', 0)->where('status', 'Active')->first();
    if (!$exam) return back()->with('error', 'Exam not found');

   
    $general = DB::table('tbl_general')->where('id', 1)->first();

    $theoryPassingPercent    = $exam->theory_passing_percent ?? 35;
    $practicalPassingPercent = $exam->practical_passing_percent ?? 40;
    $marksheets = [];

    foreach ($studentIds as $student_id) {
        $student_id = trim($student_id);

        $student = DB::table('tbl_admission')
            ->select('id','admission_no','roll_number','first_name','middle_name','last_name',
                     'father_name','mother_name','gender','dob_ad','phone','email',
                     'address','session_id','grade_id','section_id')
            ->where('id', $student_id)->where('is_deleted', 0)->where('status', 'Active')->first();
        if (!$student) continue;

        $session = DB::table('tbl_session')->select('name')->where('id', $student->session_id)->where('is_deleted', 0)->first();
        $grade   = DB::table('tbl_grade')->select('name')->where('id', $student->grade_id)->where('is_deleted', 0)->first();
        $section = DB::table('tbl_section')->select('name')->where('id', $student->section_id)->where('is_deleted', 0)->first();

        $subjects = $this->getIncludedSubjectsForMarksheet(
            $student_id, $exam_id, $student->session_id, $student->grade_id, $student->section_id
        );
        if ($subjects->isEmpty()) continue;

        $failedSubjects = $this->processSubjectsForMarksheet($subjects, $theoryPassingPercent, $practicalPassingPercent);
        $isPass         = $failedSubjects->count() == 0;

        $totalObtained          = $subjects->sum('obtained_mark');
        $totalMax_s             = $subjects->sum('max_mark');
        $totalPracticalObtained = $subjects->sum('obtained_practical_mark');
        $totalPracticalMax      = $subjects->sum('max_practical_mark');
        $overallPercentage      = $totalMax_s > 0 ? ($totalObtained / $totalMax_s) * 100 : 0;

        $gradeData    = $isPass ? $this->calculateGradeWithPoints($overallPercentage)
                                 : ['grade' => 'NG', 'points' => 0, 'description' => 'Not Graded - Fail'];
        $positionData = $this->getClassPositionWithCount($student_id, $exam_id, $student->grade_id, $student->section_id);

        $marksheets[] = [
            'student'                 => $student, 'session' => $session,
            'grade'                   => $grade,   'section' => $section,
            'subjects'                => $subjects,
            'totalObtained'           => $totalObtained, 'totalMax' => $totalMax_s,
            'totalPracticalObtained'  => $totalPracticalObtained, 'totalPracticalMax' => $totalPracticalMax,
            'overallPercentage'       => $overallPercentage,
            'resultStatus'            => $isPass ? 'PASS' : 'FAIL',
            'gradeData'               => $gradeData, 'positionData' => $positionData,
            'failedSubjects'          => $failedSubjects, 'isPass' => $isPass,
            'theoryPassingPercent'    => $theoryPassingPercent,
            'practicalPassingPercent' => $practicalPassingPercent,
            
        ];
    }

    if (empty($marksheets)) return back()->with('error', 'No valid marksheets found');

   
    return view('backend.teacher.bulk_print_marksheet_nursery', compact('marksheets', 'exam', 'general'));
}
    
    
      /* ── These private helpers are UNCHANGED ─────────────────── */
private function calculateGradeWithPoints($percentage)
{
    if      ($percentage >= 90) return ['grade' => 'A+', 'points' => 4.0, 'description' => 'Outstanding'];
    elseif  ($percentage >= 80) return ['grade' => 'A',  'points' => 3.6, 'description' => 'Excellent'];
    elseif  ($percentage >= 70) return ['grade' => 'B+', 'points' => 3.2, 'description' => 'Very Good'];
    elseif  ($percentage >= 60) return ['grade' => 'B',  'points' => 2.8, 'description' => 'Good'];
    elseif  ($percentage >= 50) return ['grade' => 'C+', 'points' => 2.4, 'description' => 'Above Average'];
    elseif  ($percentage >= 40) return ['grade' => 'C',  'points' => 2.0, 'description' => 'Average'];
    elseif  ($percentage >= 33) return ['grade' => 'D',  'points' => 1.6, 'description' => 'Needs Improvement'];
    else                         return ['grade' => 'NG', 'points' => 0,   'description' => 'Fail'];
}
 
private function calculateSubjectGradePoints($obtained, $total)
{
    if ($total == 0) return 0;
    $percentage = ($obtained / $total) * 100;
    if ($percentage >= 90) return 4.0;
    if ($percentage >= 80) return 3.6;
    if ($percentage >= 70) return 3.2;
    if ($percentage >= 60) return 2.8;
    if ($percentage >= 50) return 2.4;
    if ($percentage >= 40) return 2.0;
    if ($percentage >= 33) return 1.6;
    return 0;
}

private function calculateGradeFromGpa($gpa)
{
    if      ($gpa >= 3.61 && $gpa <= 4.00) return 'A+';
    elseif  ($gpa >= 3.21 && $gpa <= 3.60) return 'A';
    elseif  ($gpa >= 2.81 && $gpa <= 3.20) return 'B+';
    elseif  ($gpa >= 2.41 && $gpa <= 2.80) return 'B';
    elseif  ($gpa >= 2.01 && $gpa <= 2.40) return 'C+';
    elseif  ($gpa >= 1.61 && $gpa <= 2.00) return 'C';
    elseif  ($gpa >= 1.60)                 return 'D';
    else                                   return 'NG';
}
 
private function getClassPositionWithCount($student_id, $exam_id, $grade_id, $section_id)
{
    $allStudents = DB::table('tbl_student_marks as sm')
        ->select('sm.student_id',
                 DB::raw('SUM(sm.obtained_mark + sm.obtained_practical_mark) as total_obtained'),
                 DB::raw('SUM(sm.max_mark + sm.max_practical_mark) as total_max'))
        ->where('sm.exam_id',    $exam_id)
        ->where('sm.grade_id',   $grade_id)
        ->where('sm.section_id', $section_id)
        ->where('sm.is_deleted', 0)
        ->groupBy('sm.student_id')
        ->orderByRaw('(SUM(sm.obtained_mark + sm.obtained_practical_mark) / SUM(sm.max_mark + sm.max_practical_mark)) DESC')
        ->get();
 
    $position      = 1;
    $totalStudents = $allStudents->count();
 
    foreach ($allStudents as $index => $student) {
        if ($student->student_id == $student_id) { $position = $index + 1; break; }
    }
 
    return ['position' => $position, 'ordinal' => $this->getOrdinalSuffix($position), 'total' => $totalStudents];
}
 
private function getOrdinalSuffix($number)
{
    if (!in_array(($number % 100), [11, 12, 13])) {
        switch ($number % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}
    

public function edit_chapter_status($id)
    {
        $data['menu'] = 'teachers';
        $data['submenu'] = 'teacher_chapter_status';

        $teacher = Teacher::where('id', $id)->first();

        if (!$teacher) {
            return back()->with('error', 'Teacher not found');
        }

        $session = Session::where('status', 'Active')
            ->where('id', $teacher->session_id)
             ->where('is_deleted', 0)
            ->orderBy('orders_by', 'ASC')
            ->get();

        $grade = Grade::where('is_deleted', 0)
            ->where('status', 'Active')
           ->orderBy('orders_by', 'ASC')
            ->get();

        $assign = DB::table('tbl_teacher_assign')
            ->where('teacher_id', $teacher->id)
            ->get();

        $selectedGrades = [];
        $selectedMap = [];

        foreach ($assign as $row) {
            $selectedGrades[$row->grade_id] = $row->grade_id;
            $selectedMap[$row->grade_id][$row->section_id][] = (int)$row->subject_id;
        }

        if (empty($selectedGrades)) {
            $selectedGrades[] = '';
        }

        return view('backend.teacher.edit_chapter_status', compact('teacher', 'grade', 'selectedGrades', 'selectedMap', 'data','session'));
    }

    public function getChaptersBySubject($subject_id, $grade_id)
    {
        $chapters = Chapter::where('subject_id', $subject_id)
            ->where('grade_id', $grade_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('chapter_no', 'ASC')
            ->orderBy('id', 'ASC')
            ->get(['id', 'name', 'chapter_no', 'no_of_pages']);

        return response()->json($chapters);
    }

    public function getChapterStatus($teacher_id, $session_id, $grade_id, $section_id, $subject_id)
    {
        $statuses = DB::table('tbl_teacher_chapter_status')
            ->where('teacher_id', $teacher_id)
            ->where('session_id', $session_id)
            ->where('grade_id', $grade_id)
            ->where('section_id', $section_id)
            ->where('subject_id', $subject_id)
            ->get()
            ->keyBy('chapter_id');

        return response()->json($statuses);
    }

    public function getChapterLogs($teacher_id, $session_id, $grade_id, $section_id, $subject_id, $chapter_id)
    {
        $logs = DB::table('tbl_teacher_chapter_status_logs')
            ->where('teacher_id', $teacher_id)
            ->where('session_id', $session_id)
            ->where('grade_id', $grade_id)
            ->where('section_id', $section_id)
            ->where('subject_id', $subject_id)
            ->where('chapter_id', $chapter_id)
            ->orderBy('changed_at', 'DESC')
            ->limit(10)
            ->get();

        // Get user names for logs
        foreach ($logs as $log) {
            $user = DB::table('users')->where('id', $log->updated_by)->first();
            $log->updated_by_name = $user ? $user->name : 'Unknown';
            $log->formatted_date = Carbon::parse($log->changed_at)->format('d M Y h:i A');
        }

        return response()->json($logs);
    }

    public function save_chapter_status(Request $request)
{
    try {
        $request->validate([
            'teacher_id' => 'required|integer',
            'session_id' => 'required|integer',
            'grade_id' => 'required|integer',
            'section_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'chapter_status' => 'required|array',
            'chapter_status.*' => 'in:not_started,in_progress,completed',
            'remarks' => 'nullable|array'
        ]);

        $teacher_id = $request->teacher_id;
        $session_id = $request->session_id;
        $grade_id = $request->grade_id;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $currentUserId = auth()->user()->id ?? 1;
        $currentTime = now();

        foreach ($request->chapter_status as $chapter_id => $status) {
            $remarks = $request->remarks[$chapter_id] ?? null;

            // Get existing status
            $existing = DB::table('tbl_teacher_chapter_status')
                ->where([
                    'teacher_id' => $teacher_id,
                    'session_id' => $session_id,
                    'grade_id' => $grade_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'chapter_id' => $chapter_id
                ])
                ->first();

            $old_status = $existing ? $existing->status : null;

            // Update or insert status
            DB::table('tbl_teacher_chapter_status')->updateOrInsert(
                [
                    'teacher_id' => $teacher_id,
                    'session_id' => $session_id,
                    'grade_id' => $grade_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'chapter_id' => $chapter_id
                ],
                [
                    'status' => $status,
                    'remarks' => $remarks,
                    'add_id' => $currentUserId,
                    'update_id' => $currentUserId,
                    'updated_at' => $currentTime
                ]
            );

            // Create log entry if status changed or it's a new entry
            if ($old_status != $status || !$existing) {
                DB::table('tbl_teacher_chapter_status_logs')->insert([
                    'teacher_id' => $teacher_id,
                    'session_id' => $session_id,
                    'grade_id' => $grade_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'chapter_id' => $chapter_id,
                    'old_status' => $old_status,
                    'new_status' => $status,
                    'remarks' => $remarks,
                    'updated_by' => $currentUserId,
                    'changed_at' => $currentTime,
                    'created_at' => $currentTime,
                    'updated_at' => $currentTime
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Chapter status updated successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    public function getSubjectsByIds(Request $request)
    {
        $ids = $request->ids;
        if (is_array($ids)) {
            $subjects = DB::table('tbl_subject')
                ->whereIn('id', $ids)
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->select('id', 'name')
                ->get();
            return response()->json($subjects);
        }
        return response()->json([]);
    }  
    
    
public function chapterProgressReport()
{
    $user = auth()->user();

    $data['menu'] = 'teachers1';
    $data['submenu'] = 'teacher_chapter_progress';

    
    if ($user->type == 'teacher') {

        $teachers = Teacher::where('status', 'Active')
            ->where('teacher_id', $user->teacher_id)
            ->where('is_deleted', 0)
            ->orderBy('name', 'ASC')
            ->get();

    } else {

        $teachers = Teacher::where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('name', 'ASC')
            ->get();
    }


   
    $teacherMain = null; 

    if ($user->type == 'teacher') {

        $teacherMain = DB::table('tbl_teacher')
            ->where('teacher_id', $user->teacher_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        if ($teacherMain) {

            $gradeIds = DB::table('tbl_teacher_assign')
                ->where('teacher_id', $teacherMain->id)
                ->pluck('grade_id')
                ->unique()
                ->toArray();

            $grades = Grade::whereIn('id', $gradeIds)
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->orderBy('orders_by', 'ASC')
                ->get();

        } else {
            $grades = collect();
        }

    } else {

        $grades = Grade::where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by', 'ASC')
            ->get();
    }


    
    if ($user->type == 'teacher' && $teacherMain) {

        $sessions = Session::where('status', 'Active')
            ->where('id', $teacherMain->session_id) 
            ->where('is_deleted', 0)
            ->orderBy('orders_by', 'ASC')
            ->get();

    } else {

        $sessions = Session::where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('orders_by', 'ASC')
            ->get();
    }


    return view('backend.reports.teacher_chapter_progress', compact('teachers', 'sessions', 'grades', 'data'));
}

public function getChapterProgressData(Request $request)
{
    try {
        $teacher_id = $request->teacher_id;
        $session_id = $request->session_id;
        $grade_id = $request->grade_id;
        
        // Get teacher details
        $teacher = Teacher::find($teacher_id);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }
        
        // Get assignments for this teacher
        $assignments = DB::table('tbl_teacher_assign')
            ->where('teacher_id', $teacher_id)
            ->when($grade_id, function($query) use ($grade_id) {
                return $query->where('grade_id', $grade_id);
            })
            ->get();
        
        if ($assignments->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'No subjects assigned to this teacher'
            ]);
        }
        
        $reportData = [];
        $overallStats = [
            'total_pages' => 0,
            'completed_pages' => 0,
            'in_progress_pages' => 0,
            'not_started_pages' => 0,
            'total_chapters' => 0,
            'completed_chapters' => 0,
            'in_progress_chapters' => 0,
            'not_started_chapters' => 0
        ];
        
        foreach ($assignments as $assignment) {
            // Get grade and section details
            $grade = Grade::find($assignment->grade_id);
            $section = Section::find($assignment->section_id);
            $subject = DB::table('tbl_subject')->where('id', $assignment->subject_id)->first();
            
            if (!$grade || !$section || !$subject) {
                continue;
            }
            
            // Get all chapters for this subject and grade
            $chapters = Chapter::where('subject_id', $assignment->subject_id)
                ->where('grade_id', $assignment->grade_id)
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->orderBy('chapter_no', 'ASC')
                ->get();
            
            if ($chapters->isEmpty()) {
                continue;
            }
            
            // Get chapter statuses for this teacher and assignment
            $statuses = DB::table('tbl_teacher_chapter_status')
                ->where('teacher_id', $teacher_id)
                ->where('session_id', $session_id)
                ->where('grade_id', $assignment->grade_id)
                ->where('section_id', $assignment->section_id)
                ->where('subject_id', $assignment->subject_id)
                ->get()
                ->keyBy('chapter_id');
            
            $subjectData = [
                'grade_name' => $grade->name,
                'section_name' => $section->name,
                'subject_id' => $subject->id,
                'subject_name' => $subject->name,
                'total_chapters' => $chapters->count(),
                'total_pages' => 0,
                'completed_pages' => 0,
                'in_progress_pages' => 0,
                'not_started_pages' => 0,
                'completed_chapters' => 0,
                'in_progress_chapters' => 0,
                'not_started_chapters' => 0,
                'chapters' => []
            ];
            
            foreach ($chapters as $chapter) {
                $status = $statuses[$chapter->id]->status ?? 'not_started';
                $pages = $chapter->no_of_pages ?? 0;
                
                $subjectData['total_pages'] += $pages;
                
                switch ($status) {
                    case 'completed':
                        $subjectData['completed_pages'] += $pages;
                        $subjectData['completed_chapters']++;
                        break;
                    case 'in_progress':
                        $subjectData['in_progress_pages'] += $pages;
                        $subjectData['in_progress_chapters']++;
                        break;
                    default:
                        $subjectData['not_started_pages'] += $pages;
                        $subjectData['not_started_chapters']++;
                        break;
                }
                
                $subjectData['chapters'][] = [
                    'chapter_no' => $chapter->chapter_no,
                    'chapter_name' => $chapter->name,
                    'pages' => $pages,
                    'status' => $status,
                    'remarks' => $statuses[$chapter->id]->remarks ?? null
                ];
            }
            
            // Calculate completion percentage
            $subjectData['completion_percentage'] = $subjectData['total_pages'] > 0 
                ? round(($subjectData['completed_pages'] / $subjectData['total_pages']) * 100, 2)
                : 0;
            
            $reportData[] = $subjectData;
            
            // Update overall statistics
            $overallStats['total_pages'] += $subjectData['total_pages'];
            $overallStats['completed_pages'] += $subjectData['completed_pages'];
            $overallStats['in_progress_pages'] += $subjectData['in_progress_pages'];
            $overallStats['not_started_pages'] += $subjectData['not_started_pages'];
            $overallStats['total_chapters'] += $subjectData['total_chapters'];
            $overallStats['completed_chapters'] += $subjectData['completed_chapters'];
            $overallStats['in_progress_chapters'] += $subjectData['in_progress_chapters'];
            $overallStats['not_started_chapters'] += $subjectData['not_started_chapters'];
        }
        
        // Calculate overall completion percentage
        $overallStats['completion_percentage'] = $overallStats['total_pages'] > 0 
            ? round(($overallStats['completed_pages'] / $overallStats['total_pages']) * 100, 2)
            : 0;
        
        return response()->json([
            'success' => true,
            'teacher_name' => $teacher->name,
            'data' => $reportData,
            'overall' => $overallStats
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}


public function exportChapterProgressReport(Request $request)
{
    $teacher_id = $request->teacher_id;
    $session_id = $request->session_id;
    $grade_id = $request->grade_id;
    
    $teacher = Teacher::find($teacher_id);
    $session = Session::find($session_id);
    
    $assignments = DB::table('tbl_teacher_assign')
        ->where('teacher_id', $teacher_id)
        ->when($grade_id, function($query) use ($grade_id) {
            return $query->where('grade_id', $grade_id);
        })
        ->get();
    
    $exportData = [];
    $exportData[] = ['Teacher Name', $teacher->name ?? 'N/A'];
    $exportData[] = ['Session', $session->name ?? 'N/A'];
    $exportData[] = ['Export Date', now()->format('d-m-Y H:i:s')];
    $exportData[] = [];
    $exportData[] = ['Subject', 'Grade-Section', 'Total Chapters', 'Completed', 'In Progress', 'Not Started', 'Total Pages', 'Completed Pages', 'Progress %'];
    
    foreach ($assignments as $assignment) {
        $grade = Grade::find($assignment->grade_id);
        $section = Section::find($assignment->section_id);
        $subject = DB::table('tbl_subject')->where('id', $assignment->subject_id)->first();
        
        $chapters = Chapter::where('subject_id', $assignment->subject_id)
            ->where('grade_id', $assignment->grade_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->get();
        
        $statuses = DB::table('tbl_teacher_chapter_status')
            ->where('teacher_id', $teacher_id)
            ->where('session_id', $session_id)
            ->where('grade_id', $assignment->grade_id)
            ->where('section_id', $assignment->section_id)
            ->where('subject_id', $assignment->subject_id)
            ->get()
            ->keyBy('chapter_id');
        
        $completed = 0;
        $inProgress = 0;
        $notStarted = 0;
        $totalPages = 0;
        $completedPages = 0;
        
        foreach ($chapters as $chapter) {
            $status = $statuses[$chapter->id]->status ?? 'not_started';
            $pages = $chapter->no_of_pages ?? 0;
            $totalPages += $pages;
            
            switch ($status) {
                case 'completed':
                    $completed++;
                    $completedPages += $pages;
                    break;
                case 'in_progress':
                    $inProgress++;
                    break;
                default:
                    $notStarted++;
                    break;
            }
        }
        
        $progressPercent = $totalPages > 0 ? round(($completedPages / $totalPages) * 100, 2) : 0;
        
        $exportData[] = [
            $subject->name ?? 'N/A',
            $grade->name . ' - ' . $section->name,
            $chapters->count(),
            $completed,
            $inProgress,
            $notStarted,
            $totalPages,
            $completedPages,
            $progressPercent . '%'
        ];
    }
    
    // Export chapter-wise details
    $exportData[] = [];
    $exportData[] = ['Chapter-wise Detailed Report'];
    $exportData[] = ['Subject', 'Chapter No.', 'Chapter Name', 'Pages', 'Status', 'Remarks'];
    
    foreach ($assignments as $assignment) {
        $subject = DB::table('tbl_subject')->where('id', $assignment->subject_id)->first();
        $chapters = Chapter::where('subject_id', $assignment->subject_id)
            ->where('grade_id', $assignment->grade_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->orderBy('chapter_no', 'ASC')
            ->get();
        
        $statuses = DB::table('tbl_teacher_chapter_status')
            ->where('teacher_id', $teacher_id)
            ->where('session_id', $session_id)
            ->where('grade_id', $assignment->grade_id)
            ->where('section_id', $assignment->section_id)
            ->where('subject_id', $assignment->subject_id)
            ->get()
            ->keyBy('chapter_id');
        
        foreach ($chapters as $chapter) {
            $status = $statuses[$chapter->id]->status ?? 'not_started';
            $exportData[] = [
                $subject->name ?? 'N/A',
                $chapter->chapter_no,
                $chapter->name,
                $chapter->no_of_pages ?? 0,
                ucfirst(str_replace('_', ' ', $status)),
                $statuses[$chapter->id]->remarks ?? ''
            ];
        }
    }
    
    // Generate CSV
    $filename = 'teacher_chapter_progress_' . date('Y-m-d_His') . '.csv';
    $handle = fopen('php://temp', 'w');
    foreach ($exportData as $row) {
        fputcsv($handle, $row);
    }
    rewind($handle);
    $content = stream_get_contents($handle);
    fclose($handle);
    
    return response($content)
        ->withHeaders([
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
}








public function teacher_chapter_status_report(Request $request)
{
    $data['menu'] = 'teachers1';
    $data['submenu'] = 'teacher_chapter_status_report';
    
    $session_id = $request->session_id;
    $grade_id   = $request->grade_id;
    
    $user = Auth::user();
    $teacher_id = $user->teacher_id;

   
    $teacherMain = null;
    $assignments = collect();

    if ($user->type == 'teacher') {

        $teacherMain = DB::table('tbl_teacher')
            ->where('teacher_id', $teacher_id)
            ->where('status', 'Active')
            ->where('is_deleted', 0)
            ->first();

        if ($teacherMain) {
            $assignments = DB::table('tbl_teacher_assign')
                ->where('teacher_id', $teacherMain->id)
                ->select('grade_id', 'section_id', 'subject_id')
                ->get();
        }
    }

   
    if ($user->type == 'teacher' && $teacherMain) {

        $sessions = Session::where('id', $teacherMain->session_id) 
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderBy('orders_by')
            ->get();

    } else {

        $sessions = Session::where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderBy('orders_by')
            ->get();
    }

    
    if ($user->type == 'teacher' && $assignments->isNotEmpty()) {

        $gradeIds = $assignments->pluck('grade_id')->unique()->toArray();

        $grades = Grade::whereIn('id', $gradeIds)
            ->where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderBy('orders_by')
            ->get();

    } else {

        $grades = Grade::where('is_deleted', 0)
            ->where('status', 'Active')
            ->orderBy('orders_by')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | 📌 Sections (filtered by assignment)
    |--------------------------------------------------------------------------
    */
    $sections = collect();

    if ($grade_id) {

        $sections = Section::where('is_deleted', 0)
            ->where('status', 'Active')
            ->get()
            ->filter(function ($section) use ($grade_id, $user, $assignments) {

                $gradeIds = explode(',', $section->grade_id);

                if (!in_array($grade_id, $gradeIds)) {
                    return false;
                }

                // ✅ Teacher restriction
                if ($user->type == 'teacher') {
                    return $assignments->where('grade_id', $grade_id)
                                       ->where('section_id', $section->id)
                                       ->count() > 0;
                }

                return true;
            });
    }

    $reportData = collect();
    $totalCompletedChaptersCount = 0;
    $totalPendingChaptersCount = 0;
    $totalAllChaptersCount = 0;

    if ($session_id && $grade_id ) {

        $totalCompletedChaptersCount = DB::table('tbl_teacher_chapter_status')
            ->where('session_id', $session_id)
            ->where('grade_id', $grade_id)
            ->where('status', 'completed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 📖 Subjects (filtered)
        |--------------------------------------------------------------------------
        */
        $subjects = Subject::where('is_deleted', 0)
            ->where('status', 'Active')
            ->get()
            ->filter(function ($subject) use ($grade_id, $user, $assignments) {

                $gradeIds = explode(',', $subject->grade_id);

                if (!in_array($grade_id, $gradeIds)) {
                    return false;
                }

                // ✅ Teacher restriction
                if ($user->type == 'teacher') {
                    return $assignments->where('grade_id', $grade_id)
                                       ->where('subject_id', $subject->id)
                                       ->count() > 0;
                }

                return true;
            });

        foreach ($sections as $section) {
            foreach ($subjects as $subject) {

                // ✅ Teacher strict combination match
                if ($user->type == 'teacher') {
                    $valid = $assignments->where('grade_id', $grade_id)
                                         ->where('section_id', $section->id)
                                         ->where('subject_id', $subject->id)
                                         ->count();

                    if (!$valid) continue;
                }

                $chapters = Chapter::where('grade_id', $grade_id)
                    ->where('subject_id', $subject->id)
                    ->where('is_deleted', 0)
                    ->where('status', 'Active')
                    ->orderBy('chapter_no')
                    ->get();

                if ($chapters->count() == 0) continue;

                $totalPages = $chapters->sum('no_of_pages');

                $completedChapterIds = DB::table('tbl_teacher_chapter_status')
                    ->where('session_id', $session_id)
                    ->where('grade_id', $grade_id)
                    ->where('section_id', $section->id)
                    ->where('subject_id', $subject->id)
                    ->where('status', 'completed')
                    ->pluck('chapter_id')
                    ->toArray();

                $completedPages = $chapters->whereIn('id', $completedChapterIds)->sum('no_of_pages');

                $pendingPages = $totalPages - $completedPages;
                $percentage = $totalPages > 0 ? round(($completedPages / $totalPages) * 100, 2) : 0;

                $completedChaptersList = [];
                $pendingChaptersList = [];
                $allChaptersList = [];

                foreach ($chapters as $chapter) {

                    $chapterData = (object)[
                        'id' => $chapter->id,
                        'name' => $chapter->name,
                        'chapter_no' => $chapter->chapter_no,
                        'no_of_pages' => $chapter->no_of_pages
                    ];

                    $allChaptersList[] = $chapterData;
                    $totalAllChaptersCount++;

                    if (in_array($chapter->id, $completedChapterIds)) {
                        $completedChaptersList[] = $chapterData;
                    } else {
                        $pendingChaptersList[] = $chapterData;
                        $totalPendingChaptersCount++;
                    }
                }

                $completedChaptersCount = count($completedChapterIds);

                $reportData->push((object)[
                    'section_name' => $section->name,
                    'section_id' => $section->id,
                    'subject_name' => $subject->name,
                    'subject_id' => $subject->id,
                    'total_pages' => $totalPages,
                    'completed_pages' => $completedPages,
                    'pending_pages' => $pendingPages,
                    'percentage' => $percentage,
                    'total_chapters' => $chapters->count(),
                    'completed_chapters' => $completedChaptersCount,
                    'pending_chapters' => $chapters->count() - $completedChaptersCount,
                    'all_chapters_list' => $allChaptersList,
                    'completed_chapters_list' => $completedChaptersList,
                    'pending_chapters_list' => $pendingChaptersList,
                ]);
            }
        }
    }

    return view('backend.reports.teacher_chapter_status', compact(
        'sessions', 
        'grades', 
        'sections', 
        'reportData', 
        'session_id', 
        'grade_id', 
        'data',
        'totalCompletedChaptersCount',
        'totalPendingChaptersCount',
        'totalAllChaptersCount'
    ));
}




  public function student_formate_list(Request $request)
{
    $data['menu'] = 'categorys1';
    $data['submenu'] = 'student_formate_list';
    $sessions = \DB::table('tbl_session')
        ->where('is_deleted', 0)
        ->orderBy('orders_by')
        ->get();
 
    $grades = \DB::table('tbl_grade')
        ->where('is_deleted', 0)
        ->orderBy('orders_by')
        ->get();
 
    
    if (!$request->filled('session_id')) {
        return view('backend.teacher.student_formate_list', compact('data','sessions', 'grades'));
    }
 
  
    $session_id  = $request->session_id;
    $grade_ids   = $request->grade_id;  
    $section_ids = $request->section_id; 
 
    $query = \DB::table('tbl_admission as a')
        ->join('tbl_grade as g',   'a.grade_id',   '=', 'g.id')
        ->join('tbl_section as s', 'a.section_id', '=', 's.id')
        ->where('a.is_deleted', 0)
        ->where('a.status', 1)
        ->where('a.session_id', $session_id)
        ->select(
            'a.id',
            'a.admission_no',
            'a.roll_number',
            \DB::raw("CONCAT(COALESCE(a.first_name,''), ' ', COALESCE(a.middle_name,''), ' ', COALESCE(a.last_name,'')) as student_name"),
            'g.id   as grade_id',
            'g.name as grade_name',
            's.id   as section_id',
            's.name as section_name'
        );
 
    
    if ($grade_ids !== 'all' && !empty($grade_ids)) {
        $query->whereIn('a.grade_id', (array) $grade_ids);
    }
 
  
    if ($section_ids !== 'all' && !empty($section_ids)) {
        $query->whereIn('a.section_id', (array) $section_ids);
    }
 
   
    $students = $query
        ->orderBy('g.orders_by')
        ->orderBy('s.orders_by')
        ->orderBy('a.roll_number')
        ->get();
 
   
    $groups = [];
    foreach ($students as $st) {
        $key = $st->grade_id . '_' . $st->section_id;
        $groups[$key]['grade_name']   = trim($st->grade_name);
        $groups[$key]['section_name'] = trim($st->section_name);
        $groups[$key]['students'][]   = $st;
    }
 
    
    $sessionName = \DB::table('tbl_session')
        ->where('id', $session_id)
        ->value('name');
 
    return view('backend.teacher.student_formate_list', compact(
        'sessions', 'grades', 'groups', 'sessionName',
        'session_id', 'grade_ids', 'section_ids','data'
    ));
}




public function student_data_list(Request $request)
{
    $data['menu']    = 'categorys1';
    $data['submenu'] = 'student_data_list';

    $sessions = DB::table('tbl_session')
        ->where('is_deleted', 0)
        ->orderBy('orders_by')
        ->get();

    $grades = DB::table('tbl_grade')
        ->where('is_deleted', 0)
        ->orderBy('orders_by')
        ->get();

    if (! $request->filled('session_id')) {
        return view('backend.teacher.student_data_list', compact('data', 'sessions', 'grades'));
    }

    $session_id  = $request->session_id;
    $grade_ids   = $request->grade_id;
    $section_ids = $request->section_id;
    $exam_id     = $request->exam_id;

    // ── Students query ───────────────────────────────────────────────────
    $query = DB::table('tbl_admission as a')
        ->join('tbl_grade as g',   'a.grade_id',   '=', 'g.id')
        ->join('tbl_section as s', 'a.section_id', '=', 's.id')
        ->where('a.is_deleted', 0)
        ->where('a.status', 1)
        ->where('a.session_id', $session_id)
        ->select(
            'a.id',
            'a.admission_no',
            'a.roll_number',
            DB::raw("TRIM(CONCAT(
                COALESCE(a.first_name,''), ' ',
                COALESCE(a.middle_name,''), ' ',
                COALESCE(a.last_name,'')
            )) as student_name"),
            'g.id   as grade_id',
            'g.name as grade_name',
            's.id   as section_id',
            's.name as section_name'
        );

    if ($grade_ids !== 'all' && ! empty($grade_ids)) {
        $query->whereIn('a.grade_id', (array) $grade_ids);
    }
    if ($section_ids !== 'all' && ! empty($section_ids)) {
        $query->whereIn('a.section_id', (array) $section_ids);
    }

    $students = $query
        ->orderBy('g.orders_by')
        ->orderBy('s.orders_by')
        ->orderBy('a.roll_number')
        ->get();

    // ── Group by grade + section ─────────────────────────────────────────
    $groups = [];
    foreach ($students as $st) {
        $key = $st->grade_id . '_' . $st->section_id;
        $groups[$key]['grade_id']     = $st->grade_id;
        $groups[$key]['grade_name']   = trim($st->grade_name);
        $groups[$key]['section_id']   = $st->section_id;
        $groups[$key]['section_name'] = trim($st->section_name);
        $groups[$key]['students'][]   = $st;
    }

    // ── Attach subjects + marks to each group ────────────────────────────
    foreach ($groups as $key => &$group) {

        $gradeId   = $group['grade_id'];
        $sectionId = $group['section_id'];

        // Resolve exam
        if (empty($exam_id) || $exam_id === 'all') {
            $examRow = DB::table('tbl_exam')
                ->whereRaw('FIND_IN_SET(?, grade_id)', [$gradeId])
                ->where('status', 'Active')
                ->where('is_deleted', 0)
                ->orderBy('orders_by')
                ->first();
            $resolvedExamId = $examRow ? $examRow->id : null;
        } else {
            $resolvedExamId = $exam_id;
            $examRow = DB::table('tbl_exam')->where('id', $resolvedExamId)->first();
        }

        $group['exam_id']   = $resolvedExamId;
        $group['exam_name'] = ($examRow ?? null) ? $examRow->exam_name : 'N/A';

        // ── Passing percent from exam row (0 means no pass mark check) ──
        $theoryPassPercent    = ($examRow && $examRow->theory_passing_percent > 0)
                                    ? (float) $examRow->theory_passing_percent
                                    : 0;
        $practicalPassPercent = ($examRow && $examRow->practical_passing_percent > 0)
                                    ? (float) $examRow->practical_passing_percent
                                    : 0;

        // Subjects for this exam + grade
        if ($resolvedExamId) {
            $subjects = DB::table('tbl_exam_subject_marks as esm')
                ->join('tbl_subject as sub', 'sub.id', '=', 'esm.subject_id')
                ->where('esm.exam_id',     $resolvedExamId)
                ->where('esm.grade_id',    $gradeId)
                ->where('esm.is_included', 1)
                ->where('esm.is_deleted',  0)
                ->where('sub.is_deleted',  0)
                ->select(
                    'sub.id   as subject_id',
                    'sub.name as subject_name',
                    'sub.is_optional',
                    'esm.marks           as full_theory',
                    'esm.practical_marks as full_practical'
                )
                ->orderBy('sub.orders_by')
                ->get();
        } else {
            $subjects = collect();
        }

        $group['subjects']             = $subjects;
        $group['total_full_theory']    = $subjects->sum('full_theory');
        $group['total_full_practical'] = $subjects->sum('full_practical');
        $group['grand_full_marks']     = $group['total_full_theory'] + $group['total_full_practical'];

        // Fetch marks for all students in this group
        $studentIds = collect($group['students'])->pluck('id')->toArray();

        $marksRows = collect();
        if ($resolvedExamId && ! empty($studentIds)) {
            $marksRows = DB::table('tbl_student_marks')
                ->where('exam_id',    $resolvedExamId)
                ->where('session_id', $session_id)
                ->where('grade_id',   $gradeId)
                ->where('section_id', $sectionId)
                ->where('is_deleted', 0)
                ->whereIn('student_id', $studentIds)
                ->get()
                ->groupBy('student_id')
                ->map(fn($rows) => $rows->keyBy('subject_id'));
        }

        // Attach marks + compute totals per student
        $highestTotal = 0;
        $lowestTotal  = PHP_INT_MAX;
        $passedCount  = 0;
        $failedCount  = 0;

        foreach ($group['students'] as &$st) {
            $stMarks       = $marksRows[$st->id] ?? collect();
            $obtainedTotal = 0;
            $subjectFullTotal = 0;
            $failed        = false;

            foreach ($subjects as $sub) {
                $markRow = $stMarks[$sub->subject_id] ?? null;
                $isOptionalWithoutMarks = (bool) ($sub->is_optional ?? false) && ! $markRow;

                if (! $isOptionalWithoutMarks) {
                    $subjectFullTotal += (float) $sub->full_theory + (float) $sub->full_practical;
                }

                $thObtained = $markRow
                    ? ($markRow->is_absent_theory    ? 'AB' : ($markRow->obtained_mark           ?? ''))
                    : '';

                $prObtained = ($sub->full_practical > 0 && $markRow)
                    ? ($markRow->is_absent_practical ? 'AB' : ($markRow->obtained_practical_mark ?? ''))
                    : '';

                if (is_numeric($thObtained)) $obtainedTotal += (float) $thObtained;
                if (is_numeric($prObtained)) $obtainedTotal += (float) $prObtained;

               
                if ($thObtained === 'AB' || $prObtained === 'AB') {
                    $failed = true;
                }

               
                if (
                    $markRow &&
                    $thObtained !== 'AB' &&
                    is_numeric($thObtained) &&
                    $theoryPassPercent > 0 &&
                    (float) $sub->full_theory > 0
                ) {
                    $theoryPassMark = ($sub->full_theory * $theoryPassPercent) / 100;
                    if ((float) $thObtained < $theoryPassMark) {
                        $failed = true;
                    }
                }

              
                if (
                    $markRow &&
                    $sub->full_practical > 0 &&
                    $prObtained !== 'AB' &&
                    is_numeric($prObtained) &&
                    $practicalPassPercent > 0
                ) {
                    $practicalPassMark = ($sub->full_practical * $practicalPassPercent) / 100;
                    if ((float) $prObtained < $practicalPassMark) {
                        $failed = true;
                    }
                }

                $st->marks[$sub->subject_id] = [
                    'th' => $thObtained,
                    'pr' => $prObtained,
                ];
            }

            $st->obtained_total = $obtainedTotal;
            $st->subject_full_total = $subjectFullTotal;
            $st->is_failed      = $failed;

            if ($obtainedTotal > $highestTotal) $highestTotal = $obtainedTotal;
            if ($obtainedTotal < $lowestTotal)  $lowestTotal  = $obtainedTotal;
            if ($failed) $failedCount++; else $passedCount++;
        }
        unset($st);

       
        $passedStudents = collect($group['students'])
            ->filter(fn($s) => ! $s->is_failed)
            ->sortByDesc('obtained_total')
            ->values();

        $rankMap = [];
        $rank    = 1;
        foreach ($passedStudents as $i => $st) {
         
            if ($i > 0 && $st->obtained_total < $passedStudents[$i - 1]->obtained_total) {
                $rank = $i + 1;
            }
            $rankMap[$st->id] = $rank;
        }

     foreach ($group['students'] as &$st) {
        $st->rank = $st->is_failed ? '-' : ($rankMap[$st->id] ?? '-');

        $subjectGpaTotal = 0;
        $subjectGpaCount = 0;
        $hasAnyMarks     = false;
        $stMarks         = $marksRows[$st->id] ?? collect();

        foreach ($subjects as $sub) {
            $markRow = $stMarks[$sub->subject_id] ?? null;
            if ((bool) ($sub->is_optional ?? false) && ! $markRow) {
                continue;
            }

            $subjectFull = (float) $sub->full_theory + (float) $sub->full_practical;
            if ($subjectFull <= 0) {
                continue;
            }

            $thMark = $st->marks[$sub->subject_id]['th'] ?? '';
            $prMark = $st->marks[$sub->subject_id]['pr'] ?? '';
            $subjectObtained = 0;

            if (is_numeric($thMark)) {
                $subjectObtained += (float) $thMark;
                $hasAnyMarks = true;
            }

            if ($sub->full_practical > 0 && is_numeric($prMark)) {
                $subjectObtained += (float) $prMark;
                $hasAnyMarks = true;
            }

            $subjectGpaTotal += $this->calculateSubjectGradePoints($subjectObtained, $subjectFull);
            $subjectGpaCount++;
        }

        if ($st->is_failed) {
            $st->gpa_value = '-';
            $st->gpa_grade = 'NG';
        } elseif ($subjectGpaCount > 0 && $hasAnyMarks) {
            $averageGpa = round($subjectGpaTotal / $subjectGpaCount, 2);
            $st->gpa_value = number_format($averageGpa, 2);
            $st->gpa_grade = $this->calculateGradeFromGpa($averageGpa);
        } else {
            $st->gpa_value = '-';
            $st->gpa_grade = '-';
        }
    }
    unset($st);

     
        $group['students']      = collect($group['students'])->sortBy('roll_number')->values()->all();
        $group['highest_score'] = $highestTotal;
        $group['lowest_score']  = ($lowestTotal === PHP_INT_MAX) ? 0 : $lowestTotal;
        $group['passed_count']  = $passedCount;
        $group['failed_count']  = $failedCount;
    }
    unset($group);

    $sessionName = DB::table('tbl_session')->where('id', $session_id)->value('name');

    return view('backend.teacher.student_data_list', compact(
        'sessions', 'grades', 'groups', 'sessionName',
        'session_id', 'grade_ids', 'section_ids', 'exam_id', 'data'
    ));
}

}

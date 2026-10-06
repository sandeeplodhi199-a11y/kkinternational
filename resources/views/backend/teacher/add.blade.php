@extends('backend.layouts.app')

@section('content')

<style>
.grade-block{
border:1px solid #ddd;
padding:20px;
border-radius:10px;
margin-bottom:20px;
background:#fff;
}

.section-card{
border:1px solid #ddd;
border-radius:8px;
margin-bottom:15px;
overflow:hidden;
}

.section-head{
background:#f5f7fb;
padding:12px 15px;
font-weight:600;
}

.subject-box{
display:none;
padding:15px;
background:#fbfcff;
border-top:1px solid #ddd;
}

.subject-item{
margin-bottom:10px;
}

.remove-grade{
margin-top:30px;
}


.mt-4, .my-4 {
    margin-top: 0rem !important;
}
</style>



<div class="content-wrapper">
<div class="container-fluid py-4">

<div class="card shadow">
<div class="card-header bg-primary text-white">
<h4>Add Teacher</h4>
</div>


<form action="{{ route('saveTeacher') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="card-body">


<div class="row">

<div class="col-md-3 mb-3">
<label>Name</label>
<input type="text"
name="name"
class="form-control"
required>
</div>


<div class="col-md-3 mb-3">
<label>Email</label>
<input type="email"
name="email"
class="form-control">
</div>


<div class="col-md-3 mb-3">
<label>Phone</label>
<input type="text"
name="phone"
class="form-control">
</div>

<div class="col-md-3 mt-4">
<label>Image</label>

<input type="file"
name="image"
class="form-control">
</div>



<div class="col-md-3 mb-3">
<label>Gender</label>
<select name="gender" class="form-control">
<option value="">Select</option>
<option>Male</option>
<option>Female</option>
</select>
</div>


<div class="col-md-3 mb-3">
<label>DOB</label>
<input type="date"
name="dob"
class="form-control">
</div>


<div class="col-md-3 mb-3">
<label>Password</label>
<input type="password"
name="password"
class="form-control">
</div>


<div class="col-md-3 mb-3">
<label>City</label>
<input type="text"
name="city"
class="form-control">
</div>


<div class="col-md-6 mb-4">
<label>Address</label>
<input type="text"
name="address"
class="form-control">
</div>


<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Session</label>
                                        <select name="session_id" id="session_id" class="form-control select2" required>
                                            <option value="">Select Session</option>
                                            @foreach($session as $ses)
                                                <option value="{{ $ses->id }}">
                                                    {{ $ses->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


<div class="col-md-12">

<h5>
Assign Grade / Section / Subject
</h5>

<div id="grade-wrapper">


<div class="grade-block">

<div class="row">

<div class="col-md-3">
<label>Grade</label>

<select class="form-control grade-select">

<option value="">
Select Grade
</option>

@foreach($grade as $g)

<option value="{{$g->id}}">
{{$g->name}}
</option>

@endforeach

</select>

</div>


<div class="col-md-8">

<label>
Sections & Subjects
</label>

<div class="section-box border p-3">
Select Grade First
</div>

</div>


<div class="col-md-1">
<button type="button"
class="btn btn-danger remove-grade">
X
</button>
</div>


</div>

</div>


</div>



<button type="button"
id="add-grade"
class="btn btn-primary">
+ Add More Grade
</button>


</div>




</div>

</div>


<div class="card-footer text-right">
<button class="btn btn-success">
Save Teacher
</button>
</div>

</form>

</div>
</div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

$(function(){



/* Add More Grade */

$('#add-grade').click(function(){

let clone=$('.grade-block:first').clone();

clone.find('select').val('');
clone.find('.section-box')
.html('Select Grade First');

$('#grade-wrapper').append(clone);

refreshGrades();

});



/* Remove Grade */

$(document).on(
'click',
'.remove-grade',
function(){

if($('.grade-block').length>1){

$(this)
.closest('.grade-block')
.remove();

refreshGrades();

}

});





/* Grade Change */

$(document).on(
'change',
'.grade-select',
function(){

let grade=$(this).val();

let parent=$(this)
.closest('.grade-block');

let box=parent.find('.section-box');


if(!grade){
box.html('');
return;
}


refreshGrades();



$.get('/admin/get-sections/'+grade,function(sec){


$.get('/admin/get-subjects/'+grade,function(sub){


let html='';


sec.forEach(function(section){


html+=`

<div class="section-card">

<div class="section-head">

<label>

<input
type="checkbox"
class="section-toggle"
data-target="sec_${grade}_${section.id}"
>

${section.name}

</label>

</div>


<div
id="sec_${grade}_${section.id}"
class="subject-box">

<div class="row">

`;



sub.forEach(function(subject){

html+=`

<div class="col-md-4 subject-item">

<label>

<input
type="checkbox"

name="subject_id[${grade}][${section.id}][]"

value="${subject.id}">

${subject.name}

</label>

</div>

`;

});


html+=`

</div>

</div>

</div>

`;



});


box.html(html);


});


});


});





/* Section Toggle */

$(document).on(
'change',
'.section-toggle',
function(){

let target=$(this).data('target');

if($(this).is(':checked')){

$('#'+target).slideDown();

}else{

$('#'+target).slideUp();

$('#'+target)
.find('input[type=checkbox]')
prop('checked',false);

}

});






/* Prevent Duplicate Grade */

function refreshGrades(){

let selected=[];

$('.grade-select').each(function(){

if($(this).val()){
selected.push($(this).val());
}

});


$('.grade-select').each(function(){

let current=$(this).val();

$(this)
.find('option')
.each(function(){

let val=$(this).val();

if(
val!=''
&& selected.includes(val)
&& val!=current
){
$(this).prop(
'disabled',
true
);
}
else{
$(this).prop(
'disabled',
false
);
}

});

});

}



});
</script>

@endsection
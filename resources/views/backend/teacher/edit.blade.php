@extends('backend.layouts.app')

@section('content')

@php
$user = Auth::user();
@endphp

<div class="content-wrapper">
<div class="container-fluid py-3">

<h3>Edit Teacher</h3>

<form method="POST"
action="{{url('admin/Updateteacher')}}"
enctype="multipart/form-data">

@csrf

<input type="hidden"
name="id"
value="{{$teacher->id}}">


<div class="row">

<div class="col-md-9">

<div class="row">

<div class="col-md-4 mb-3">
<label>Name</label>

<input
type="text"
name="name"
value="{{$teacher->name}}"
class="form-control">
</div>



<div class="col-md-4 mb-3">
<label>Email</label>

<input
type="email"
name="email"
value="{{$teacher->email}}"
class="form-control">
</div>



<div class="col-md-4 mb-3">
<label>Phone</label>

<input
type="text"
name="phone"
value="{{$teacher->phone}}"
class="form-control">
</div>



<div class="col-md-4 mb-3">
<label>DOB</label>

<input
type="date"
name="dob"
value="{{$teacher->dob}}"
class="form-control">
</div>



<div class="col-md-4 mb-3">
<label>City</label>

<input
type="text"
name="city"
value="{{$teacher->city}}"
class="form-control">
</div>



<div class="col-md-4 mb-3">
<label>Address</label>

<input
type="text"
name="address"
value="{{$teacher->address}}"
class="form-control">
</div>


 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Session</label>
                                    <select name="session_id" class="form-control" required>
                                        <option value="">Select Session</option>
                                        @foreach($session as $ses)
                                            <option value="{{ $ses->id }}" 
                                                {{ $teacher->session_id == $ses->id ? 'selected' : '' }}>
                                                {{ $ses->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
    
<div class="col-md-12">
<label><strong>Assign Grade / Section / Subject</strong></label>

<div id="grade-wrapper">
@foreach($selectedGrades as $gid)
<div class="grade-block border p-3 mb-3">
<div class="row">

    <div class="col-md-3">
        <label>Grade</label>

        @if($user->type == 'teacher')
            {{-- Show only / non editable --}}
            <select class="form-control grade-select" disabled>
                @foreach($grade as $g)
                    <option value="{{$g->id}}" {{$gid==$g->id?'selected':''}}>
                        {{$g->name}}
                    </option>
                @endforeach
            </select>

            {{-- disabled fields submit nahi hote --}}
            <input type="hidden" name="grades[]" value="{{$gid}}">
        @else
            {{-- Editable --}}
            <select name="grades[]" class="form-control grade-select">
                <option value="">Select</option>
                @foreach($grade as $g)
                    <option value="{{$g->id}}" {{$gid==$g->id?'selected':''}}>
                        {{$g->name}}
                    </option>
                @endforeach
            </select>
        @endif
    </div>


    <div class="col-md-8">
        <label>Sections & Subjects</label>

        <div 
            class="section-box border p-2"
            data-map='@json($selectedMap[$gid]??[])'
            @if($user->type=='teacher')
                style="pointer-events:none;background:#f8f9fa;"
            @endif
        >
        </div>
    </div>


    @if($user->type != 'teacher')
    <div class="col-md-1 d-flex align-items-end">
        <button type="button" class="btn btn-danger remove-grade">
            X
        </button>
    </div>
    @endif

</div>
</div>
@endforeach
</div>

@if($user->type != 'teacher')
<button type="button" id="add-grade" class="btn btn-primary btn-sm">
    + Add More
</button>
@endif

</div>

</div>

</div>



<div class="col-md-3 text-center">

<img
id="preview-image"
src="{{ !empty($teacher->image)
? url('public/teacher/uploads/'.$teacher->image)
: asset('assets/img/user.png')}}"

class="img-thumbnail mb-2"
style="
height:150px;
width:150px;
object-fit:cover;
">

<input
type="file"
name="image"
id="image"
class="form-control">

</div>


</div>


<button class="btn btn-success mt-3">
Update
</button>

</form>

</div>
</div>



<script>
$(document).ready(function(){


/* ==========================
LOAD EXISTING GRADE DATA
========================== */

$('.grade-select').each(function(){

let grade=$(this).val();

if(grade!=''){
loadData(
$(this).closest('.grade-block'),
grade
);
}

});



/* ==========================
GRADE CHANGE
========================== */

$(document).on(
'change',
'.grade-select',
function(){

let grade=$(this).val();

let parent=$(this)
.closest('.grade-block');

if(!grade){
parent.find('.section-box')
.html('Select Grade First');
return;
}

loadData(parent,grade);

refreshGrades();

});




/* ==========================
LOAD SECTION + SUBJECTS
========================== */

function loadData(parent,grade){

let box=
parent.find('.section-box');

let saved=
box.data('map') || {};


$.get(
"{{url('admin/get-sections')}}/"+grade,
function(sec){

$.get(
"{{url('admin/get-subjects')}}/"+grade,
function(sub){

let html='';


sec.forEach(function(section){

let checked=
saved[section.id]
?'checked':'';


let open=
saved[section.id]
?'block':'none';


html+=`

<div class="card mb-2">

<div class="card-header bg-light">

<label class="mb-0">

<input
type="checkbox"
class="section-toggle"
data-target="sec_${grade}_${section.id}"
${checked}
>

<b>${section.name}</b>

</label>

</div>


<div
id="sec_${grade}_${section.id}"
style="
display:${open};
padding:15px;
">

<div class="row">

`;


sub.forEach(function(subject){

let mark='';

if(
saved[section.id]
&&
saved[section.id].includes(
parseInt(subject.id)
)
){
mark='checked';
}


html+=`

<div class="col-md-4 mb-2">

<label>

<input
type="checkbox"
name="subject_id[${grade}][${section.id}][]"
value="${subject.id}"
${mark}
>

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

}





/* ==========================
SECTION OPEN/CLOSE
========================== */

$(document).on(
'change',
'.section-toggle',
function(){

let target=
$(this).data('target');


if($(this).is(':checked')){

$('#'+target).slideDown();

}
else{

$('#'+target).slideUp();

$('#'+target)
.find(':checkbox')
.prop(
'checked',
false
);

}

});





/* ==========================
ADD MORE GRADE
========================== */

$('#add-grade').off('click').on(
'click',
function(){

let clone=
$('.grade-block:first')
.clone(false);


clone.find('.grade-select')
.val('');


clone.find('.section-box')
.html('Select Grade First')
.attr(
'data-map',
'{}'
);


clone.find(':checkbox')
.prop(
'checked',
false
);


clone.find('.card').remove();


$('#grade-wrapper')
.append(clone);


refreshGrades();

});





/* ==========================
REMOVE GRADE
========================== */

$(document).on(
'click',
'.remove-grade',
function(){

if(
$('.grade-block').length>1
){

$(this)
.closest('.grade-block')
.remove();

refreshGrades();

}

});






/* ==========================
DUPLICATE GRADE DISABLE
========================== */

function refreshGrades(){

let selected=[];


$('.grade-select').each(function(){

let v=$(this).val();

if(v){
selected.push(v);
}

});



$('.grade-select').each(function(){

let current=
$(this).val();

$(this)
.find('option')
.each(function(){

let v=
$(this).val();

if(
v!=''
&&
selected.includes(v)
&&
v!=current
){
$(this)
.prop(
'disabled',
true
);
}
else{
$(this)
.prop(
'disabled',
false
);
}

});

});

}



/* ==========================
IMAGE PREVIEW
========================== */

$('#image').change(function(){

let reader=
new FileReader();

reader.onload=function(e){

$('#preview-image')
.attr(
'src',
e.target.result
);

};

reader.readAsDataURL(
this.files[0]
);

});



refreshGrades();


});
</script>

@endsection
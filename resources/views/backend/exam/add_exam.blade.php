@extends('backend.layouts.app')
@section('content')

<style>
.content-wrapper{ background:linear-gradient(180deg,#eef4ff,#f8fbff); padding-bottom:40px; }
.exam-card{ border:none; border-radius:22px; overflow:hidden; box-shadow:0 12px 35px rgba(37,99,235,.10); }
.exam-head{ background:linear-gradient(135deg,#2563eb,#4f46e5,#06b6d4); padding:22px 28px; color:#fff; }
.exam-head h4{ margin:0; font-weight:700; }
.form-label{ font-weight:600; margin-bottom:7px; color:#334155; }
.form-control{ height:46px; border-radius:12px; border:1px solid #d6ddea; }
.form-control:focus{ box-shadow:0 0 0 3px rgba(37,99,235,.08); border-color:#2563eb; }
.top-box{ background:#fff; padding:20px; border-radius:18px; box-shadow:0 6px 20px rgba(0,0,0,.05); }
.section-title{ font-size:20px; font-weight:700; color:#1e293b; }
.add-btn{ border:none; padding:11px 20px; border-radius:12px; background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; font-weight:600; }
.grade-card{ border:none; border-radius:18px; overflow:hidden; box-shadow:0 6px 24px rgba(0,0,0,.05); }
.grade-head{ background:linear-gradient(135deg,#eff6ff,#dbeafe); padding:18px; border-bottom:1px solid #dbeafe; }
.removeGrade{ border-radius:10px; }
.subject-panel{ background:#ffffff; padding:18px; border-radius:18px; }
.master-box{ background:linear-gradient(135deg,#fff7ed,#fef3c7); padding:18px; border-radius:15px; margin-bottom:18px; border:1px solid #fde68a; }
.master-box label{ font-size:13px; font-weight:700; margin-bottom:6px; display:block; }
.subject-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:16px; }
.subject-item{ background:linear-gradient(135deg,#ffffff,#f8fbff); border:1px solid #dbeafe; border-radius:16px; padding:18px; transition:.3s; }
.subject-item:hover{ transform:translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,.05); }
.subject-item.excluded-item{ opacity:.55; border-color:#fecaca !important; background:linear-gradient(135deg,#fff5f5,#fff) !important; }
.subject-name{ font-size:15px; font-weight:700; color:#0f172a; }
.mark-row{ display:flex; gap:14px; }
.mark-box{ flex:1; }
.mark-box label{ font-size:12px; font-weight:700; margin-bottom:6px; display:block; }
.theory-label{ color:#2563eb; }
.practical-label{ color:#16a34a; }
.compact-input{ height:44px; border-radius:11px; }
.save-btn{ background:linear-gradient(135deg,#2563eb,#4f46e5); border:none; padding:12px 34px; border-radius:12px; font-weight:700; }
.subject-wrap{ padding:18px; }
.toggle-pill{ display:inline-block; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; transition:.2s; user-select:none; cursor:pointer; }
.toggle-pill.included{ background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
.toggle-pill.excluded{ background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }
</style>

<div class="content-wrapper">
<div class="container-fluid mt-4">

<form method="POST" action="{{ url('admin/saveExam') }}">
@csrf

<div class="card exam-card">

  <div class="exam-head d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Add Exam</h4>
    <a href="{{ url('admin/exam') }}" class="btn btn-light font-weight-bold px-4 py-2"
       style="border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.12);font-weight:600;">
      Manage Exam
    </a>
  </div>

  <div class="card-body">

    <div class="top-box mb-4">
      <div class="row">
        <div class="col-md-3">
          <label class="form-label">Exam Name</label>
          <input type="text" name="exam_name" class="form-control" placeholder="Half Yearly Exam">
        </div>
        <div class="col-md-2">
          <label class="form-label">Order By</label>
          <input type="text" name="orders_by" class="form-control">
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-control">
            <option value="Active">Active</option>
            <option value="InActive">InActive</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Theory Pass %</label>
          <input type="text" name="theory_passing_percent" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Practical Pass %</label>
          <input type="text" name="practical_passing_percent" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Start Date</label>
          <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">End Date</label>
          <input type="date" name="end_date" class="form-control" required>
        </div>
          <div class="col-md-4">
          <label class="form-label">Marksheet Publish Date</label>
          <input type="date" name="marksheet_publish_date" class="form-control" required>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="section-title">Grade Subject Mapping</div>
      <button type="button" class="add-btn addGrade">+ Add Grade</button>
    </div>

    <div id="gradeWrapper">
      <div class="grade-card mb-3" data-row="0">
        <div class="grade-head">
          <div class="row align-items-end">
            <div class="col-md-5">
              <label class="form-label">Select Grade</label>
              <select class="form-control grade-select" name="grade_id[0]">
                <option value="">Select Grade</option>
                @foreach($grade as $g)
                  <option value="{{$g->id}}">{{$g->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-danger removeGrade">Remove</button>
            </div>
          </div>
        </div>
        <div class="subject-wrap">Select Grade First</div>
      </div>
    </div>

    <button class="btn btn-primary save-btn mt-4">Save Exam</button>

  </div>
</div>

</form>
</div>
</div>

<script>
$(function(){

  let rowCount = 1;

  function gradeHtml(index){
    return `
    <div class="grade-card mb-3" data-row="${index}">
      <div class="grade-head">
        <div class="row align-items-end">
          <div class="col-md-5">
            <label class="form-label">Select Grade</label>
            <select class="form-control grade-select" name="grade_id[${index}]">
              <option value="">Select Grade</option>
              @foreach($grade as $g)
              <option value="{{$g->id}}">{{$g->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-danger removeGrade">Remove</button>
          </div>
        </div>
      </div>
      <div class="subject-wrap">Select Grade First</div>
    </div>`;
  }

  function disableSelectedGrades(){
    let selected = [];
    $('.grade-select').each(function(){
      if($(this).val() != '') selected.push($(this).val());
    });
    $('.grade-select').each(function(){
      let current = $(this).val();
      $(this).find('option').each(function(){
        let val = $(this).val();
        $(this).prop('disabled', selected.includes(val) && current != val);
      });
    });
  }

  $('.addGrade').click(function(){
    $('#gradeWrapper').prepend(gradeHtml(rowCount));
    rowCount++;
    disableSelectedGrades();
  });

  $(document).on('click', '.removeGrade', function(){
    if($('.grade-card').length > 1){
      $(this).closest('.grade-card').remove();
      disableSelectedGrades();
    }
  });

  $(document).on('change', '.grade-select', function(){

    let currentGrade = $(this).val();
    let duplicate = false;

    $('.grade-select').not(this).each(function(){
      if($(this).val() == currentGrade && currentGrade != '') duplicate = true;
    });

    if(duplicate){
      alert('Grade already selected');
      $(this).val('');
      return;
    }

    disableSelectedGrades();

    let grade_id = $(this).val();
    let block    = $(this).closest('.grade-card');
    let index    = block.data('row');

    if(!grade_id){
      block.find('.subject-wrap').html('Select Grade First');
      return;
    }

    $.ajax({
      url: "{{url('admin/get-subjects')}}/" + grade_id,
      type: 'GET',
      success: function(res){

        let html = `
        <div class="subject-panel">
          <div class="master-box">
            <div class="row">
              <div class="col-md-6">
                <label>Master Theory Marks</label>
                <input type="text" class="form-control compact-input master-theory" placeholder="Auto Fill">
              </div>
              <div class="col-md-6">
                <label>Master Practical Marks</label>
                <input type="text" class="form-control compact-input master-practical" placeholder="Auto Fill">
              </div>
            </div>
          </div>
          <div class="subject-grid">`;

        res.forEach(function(sub){
          /* ✅ ALL inputs keyed by sub.id — subject_id, theory, practical, is_included */
          html += `
          <div class="subject-item">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="subject-name">${sub.name}</div>
              <span class="toggle-pill included">&#10003; Included</span>
            </div>
            <input type="hidden"   name="subject_id[${index}][${sub.id}]"      value="${sub.id}">
            <input type="checkbox" name="is_included[${index}][${sub.id}]"     class="include-check" value="1" checked style="display:none">
            <div class="mark-row subject-marks">
              <div class="mark-box">
                <label class="theory-label">Theory</label>
                <input type="text" name="theory_marks[${index}][${sub.id}]"    class="form-control compact-input theory-mark">
              </div>
              <div class="mark-box">
                <label class="practical-label">Practical</label>
                <input type="text" name="practical_marks[${index}][${sub.id}]" class="form-control compact-input practical-mark">
              </div>
            </div>
          </div>`;
        });

        html += `</div></div>`;
        block.find('.subject-wrap').html(html);
      }
    });
  });

  /* Toggle included/excluded */
  $(document).on('click', '.toggle-pill', function(){
    let item  = $(this).closest('.subject-item');
    let cb    = item.find('.include-check');
    let marks = item.find('.subject-marks');

    if(cb.prop('checked')){
      cb.prop('checked', false);
      $(this).removeClass('included').addClass('excluded').html('&#10007; Excluded');
      item.addClass('excluded-item');
      marks.find('input[type=text]').prop('disabled', true).val('');
    } else {
      cb.prop('checked', true);
      $(this).removeClass('excluded').addClass('included').html('&#10003; Included');
      item.removeClass('excluded-item');
      marks.find('input[type=text]').prop('disabled', false);
    }
  });

  /* Numbers only */
  $(document).on('input',
    '.theory-mark,.practical-mark,.master-theory,.master-practical,[name="orders_by"],[name="theory_passing_percent"],[name="practical_passing_percent"]',
    function(){ this.value = this.value.replace(/[^0-9]/g,''); }
  );

  /* Master fill — skip disabled */
  $(document).on('keyup change', '.master-theory', function(){
    $(this).closest('.subject-wrap').find('.theory-mark').not(':disabled').val($(this).val());
  });

  $(document).on('keyup change', '.master-practical', function(){
    $(this).closest('.subject-wrap').find('.practical-mark').not(':disabled').val($(this).val());
  });

});
</script>

@endsection
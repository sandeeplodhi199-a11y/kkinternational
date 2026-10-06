<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admit Card Preview</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: Arial, Helvetica, sans-serif;
  background: #d4d8e0;
  font-size: 9pt;
  padding: 0;
}

/* ─── CONTROLS PANEL ─── */
#ctrl-panel {
  background: #1a3a6b;
  color: #fff;
  padding: 10px 16px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: flex-end;
  position: sticky;
  top: 0;
  z-index: 100;
  border-bottom: 2px solid #0d2246;
}
#ctrl-panel label {
  font-size: 7pt;
  font-weight: 700;
  letter-spacing: 0.05em;
  color: #aec6e8;
  display: block;
  margin-bottom: 3px;
}
#ctrl-panel input, #ctrl-panel select {
  font-size: 8pt;
  padding: 4px 7px;
  border: 1px solid #3a5a8b;
  border-radius: 3px;
  background: #0d2246;
  color: #fff;
  width: 100%;
}
.cf { display: flex; flex-direction: column; min-width: 80px; }
.cf-wide { min-width: 140px; }
#ctrl-panel button {
  background: #fff;
  color: #1a3a6b;
  border: none;
  padding: 6px 14px;
  font-size: 8pt;
  font-weight: 900;
  border-radius: 3px;
  cursor: pointer;
  letter-spacing: 0.04em;
  margin-top: 12px;
}
#ctrl-panel button:hover { background: #e0e8f8; }
#page-count-info {
  font-size: 7pt;
  color: #aec6e8;
  margin-top: 12px;
  white-space: nowrap;
}

/* ─── A4 PAGE ─── */
.a4-wrap {
  width: 210mm;
  margin: 12px auto;
  background: #fff;
  box-shadow: 0 2px 18px rgba(0,0,0,0.2);
  padding: 5mm 7mm 4mm 7mm;
}
.page-badge {
  text-align: center;
  font-size: 6.5pt;
  color: #999;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 3mm;
}

/* ─── OUTER GRID ─── */
.outer {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}
.outer td.cc {
  width: 50%;
  padding: 0 2mm 4mm 2mm;
  vertical-align: top;
}

/* ─── CARD ─── */
.card {
  width: 100%;
  border-collapse: collapse;
  border: 1pt solid #b0bcd4;
  background: #fff;
}

/* Header */
.hdr-td {
  border-bottom: 1pt solid #c8d4e8;
  padding: 0;
}
.hdr-inner {
  width: 100%;
  border-collapse: collapse;
}
.logo-cell {
  width: 16mm;
  padding: 2mm 1mm 2mm 2mm;
  vertical-align: middle;
  text-align: center;
}
.logo-circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #1a3a6b;
  color: #fff;
  font-size: 5pt;
  font-weight: 900;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  border: 2px solid #c8d4e8;
  line-height: 1.2;
}
.info-cell {
  padding: 2mm 2mm 2mm 1mm;
  vertical-align: middle;
  text-align: center;
}
.tagline {
  font-size: 5.5pt;
  color: #666;
  font-style: italic;
  margin-bottom: 0.8mm;
}
.sname {
  font-size: 9.5pt;
  font-weight: 900;
  color: #111;
  line-height: 1.1;
}
.saddr {
  font-size: 5.8pt;
  color: #555;
  margin-top: 0.6mm;
}

/* Banner */
.banner {
  background: #1a3a6b;
  color: #fff;
  text-align: center;
  font-size: 7.5pt;
  font-weight: 900;
  letter-spacing: 0.2em;
  padding: 4px 0;
  display: block;
}

/* Body — CENTERED */
.body-center {
  padding: 6px 10% 5px 10%;
  text-align: center;
}
.ename {
  text-align: center;
  font-size: 7.5pt;
  font-weight: 900;
  color: #111;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  margin-bottom: 1px;
}
.edate {
  text-align: center;
  font-size: 6.5pt;
  color: #444;
  margin-bottom: 6px;
}
.itbl {
  width: auto;
  border-collapse: collapse;
  margin: 0 auto;
}
.itbl td {
  font-size: 7.5pt;
  padding: 1.8px 0;
  color: #111;
  vertical-align: middle;
}
.lb {
  width: 44px;
  font-weight: 400;
  color: #333;
  white-space: nowrap;
  text-align: left;
}
.cl {
  width: 14px;
  text-align: center;
  color: #555;
}
.vl {
  font-weight: 700;
  color: #111;
  min-width: 72px;
  text-align: left;
}

/* Signatures */
.sig-td {
  border-top: 0.7pt solid #ccd4e4;
  padding: 4px 10px 6px 10px;
  vertical-align: bottom;
}
.stbl {
  width: 100%;
  border-collapse: collapse;
}
.stbl td {
  text-align: center;
  width: 50%;
  padding: 0;
  vertical-align: bottom;
}
.sig-squiggle {
  display: block;
  height: 20px;
  margin: 0 auto 3px;
}
.sline {
  width: 65%;
  border: none;
  border-top: 0.8pt solid #555;
  margin: 0 auto 2px;
  display: block;
  height: 0;
}
.slbl {
  font-size: 5.5pt;
  color: #444;
  letter-spacing: 0.06em;
  display: block;
  text-align: center;
  text-transform: uppercase;
}

/* Empty card */
.empty-card {
  width: 100%;
  border: 1pt dashed #c4cee4;
  background: #f5f7fc;
  min-height: 64mm;
  display: block;
}
</style>
</head>
<body>

<!-- CONTROLS -->
<div id="ctrl-panel">
  <div class="cf cf-wide">
    <label>EXAM NAME</label>
    <input type="text" id="exam_name" value="FINAL TERMINAL EXAMINATION - 2082">
  </div>
  <div class="cf">
    <label>START DATE</label>
    <input type="text" id="start_date" value="2082-06-01">
  </div>
  <div class="cf">
    <label>END DATE</label>
    <input type="text" id="end_date" value="2082-06-10">
  </div>
  <div class="cf">
    <label>GRADE</label>
    <input type="text" id="grade" value="Grade 10">
  </div>
  <div class="cf">
    <label>SECTION</label>
    <input type="text" id="section" value="A">
  </div>
  <div class="cf">
    <label>TOTAL STUDENTS</label>
    <input type="number" id="total_students" value="8" min="1" max="100">
  </div>
  <div class="cf">
    <label>START ROLL NO</label>
    <input type="number" id="start_roll" value="1" min="1">
  </div>
  <button onclick="renderCards()">&#8635; REFRESH</button>
  <div id="page-count-info"></div>
</div>

<div id="pages-container"></div>

<script>
// Sample first names
var firstNames = [
  'AAROSH','AAYU','ABINASH','AFRIN','ALINA','ANGHU','ANISHA','AARAV',
  'BIKASH','DIVISHA','DIVYANI','PRIYA','RAHUL','SUNITA','SUMAN','RITA',
  'ANIL','BIJAY','SABITA','ROSHAN','MANITA','SURESH','KAMALA','RAJAN',
  'NISHA','DEEPAK','SRIJANA','PAWAN','KRITI','MILAN','SUSHMA','BINOD'
];
var lastNames = [
  'SUNDAS','RAI','DARNAL','ALAM','MAGAR','BISHWOKARMA','GURUNG','NEPAL',
  'LIMBU','TAMANG','SHARMA','THAPA','KARKI','BHANDARI','ADHIKARI','POUDEL',
  'BIYANI','SHRESTHA','KC','BASNET','CHAUDHARY','YADAV','SAHA','TIWARI'
];

function randomName(i) {
  return firstNames[i % firstNames.length] + ' ' + lastNames[(i + 7) % lastNames.length];
}

function pad(n) { return n < 10 ? '0' + n : '' + n; }

function makeSigSVG(type) {
  if (type === 'ec') {
    return '<svg class="sig-squiggle" viewBox="0 0 72 22" xmlns="http://www.w3.org/2000/svg">' +
      '<path d="M4 17 Q9 5 15 13 Q19 19 23 9 Q27 2 32 11 Q36 19 41 9 Q45 3 50 12 Q54 19 58 13 Q62 9 67 7" stroke="#333" stroke-width="1.2" fill="none" stroke-linecap="round"/>' +
      '<path d="M16 19 Q24 21 34 19" stroke="#333" stroke-width="0.9" fill="none" stroke-linecap="round"/>' +
      '</svg>';
  } else {
    return '<svg class="sig-squiggle" viewBox="0 0 72 22" xmlns="http://www.w3.org/2000/svg">' +
      '<path d="M5 15 Q12 3 19 12 Q24 18 29 7 Q33 1 39 10 Q43 17 48 8 Q52 3 57 11 Q61 16 65 9" stroke="#333" stroke-width="1.2" fill="none" stroke-linecap="round"/>' +
      '<path d="M20 19 Q30 22 41 19" stroke="#333" stroke-width="0.9" fill="none" stroke-linecap="round"/>' +
      '</svg>';
  }
}

function makeCard(student, examName, startDate, endDate) {
  return '<table class="card" cellpadding="0" cellspacing="0"><tbody>' +

    // Header
    '<tr><td class="hdr-td">' +
    '<table class="hdr-inner" cellpadding="0" cellspacing="0"><tr>' +
    '<td class="logo-cell"><div class="logo-circle">K.K.<br>INT</div></td>' +
    '<td class="info-cell">' +
    '<div class="tagline">Learning today for a better tomorrow.</div>' +
    '<div class="sname">K.K. INTERNATIONAL SCHOOL</div>' +
    '<div class="saddr">DHARAN-15, SUNSARI, NEPAL</div>' +
    '</td></tr></table>' +
    '</td></tr>' +

    // Banner
    '<tr><td style="padding:0;"><div class="banner">ADMIT CARD</div></td></tr>' +

    // Body — CENTERED
    '<tr><td>' +
    '<div class="body-center">' +
    '<div class="ename">' + examName + '</div>' +
    '<div class="edate">(' + startDate + ' - ' + endDate + ')</div>' +
    '<table class="itbl" cellpadding="0" cellspacing="0">' +
    '<tr><td class="lb">Name</td><td class="cl">:</td><td class="vl">' + student.name + '</td></tr>' +
    '<tr><td class="lb">Grade</td><td class="cl">:</td><td class="vl">' + student.grade + '</td></tr>' +
    '<tr><td class="lb">Section</td><td class="cl">:</td><td class="vl">' + student.section + '</td></tr>' +
    '<tr><td class="lb">Roll No</td><td class="cl">:</td><td class="vl">' + student.roll + '</td></tr>' +
    '</table></div>' +
    '</td></tr>' +

    // Signatures
    '<tr><td class="sig-td">' +
    '<table class="stbl" cellpadding="0" cellspacing="0"><tr>' +
    '<td>' + makeSigSVG('ec') + '<span class="sline"></span><span class="slbl">Exam Controller</span></td>' +
    '<td>' + makeSigSVG('pr') + '<span class="sline"></span><span class="slbl">Principal</span></td>' +
    '</tr></table>' +
    '</td></tr>' +

    '</tbody></table>';
}

function renderCards() {
  var examName = document.getElementById('exam_name').value.toUpperCase() || 'EXAM NAME';
  var startDate = document.getElementById('start_date').value;
  var endDate = document.getElementById('end_date').value;
  var grade = document.getElementById('grade').value;
  var section = document.getElementById('section').value.toUpperCase();
  var total = parseInt(document.getElementById('total_students').value) || 8;
  var startRoll = parseInt(document.getElementById('start_roll').value) || 1;

  // Build student list
  var students = [];
  for (var i = 0; i < total; i++) {
    students.push({
      name: randomName(i),
      grade: grade,
      section: section,
      roll: pad(startRoll + i)
    });
  }

  // Chunk into pages of 8
  var pages = [];
  for (var p = 0; p < students.length; p += 8) {
    pages.push(students.slice(p, p + 8));
  }

  var html = '';
  pages.forEach(function(pageStudents, pi) {
    html += '<div class="a4-wrap">';
    html += '<div class="page-badge">Page ' + (pi+1) + ' of ' + pages.length + ' &nbsp;·&nbsp; A4 · 2 cols × 4 rows = 8 cards per page</div>';
    html += '<table class="outer" cellpadding="0" cellspacing="0"><tbody>';

    // Chunk into rows of 2
    for (var r = 0; r < pageStudents.length; r += 2) {
      html += '<tr>';
      var left = pageStudents[r];
      var right = pageStudents[r+1];

      html += '<td class="cc">' + makeCard(left, examName, startDate, endDate) + '</td>';
      if (right) {
        html += '<td class="cc">' + makeCard(right, examName, startDate, endDate) + '</td>';
      } else {
        html += '<td class="cc"><div class="empty-card"></div></td>';
      }
      html += '</tr>';
    }

    html += '</tbody></table></div>';
  });

  document.getElementById('pages-container').innerHTML = html;
  var pageCount = pages.length;
  var totalCards = total;
  document.getElementById('page-count-info').textContent =
    totalCards + ' students · ' + pageCount + ' page' + (pageCount > 1 ? 's' : '');
}

// Initial render
renderCards();

// Live update on input change
document.querySelectorAll('#ctrl-panel input').forEach(function(el) {
  el.addEventListener('change', renderCards);
});
</script>
</body>
</html>
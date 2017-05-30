<?php

include 'db_functions.php';

$studentEmail = $_GET['email']; //email

$result = getStudent($studentEmail);

$res = "<ul id='studenteNavTab' class='nav nav-tabs'>";
$tabContent = "";

$i = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $res .= "<li class='". ($i ? "" : "active") ."'><a data-toggle='tab' href='#student{$row['id']}'>{$row['first_name']} {$row['mi']} {$row['last_name']}</a></li>";

    $tabContent .= "<div id='student{$row['id']}' class='". ($i ? "tab-pane" : "tab-pane fade active in") ."'>";
    $tabContent .= "<div class='form-group'>
        <div class='student-name-bar'>
          <label><span id='first_name'>{$row['first_name']}</span> <span id='mi'>{$row['mi']}</span> <span id='last_name'>{$row['last_name']}</span></label>
          <button type='button' class='btn btn-warning' onclick='removeStudent(event, {$row['id']})'><span class='glyphicon glyphicon-remove'></span> Remove</button>
          <button type='button' class='btn btn-primary' onclick='editStudent(event, {$row['id']})'><span class='glyphicon glyphicon-pencil'></span> Edit</button>
        </div>
        <div class='student-birth-grade'>
          <label>Date of Birth:</label> <span id='date_birth'>{$row['date_birth']}</span> <label>Grade:</label> <span id='grade'>{$row['grade']}</span>
        </div>
        <div class='student-enrollmentoptions'>
          Enrollment Options
        </div>
        <div class='student-enrollmenttype'>
          <label>Enrollment Type</label>:
          <div class='btn-group btn-group-sm' role='group'>
            <button type='button' class='btn btn-default btn-opt active'>Full Curriculum</button>
            <button type='button' class='btn btn-default btn-opt'>Individual Courses</button>
          </div>
        </div>
      </div>";
    $tabContent .= "</div>";

    $i++;
  }
}

$res .= "<li class=''><a data-toggle='tab' href='#studentAdd'>Add Student</a></li>"; //Add Student Tab
$res .= "</ul>";
$res .= "<br>";

$res .= "<div class='tab-content'>";
$res .= $tabContent; // Student individual info Tab
// Add Student Tab
$res .= "<div id='studentAdd' class='tab-pane'>
  <div class='studentAddBox'>
    <div class='form-group col-md-4'>
      First Name<br>
      <input id='studentFirstName' type='text' placeholder='required' class='form-control'>
    </div>
    <div class='form-group col-md-1'>
      M.I.<br>
      <input id='studentMI' type='text' placeholder='' class='form-control'>
    </div>
    <div class='form-group col-md-4'>
      Last Name<br>
      <input id='studentLastName' type='text' placeholder='required' class='form-control'>
    </div>
    <div class='form-group col-md-4'>
      Date of Birth<br>
      <div class='form-group'>
        <div class='input-group date' id='studentBirthdayDatepicker'>
          <input type='text' class='form-control' />
          <span class='input-group-addon'>
            <span class='glyphicon glyphicon-calendar'></span>
          </span>
        </div>
      </div>
    </div>
    <div class='form-group col-md-4'>
      Grade<br>
      <select id='selectGrade' class='form-control'></select>
    </div>
    <div class='form-group col-md-12'>
      <button id='btnSaveAddStudent' type='button' class='btn btn-primary'>Save</button>
      <button id='btnCancelAddStudent' type='button' class='btn btn-default'>Cancel</button>
    </div>
  </div>
  <div class='notEnrolledstudentAddBox col-md-12'>
    <div class='instruction'>
      <p>The following students were previously enrolled with Seton Home Study School, or previously added to this application and then removed.  Please indicate which of them you would like to add to the application and the grade in which they will be enrolled.</p>
      <p>Alternately, you may add a new student by clicking the \"New Student\" button.</p>
    </div>
    <div class='students-not-enrolled'>
      <table><tbody></tbody></table>
      <div class='button-group'>
        <button id='btnAddSelectedStudents' class='btn btn-primary'>Add Selected Students</button>
        <button id='btnAddNewStudent' class='btn btn-primary'>Add New Student</button>
      </div>
    </div>
  </div>
</div>";
// Modal
$res .= "<div class='modal fade' id='deleteStudentModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header' style='background-color:#fab402; border-radius:5px 5px 0 0; margin:1px;'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='myModalLabel'>Delete Student?</h4>
      </div>
      <div class='modal-body'>
        <p>Please confirm that you wish to Delete the student record and course selections for <span id='deleteStudentName'></span>?</p>
        <p>This action cannot be undone and will remove all course selections, etc. associated with this student in this application.  As an alternative you may wish to simply mark <span id='deleteStudentName'></span> as not enrolling.</p>
      </div>
      <div class='modal-footer'>
        <button class='btn btn-default' data-dismiss='modal'>Cancel</button>
        <button id='btnDeleteStudent' class='btn btn-primary'>Delete</button>
      </div>
    </div>
  </div>
  <input id='deleteStudentId' type='hidden' value='' />
</div>";
$res .= "</div>";

echo $res;
?>

<script type="text/javascript">
$(document).ready(function() {
  // Insert Grade Select Element in Add Student Tab
  insertGradeSelectElement('#studentAdd select#selectGrade');
  // Insert Grade Select Element in table Add Student Tab When exist removed student
  insertGradeSelectElement('.notEnrolledstudentAddBox select#grade ');

  // datepicker configuration
  let start = moment().subtract(5, 'years');
  $('#studentBirthdayDatepicker').daterangepicker(
    {
      locale: {format: 'YYYY-MM-DD'},
      singleDatePicker: true,
      showDropdowns: true,
      autoclose: true,
      startDate: start,
      "maxDate": start,
    }, function(start, end, label) {
      $('#studentBirthdayDatepicker input').val(start.format('YYYY-MM-DD'));
    }
  );

  // Add Student
  $('#studentAdd #btnSaveAddStudent').on('click', function(e) {
    e.preventDefault();
    addStudent();
  });
  // When click Cancel button, Go to first tab
  $('#studentAdd #btnCancelAddStudent').on('click', function(e) {
    e.preventDefault();
    $('#studenteNavTab li:first-child a').trigger('click');
  });
  // Enrollment Type
  $('.btn-group .btn-opt').on('click', function(e) {
    e.preventDefault();
    $(this).parent().find('.btn-opt.active').removeClass('active');
    $(this).addClass('active');
  });
  // Display NotEnrolledStudent
  $('#studenteNavTab li a[href=#studentAdd]').on('click', function(e) {
    e.preventDefault();
    displayNotEnrolledStudent();
  });
  // In modal
  $('#btnDeleteStudent').on('click', function(e) {
    e.preventDefault();
    let studentId = $('#deleteStudentModal #deleteStudentId').val();
    deleteStudent(studentId);
  });
  // 'Add Selected Students' button
  $('#btnAddSelectedStudents').on('click', function(e) {
    e.preventDefault();

    let studentIds = [];
    let $trs = $('.students-not-enrolled tr:has(#enrolling:checked)');
    for (let i = 0; i < $trs.length; i++) {
      studentIds.push($trs.eq(i).attr('id'));
    }

    revertStudent(studentIds.toString());
  });
  // 'Add New Student' button
  $('#btnAddNewStudent').on('click', function(e) {
    e.preventDefault();
    $('.studentAddBox').css('display', 'block');
    $('.notEnrolledstudentAddBox').css('display', 'none');
  });
});

// Insert Grade Select Element
function insertGradeSelectElement(selector) {
  var gradeStr = "<option></option><option>Pre-Kindergarten</option><option>Kindergarten</option>";

  for (let i = 1; i <= 12; i++) {
    let grade = "";
    if (i == 1) grade = "1st";
    else if (i == 2) grade = "2nd";
    else if (i == 3) grade = "3rd";
    else grade = i + "th";

    gradeStr += "<option>" + grade +" Grade</option>";
  }
  $(selector).html(gradeStr);
}
// Add Student
function addStudent() {

  let email = $('#textinputEmail').val();
  let studentFirstName = $.trim($('#studentAdd #studentFirstName').val());
  let studentMI = $.trim($('#studentAdd #studentMI').val());
  let studentLastName = $.trim($('#studentAdd #studentLastName').val());
  let studentGrade = $.trim($('#studentAdd #selectGrade').val());
  let studentDateBirth = $.trim($('#studentAdd #studentBirthdayDatepicker input').val());

  if (studentFirstName == '') {
    alert('Please input First Name.');
    return;
  }

  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'addStudent',
      email: email,
      studentFirstName: studentFirstName,
      studentMI: studentMI,
      studentLastName: studentLastName,
      studentGrade: studentGrade,
      studentDateBirth: studentDateBirth
    },
    success: function(result) {
      console.log(result);
      $('#studentAdd input, #studentAdd select').val('');
      showStudent($('#textinputEmail').val()); // reload student tabs
    }, 
    error: function() {
      console.log('An error has occurred when save in Add Student Tab');
    },
  });
}

// Update Student
function updateStudent(studentId) {

  let blockId = 'student' + studentId;
  let studentFirstName = $.trim($('#'+blockId+' #studentFirstName').val());
  let studentMI = $.trim($('#studentMI').val());
  let studentLastName = $.trim($('#studentLastName').val());
  let studentGrade = $.trim($('#selectGrade').val());
  let studentDateBirth = $.trim($('#studentBirthdayDatepicker input').val());

  if (studentFirstName == '') {
    alert('Please input First Name.');
    return;
  }

  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'updateStudent',
      studentFirstName: studentFirstName,
      studentMI: studentMI,
      studentLastName: studentLastName,
      studentGrade: studentGrade,
      studentDateBirth: studentDateBirth
    },
    success: function(result) {
      console.log(result);
      $('#studentAdd input, #studentAdd select').val('');
      showStudent($('#textinputEmail').val()); // reload student tabs
    }, 
    error: function() {
      console.log('An error has occurred when save in Add Student Tab');
    },
  });
}

// Remove Student
function removeStudent(event, studentId) {
  event.preventDefault();
  
  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'removeStudent',
      studentId: studentId
    },
    success: function(result) {
      console.log(result)
      showStudent($('#textinputEmail').val()); // reload student tabs
    }, 
    error: function() {
      console.log('An error has occurred when remove student in Student Tab');
    },
  });
}

// Edit Student, Replace to edit form when click 'Edit' button
function editStudent(event, studentId) {
  event.preventDefault();

  let blockId = 'student' + studentId;
  let first_name = $('#'+blockId+' #first_name').text();
  let mi = $('#'+blockId+' #mi').text();
  let last_name = $('#'+blockId+' #last_name').text();
  let date_birth = $('#'+blockId+' #date_birth').text();
  let grade = $('#'+blockId+' #grade').text();
  let originForm = $('#'+blockId).html();
  let editForm = $('.studentAddBox').html();

  $('#'+blockId).html(editForm);
  // Insert Grade Select Element
  insertGradeSelectElement('#'+blockId+' select#selectGrade');
  // datepicker configuration
  let start = moment().subtract(5, 'years');
  $('#'+blockId+' #studentBirthdayDatepicker').daterangepicker(
    {
      locale: {format: 'YYYY-MM-DD'},
      singleDatePicker: true,
      showDropdowns: true,
      autoclose: true,
      startDate: start,
      "maxDate": start,
    }, function(start, end, label) {
      $('#studentBirthdayDatepicker input').val(start.format('YYYY-MM-DD'));
    }
  );
  $('#'+blockId+' #studentFirstName').val(first_name);
  $('#'+blockId+' #studentMI').val(mi);
  $('#'+blockId+' #studentLastName').val(last_name);
  $('#'+blockId+' #studentBirthdayDatepicker input').val(date_birth);
  $('#'+blockId+' #selectGrade option:contains("'+grade+'")').attr('selected', 'selected');
  // 'Cancel' button, Return origin page
  $('#'+blockId+' #btnCancelAddStudent').on('click', function(e) {
    e.preventDefault();
    $('#'+blockId).html(originForm);
  });
  // Update Student
  $('#'+blockId+' #btnSaveAddStudent').on('click', function(e) {
    e.preventDefault();
    updateStudent(studentId);
  });
}
// Revert Student
function revertStudent(studentIds) {
  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'revertStudent',
      studentIds: studentIds
    },
    success: function(result) {
      console.log(result)
      showStudent($('#textinputEmail').val());
      displayNotEnrolledStudent();
    }, 
    error: function() {
      console.log('Error:Add Selected Students button event');
    },
  });
}
// Get Not Enrolled Student. Display the data
function displayNotEnrolledStudent() {
  //Init Modal
  $('#deleteStudentModal #deleteStudentId').val('');
  $('#deleteStudentModal #deleteStudentName').text('');
  //Init Button
  $('#btnAddSelectedStudents').attr('disabled', 'disabled');
  $.ajax({
    type: "GET",
    url: "process_ajax_student.php",
    data: {
      proc: 'getNotEnrolledStudent',
      email: $('#textinputEmail').val()
    },
    dataType: "json",
    success: function(result) {
      if (result.length) {
        $('.studentAddBox').css('display', 'none');
        $('.notEnrolledstudentAddBox').css('display', 'block');

        let rows = "<tr>";
        rows += "<th>Enrolling</th>";
        rows += "<th>Student</th>";
        rows += "<th>Grade</th>";
        rows += "<th></th>";
        rows += "</tr>";
        let gradeAry = ['', 'Pre-Kindergarten', 'Kindergarten', '1st Grade', '2nd Grade', '3rd Grade', '4th Grade', '5th Grade', '6th Grade', '7th Grade', '8th Grade', '9th Grade', '10th Grade', '11th Grade', '12th Grade'];
        for (let i = 0; i < result.length; i++) {
          let row = "<tr id='"+ result[i].id +"'>";
          row += "<td><input id='enrolling' type='checkbox'></td>";
          row += "<td id='name'>"+ result[i].first_name + " " + result[i].mi + " " + result[i].last_name +"</td>";
          row += "<td><select id='grade' class='form-control'>";
          for (c in gradeAry) {
            row += "<option "+ (gradeAry[c]==result[i].grade ? "selected" : "") +">"+ gradeAry[c] +"</option>";
          }
          row += "</select></td>";
          row += "<td style='width:75px'><button id='btnDispalyDeleteStudentModal' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#deleteStudentModal'><span class='glyphicon glyphicon-remove'></span> <span>Delete</span></button></td>";
          row += "</tr>";
          rows += row;
        }
        
        $('.students-not-enrolled tbody').html(rows);
        // checkbox click
        $('.students-not-enrolled #enrolling').on('change', function(e) {
          e.preventDefault();

          let flag = false;
          let $checkboxList = $('.students-not-enrolled #enrolling');
          for (c in $checkboxList) {
            if ($checkboxList.eq(c).prop('checked') === true) {
              flag = true;
              break;              
            }
          }

          if (flag === true) {
            $('#btnAddSelectedStudents').removeAttr('disabled');
          } else {
            $('#btnAddSelectedStudents').attr('disabled', 'disabled');
          }
        });
        // In modal, 'Delete' button
        $('.students-not-enrolled #btnDispalyDeleteStudentModal').on('click', function(e) {
          e.preventDefault();
          let $tr = $(this).parent().parent();
          let studentId = $tr.attr('id');
          let studentName = $tr.find('#name').text();
          
          $('#deleteStudentModal #deleteStudentId').val(studentId);
          $('#deleteStudentModal #deleteStudentName').text(studentName.substring(0, studentName.indexOf(' ')));
        });
      } else {
        $('.studentAddBox').css('display', 'block');
        $('.notEnrolledstudentAddBox').css('display', 'none');
      }
    }, 
    error: function() {
      console.log('An error has occurred when remove student in Student Tab');
    },
  });
}
// Delete Student
function deleteStudent(studentId) {
  
  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'deleteStudent',
      studentId: studentId
    },
    success: function(result) {
      console.log(result)
      displayNotEnrolledStudent();
      $('#deleteStudentModal').modal('hide');
    }, 
    error: function() {
      console.log('Error: Delete button event in Modal Dialog');
    },
  });
}
</script>
<?php

include 'db_functions.php';

$studentEmail = ($_GET['email']); //email

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
          <label> {$row['first_name']} {$row['mi']} {$row['last_name']}</label>
          <button type='button' class='btn btn-warning' onclick='removeStudent(event, {$row['id']})'><span class='glyphicon glyphicon-remove'></span> Remove</button>
          <button id='btnEditStudent' studentid='{$row['id']}' type='button' class='btn btn-primary'><span class='glyphicon glyphicon-pencil'></span> Edit</button>
        </div>
        <div class='student-birth-grade'>
          <label>Date of Birth</label>: {$row['date_birth']} <label>Grade</label>: {$row['grade']}
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
      <table>
        <tbody><tr>
          <th>Enrolling</th>
          <th>Student</th>
          <th>Grade</th>
          <th></th>
        </tr>
        <tr>
          <td><input id='enrolling' type='checkbox'></td>
          <td id='name'></td>
          <td><select id='grade' class='form-control'></select></td>
          <td><button class='btn btn-xs btn-warning'><span class='glyphicon glyphicon-remove'></span> <span>Delete</span></button></td>
        </tr>
    </tbody></table>
    </div>
  </div>
</div>";

// Modal
$res .= "<div class='modal fade' id='removeStudentModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='myModalLabel'>Modal title</h4>
      </div>
      <div class='modal-body'>
        ...
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        <button type='button' class='btn btn-primary'>Save changes</button>
      </div>
    </div>
  </div>
</div>";

$res .= "</div>";

echo $res;

?>

<script type="text/javascript">
$(document).ready(function() {
  // Insert Grade Select Element in Add Student Tab
  insertGreadSelectElement('#studentAdd select#selectGrade');
  // Insert Grade Select Element in table Add Student Tab When exist removed student
  insertGreadSelectElement('.notEnrolledstudentAddBox select#grade ');

  // datepicker configuration
  var start = moment().subtract(5, 'years');
  var end = moment();
  var options={
    format: 'MM/DD/YYYY',
    singleDatePicker: true,
    showDropdowns: true,
    autoclose: true,
    startDate: start,
    "maxDate": start,
  };
  $('#studentBirthdayDatepicker').daterangepicker(
    options, 
    function(start, end, label) {
        $('#studentBirthdayDatepicker input').val(start.format('MM/DD/YYYY'))
    }
  );

  // Add Student
  $('#btnSaveAddStudent').on('click', function(e) {
    e.preventDefault();
    addStudent();
  });
  // When click Cancel button, Go to first tab
  $('#btnCancelAddStudent').on('click', function(e) {
    e.preventDefault();
    $('#studenteNavTab li:first-child a').trigger('click');
  });
  // Enrollment Type
  $('.btn-group .btn-opt').on('click', function(e) {
    e.preventDefault();
    $(this).parent().find('.btn-opt.active').removeClass('active');
    $(this).addClass('active');
  });

  $('#studenteNavTab li a[href=#studentAdd]').on('click', function(e) {
    e.preventDefault();
    // $('#studentAdd').html('');

  })
});

// Insert Grade Select Element
function insertGreadSelectElement(selector) {
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
  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'addStudent',
      email: $('#textinputEmail').val(),
      studentFirstName: $('#studentFirstName').val(),
      studentMI: $('#studentMI').val(),
      studentLastName: $('#studentLastName').val(),
      studentGrade: $('#selectGrade').val(),
      studentDateBirth: $('#studentBirthdayDatepicker input').val()
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
// Get Not Enrolled Student
function getNotEnrolledStudent(event, studentId) {
  event.preventDefault();
  
  $.ajax({
    type: "GET",
    url: "process_ajax_student.php",
    data: {
      proc: 'getNotEnrolledStudent',
      email: $('#textinputEmail').val()
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
// Delete Student
function deleteStudent(event, studentId) {
  event.preventDefault();
  
  $.ajax({
    type: "POST",
    url: "process_ajax_student.php",
    data: {
      proc: 'deleteStudent',
      studentId: studentId
    },
    success: function(result) {
      console.log(result)
      showStudent($('#textinputEmail').val()); // reload student tabs
    }, 
    error: function() {
      console.log('An error has occurred when save in Student Tab');
    },
  });
}
</script>
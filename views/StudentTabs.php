<?php

include '../app/model_functions.php';

$studentEmail = $_POST['email']; //email
$stmt = getStudent($studentEmail, true); // get student data

$res = "<ul id='studenteNavTab' class='nav nav-tabs'>";
$tabContent = "";

$i = 0;
if ($stmt->rowCount() > 0) {
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($rows as $row) {
    $res .= "<li class='". ($i ? "" : "active") ."'><a data-toggle='tab' href='#student{$row['Student_Id']}'>{$row['First_Name']} {$row['Middle_Name']} {$row['Last_Name']}</a></li>";

    $tabContent .= "<div id='student{$row['Student_Id']}' class='". ($i ? "tab-pane" : "tab-pane fade active in") ."'>";
    $tabContent .= "<div class='form-group'>
        <div class='student-name-bar'>
          <label><span id='First_Name'>{$row['First_Name']}</span> <span id='Middle_Name'>{$row['Middle_Name']}</span> <span id='Last_Name'>{$row['Last_Name']}</span></label>
          <button type='button' class='btn btn-warning' onclick='removeStudent(event, {$row['Student_Id']})'><span class='glyphicon glyphicon-remove'></span> Remove</button>
          <button type='button' class='btn btn-primary' onclick='editStudent(event, {$row['Student_Id']})'><span class='glyphicon glyphicon-pencil'></span> Edit</button>
        </div>
        <div class='student-birth-grade'>
          <label>Date of Birth:</label> <span id='Birth_Date'>{$row['Birth_Date']}</span>
          <label>Grade:</label> <span id='Grade'>{$row['Grade']}</span> <input id='Grade_Id' type='hidden' value='{$row["Grade_Id"]}'> <br>
          <label>Diploma Type:</label> <span id='DiplomaType'>{$row['DiplomaType']}</span> <input id='DiplomaType_Id' type='hidden' value='{$row["DiplomaType_Id"]}'>
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
    <div class='row'>
      <div class='form-group col-sm-4'>
        <label>First Name</label><br>
        <input id='studentFirstName' type='text' class='form-control'>
      </div>
      <div class='form-group col-sm-4'>
        <label>Middle Name</label><br>
        <input id='studentMiddleName' type='text' placeholder='' class='form-control'>
      </div>
      <div class='form-group col-sm-4'>
        <label>Last Name</label><br>
        <input id='studentLastName' type='text' class='form-control'>
      </div>
    </div>
    <div class='row'>
      <div class='form-group col-sm-4'>
        <label>Date of Birth</label><br>
        <div class='form-group'>
          <div class='input-group date' id='studentBirthdayDatepicker'>
            <input type='text' class='form-control' />
            <span class='input-group-addon'>
              <span class='glyphicon glyphicon-calendar'></span>
            </span>
          </div>
        </div>
      </div>
      <div class='form-group col-sm-4'>
        <label>Grade</label><br>
        <select id='selectGrade' class='form-control'></select>
      </div>
    </div>
    <div class='row'>
      <div class='form-group col-sm-6'>
        <label>Diploma Type</label><br>
        <select id='diplomaType' class='form-control'></select>
      </div>
    </div>
    <div class='row'>
      <div class='form-group col-md-12'>
        <button id='btnSaveAddStudent' type='button' class='btn btn-primary'>Save</button>
        <button id='btnCancelAddStudent' type='button' class='btn btn-default'>Cancel</button>
      </div>
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
'use strict';
$(document).ready(function() {
  // Insert Diploma Type in Add Student Tab
  insertDiplomaTypeSelectElement('#studentAdd select#diplomaType');
  // Insert Grade Select Element in Add Student Tab
  insertGradeSelectElement('#studentAdd select#selectGrade');
  // Insert Grade Select Element in table Add Student Tab When exist removed student
  insertGradeSelectElement('.notEnrolledstudentAddBox select#Grade ');

  // datepicker configuration
  let start = moment().subtract(4, 'years');
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
    // Display First Student Tab
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
</script>
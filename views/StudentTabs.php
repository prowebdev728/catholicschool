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
          <label>Date of Birth:</label> <span id='Birth_Date'>{$row['Birth_Date']}</span> <label>Grade:</label> <span id='Grade'>{$row['Grade']}</span> <input id='Grade_Id' type='hidden' value='{$row["Grade_Id"]}'>
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
    <div class='form-group col-md-3'>
      First Name<br>
      <input id='studentFirstName' type='text' class='form-control'>
    </div>
    <div class='form-group col-md-3' style='min-width:75px'>
      Middle Name<br>
      <input id='studentMiddleName' type='text' placeholder='' class='form-control'>
    </div>
    <div class='form-group col-md-3'>
      Last Name<br>
      <input id='studentLastName' type='text' class='form-control'>
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
var gradeAry = ['', 'First Grade', 'Second Grade', 'Third Grade', 'Fourth Grade', 'Fifth Grade', 'Sixth Grade', 'Seventh Grade', 'Eighth Grade', 'Ninth Grade', 'Tenth Grade', 'Eleventh Grade', 'Twelfth Grade'];
$(document).ready(function() {
  // Insert Grade Select Element in Add Student Tab
  insertGradeSelectElement('#studentAdd select#selectGrade');
  // Insert Grade Select Element in table Add Student Tab When exist removed student
  insertGradeSelectElement('.notEnrolledstudentAddBox select#Grade ');

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

// Insert Grade Select Element
function insertGradeSelectElement(selector) {
  let gradeStr = "";

  for (let i = 0; i <= 12; i++) {
    gradeStr += "<option value='" + i + "'>" + gradeAry[i] +"</option>";
  }

  $(selector).html(gradeStr);
}
// Add Student
function addStudent() {
  let email = $('#email').val();
  let studentFirstName = $.trim($('#studentAdd #studentFirstName').val());
  let studentMiddleName = $.trim($('#studentAdd #studentMiddleName').val());
  let studentLastName = $.trim($('#studentAdd #studentLastName').val());
  let studentGradeId = $.trim($('#studentAdd #selectGrade').val());
  let studentBirthDate = $.trim($('#studentAdd #studentBirthdayDatepicker input').val());

  if (studentFirstName == '') {
    alert('Please input First Name.');
    return;
  }

  $.ajax({
    type: "post",
    url: "../app/api_student.php",
    data: {
      proc: 'addStudent',
      email: email,
      Account_Id: Account_Id,
      studentFirstName: studentFirstName,
      studentMiddleName: studentMiddleName,
      studentLastName: studentLastName,
      studentGradeId: studentGradeId,
      studentBirthDate: studentBirthDate
    },
    dataType: "json",
    success: function(response) {
      console.log(response);
      if (response.statusCode == '200' && response.message == 'Success') {
        $('#studentAdd input, #studentAdd select').val('');
        showStudent($('#email').val()); // reload student tabs
      }
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
  let studentMiddleName = $.trim($('#'+blockId+' #studentMiddleName').val());
  let studentLastName = $.trim($('#'+blockId+' #studentLastName').val());
  let studentGrade = $.trim($('#'+blockId+' #selectGrade').val());
  let studentDateBirth = $.trim($('#'+blockId+' #studentBirthdayDatepicker input').val());

  if (studentFirstName == '') {
    alert('Please input First Name.');
    return;
  }

  $.ajax({
    type: "post",
    url: "../app/api_student.php",
    data: {
      proc: 'updateStudent',
      studentId: studentId,
      studentFirstName: studentFirstName,
      studentMiddleName: studentMiddleName,
      studentLastName: studentLastName,
      studentGrade: studentGrade,
      studentDateBirth: studentDateBirth
    },
    dataType: "json",
    success: function(response) {
      console.log(response)
      if (response.statusCode == '200' && response.message == 'Success') {
        showStudent($('#email').val()); // reload student tabs
      }
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
    type: "post",
    url: "../app/api_student.php",
    data: {
      proc: 'removeStudent',
      studentId: studentId
    },
    dataType: "json",
    success: function(response) {
      console.log(response)
      if (response.statusCode == '200' && response.message == 'Success') {
        showStudent($('#email').val()); // reload student tabs  
      }
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
  let First_Name = $('#'+blockId+' #First_Name').text();
  let Middle_Name = $('#'+blockId+' #Middle_Name').text();
  let Last_Name = $('#'+blockId+' #Last_Name').text();
  let Birth_Date = $('#'+blockId+' #Birth_Date').text();
  let Grade_Id = $('#'+blockId+' #Grade_Id').val();
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
  $('#'+blockId+' #studentFirstName').val(First_Name);
  $('#'+blockId+' #studentMiddleName').val(Middle_Name);
  $('#'+blockId+' #studentLastName').val(Last_Name);
  $('#'+blockId+' #studentBirthdayDatepicker input').val(Birth_Date);
  $('#'+blockId+' #selectGrade option[value='+Grade_Id+']').attr('selected', 'selected');
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
    type: "post",
    url: "../app/api_student.php",
    data: {
      proc: 'revertStudent',
      studentIds: studentIds
    },
    dataType: "json",
    success: function(response) {
      if (response.statusCode == '200' && response.message == 'Success') {
        console.log('response', response)
        showStudent($('#email').val());
        displayNotEnrolledStudent();
      }
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
    type: "post",
    url: "../app/api_student.php",
    data: {
      proc: 'getNotEnrolledStudent',
      email: $('#email').val()
    },
    dataType: "json",
    success: function(response) {
      if (response.statusCode == '200' && response.message == 'Success') {
        let datas = response.datas;
        
        $('.studentAddBox').css('display', 'none');
        $('.notEnrolledstudentAddBox').css('display', 'block');

        let rows = "<tr>";
        rows += "<th>Enrolling</th>";
        rows += "<th>Student</th>";
        rows += "<th></th>";
        rows += "</tr>";

        for (i in datas) {
          let row = "<tr id='"+ datas[i].Student_Id +"'>";
          row += "<td><input id='enrolling' type='checkbox'></td>";
          row += "<td id='name' style='padding-left:15px; padding-right:15px;'>"+ datas[i].First_Name + " " + datas[i].Middle_Name + " " + datas[i].Last_Name +"</td>";
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
    type: "post",
    url: "../app/api_student.php",
    data: {
      proc: 'deleteStudent',
      studentId: studentId
    },
    dataType: "json",
    success: function(response) {
      console.log(result)
      if (response.statusCode == '200' && response.message == 'Success') {
        displayNotEnrolledStudent();
        $('#deleteStudentModal').modal('hide');
      }
    }, 
    error: function() {
      console.log('Error: Delete button event in Modal Dialog');
    },
  });
}
</script>
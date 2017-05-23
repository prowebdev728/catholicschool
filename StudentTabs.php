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
    $tabContent .= "
      <div class='form-group'>
        <div class='col-md-8'>
          <h3 class='titlelabel'> {$row['first_name']} {$row['mi']} {$row['last_name']}</h3>
        </div>
        <div class='col-md-4'>
          <button id='btnEditStudent' studentid='{$row['id']}' type='button' class='btn btn-primary'><span class='glyphicon glyphicon-pencil'></span> Edit</button>
          <button type='button' class='btn btn-warning' onclick='removeStudent(event, {$row['id']})'><span class='glyphicon glyphicon-remove'></span> Remove</button>
        </div>
      </div>
    ";
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
$res .= "
  <div id='studentAdd' class='tab-pane'>
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
      <select id='selectGrade' class='form-control'>
        <option value=''></option>
        <option>Pre-Kindergarten</option>
        <option>Kindergarten</option>
        <option>1st Grade</option>
        <option>2nd Grade</option>
        <option>3rd Grade</option>
        <option>4th Grade</option>
        <option>5th Grade</option>
        <option>6th Grade</option>
        <option>7th Grade</option>
        <option>8th Grade</option>
        <option>9th Grade</option>
        <option>10th Grade</option>
        <option>11th Grade</option>
        <option>12th Grade</option>
      </select>
    </div>
    <div class='form-group col-md-12'>
      <button id='btnSaveAddStudent' type='button' class='btn btn-primary'>Save</button>
      <button id='btnCancelAddStudent' type='button' class='btn btn-default'>Cancel</button>
    </div>
  </div>
";
$res .= "</div>";

echo $res;

?>

<script>
  $(document).ready(function() {

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
  })

  // Add Student
  function addStudent() {
    $.ajax({
      type: "POST",
      url: "process_ajax_addStudent.php",
      data: {
        email: $('#textinputEmail').val(),
        studentFirstName: $('#studentFirstName').val(),
        studentMI: $('#studentMI').val(),
        studentLastName: $('#studentLastName').val(),
        studentGrade: $('#selectGrade').val(),
        studentDateBirth: $('#studentBirthdayDatepicker input').val()
      },
      success: function(result) {
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
      type: "DELETE",
      url: "process_ajax_addStudent.php",
      data: {
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
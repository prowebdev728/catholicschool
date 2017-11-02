<div class="student_page">
  <h3 style="margin-top: 0;color:#55518a">Student Information</h3>

  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="message"></span>
  </div>
  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="message"></span>
  </div>

  <p>This section shows the students who are being enrolled with this application and the details of their enrollment. Use the 'Add Student' tab to enroll a new or previously enrolled student.</p>
  <p>Once you have indicated who will be enrolling, you will be able to select each student's courses in the next section. You may return to this section at any time to add or remove students.</p>    
  <p id="StudentTabsPlaceHolder">
    <b>StudentTabsPlaceHolder</b>      
  </p>
</div>

<script type="text/javascript">
  'use strict';

  const gradeAry = ['', 'First Grade', 'Second Grade', 'Third Grade', 'Fourth Grade', 'Fifth Grade', 'Sixth Grade', 'Seventh Grade', 'Eighth Grade', 'Ninth Grade', 'Tenth Grade', 'Eleventh Grade', 'Twelfth Grade'];

  $(document).ready(function() {
    showStudent($('#email').val());
  });

  function showStudent(email) {
    if (email == "") {
      $("#StudentTabsPlaceHolder").html("");
      return;
    }
    
    $.ajax({
      type: "post",
      url: "StudentTabs.php",
      data: {
        email: email
      },
      success: function(result) {
        let nth = $('#studenteNavTab li.active').index()+1;
        $("#StudentTabsPlaceHolder").html(result);
        $('#studenteNavTab li:nth-child('+nth+') a').trigger('click');
      }, 
      error: function() {
        $('#StudentTabsPlaceHolder').html('<p>An error has occurred</p>');
      },
    });
  }

  // Insert Diploma Type Select Element
  function insertDiplomaTypeSelectElement(selector) {
    let diplomaTypeStr = "";

    $.ajax({
      type: "post",
      url: "../app/api_student.php",
      data: {
        proc: 'diplomaType'
      },
      dataType: "json",
      success: function(response) {
        if (response.statusCode == '200' && response.message == 'Success') {
          let datas = response.datas;
          for (let i in datas) {
            diplomaTypeStr += "<option value='" + datas[i].DiplomaType_Id + "'>" + datas[i].Name +"</option>";
          }
          $(selector).html(diplomaTypeStr);
        } else {
          $('.student_page .alert-warning .message').html(alertMessage);
          $('.student_page .alert-warning').slideDown();
        }
      }, 
      error: function() {
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
      },
    });
  }

  // Insert Grade Select Element
  function insertGradeSelectElement(selector) {
    let gradeStr = "";
    for (let i = 1; i <= 12; i++) {
      gradeStr += "<option value='" + i + "'>" + gradeAry[i] +"</option>";
    }
    $(selector).html(gradeStr);
  }

  // Add Student
  function isValidAddStudent() {
    let studentFirstName = $.trim($('#studentAdd #studentFirstName').val());
    let studentMiddleName = $.trim($('#studentAdd #studentMiddleName').val());
    let studentLastName = $.trim($('#studentAdd #studentLastName').val());
    let studentBirthDate = $.trim($('#studentAdd #studentBirthdayDatepicker input').val());
    let studentGradeId = $.trim($('#studentAdd #selectGrade').val());
    let studentDiplomaTypeId = $.trim($('#studentAdd #diplomaType').val());

    if (studentFirstName == '') {
      $('#studentAdd #studentFirstName').focus();
      $('.student_page .alert-warning .message').html('<strong>First Name</strong> is required.');
    } else if (studentLastName == '') {
      $('#studentAdd #studentLastName').focus();
      $('.student_page .alert-warning .message').html('<strong>Last Name</strong> is required.');
    } else if (studentBirthDate == '') {
      $('#studentAdd #studentBirthdayDatepicker input').focus();
      $('.student_page .alert-warning .message').html('<strong>Date of Birth</strong> is required.');
    } else if (studentGradeId == 0) {
      $('#studentAdd #selectGrade').focus();
      $('.student_page .alert-warning .message').html('Please select a <strong>Grade</strong>.');
    } else if (studentDiplomaTypeId == '') {
      $('#studentAdd #diplomaType').focus();
      $('.student_page .alert-warning .message').html('Please select a <strong>Diploma</strong>.');
    } else {
      $('.student_page .alert-warning').slideUp();
      return true;
    }

    $('.student_page .alert-warning').slideDown();
    setTimeout(function() {
      $('.student_page .alert-warning').slideUp();
    }, 3000);
    return false;
  }
  function addStudent() {
    if (!isValidAddStudent()) return;

    let email = $('#email').val();
    let studentFirstName = $.trim($('#studentAdd #studentFirstName').val());
    let studentMiddleName = $.trim($('#studentAdd #studentMiddleName').val());
    let studentLastName = $.trim($('#studentAdd #studentLastName').val());
    let studentBirthDate = $.trim($('#studentAdd #studentBirthdayDatepicker input').val());
    let studentGradeId = $.trim($('#studentAdd #selectGrade').val());
    let studentDiplomaTypeId = $.trim($('#studentAdd #diplomaType').val());

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
        studentBirthDate: studentBirthDate,
        studentDiplomaTypeId: studentDiplomaTypeId
      },
      dataType: "json",
      success: function(response) {
        if (response.statusCode == '200' && response.message == 'Success') {
          $('.student_page .alert-info .message').html('<strong>Add Student Success!</strong>');
          $('.student_page .alert-info').slideDown();
          setTimeout(function() {
            $('.student_page .alert-info').slideUp();
          }, 3000);

          $('#studentAdd input, #studentAdd select').val('');
          showStudent($('#email').val()); // reload student tabs
        } else {
          $('.student_page .alert-warning .message').html(alertMessage);
          $('.student_page .alert-warning').slideDown();
        }
      }, 
      error: function() {
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
      },
    });
  }

  // Update Student
  function isValidUpdateStudent(studentId) {
    let blockId = 'student' + studentId;
    let studentFirstName = $.trim($('#'+blockId+' #studentFirstName').val());
    let studentMiddleName = $.trim($('#'+blockId+' #studentMiddleName').val());
    let studentLastName = $.trim($('#'+blockId+' #studentLastName').val());
    let studentGradeId = $.trim($('#'+blockId+' #selectGrade').val());
    let studentBirthDate = $.trim($('#'+blockId+' #studentBirthdayDatepicker input').val());
    let studentDiplomaTypeId = $.trim($('#'+blockId+' #diplomaType').val());

    if (studentFirstName == '') {
      $('#'+blockId+' #studentFirstName').focus();
      $('.student_page .alert-warning .message').html('<strong>First Name</strong> is required.');
    } else if (studentLastName == '') {
      $('#'+blockId+' #studentLastName').focus();
      $('.student_page .alert-warning .message').html('<strong>Last Name</strong> is required.');
    } else if (studentBirthDate == '') {
      $('#'+blockId+' #studentBirthdayDatepicker input').focus();
      $('.student_page .alert-warning .message').html('<strong>Date of Birth</strong> is required.');
    } else if (studentGradeId == 0) {
      $('#'+blockId+' #selectGrade').focus();
      $('.student_page .alert-warning .message').html('Please select a <strong>Grade</strong>.');
    } else if (studentDiplomaTypeId == '') {
      $('#'+blockId+' #diplomaType').focus();
      $('.student_page .alert-warning .message').html('Please select a <strong>Diploma</strong>.');
    } else {
      $('.student_page .alert-warning').slideUp();
      return true;
    }

    $('.student_page .alert-warning').slideDown();
    setTimeout(function() {
      $('.student_page .alert-warning').slideUp();
    }, 3000);
    return false;
  }

  function updateStudent(studentId) {
    if (!isValidUpdateStudent(studentId)) return;

    let blockId = 'student' + studentId;
    let studentFirstName = $.trim($('#'+blockId+' #studentFirstName').val());
    let studentMiddleName = $.trim($('#'+blockId+' #studentMiddleName').val());
    let studentLastName = $.trim($('#'+blockId+' #studentLastName').val());
    let studentGradeId = $.trim($('#'+blockId+' #selectGrade').val());
    let studentBirthDate = $.trim($('#'+blockId+' #studentBirthdayDatepicker input').val());
    let studentDiplomaTypeId = $.trim($('#'+blockId+' #diplomaType').val());

    $.ajax({
      type: "post",
      url: "../app/api_student.php",
      data: {
        proc: 'updateStudent',
        studentId: studentId,
        studentFirstName: studentFirstName,
        studentMiddleName: studentMiddleName,
        studentLastName: studentLastName,
        studentGradeId: studentGradeId,
        studentBirthDate: studentBirthDate,
        studentDiplomaTypeId: studentDiplomaTypeId
      },
      dataType: "json",
      success: function(response) {
        if (response.statusCode == '200' && response.message == 'Success') {
          $('.student_page .alert-info .message').html('<strong>Update Student Success!</strong>');
          $('.student_page .alert-info').slideDown();
          setTimeout(function() {
            $('.student_page .alert-info').slideUp();
          }, 3000);

          showStudent($('#email').val()); // reload student tabs
        } else {
          $('.student_page .alert-warning .message').html(alertMessage);
          $('.student_page .alert-warning').slideDown();
        }
      }, 
      error: function() {
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
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
        if (response.statusCode == '200' && response.message == 'Success') {
          showStudent($('#email').val()); // reload student tabs  
        } else {
          $('.student_page .alert-warning .message').html(alertMessage);
          $('.student_page .alert-warning').slideDown();
        }
      }, 
      error: function() {
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
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
    let DiplomaType_Id = $('#'+blockId+' #DiplomaType_Id').val();
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
    $('#'+blockId+' #diplomaType option[value='+DiplomaType_Id+']').attr('selected', 'selected');
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
          showStudent($('#email').val());
          displayNotEnrolledStudent();
        } else {
          $('.student_page .alert-warning .message').html(alertMessage);
          $('.student_page .alert-warning').slideDown();
        }
      }, 
      error: function() {
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
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

          for (let i in datas) {
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
            for (let c in $checkboxList) {
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
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
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
        if (response.statusCode == '200' && response.message == 'Success') {
          $('.student_page .alert-info .message').html('<strong>Delete Student Success!</strong>');
          $('.student_page .alert-info').slideDown();
          setTimeout(function() {
            $('.student_page .alert-info').slideUp();
          }, 3000);

          $('#deleteStudentModal').modal('hide');
          displayNotEnrolledStudent();
        } else {
          $('.student_page .alert-warning .message').html(alertMessage);
          $('.student_page .alert-warning').slideDown();
        }
      }, 
      error: function() {
        $('.student_page .alert-warning .message').html(alertMessage);
        $('.student_page .alert-warning').slideDown();
      },
    });
  }
</script>
<div class="student_page">
  <h3 style="margin-top: 0;color:#55518a">Student Information</h3>
  <p>
    This section shows the students who are being enrolled with this application and the details of their enrollment. Use the 'Add Student' tab to enroll a new or previously enrolled student.
  </p>
  <p>
    Once you have indicated who will be enrolling, you will be able to select each student's courses in the next section. You may return to this section at any time to add or remove students.
  </p>    
  <p id="StudentTabsPlaceHolder">
    <b>StudentTabsPlaceHolder</b>      
  </p>
</div>

<script type="text/javascript">
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
</script>
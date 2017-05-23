
<?php

include 'db_functions.php';

//email
$studentEmail = ($_GET['email']);

$result = getStudent($studentEmail);

$res = "<ul id='studenteNavTab' class='nav nav-tabs'>";
$tabContent = "";

$i = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $res .= "<li class='". ($i ? "" : "active") ."'><a data-toggle='tab' href='#student". $row['id'] ."'>". $row['first_name'] ." ". $row['mi'] ." ". $row['last_name'] ."</a></li>";

    $tabContent .= "<div id='student". $row['id'] ."' class='". ($i ? "tab-pane" : "tab-pane fade active in") ."'>". $row['first_name'] ." ". $row['mi'] ." ". $row['last_name'] ."</div>";

    $i++;
  }
}

$res .= "<li class=''><a data-toggle='tab' href='#studentAdd'>Add Student</a></li>"; //Add Student Tab
$res .= "</ul>";
$res .= "<br>";

$res .= "<div class='tab-content'>";
$res .= $tabContent;
$res .= "
<div id='studentAdd' class='tab-pane'>
  <div class='form-group col-md-4'>
    First Name<br>
    <input value='' id='' name='' type='text' placeholder='required' class='form-control'>
  </div>
  <div class='form-group col-md-1'>
    M.I.<br>
    <input value='' id='' name='' type='text' placeholder='' class='form-control'>
  </div>
  <div class='form-group col-md-4'>
    Last Name<br>
    <input value='' id='' name='' type='text' placeholder='required' class='form-control'>
  </div>
  <div class='form-group col-md-4'>
    Date of Birth<br>
    <div class='form-group'>
        <div class='input-group date' id='datepicker'>
            <input type='text' class='form-control' />
            <span class='input-group-addon'>
                <span class='glyphicon glyphicon-calendar'></span>
            </span>
        </div>
    </div>
  </div>
</div>
";
$res .= "</div>";

echo $res;

?>
<script>
  $(document).ready(function(){
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
    $('#datepicker').daterangepicker(
      options, 
      function(start, end, label) {
          $('#datepicker input').val(start.format('MM/DD/YYYY'))
      }
    );
  })
</script>
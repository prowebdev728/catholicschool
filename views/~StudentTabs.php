<?php

include 'db_functions.php';

function printStudentContent($rowNumber, $studentId, $studentFirstName, $studentMI, $studentLastName, $studentEucharist, $studentPenance, $studentConfirmation, $studentGrade, $studentDateBirth) {


  $active = "";
  if ($rowNumber==1) 
  {
    $active = "fade active in";
  } 

  if ($studentEucharist == 1) {
    $studentEucharist = "checked";
  } else {
    $studentEucharist = "";
  }

  if ($studentPenance == 1) {
    $studentPenance = "checked";
  } else {
    $studentPenance = "";
  }

  if ($studentConfirmation == 1) {
    $studentConfirmation = "checked";
  } else {
    $studentConfirmation = "";
  }

  
  $result = "<div id='student" . $studentId . "' class='tab-pane " . $active . "'>

        <table border=0 class='Table table-striped'>

          <tr> 
            <td>
              Sacraments Received:
            </td>    

            <td>
              <input type=checkbox name=ckbEucharist id=ckbEucharist $studentEucharist>
              Eucharist
            </td>    

            <td>
              <input type=checkbox name=ckbPenance id=ckbPenance $studentPenance>
              Penance
            </td>                
            <td>
              <input type=checkbox name=ckbConfirmation id=ckbConfirmation $studentConfirmation>
              Confirmation
            </td>    
          </tr>
          <tr> 
            <td colspan=100%>Grade: $studentGrade</td>    
          </tr>
          <tr> 
            <td colspan=100%>Date of Birth: $studentDateBirth</td>    
          </tr>
        </table>    
    </div>";

  return $result;
}

//variables for each student field

$studentEmail = ($_GET['email']);
$studentId = "";
$studentFirstName = "";
$studentMI = "";
$studentLastName = "";
$studentEucharist = "";
$studentPenance = "";
$studentConfirmation = "";
$studentGrade = "";
$studentDateBirth = "";

$result = getStudent($studentEmail);

$rowNumber = 0;

echo "<ul id=studenteNavTab class='nav nav-tabs'>";

if ($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc())
    {
      $studentId = $row["id"];
      $studentFirstName = $row["first_name"];
      $studentMI = $row["mi"];
      $studentLastName = $row["last_name"];
      $studentEucharist = $row["eucharist"];
      $studentPenance = $row["penance"];
      $studentConfirmation = $row["confirmation"];
      $studentGrade = $row["grade"];
      $studentDateBirth = $row["date_birth"];

      $active = "";
      $rowNumber = $rowNumber + 1;
      if ($rowNumber==1) 
      {
        $active = "active";
      } 

      echo "<li class=" . $active . "><a data-toggle='tab' href='#student" . $studentId . "'>" . $studentFirstName . " " . $studentMI . " " . $studentLastName . "</a></li>";
    }
}

echo "</ul>";
echo "<br>";
echo "<div class='tab-content'>";  

$resultContent = getStudent($studentEmail);
$rowNumber = 0;

if ($resultContent->num_rows > 0) 
{
    while ($row = $resultContent->fetch_assoc())
    {
      $studentId = $row["id"];
      $studentFirstName = $row["first_name"];
      $studentMI = $row["mi"];
      $studentLastName = $row["last_name"];
      $studentEucharist = $row["eucharist"];
      $studentPenance = $row["penance"];
      $studentConfirmation = $row["confirmation"];
      $studentGrade = $row["grade"];
      $studentDateBirth = $row["date_birth"];

      $rowNumber = $rowNumber + 1;
      echo printStudentContent($rowNumber, $studentId, $studentFirstName, $studentMI, $studentLastName, $studentEucharist, $studentPenance, $studentConfirmation, $studentGrade, $studentDateBirth);
      
    }
}

echo "</div><br>";  

echo "<div align=center>";
echo "<table width=70%><tr>";
echo "<td><button type=button class='btn btn-primary' disabled>&nbsp;&nbsp;New&nbsp;&nbsp;</button></td>";
echo "<td><button type=button class='btn btn-primary' disabled>Update</button></td>";
echo "<td><button type=button class='btn btn-primary' disabled>Delete</button></td>";
echo "</tr></table>";
echo "</div>";  

?>

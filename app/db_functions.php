<?php

// Get an user record from user table by email

function getUser($email) {

  require("db_connection.php");

  $sql = "SELECT * FROM `user` WHERE `email` = '$email' ";
  $result = $conn->query($sql);
  $conn->close();
  return $result;
}

// Update the user table

function updateUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased) {

  require("db_connection.php");

  $sql=("UPDATE user
          SET 
            father_name = $fatherName, 
            father_family_name = $fatherFamilyName, 
            mother_name = $motherName,
            mother_family_name = $motherFamilyName,
            father_resides_at_home = $fatherResidesAtHome,
            father_deceased = $fatherDeceased,
            mother_resides_at_home = $motherResidesAtHome,
            mother_deceased = $motherDeceased
          WHERE email = $email");

  //Checking the results
  if ($conn->query($sql) === TRUE) {
      return true;
  } else {
      echo "Error updating record: " . $conn->error;
      return false;
  }

}

// Insert the user table

function insertUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased) {

  require("db_connection.php");

  $sql= "INSERT INTO user ( 
            email, 
            father_name, 
            father_family_name, 
            mother_name, 
            mother_family_name, 
            father_resides_at_home, 
            father_deceased, 
            mother_resides_at_home, 
            mother_deceased
            ) 
          VALUES (
            '$email', 
            '$fatherName', 
            '$fatherFamilyName', 
            '$motherName', 
            '$motherFamilyName', 
            $fatherResidesAtHome, 
            $fatherDeceased, 
            $motherResidesAtHome, 
            $motherDeceased
            )";

  //Checking the results
  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    echo "Error inserting record: " . $conn->error;
    return false;
  }
}

// Get one or more student record from student table by email

function getStudent($email) {

  require("db_connection.php");

  $sql = "SELECT * FROM student WHERE email = '{$email}' AND enroll_status = 1";

  $result = $conn->query($sql);
  $conn->close();
  return $result;
}

function getNotEnrolledStudent($email) {

  require("db_connection.php");

  $sql = "SELECT * FROM student WHERE email = '{$email}' AND enroll_status = 0";

  $result = $conn->query($sql);
  $conn->close();
  return $result;
}


// Insert student
function insertStudent($data) {

  require("db_connection.php");

  $sql= "INSERT INTO student ( 
            email,
            first_name,
            mi,
            last_name,
            grade,
            date_birth
          ) 
          VALUES (
            '{$data['email']}', 
            '{$data['first_name']}',
            '{$data['mi']}',
            '{$data['last_name']}',
            '{$data['grade']}',
            '{$data['date_birth']}'
          )";

  //Checking the results
  if ($conn->query($sql) === true) {
    $conn->close();
    return true;
  } else {
    echo "Error inserting record: " . $conn->error;
    return false;
  }
}

// Update student
function updateStudent($data) {

  require("db_connection.php");

  $sql = "UPDATE student SET
            first_name = '{$data['first_name']}',
            mi = '{$data['mi']}',
            last_name = '{$data['last_name']}',
            grade = '{$data['grade']}',
            date_birth = '{$data['date_birth']}'
          WHERE id='{$data['id']}'";

  //Checking the results
  if ($conn->query($sql) === true) {
    $conn->close();
    return true;
  } else {
    echo "Error updating record: " . $conn->error;
    return false;
  }
}

// Remove Student, Set enroll_status = 0
function removeStudent($id) {
  require("db_connection.php");

  $sql = "UPDATE student SET enroll_status=0 WHERE id='{$id}'";

  if ($conn->query($sql) === true) {
    $conn->close();
    return true;
  } else {
    echo "Update enroll_status field Error: " . $conn->error;
    return false;
  }
}

// Revert Student, Set enroll_status = 1
function revertStudent($ids) {
  require("db_connection.php");

  $sql = "UPDATE student SET enroll_status=1 WHERE id IN ($ids)";

  if ($conn->query($sql) === true) {
    $conn->close();
    return true;
  } else {
    echo "Update enroll_status field Error: " . $conn->error;
    return false;
  }
}

// Delete Student
function deleteStudent($id) {
  require("db_connection.php");

  $sql = "DELETE FROM student WHERE id='{$id}' AND enroll_status=0";

  if ($conn->query($sql) === true) {
    $conn->close();
    return true;
  } else {
    echo "Delete Error: " . $conn->error;
    return false;
  }
}

?>
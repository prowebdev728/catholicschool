<?php

// get login status
function loginCheck($email, $password) {
	require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM account AS a
    LEFT JOIN wordpress2.wp_users AS w ON a.wp_users_ID=w.ID
    WHERE w.user_email=? AND w.user_pass=? AND a.active=1");
  $stmt->execute(array($email, $password));

  $db = null;
  return $stmt;
}

// insert account
function signup($email, $password) {
	require("db_connection.php");

	$data = array();
	$data['double'] = false;
	$data['status'] = false;

  $stmt = $db->prepare("SELECT * FROM wordpress2.wp_users WHERE user_email=?");
  $stmt->execute(array($email));
  $row_count = $stmt->rowCount();
  $stmt->closeCursor();

  if ($stmt->rowCount()) {
  	$data['double'] = true;
  } else {
    $st1 = $db->prepare("INSERT INTO wordpress2.wp_users SET user_email=:email, user_pass=:password");
    try { 
      $st1->execute(array(':email' => $email, ':password' => $password));
      $insert_wp_users_ID = $db->lastInsertId();
      $st1->closeCursor();

      $st2 = $db->prepare("INSERT INTO contactperson SET Email1=?");
      try { 
        $st2->execute(array($email));
        $insert_ContactPerson_Id = $db->lastInsertId();
        $st2->closeCursor();

        $st3 = $db->prepare("INSERT INTO account SET wp_users_ID=:wp_users_ID, active='1', Parent_Or_Guardian_1_Id=:Parent_Or_Guardian_1_Id, Parent_Or_Guardian_2_Id=:Parent_Or_Guardian_2_Id");
        try { 
          $st3->execute(array(':wp_users_ID' => $insert_wp_users_ID, ':Parent_Or_Guardian_1_Id' => $insert_ContactPerson_Id, ':Parent_Or_Guardian_2_Id' => $insert_ContactPerson_Id));
          $data['status'] = true;
        } catch(PDOExecption $e) { 
          print "Error!: " . $e->getMessage() . "</br>"; 
        }
      } catch(PDOExecption $e) { 
        print "Error!: " . $e->getMessage() . "</br>"; 
      }
    } catch(PDOExecption $e) { 
      print "Error!: " . $e->getMessage() . "</br>"; 
    }
  }

  $db = null;
  return $data;
}

// get household data
function getContactPerson($email) {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM contactperson WHERE Email1=:email");
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $db = null;
  return $rows;
}

// set(insert, update) household data
function setHousehold($params) {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT * FROM contactperson WHERE Email1=? AND First_Name=? AND Last_Name=?");
  $stmt->execute(array($params['Email1'], $params['First_Name'], $params['Last_Name']));
  $row_count = $stmt->rowCount();

  if ($row_count) {
    $st = $db->prepare("UPDATE contactperson SET 
      Address_1=:Address_1, 
      Address_2=:Address_2,
      City=:City,
      State=:State,
      Zip=:Zip,
      Country=:Country,
      Phone1=:Phone1,
      Phone2=:Phone2,
      Email2=:Email2
      WHERE Email1=:Email1 AND First_Name=:First_Name AND Last_Name=:Last_Name
    ");
  } else {
    $st = $db->prepare("INSERT INTO contactperson SET 
      First_Name=:First_Name, 
      Last_Name=:Last_Name, 
      Address_1=:Address_1, 
      Address_2=:Address_2,
      City=:City,
      State=:State,
      Zip=:Zip,
      Country=:Country,
      Phone1=:Phone1,
      Phone2=:Phone2,
      Email1=:Email1,
      Email2=:Email2,
      Notes_Comments=''
    ");
  }
  
  try { 
    $st->execute(array(
      ':First_Name' => $params['First_Name'],
      ':Last_Name' => $params['Last_Name'],
      ':Address_1' => $params['Address_1'],
      ':Address_2' => $params['Address_2'],
      ':City' => $params['City'],
      ':State' => $params['State'],
      ':Zip' => $params['Zip'],
      ':Country' => $params['Country'],
      ':Phone1' => $params['Phone1'],
      ':Phone2' => $params['Phone2'],
      ':Email1' => $params['Email1'],
      ':Email2' => $params['Email2']
    ));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage() . "</br>"; 
  }

  $db = null;
  return;
}

// get student data (enrolled: Status='1', not enrolled: Status='0')
function getStudent($email, $enrollStatus) {
  require("db_connection.php");

  $stmt = $db->prepare("SELECT s.*, g.Description AS Grade FROM student AS s 
    LEFT JOIN account AS a ON s.Account_Id=a.Account_Id 
    LEFT JOIN wordpress2.wp_users AS w ON a.wp_users_ID=w.ID
    LEFT JOIN grade AS g ON s.Grade_Id=g.Grade_Id
    WHERE w.user_email=? AND s.Status=?
  ");
  if ($enrollStatus)
    $stmt->execute(array($email, 1));
  else
    $stmt->execute(array($email, 0));

  $db = null;
  return $stmt;
}

// insert student data
function insertStudent($data) {
  require("db_connection.php");

  $stmt = $db->prepare("INSERT INTO student SET
            Account_Id = :Account_Id,
            First_Name = :First_Name,
            Middle_Name = :Middle_Name,
            Last_Name = :Last_Name,
            Grade_Id = :Grade_Id,
            Birth_Date = :Birth_Date,
            Status = '1',
            Parent_or_Guardian_1_GuardianToStudentRelation_Id = '20',
            Parent_or_Guardian_2_GuardianToStudentRelation_Id = '10'
  ");

  try { 
    $stmt->execute(array(':Account_Id' => $data['Account_Id'], ':First_Name' => $data['First_Name'], ':Middle_Name' => $data['Middle_Name'], ':Last_Name' => $data['Last_Name'], ':Grade_Id' => $data['Grade_Id'], ':Birth_Date' => $data['Birth_Date']));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage() . "</br>"; 
  }

  $db = null;
  return $stmt;
}

// update student data
function updateStudent($data) {
  require("db_connection.php");

  $stmt = $db->prepare("UPDATE student SET
            First_Name = :First_Name,
            Middle_Name = :Middle_Name,
            Last_Name = :Last_Name,
            Grade_Id = :Grade_Id,
            Birth_Date = :Birth_Date
          WHERE Student_Id=:Student_Id
  ");

  try { 
    $stmt->execute(array(':Student_Id' => $data['Student_Id'], ':First_Name' => $data['First_Name'], ':Middle_Name' => $data['Middle_Name'], ':Last_Name' => $data['Last_Name'], ':Grade_Id' => $data['Grade_Id'], ':Birth_Date' => $data['Birth_Date']));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage() . "</br>"; 
  }

  $db = null;
  return $stmt;
}

// remove student data, set Status='0'
function removeStudent($Student_Id) {
  require("db_connection.php");

  $stmt = $db->prepare("UPDATE student SET Status='0' WHERE Student_Id=:Student_Id");

  try { 
    $stmt->execute(array(':Student_Id' => $Student_Id));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage() . "</br>"; 
  }

  $db = null;
  return true;
}

// revert student data, set Status='1'
function revertStudent($Student_Ids) {
  require("db_connection.php");
  
  $stmt = $db->prepare("UPDATE student SET Status='1' WHERE Student_Id=?");

  try {
    foreach (explode(',', $Student_Ids) as $Student_Id) {
      $stmt->execute(array($Student_Id));  
    }
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage() . "</br>"; 
  }

  $db = null;
  return true;
}

// delete student data
function deleteStudent($Student_Id) {
  require("db_connection.php");

  $stmt = $db->prepare("DELETE FROM student WHERE Student_Id=? AND Status='0'");

  try {
    $stmt->execute(array($Student_Id));
  } catch(PDOExecption $e) { 
    print "Error!: " . $e->getMessage() . "</br>"; 
  }

  $db = null;
  return true;
}
?>
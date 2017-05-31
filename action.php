<!-- Style -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="style.css">

<!-- Jquery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="include.js"></script>

<!-- Bootstrap CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<?php

include 'db_functions.php';

error_reporting( E_ALL | E_STRICT );

// get the email parameter and query the dabatase. If does not exist, a new application will be created.

$email = $_POST["validate-email"];

// Family Information

$fatherName = "";
$fatherFamilyName = "";
$fatherResidesAtHome = 0;
$fatherDeceased = 0;

$motherName = "";
$motherFamilyName = "";
$motherResidesAtHome = 0;
$motherDeceased = 0;

$row = 0;

$result = getUser($email);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $fatherName = $row["father_name"];
    $fatherFamilyName = $row["father_family_name"];
    $fatherResidesAtHome = $row["father_resides_at_home"];
    $fatherDeceased = $row["father_deceased"];

    $motherName = $row["mother_name"];
    $motherFamilyName = $row["mother_family_name"];
    $motherResidesAtHome = $row["mother_resides_at_home"];
    $motherDeceased = $row["mother_deceased"];
} else {
    
    insertUser($email, $fatherName, $fatherFamilyName, $motherName, $motherFamilyName, $fatherResidesAtHome, $fatherDeceased, $motherResidesAtHome, $motherDeceased);
}

if ($fatherResidesAtHome == 1) {
  $fatherResidesAtHome = "checked";
} else {
  $fatherResidesAtHome = "";
}

if ($fatherDeceased == 1) {
  $fatherDeceased = "checked";
} else {
  $fatherDeceased = "";
}

if ($motherResidesAtHome == 1) {
  $motherResidesAtHome = "checked";
} else {
  $motherResidesAtHome = "";
}

if ($motherDeceased == 1) {
  $motherDeceased = "checked";
} else {
  $motherDeceased = "";
}

?>

<!DOCTYPE html>
<html>
<head>
  <!-- <link rel="stylesheet" href="verticalTab.css"> -->
</head>
<body>
<div class="container-fluid">
  <!-- Header-->
  <!-- <div class="jumbotron"> -->
  <div>
    <div class="container">
      <h3 class="display-2">Home Study Catholic School</h3>
    </div>
  </div>

  <!-- Tabs: header-->
  <div class="col-sm-12">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
      <div class="list-group">
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-info-sign"></h4>&nbsp;&nbsp;&nbsp;Introduction
        </a>
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-home"></h4>&nbsp;&nbsp;&nbsp;Household Information
        </a>
        <a href="#" class="list-group-item active text-left">
          <h4 class="glyphicon glyphicon-user"></h4>&nbsp;&nbsp;&nbsp;Student Information
        </a>
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-book"></h4>&nbsp;&nbsp;&nbsp;Courses Credits
        </a>
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-scissors"></h4>&nbsp;&nbsp;&nbsp;Supplements
        </a>
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-duplicate"></h4>&nbsp;&nbsp;&nbsp;Summary
        </a>
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-credit-card"></h4>&nbsp;&nbsp;&nbsp;Submission & Payments
        </a>
      </div>
    </div>

    <!-- Tabs: Body-->
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 bhoechie-tab">

        <!-- Introduction section -->
        <div class="bhoechie-tab-content">
          <h2 style="margin-top: 0;color:#55518a">Introduction to the Application Process</h2>
          <p>
            The enrollment process generally follows the steps below. However if you are a returning family, much of the information will already be there and all you need to do is update it.
          </p>
          <p>
            While the below steps are usually performed in order, feel free to use the tabs on the left hand side of the page to move back and forth as you work.
          </p>
          <p>
            Hover over each step to see a link to more information.
          </p>
          <ol> <!-- ordered list -->
            <li>Provide your household information.</li>
            <li>Add students to the application.</li>
            <li>For each student select the courses he or she will be taking.</li>
            <li>Optionally take tuition credits for books you already have.</li>
            <li>Optionally add additional materials to your order.</li>
            <li>Review your appliction.</li>
            <li>Provide your payment information and submit the application.</li>
          </ol>
          <p>
            There is no need to complete this application in one sitting. Your work will be saved as you go. Feel free to log out at any time. Your information will be ready and waiting for you when you return.
          </p>
          <h4 style="margin-top: 0;color:#55518a">Need Help?</h4>
          <p>
            If you need help feel free to call one of our expert admissions advisors at (866) 280-1930.
          </p>
        </div>

        <!-- Household Information section -->
        <div class="bhoechie-tab-content">
            <h3 style="margin-top: 0;color:#55518a">Family Information</h3>
              <form>
                <fieldset>
                  <table border=0 class="Table">
                    <tr>
                      <td>
                        <div class="form-group">
                          Email<br>
                          <input readonly id="textinputEmail" name="textinputEmail" type="text" value="<?php echo $email;?>" class="form-control input-md">
                        </div>  
                      </td>
                    </tr>
                  </table>

                  <!-- Father Name -->
                  <h4 class="titlelabel">Father</h4>
                  <table border=0 class="Table">
                    <tr>
                      <td>
                        <div class="form-group">
                          First Name<br>
                          <input value="<?php echo $fatherName;?>" id="textinputFatherName" name="textinputFatherName" type="text" placeholder="" class="form-control input-md">
                        </div>  
                      </td>
                      <td></td>
                      <td>
                        <!-- Text input: Father Family Name-->
                        <div class="form-group">
                          Last Name<br>
                          <input value="<?php echo $fatherFamilyName;?>"  id="textinputFatherFamilyName" name="textinputFatherFamilyName" type="text" placeholder="" class="form-control input-md">
                        </div>
                      </td>
                      <td></td>
                      <td>
                        Residency Status:<br>
                        <div class="checkbox">
                          <label for="ckbFatherResidesAtHome">
                            <input type="checkbox" name="ckbFatherResidesAtHome" id="ckbFatherResidesAtHome" <?php echo $fatherResidesAtHome;?> >
                            Resides at home
                          </label>
                        </div>
                        <div class="checkbox">
                          <label for="ckbFatherDeceased-1">
                            <input type="checkbox" name="ckbFatherDeceased" id="ckbFatherDeceased" <?php echo $fatherDeceased;?>>
                            Deceased
                          </label>
                        </div>
                        <p class="help-block">Check any that apply</p>
                      </td>
                    </tr>
                  </table>
                  <!-- Mother Name -->
                  <h4 class="titlelabel">Mother</h4>
                  <table border=0 class="Table">
                    <tr>
                      <td>
                        <div class="form-group">
                          First Name<br>
                          <input id="textinputMotherName" value="<?php echo $motherName;?>" name="textinputMotherName" type="text" placeholder="" class="form-control input-md">  
                        </div>  
                      </td>
                      <td></td>
                      <td>
                        <!-- Text input-->
                        <div class="form-group">
                          Last Name<br>
                          <input value="<?php echo $motherFamilyName;?>"  id="textinputMotherFamilyName" name="textinputMotherFamilyName" type="text" placeholder="" class="form-control input-md">
                        </div>
                      </td>
                      <td></td>
                      <td>
                        Residency Status:<br>
                        <div class="checkbox">
                          <label for="ckbMotherResidesAtHome">
                            <input type="checkbox" name="ckbMotherResidesAtHome" id="ckbMotherResidesAtHome" <?php echo $motherResidesAtHome;?> >
                            Resides at home
                          </label>
                        </div>
                        <div class="checkbox">
                          <label for="ckbMotherDeceased">
                            <input type="checkbox" name="ckbMotherDeceased" id="ckbMotherDeceased" <?php echo $motherDeceased;?> >
                            Deceased
                          </label>
                        </div>
                        <p class="help-block">Check any that apply</p>
                      </td>
                    </tr>
                  </table>
                  <!-- Home Address -->
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <h4 class="titlelabel">Home Address</h4>
                      <div class="homeaddress">
                        <div class="form-group" style="margin-top: 25px;">
                          Street Address<br>
                          <input id="homeaddress-streetaddress1" value="" type="text" class="form-control input-md">  
                        </div>
                        <div class="form-group">
                          <input id="homeaddress-streetaddress2" value="" type="text" class="form-control input-md">  
                        </div>
                        <div class="form-group">
                          <div class="homeaddress-city">
                            City<br>
                            <input id="homeaddress-city" value="" type="text" class="form-control">
                          </div>
                          <div class="homeaddress-state">
                            State<br>
                            <input id="homeaddress-state" value="" type="text" class="form-control">
                          </div>
                          <div class="homeaddress-zipcode">
                            Zip Code<br>
                            <input id="homeaddress-zipcode" value="" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="homeaddress-country">
                            Country<br>
                            <input id="homeaddress-country" value="" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                      <h4 class="titlelabel">Shipping Address</h4>
                      <div class="shippingaddress">
                        <div class="form-group" style="margin-bottom: 0px">
                          <input type="checkbox" id="ckbShipHomeAddress" checked />
                          Ship to Home Address
                        </div>
                        <div class="form-group">
                          Street Address<br>
                          <input id="shippingaddress-streetaddress1" value="" type="text" class="form-control">  
                        </div>
                        <div class="form-group">
                          <input id="shippingaddress-streetaddress2" value="" type="text" class="form-control">  
                        </div>
                        <div class="form-group">
                          <div class="shippingaddress-city">
                            City<br>
                            <input id="shippingaddress-city" value="" type="text" class="form-control">
                          </div>
                          <div class="shippingaddress-state">
                            State<br>
                            <input id="shippingaddress-state" value="" type="text" class="form-control">
                          </div>
                          <div class="shippingaddress-zipcode">
                            Zip Code<br>
                            <input id="shippingaddress-zipcode" value="" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="shippingaddress-country">
                            Country<br>
                            <input id="shippingaddress-country" value="" type="text" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Contact Information -->
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <h4 class="titlelabel">Contact Information</h4>
                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                          Phone Number<br>
                          <input id="phonenumber" value="" type="text" class="form-control">
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                          Alternate Phone Number<br>
                          <input id="altphonenumber" value="" type="text" class="form-control">
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                          Email Address<br>
                          <input id="emailaddress" value="" type="text" class="form-control">
                      </div>
                    </div>
                  </div>
                </fieldset>
              </form>
        </div>

        <!-- Student section -->
        <div class="bhoechie-tab-content active">
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

        <div class="bhoechie-tab-content">
            <h3 style="margin-top: 0;color:#55518a">Courses Credits</h3>
            <p>
              This section shows each student who is being enrolled and allows you to select the courses they will enroll in and take credits for any required books that you may already have.
            <p>
        </div>

        <div class="bhoechie-tab-content">
            <h3 style="margin-top: 0;color:#55518a">Supplemental Materials</h3>
            <p>
              Enrollment is a great time to order additional materials from Seton Educational Media. For US addresses, additional materials ordered at the time of enrollment receive free shipping. (Extra materials shipments to Canada are charged a 20% shipping fee, and extra materials shipments to other foreign countries are charged a 45% shipping fee.)
            </p>
            <p>
              Below are suggested items that Seton recommends based on your enrollment. You may also add additional items directly from the Seton Educational Media catalog on the 'Items You Have Chosen' tab.
            </p>
            <p>
            Supplemental items are not required for enrollement.
            </p>
        </div>

        <div class="bhoechie-tab-content">
            <h3 style="margin-top: 0;color:#55518a">Application Summary</h3>
            <p>
              This section displays a summary of your enrollment application including a breakdown of charges and fees for each student as well as any family-based fees. Also shown are your payment plan options. Plan A has the lowest overall cost but requires all charges to be paid upfront at the time of enrollment. Plan B is our installment plan. It features a lower upfront cost followed by monthly installments. It is slightly more expensive overall.
            </p>
        </div>

        <div class="bhoechie-tab-content">
            <h2 style="margin-top: 0;color:#55518a">Cooming Soon</h2>
            <h3 style="margin-top: 0;color:#55518a">Submission & Payments</h3>
        </div>
    </div>
  </div>
</div>
</body>

<script>

//This script handle the tab's navigation
$(document).ready(function() {
  $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
    e.preventDefault();
    $(this).siblings('a.active').removeClass("active");
    $(this).addClass("active");
    var index = $(this).index();
    $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
    $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
  });
});

// Household Information

$(document).ready(function() {
  //Set the props of input boxes in Shipping Address
  if ( $("#ckbShipHomeAddress").prop('checked') ) {
    $(".shippingaddress input").prop("readonly", true);
  }
  
  //when check "Ship to Home Address"
  $("#ckbShipHomeAddress").on("change", function(e) {
    e.preventDefault();
    if ( $(this).prop('checked') ) {
      $(".shippingaddress input").prop("readonly", true);
    } else {
      $(".shippingaddress input").prop("readonly", false);
    }
  });

  //key event of input boxes in Home Address
  $(".homeaddress input").on("keyup", function(e) {
    e.preventDefault();
    if ( $("#ckbShipHomeAddress").prop('checked') ) {
      id = $(this).attr("id");
      targetId = "shippingaddress" + id.substr(id.indexOf("-"));
      $("#" + targetId).val($(this).val());
    }
  });
});

//Timer to auto update the database for Household Information
// setInterval("updateFamilyData();",10000);

//This function request an Ajax Call to update the database's user table
function updateFamilyData(){

  //get the parameters
  var email = document.getElementById('textinputEmail').value;

  var fatherName = document.getElementById('textinputFatherName').value;
  var fatherFamilyName = document.getElementById('textinputFatherFamilyName').value;
  var fatherResidesAtHome = document.getElementById('ckbFatherResidesAtHome').checked;
  var fatherDeceased = document.getElementById('ckbFatherDeceased').checked;
  var motherName = document.getElementById('textinputMotherName').value;
  var motherFamilyName = document.getElementById('textinputMotherFamilyName').value;
  var motherResidesAtHome = document.getElementById('ckbMotherResidesAtHome').checked;
  var motherDeceased = document.getElementById('ckbMotherDeceased').checked;

  // prepare the ajax call to update the database
  var xmlhttp = new XMLHttpRequest();
  var url = "process_ajax.php";
  
  var params = "";
  params = params.concat('email', "='", email, "'&", 'fatherName', "='", fatherName, "'&");
  params = params.concat('fatherFamilyName', "='", fatherFamilyName , "'&");
  params = params.concat('fatherResidesAtHome', "=", fatherResidesAtHome , "&");
  params = params.concat('fatherDeceased', "=", fatherDeceased , "&");
  params = params.concat('motherName', "='", motherName , "'&");
  params = params.concat('motherFamilyName', "='", motherFamilyName , "'&");
  params = params.concat('motherResidesAtHome', "=", motherResidesAtHome , "&");
  params = params.concat('motherDeceased', "=", motherDeceased);

  url = url.concat("?", params);

  //alert(url);

  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}

// Student Information

$(document).ready(function() {  
  showStudent(document.getElementById('textinputEmail').value);
});

function showStudent(email) {
  if (email == "") {
    $("#StudentTabsPlaceHolder").html("");
    return;
  }
  
  $.ajax({
    type: "GET",
    url: "StudentTabs.php",
    data: {
      email: email
    },
    success: function(result) {
      console.log(3)
      $("#StudentTabsPlaceHolder").html(result);
    }, 
    error: function() {
      $('#StudentTabsPlaceHolder').html('<p>An error has occurred</p>');
    },
  });
}

// This jQuery script validate the fields

$(document).ready(function() {

  $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function() {
      var $form = $(this).closest('form'),
      $group = $(this).closest('.input-group'),
      $addon = $group.find('.input-group-addon'),
      $icon = $addon.find('span'),
      state = false;

      if (state) {
        $addon.removeClass('danger');
        $addon.addClass('success');
        $icon.attr('class', 'glyphicon glyphicon-ok');
        $addon = $group.find('.input-group-addon'),
        $icon = $addon.find('span'),
        state = false;
                
        if (!$group.data('validate')) {
          state = $(this).val() ? true : false;
        }else if ($group.data('validate') == "email") {
          state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
        }else if($group.data('validate') == 'phone') {
          state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
        }else if ($group.data('validate') == "length") {
          state = $(this).val().length >= $group.data('length') ? true : false;
        }else if ($group.data('validate') == "number") {
          state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
        }
      }else{
        $addon.removeClass('success');
        $addon.addClass('danger');
        $icon.attr('class', 'glyphicon glyphicon-remove');
      }
          
      if ($form.find('.input-group-addon.danger').length == 0) {
        $form.find('[type="submit"]').prop('disabled', false);
      }else{
        $form.find('[type="submit"]').prop('disabled', true);
      }
  });
  
  $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');
});

</script>

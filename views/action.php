<?php

include '../app/model_functions.php';

error_reporting( E_ALL | E_STRICT );

// get the email parameter and query the dabatase. If does not exist, a new application will be created.

$email = $_POST["email"];

// Contact Person
$rows = getContactPerson($email);
$First_Name = $rows ? $rows[0]["First_Name"] : '';
$Last_Name = $rows ? $rows[0]["Last_Name"] : '';

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="david" />
  <meta name="description" content="Catholic School">
  <link rel="icon" href="images/favicon.ico">
  <title>Catholic School</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.tooltipster/4.2.5/css/tooltipster.bundle.min.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="../css/app.css">
</head>
<body>
<div class="container-fluid">
  <!-- Header-->
  <!-- <div class="jumbotron"> -->
  <div class="col-sm-12 p-l-30">
    <h3 class="display-2">Home Study Catholic School</h3>
  </div>

  <!-- Tabs: header-->
  <div class="col-sm-12">
    <div class="col-sm-4 col-md-4 col-lg-3 bhoechie-tab-menu">
      <div class="list-group">
        <a href="#" class="list-group-item active text-left">
          <h4 class="glyphicon glyphicon-info-sign"></h4>&nbsp;&nbsp;&nbsp;Introduction
        </a>
        <a href="#" class="list-group-item text-left">
          <h4 class="glyphicon glyphicon-home"></h4>&nbsp;&nbsp;&nbsp;Household Information
        </a>
        <a href="#" class="list-group-item text-left">
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
    <div class="col-sm-8 col-md-8 col-lg-7 bhoechie-tab">
        <!-- Introduction section -->
        <div class="bhoechie-tab-content active">
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
          <form id="householdinfoform">
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
              <!-- Parent or Guardian Name -->
              <div class="row">
                <div class="col-md-12"><h4 class="titlelabel">Parent or Guardian</h4></div>
                <div class="col-md-6">
                  <div class="form-group">
                    First Name<br>
                    <input id="textinputMotherName" value="<?php echo $First_Name;?>" name="textinputMotherName" type="text" placeholder="" class="form-control input-md">  
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    Last Name<br>
                    <input value="<?php echo $Last_Name;?>"  id="textinputMotherFamilyName" name="textinputMotherFamilyName" type="text" placeholder="" class="form-control input-md">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <h4 class="titlelabel">Home Address</h4>
                </div>
                <div class="homeaddress">
                  <div class="col-sm-6">
                    <div class="form-group">
                      Street Address<br>
                      <input id="Address_1" name="Address_1" type="text" class="form-control input-md">  
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <br>
                    <div class="form-group">
                      <input id="Address_2" type="text" class="form-control input-md">  
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="homeaddress-city">
                        City<br>
                        <input id="City" name="City" type="text" class="form-control">
                      </div>
                      <div class="homeaddress-state">
                        State<br>
                        <input id="State" name="State" type="text" class="form-control">
                      </div>
                      <div class="homeaddress-zipcode">
                        Zip Code<br>
                        <input id="Zip" name="Zip" type="text" class="form-control">
                      </div>
                      <div class="homeaddress-country">
                        Country<br>
                        <input id="Country" name="Country" type="text" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Contact Information -->
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <h4 class="titlelabel">Contact Information</h4>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Phone Number<br>
                    <input id="Phone1" name="Phone1" type="text" class="form-control">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Alternate Phone Number<br>
                    <input id="Phone2" name="Phone2" type="text" class="form-control">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Email Address<br>
                    <input id="Email2" name="Email2" type="text" class="form-control">
                </div>
              </div>
            </fieldset>
          </form>
        </div>

        <!-- Student section -->
        <div class="bhoechie-tab-content">
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
          </p>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.tooltipster/4.2.5/js/tooltipster.bundle.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

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
      targetId = "shippingaddress" + id.substr(11); // 11 = next index of homeaddress string
      $("#" + targetId).val($(this).val());
    }
  });

// Form Validation, Tooltipster
  $('#householdinfoform :input').each(function() {
    var tipelement = getTipContainer(this);

    $(tipelement).tooltipster({
       trigger: 'custom', 
       onlyOne: false,
       position: 'top',
       multiple: false,
       autoClose: false
    });
  });

  function getTipContainer(element) {
    var tipelement = element;
    // if ( $(element).is(":checkbox") || $(element).is(":radio") ) {
    //    tipelement = $(element).parents('.container').get(0);
    // }
    return tipelement;
  }

  $("#householdinfoform").validate({
    rules: {
      First_Name: {required: true},
      Last_Name: {required:true},
      Address_1: {required:true},
      City: {required:true},
      State: {required:true},
      Zip: {required:true},
      Country: {required:true},
      Phone1: {required:true},
      Email2: {required:true, email:true},
    },
    messages: {
      
    },
    errorPlacement: function(error, element) {
      console.log('error', error)
      var $element = $(element),
        tipelement=element,
        errtxt=$(error).text(),
        last_error='';
    
      tipelement = getTipContainer(element);
    
      last_error = $(tipelement).data('last_error');
      $(tipelement).data('last_error',errtxt);
      console.log(errtxt)
      console.log(last_error)
      if(errtxt !=='' && errtxt != last_error) {
        $(tipelement).tooltipster('content', errtxt);
        $(tipelement).tooltipster('show');
      }
    },
    success: function (label, element) {
      var tipelement = getTipContainer(element);
      $(tipelement).tooltipster('hide');
    }
  });
});

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
      let nth = $('#studenteNavTab li.active').index()+1;
      $("#StudentTabsPlaceHolder").html(result);
      $('#studenteNavTab li:nth-child('+nth+') a').trigger('click');
    }, 
    error: function() {
      $('#StudentTabsPlaceHolder').html('<p>An error has occurred</p>');
    },
  });
}

// This jQuery script validate the fields

$(document).ready(function() {

  /*$('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function() {
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
  
  $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');*/
});

</script>
</body>
</html>
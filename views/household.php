<div id="household_page">
  <h3>Family Information</h3>

  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Save Successful!</strong>
  </div>
  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span id="message"></span>
  </div>

  <form id="householdinfoform">
    <div class="row">
      <div class="col-md-12"><h4 class="titlelabel">Parent or Guardian</h4></div>
      <div class="col-md-6">
        <div class="form-group">
          <label>First Name</label><br>
          <input type="text" id="First_Name" class="form-control input-md" value="<?php echo $First_Name;?>">  
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Last Name</label><br>
          <input type="text" id="Last_Name" class="form-control input-md" value="<?php echo $Last_Name;?>">
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
            <label>Street Address</label><br>
            <input type="text" id="Address_1" class="form-control input-md" value="<?php echo $Address_1;?>">  
          </div>
        </div>
        <div class="col-sm-6">
          <br>
          <div class="form-group">
            <input type="text" id="Address_2" class="form-control input-md" value="<?php echo $Address_2;?>">  
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <div class="homeaddress-city">
              <label>City</label><br>
              <input type="text" id="City" class="form-control" value="<?php echo $City;?>">
            </div>
            <div class="homeaddress-state">
              <label>State</label><br>
              <input type="text" id="State" class="form-control" value="<?php echo $State;?>">
            </div>
            <div class="homeaddress-zipcode">
              <label>Zip Code</label><br>
              <input type="text" id="Zip" class="form-control" value="<?php echo $Zip;?>">
            </div>
            <div class="homeaddress-country">
              <label>Country</label><br>
              <input type="text" id="Country" class="form-control" value="<?php echo $Country;?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h4 class="titlelabel">Contact Information</h4>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Phone Number</label><br>
        <input type="text" id="Phone1" class="form-control" value="<?php echo $Phone1;?>" placeholder="123-123-1234">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Alternate Phone Number</label><br>
        <input type="text" id="Phone2" class="form-control" value="<?php echo $Phone2;?>" placeholder="123-123-1234">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Email</label><br>
        <input type="text" id="Email2" class="form-control" value="<?php echo $Email2;?>" placeholder="you@example.com">
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <input type="submit" class="btn btn-primary" value="Save">
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  'use strict';
  $(document).ready(function() {
    
    let _isValidForm = (form) => {
      const $form = $(form);
      const $alert = $('#household_page .alert-warning');
      const $First_Name = $form.find('#First_Name');
      const $Last_Name = $form.find('#Last_Name');
      const $Address_1 = $form.find('#Address_1');
      const $City = $form.find('#City');
      const $State = $form.find('#State');
      const $Zip = $form.find('#Zip');
      const $Phone1 = $form.find('#Phone1');
      const $Phone2 = $form.find('#Phone2');
      const $Email2 = $form.find('#Email2');

      if ($.trim($First_Name.val()) == '') {
        $First_Name.focus();
        $alert.find('#message').html('<strong>First Name</strong> is required.');
      } else if ($.trim($Last_Name.val()) == '') {
        $Last_Name.focus();
        $alert.find('#message').html('<strong>Last Name</strong> is required.');
      } else if ($.trim($Address_1.val()) == '') {
        $Address_1.focus();
        $alert.find('#message').html('<strong>Street Address</strong> is required.');
      } else if ($.trim($City.val()) == '') {
        $City.focus();
        $alert.find('#message').html('<strong>City</strong> is required.');
      } else if ($.trim($State.val()) == '') {
        $State.focus();
        $alert.find('#message').html('<strong>State</strong> is required.');
      } else if ($.trim($Zip.val()) == '') {
        $Zip.focus();
        $alert.find('#message').html('<strong>Zip Code</strong> is required.');
      } else if ($.trim($Phone1.val()) == '') {
        $Phone1.focus();
        $alert.find('#message').html('<strong>Phone Number</strong> is required.');
      } else if ($.trim($Phone1.val()) != '' && !/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/.test($.trim($Phone1.val()))) {
        $Phone1.focus();
        $alert.find('#message').html('<strong>Phone Number</strong> is invalid format. <strong>Example:</strong> 123-123-1234');
      } else if ($.trim($Phone2.val()) != '' && !/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/.test($.trim($Phone2.val()))) {
        $Phone2.focus();
        $alert.find('#message').html('<strong>Alternate Phone Number</strong> is invalid format. <strong>Example:</strong> 123-123-1234');
      } else if ($.trim($Email2.val()) != '' && !/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($.trim($Email2.val()))) {
        $Email2.focus();
        $alert.find('#message').html('<strong>Email</strong> is invalid format. <strong>Example:</strong> you@example.com');
      } else {
        return true;
      }

      $alert.slideDown();
      setTimeout(function() {
        $alert.slideUp();
      }, 5000);
      return false;
    };

    $("#household_page form").on("submit", function(event) {
      event.preventDefault();
      $('#household_page .alert').css('display', 'none');

      if (!_isValidForm(this)) return;

      $.ajax({
        type: "post",
        url: "../app/api_household.php",
        data: {
          Email1: $('#email').val(),
          First_Name: $('#household_page #First_Name').val(),
          Last_Name: $('#household_page #Last_Name').val(),
          Address_1: $('#household_page #Address_1').val(),
          Address_2: $('#household_page #Address_2').val(),
          City: $('#household_page #City').val(),
          State: $('#household_page #State').val(),
          Zip: $('#household_page #Zip').val(),
          Country: $('#household_page #Country').val(),
          Phone1: $('#household_page #Phone1').val(),
          Phone2: $('#household_page #Phone2').val(),
          Email2: $('#household_page #Email2').val(),
        },
        dataType: "json",
        success: function(response) {
          console.log(response)
          if (response.statusCode == '200' && response.message == 'Success') {
            $('#household_page .alert-info').slideDown();
          } else {
            $('#household_page .alert-warning #message').html(alertMessage);
            $('#household_page .alert-warning').slideDown();
          }
          setTimeout(function() {
            $('#household_page .alert').slideUp();
          }, 5000);
        },
        error: function() {
          $('#household_page .alert-warning #message').html(alertMessage);
          $('#household_page .alert-warning').slideDown();
        },
      });
    });
  });
</script>
<div id="household_page">
  <h3>Family Information</h3>
  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Save Successful!</strong>
  </div>
  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> <span id="err-msg"></span>
  </div>
  <form id="householdinfoform">
    <div class="row">
      <div class="col-md-12"><h4 class="titlelabel">Parent or Guardian</h4></div>
      <div class="col-md-6">
        <div class="form-group">
          First Name<br>
          <input type="text" id="First_Name" class="form-control input-md" value="<?php echo $First_Name;?>" required>  
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          Last Name<br>
          <input type="text" id="Last_Name" class="form-control input-md" value="<?php echo $Last_Name;?>" required>
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
            <input type="text" id="Address_1" class="form-control input-md" value="<?php echo $Address_1;?>" required>  
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
              City<br>
              <input type="text" id="City" class="form-control" value="<?php echo $City;?>" required>
            </div>
            <div class="homeaddress-state">
              State<br>
              <input type="text" id="State" class="form-control" value="<?php echo $State;?>" required>
            </div>
            <div class="homeaddress-zipcode">
              Zip Code<br>
              <input type="text" id="Zip" class="form-control" value="<?php echo $Zip;?>" required>
            </div>
            <div class="homeaddress-country">
              Country<br>
              <input type="text" id="Country" class="form-control" value="<?php echo $Country;?>" required>
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
        <input type="text" id="Phone1" class="form-control" value="<?php echo $Phone1;?>" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" placeholder="ex: 123-123-1234" required>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        Alternate Phone Number<br>
        <input type="text" id="Phone2" class="form-control" value="<?php echo $Phone2;?>" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" placeholder="ex: 123-123-1234">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        Email Address<br>
        <input type="email" id="Email2" class="form-control" value="<?php echo $Email2;?>" placeholder="ex: you@example.com">
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
  $(document).ready(function() {
    $("#household_page form").on("submit", function(event) {
      event.preventDefault();
      
      $('#household_page .alert').css('display', 'none');
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
            $('#household_page #err-msg').html(response.message);
            $('#household_page .alert-warning').slideDown();
          }
          setTimeout(function() {
            $('#household_page .alert').slideUp();
          }, 10000);
        },
        error: function() {
          console.log('An error has occurred when save household data');
        },
      });
    });
  });
</script>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="david" />
  <meta name="description" content="Catholic School">
  <link rel="icon" href="images/favicon.ico">
  <title>Catholic School | Register</title>

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/app.css">
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <h3 class="display-2">Home Study Catholic School - Register</h3>
    </div>
  </div>

  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
    <form id="signup_form" action="login.php"  method="post">
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Warning!</strong> Please input valid email and password.
      </div>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Signup Success!</strong> Welcome to Catholic School.
      </div>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Sorry, some unknown error occurred!  Please contact us at  <strong>support@ada.school</strong> to resolve this problem.
      </div>
      <div class="form-group">
        <label for="email">E-mail Address</label>
        <div class="input-group" data-validate="email">
          <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
        </div>
        <span class="help-block">Please provide a valid email address</span> 
        <label for="password">Password</label>
        <div class="input-group" data-validate="password">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
        </div>
        <label for="password" class="m-t-20">Confirm Password</label>
        <div class="input-group" data-validate="confirm-password">
          <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
        </div>
      </div>
      <div class="controll-bar">
        <a href="../index.php">
          <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
        </a>
        <button id="signup" type="button" class="btn btn-primary" disabled>Create Account</button>
      </div>
    </form>
  </div>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/moment.min.js"></script>
<script>
  $(document).ready(function() {
    $('.alert').css('display', 'none');

    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function() {
      var $form = $(this).closest('form'),
          $group = $(this).closest('.input-group'),
          $addon = $group.find('.input-group-addon'),
          $icon = $addon.find('span'),
          state = false;
            
      if (!$group.data('validate')) {
        state = $(this).val() ? true : false;
      } else if ($group.data('validate') == "email") {
        state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
      } else if ($group.data('validate') == 'phone') {
        state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
      } else if ($group.data('validate') == "password") {
        if ($(this).val().length && ($('#confirm-password').val() == $(this).val())) {
          state = true;
        } else {
          state = false;
        }

        $confirmAddon = $('#confirm-password').next();
        $confirmIcon = $confirmAddon.find('span');
        if (state) {
          $confirmAddon.removeClass('danger');
          $confirmAddon.addClass('success');
          $confirmIcon.attr('class', 'glyphicon glyphicon-ok');
        } else {
          $confirmAddon.removeClass('success');
          $confirmAddon.addClass('danger');
          $confirmIcon.attr('class', 'glyphicon glyphicon-remove');
        }
      } else if ($group.data('validate') == "confirm-password") {
        if ($(this).val().length && ($('#password').val() == $(this).val())) {
          state = true;
        } else {
          state = false;
        }

        $confirmAddon = $('#password').next();
        $confirmIcon = $confirmAddon.find('span');
        if (state) {
          $confirmAddon.removeClass('danger');
          $confirmAddon.addClass('success');
          $confirmIcon.attr('class', 'glyphicon glyphicon-ok');
        } else {
          $confirmAddon.removeClass('success');
          $confirmAddon.addClass('danger');
          $confirmIcon.attr('class', 'glyphicon glyphicon-remove');
        }
      } else if ($group.data('validate') == "length") {
        state = $(this).val().length >= $group.data('length') ? true : false;
      } else if ($group.data('validate') == "number") {
        state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
      }

      if (state) {
        $addon.removeClass('danger');
        $addon.addClass('success');
        $icon.attr('class', 'glyphicon glyphicon-ok');
      } else {
        $addon.removeClass('success');
        $addon.addClass('danger');
        $icon.attr('class', 'glyphicon glyphicon-remove');
      }
          
      if ($form.find('.input-group-addon.danger').length == 0) {
        $('#signup').prop('disabled', false);
      } else {
        $('#signup').prop('disabled', true);
      }
    });

    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');

    $('#signup').on('click', function(e) {
      $.ajax({
        type: "post",
        url: "../app/api_signup.php",
        data: {
          email: $('#email').val(),
          password: $('#password').val()
        },
        dataType: "json",
        success: function(result) {
          console.log(result);
          if (result.double == true) {
            $('.alert').css('display', 'none');
            $('.alert-warning').css('display', 'block');
          } else if (result.status == true) {
            $('.alert').css('display', 'none');
            $('.alert-success').css('display', 'block');
            $('#signup_form').submit();
          } else {
            $('.alert').css('display', 'none');
            $('.alert-danger').css('display', 'block');
          }
        },
        error: function() {
          $('.alert').css('display', 'none');
          $('.alert-danger').css('display', 'block'); 
        },
      });
    });
  });
</script>
</body>
</html>
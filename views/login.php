<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="david" />
  <meta name="description" content="Catholic School">
  <link rel="icon" href="images/favicon.ico">
  <title>Catholic School | Login</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/app.css">  
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <h3 class="display-2">Home Study Catholic School - Login</h3>
    </div>
  </div>

  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
    <form id="login_form" action="action.php" method="POST">
      <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Please input email and password for log in.
      </div>
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Log in failed!</strong> Plese input valid email and password.
      </div>
      <div class="form-group">
        <label for="email">E-mail</label>
        <div class="input-group" data-validate="email">
          <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span> 
        </div>
        <span class="help-block">Please provide a valid email address</span> 
        <br>
        <label for="password">Password</label>
        <div class="input-group" data-validate="password">
          <input type="text" class="form-control" name="password" id="password" placeholder="Password" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span> 
        </div>
      </div>
      <div class="float-left m-t-30">
        <a href="../index.php">
          <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
        </a>
      </div>
      <button id="login" type="button" class="btn btn-primary float-right m-t-20" disabled>Log In</button>
    </form>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script>
  $(document).ready(function() {
    $('.alert-warning').css('display', 'none');

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
        state = $(this).val().length ? true : false;
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
        $form.find('#login').prop('disabled', false);
      } else {
        $form.find('#login').prop('disabled', true);
      }
    });

    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');

    $('#login').on('click', function(e) {
      $.ajax({
        type: "GET",
        url: "../app/api_login.php",
        data: {
          email: $('#email').val(),
          password: $('#password').val()
        },
        dataType: "json",
        success: function(result) {
          console.log('resulst', result.status);
          if (result.status === true)
            $('#login_form').submit();
          else {
            $('.alert-info').css('display', 'none');
            $('.alert-warning').css('display', 'block');
            console.log(result.status);
          }
        },
        error: function() {
          console.log('An error has occurred when get login data');
        },
      });
    });
  });
</script>
</body>
</html>
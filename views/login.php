<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="david" />
  <meta name="description" content="Catholic School">
  <link rel="icon" href="images/favicon.ico">
  <title>Catholic School | Login</title>

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/app.css">  
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <h3 class="display-2">Home Study Catholic School - Login</h3>
    </div>
  </div>

  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Login Failed!</strong> The email and password is incorrect.
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Sorry, some unknown error occurred! Please contact us at <strong>support@ada.school</strong> to resolve this problem.
    </div>

    <form id="login_form" action="action.php" method="post">
      <input type="hidden" id="Account_Id" name="Account_Id" value="">
      <div class="form-group">
        <label for="email">E-mail</label>
        <div class="input-group" data-validate="email">
          <input type="text" class="form-control" name="email" id="email" placeholder="Email" autofocus required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span> 
        </div>
        <br>
        <label for="password">Password</label>
        <div class="input-group" data-validate="password">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span> 
        </div>
      </div>
      <div class="controll-bar">
        <a href="../index.php">
          <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
        </a>
        <button id="login" type="button" class="btn btn-primary" disabled>Log In</button>
      </div>
    </form>
  </div>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/moment.min.js"></script>
<script>
  $(document).ready(function() {
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
      } else if ($group.data('validate') == "password") {
        state = $(this).val().length ? true : false;
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

    $('.input-group input[required]').trigger('change');

    $('#login').on('click', function(e) {
      $.ajax({
        type: "post",
        url: "../app/api_login.php",
        data: {
          email: $('#email').val(),
          password: $('#password').val()
        },
        dataType: "json",
        success: function(response) {
          if (response.statusCode == '200' && response.message == 'Success') {
            $('#Account_Id').val(response.Account_Id);
            $('#login_form').submit();
          } else {
            $('.alert-warning').slideDown("slow");
            setTimeout(function() {
              $('.alert-warning').slideUp("slow");
            }, 10000);
          }
        },
        error: function() {
          $('.alert-danger').slideDown("slow");
        },
      });
    });
  });
</script>
</body>
</html>
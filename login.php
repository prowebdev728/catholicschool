<!-- Jquery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Bootstrap CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


<head>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<style type="text/css">
  .input-group-addon.primary {
      color: rgb(255, 255, 255);
      background-color: rgb(50, 118, 177);
      border-color: rgb(40, 94, 142);
  }
  .input-group-addon.success {
      color: rgb(255, 255, 255);
      background-color: rgb(92, 184, 92);
      border-color: rgb(76, 174, 76);
  }
  .input-group-addon.info {
      color: rgb(255, 255, 255);
      background-color: rgb(57, 179, 215);
      border-color: rgb(38, 154, 188);
  }
  .input-group-addon.warning {
      color: rgb(255, 255, 255);
      background-color: rgb(240, 173, 78);
      border-color: rgb(238, 162, 54);
  }
  .input-group-addon.danger {
      color: rgb(255, 255, 255);
      background-color: rgb(217, 83, 79);
      border-color: rgb(212, 63, 58);
  }
</style>

<!DOCTYPE html>
<html>
<head>
  <!-- <link rel="stylesheet" href="verticalTab.css"> -->
</head>
<body>

  <div class="jumbotron">
    <div class="container">
      <h3 class="display-2">Home Study Catholic School - Login</h3>
    </div>
  </div>

  <div class="col-sm-8 col-sm-offset-2">
    <p align=center>

      <form id="regiration_form" action="action.php"  method="post">
        <fieldset>
          <div class="form-group">
            <label for="validate-email">Validate Email</label>
            <div class="input-group" data-validate="email">
              <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="Validate Email" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span> 
            </div>
            <span class="help-block">Please provide a valid email address</span> 
          </div>
          </fieldset>
          <button type="submit" class="btn btn-primary col-xs-2 col-sm-offset-5" disabled>Submit</button>
      </form>

    </p>
  </div>


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
    }else if ($group.data('validate') == "email") {
      state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
    }else if($group.data('validate') == 'phone') {
      state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
    }else if ($group.data('validate') == "length") {
      state = $(this).val().length >= $group.data('length') ? true : false;
    }else if ($group.data('validate') == "number") {
      state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
    }

    if (state) {
        $addon.removeClass('danger');
        $addon.addClass('success');
        $icon.attr('class', 'glyphicon glyphicon-ok');
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


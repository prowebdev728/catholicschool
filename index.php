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
	<link rel="stylesheet" type="text/css" href="css/app.css">  
</head>
<body>
<section id="index">
	<div class="container">
		<div class="col-md-12">
			<h3>Have you ever enrolled with ADA before?</h3>
		</div>
		<div class="col-md-12">
			<button id="yes" class="btn btn-primary">Yes</button>
			<button id="no" class="btn btn-primary">No</button>
		</div>
	</div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('section#index #yes').on('click', function() {
			location.href = 'views/login.php';
		});

		$('section#index #no').on('click', function() {
			location.href = 'views/register.php';
		});
	});
</script>
</body>
</html>
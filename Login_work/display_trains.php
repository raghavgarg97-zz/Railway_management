<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Booking Form HTML Template</title>

	<!-- Google font -->
	<link href="http://fonts.googleapis.com/css?family=Playfair+Display:900" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Alice:400,700" rel="stylesheet" type="text/css" />


	<!-- Bootstrap -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

	<link href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
	

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="styles/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form">
						<div class="booking-bg">
							<div class="form-header">
								<h2>Book Your Train</h2>
								<p>Come In As Guests. Leave As Family.</p>
							</div>
						</div>
						<form action="includes/train_list.php" method="post">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="sel1">Source:</label>
										  <select class="form-control" name="sel1">
										    <option>CNB</option>
										    <option>NDLS</option>
										    <option>GZB</option>
										    <option>Etawah</option>
										  </select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="sel2">Destination:</label>
										  <select class="form-control" name="sel2">
										    <option>CNB</option>
										    <option>NDLS</option>
										    <option>GZB</option>
										    <option>Etawah</option>
										  </select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<label for="sel3">Pick Date:</label>
										<div class='input-group date' id='datetimepicker1'>
						                    <input type='text' class="form-control" id="date-daily" name="date" />
						                    <span class="input-group-addon">
						                        <span class="glyphicon glyphicon-calendar"></span>
						                    </span>
						                </div>
									</div>
								</div>
								<script type="text/javascript">
								$(document).ready(function () {
							        $('#datetimepicker1').datetimepicker({ format: 'DD/MM/YYYY'});						        
							    }

							    );
								</script> 

								<div class="col-md-6">
									<div class="form-group">
										<label for="sel4">Select Class:</label>
										  <select class="form-control" name="sel3">
										    <option>CC</option>
										    <option>EC</option>
										    <option>3AC</option>
										    <option>2AC</option>
										    <option>1AC</option>
										    <option>SL</option>
										    <option>GN</option>
										    <option>2S</option>
										  </select>
									</div>
								</div>
							</div>
							
							<div class="form-btn">
								<button class="submit-btn">Check Trains</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->


</html>
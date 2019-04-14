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

</head>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form">
						<div class="booking-bg">
							<div class="form-header">
								<h2>Enter your information</h2>
								<p>Come In As Guests. Leave As Family.</p>
							</div>
						</div>
						
						<?php
							$Train_no = $_GET['Train_no'];
							$Train_name = $_GET['Train_name'];
							$username = $_GET['username'];
							$source = $_GET['source'];
							$destination = $_GET['destination'];
							$date = $_GET['date'];
							$coach = $_GET['coach'];
						?>

						<form action="booking_confirm.php?Train_no=<?php echo $Train_no;?>&Train_name=<?php echo $Train_name;?>&username=<?php echo $username;?>&source=<?php echo $source;?>&destination=<?php echo $destination;?>&date=<?php echo $date;?>&coach=<?php echo $coach;?>" method="post">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group" required>
										<label for="sel1">Name:</label>
										<input type="text" name="sel1"><br>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" required>
										<label for="sel2">Age:</label>
										  <input type="text" name="sel2"><br>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group" required>
									<label for="sel3">DOB:</label>
										<div class='input-group date' id='datetimepicker1'>
						                    <input type='text' class="form-control" id="date-daily" name="sel3" />
						                    <span class="input-group-addon">
						                        <span class="glyphicon glyphicon-calendar"></span>
						                    </span>
						                </div>
									</div>
								</div>
								<script type="text/javascript">
								$(document).ready(function () {
							        $('#datetimepicker1').datetimepicker({ format: 'YYYY-MM-DD'});						        
							    }

							    );
								</script> 

								<div class="col-md-6">
									<div class="form-group" required>
										<label for="sel4">Gender:</label>
										  <select class="form-control" name="sel4">
										    <option>Male</option>
										    <option>Female</option>
										    <option>Other</option>
										  </select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<span class="form-label">Insurance AV</span>
								<select class="form-control" required name="sel5">
									<option value="" selected hidden>Do you want insurance?</option>
									<option>Yes</option>
									<option>No</option>
								</select>
								<span class="select-arrow"></span>
							</div>
							
							<div class="form-btn">
								<button class="submit-btn">Book Ticket</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
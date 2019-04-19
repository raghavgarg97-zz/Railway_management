<?php
include_once './includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>PNR Status HTML Template</title>

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
								<h2>PNR Status</h2>
								<!-- <p>Home Page</p> -->
							</div>
						</div>
						
						<?php
							$PNR = $_POST['PNR'];
							$username = $_GET['username'];
							$sq='SELECT * FROM BOOKING WHERE PNR_no='.$PNR.';';
							$result=$mysqli->query($sq);
							$row = $result->fetch_assoc();
							if(!empty($row)){
								$status=$row['Booking_Status'];								
								if($status == "CNF"){
									echo "<script type='text/javascript'>alert('Your booking is confirmed');</script>";
								}
								else{
									$Train_no=$row['Train_no'];
									$source_no=$row['Source_station'];
									$dest_no=$row['Destination_station'];
									$date=$row['Boarding_Date'];
									$coach=$row['Coach_Type'];
									

									$sq = 'SELECT * FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = "'.$date.'" AND Coach_Type = "'.$coach.'" AND PNR_no='.$PNR.';';
									// echo "<script type='text/javascript'>alert('$sq');</script>";
									$result = $mysqli->query($sq);
									$row = $result->fetch_assoc();
									$WL = $row['WL_no'];
									echo "<script type='text/javascript'>alert('Your waiting list number is $WL');</script>";
								}
							}
							else{
								echo "<script type='text/javascript'>alert('The PNR number : $PNR does not exist');</script>";
							}
						?>
						
						<form action="home.php?username=<?php echo $username;?>" method="post">
							<div class="form-btn">
								<button class="submit-btn">Go Back to Home</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->


</html>
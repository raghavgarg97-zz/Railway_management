<?php
include_once 'includes/db_connect.php';

function find_min_seats($train_no,$source_no,$dest_no,$date,$coach,$mysqli){
	$sq='Select Station_no from  RAILWAY_PATH where Train_no='.$train_no.' and Sequence_number BETWEEN '.$source_no.' and '.($dest_no-1).';';
	$result = $mysqli->query($sq);
	if ($result==false){
		echo "<script type='text/javascript'>alert('".$sq."');</script>";

	}
	$min=1000;
	while ($row = $result->fetch_assoc()){
		$sq2='SELECT Total_available_seats from TICKET_AVAILABLITY where Train_no='.$train_no.' and Station_no='.$row["Station_no"].' and Date="'.$date.'" and Coach_Type="'.$coach.'";';
		$result2 = $mysqli->query($sq2);
		$row2 = $result2->fetch_assoc();
		if ($row2 == false){
			return false;
		}
		if ($row2["Total_available_seats"]<$min){
			$min=$row2["Total_available_seats"];
		}
	}
	return $min;

}
function cancel_normal($train_no,$source_no,$dest_no,$date,$coach,$mysqli){
	$sq='Select Station_no from RAILWAY_PATH where Train_no='.$train_no.' and Sequence_number BETWEEN '.$source_no.' and '.($dest_no-1).';';
	$result = $mysqli->query($sq);
	while ($row = $result->fetch_assoc()){
		$sq2='SELECT Total_available_seats as TOT from TICKET_AVAILABLITY where Train_no='.$train_no.' and Station_no='.$row["Station_no"].' and Date="'.$date.'" and Coach_Type="'.$coach.'";';
		$result2 = $mysqli->query($sq2);
		$row2 = $result2->fetch_assoc();
		$row2 = $row2["TOT"] + 1;
		$sq2='UPDATE TICKET_AVAILABLITY SET Total_available_seats='.$row2.' where Train_no='.$train_no.' and Station_no='.$row["Station_no"].' and Date="'.$date.'" and Coach_Type="'.$coach.'";';
		$mysqli->query($sq2);
	}
}
function book_normal($train_no,$source_no,$dest_no,$date,$coach,$mysqli){
	$sq='Select Station_no from RAILWAY_PATH where Train_no='.$train_no.' and Sequence_number BETWEEN '.$source_no.' and '.($dest_no-1).';';
	$result = $mysqli->query($sq);
	while ($row = $result->fetch_assoc()){
		$sq2='SELECT Total_available_seats as TOT from TICKET_AVAILABLITY where Train_no='.$train_no.' and Station_no='.$row["Station_no"].' and Date="'.$date.'" and Coach_Type="'.$coach.'";';
		$result2 = $mysqli->query($sq2);
		$row2 = $result2->fetch_assoc();
		$row2 = $row2["TOT"] - 1;
		$sq2='UPDATE TICKET_AVAILABLITY SET Total_available_seats='.$row2.' where Train_no='.$train_no.' and Station_no='.$row["Station_no"].' and Date="'.$date.'" and Coach_Type="'.$coach.'";';
		$mysqli->query($sq2);
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>General Query HTML Template</title>

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
								<h2>Cancellation Confirmed</h2>
								<p>Go to home page</p>
							</div>
						</div>
						<?php
							$username = $_GET['username'];
							$PNR = $_POST['PNR'];
							$sq='SELECT * FROM BOOKING WHERE PNR_no='.$PNR.';';
							$result=$mysqli->query($sq);
							$row = $result->fetch_assoc();
							if(!empty($row)){
								$sq='DELETE FROM BOOKING WHERE PNR_no='.$PNR.';';
								$mysqli->query($sq);

								$Train_no=$row['Train_no'];
								$source_no=$row['Source_station_no'];
								$dest_no=$row['Destination_station_no'];
								$date=$row['Boarding_Date'];
								$coach=$row['Coach_Type'];
								$status=$row['Booking_Status'];

								if($status == "CNF"){
									cancel_normal($Train_no,$source_no,$dest_no,$date,$coach,$mysqli);

									$sq = 'SELECT * FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = '.$date.'AND Coach_Type = '.$coach.';';
									$result = $mysqli->query($sq);
									while($row = $result->fetch_assoc()){
										$seats=find_min_seats($Train_no,$source_no,$dest_no,$date,$coach,$mysqli);
										if($seats!=0){
											$sq='SELECT * FROM BOOKING WHERE PNR_no='.$row['PNR_no'].';';
											$row1=$mysqli->query($sq);

											$sq='INSERT INTO BOOKING values('.$row['PNR_no'].','.$row1['Username'].','.$row1['Name'].','.$row1['Age'].','.$row1['DOB'].','.$row1['Gender'].','.$row1['Insurance_AV'].','.$row1['Train_no'].','.$row1['Coach_Type'].','.$row1['Source_station_no'].','.$row1['Destination_station_no'].','.$row1['Boarding_Date'].',CNF);';
											$mysqli->query($sq);
											
											$wl = $row['WL_no'];
											$sq='DELETE FROM OVERALL_WAITING WHERE PNR_no='.$row['PNR_no'].';';
											$mysqli->query($sq);

											$sq='UPDATE OVERALL_WAITING SET WL_no=WL_no-1 WHERE Train_no = '.$Train_no.' AND Dates = '.$date.'AND Coach_Type = '.$coach.' AND WL_no >'.$wl.';';
											$mysqli->query($sq);
										}
									}
								}
								else{
									$sq = 'SELECT WL_no FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = '.$date.'AND Coach_Type = '.$coach.' AND PNR_no='.$PNR.';';
									$result = $mysqli->query($sq);
									$row = $result->fetch_assoc();
									$wl = $row['WL_no'];
									
									$sq='DELETE FROM OVERALL_WAITING WHERE PNR_no='.$PNR.';';
									$mysqli->query($sq);

									$sq='UPDATE OVERALL_WAITING SET WL_no=WL_no-1 WHERE Train_no = '.$Train_no.' AND Dates = '.$date.'AND Coach_Type = '.$coach.' AND WL_no >'.$wl.';';
									$mysqli->query($sq);
								}
							}
							else{
								echo "<script type='text/javascript'>alert('The PNR number : $PNR does not exist');</script>";
							}	

							?>
						<form action="home.php?username=<?php echo $username;?>" method="post">
							<div class="form-btn">
								<button class="submit-btn">Go to Home Page</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->


</html>
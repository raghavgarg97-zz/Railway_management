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
							
							// $sq='START TRANSACTION;LOCK TABLES BOOKING WRITE;';
							// $mysqli->query($sq);

							$sq='SELECT * FROM BOOKING WHERE PNR_no='.$PNR.' and Username="'.$username.'";';
							$result=$mysqli->query($sq);
							$row = $result->fetch_assoc();
							if(!empty($row)){
								
								$Train_no=$row['Train_no'];
								$source=$row['Source_station'];
								$dest=$row['Destination_station'];
								$date=$row['Boarding_Date'];
								$coach=$row['Coach_Type'];
								$status=$row['Booking_Status'];
								
								$sq='DELETE FROM BOOKING WHERE PNR_no='.$PNR.';';
								$mysqli->query($sq);

								// $sq='LOCK TABLES RAILWAY_PATH READ;LOCK TABLES STATIONS read;LOCK TABLES TRAIN_INFO READ; ';
								// $mysqli->query($sq);

								$sq='SELECT T.Sequence_number as source_no,S.Sequence_number as dest_no FROM 
								(SELECT Sequence_number,Train_no from RAILWAY_PATH,STATIONS where Station_name="'.$source.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)T,(
								SELECT Sequence_number,Train_no from RAILWAY_PATH,STATIONS where Station_name="'.$dest.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)S,TRAIN_INFO where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number and T.Train_no=TRAIN_INFO.Train_no and T.Train_no='.$Train_no.';';
								$result = $mysqli->query($sq);
								$row2=$result->fetch_assoc();									
								/*$sq6='unlock tables;commit; ';
								$mysqli->query($sq6);*/

								$source_no=$row2["source_no"];
								$dest_no=$row2["dest_no"];
								

								if($status == "CNF"){
									// $sq='select * from TICKET_AVAILABLITY where Train_no='.$Train_no.' FOR UPDATE;';
									// $mysqli->query($sq);
									$sq='select * from TICKET_AVAILABLITY where Train_no='.$Train_no.';';
									$mysqli->query($sq);
									
									cancel_normal($Train_no,$source_no,$dest_no,$date,$coach,$mysqli);

									// $sq = 'lock tables OVERALL_WAITING write;';
									// $mysqli->query($sq);

									$sq = 'SELECT * FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = "'.$date.'" AND Coach_Type = "'.$coach.'";';
									$result3 = $mysqli->query($sq);

									
									while($row3 = $result3->fetch_assoc()){

										$pnr = $row3['PNR_no'];
										$wl = $row['WL_no'];


										$sq='SELECT * FROM BOOKING WHERE PNR_no='.$pnr.';';
										// echo "<script type='text/javascript'>alert('$sq');</script>";
										$resultn=$mysqli->query($sq);
										$row4= $resultn->fetch_assoc();

										$Train_no2=$row4['Train_no'];
										$source2=$row4['Source_station'];
										$dest2=$row4['Destination_station'];
										$date2=$row4['Boarding_Date'];
										$coach2=$row4['Coach_Type'];


										$sq='SELECT T.Sequence_number as source_no,S.Sequence_number as dest_no FROM 
										(SELECT Sequence_number,Train_no from RAILWAY_PATH,STATIONS where Station_name="'.$source.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)T,(
										SELECT Sequence_number,Train_no from RAILWAY_PATH,STATIONS where Station_name="'.$dest.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)S,TRAIN_INFO where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number and T.Train_no=TRAIN_INFO.Train_no and T.Train_no='.$Train_no.';';
										$result5 = $mysqli->query($sq);
										$row5=$result5->fetch_assoc();									
										/*$sq6='unlock tables;commit; ';
										$mysqli->query($sq6);*/

										$source_no2=$row5["source_no"];
										$dest_no2=$row5["dest_no"];
										

										$seats=find_min_seats($Train_no2,$source_no2,$dest_no2,$date2,$coach2,$mysqli);
										echo "<script type='text/javascript'>alert('$seats');</script>";
										if($seats!=0){
											// $sq='SELECT * FROM BOOKING WHERE PNR_no='.$row['PNR_no'].';';
											// $row1=$mysqli->query($sq);

											$sq='UPDATE BOOKING SET Booking_Status="CNF" where PNR_no='.$pnr.';';
											$mysqli->query($sq);

											book_normal($Train_no2,$source_no2,$dest_no2,$date2,$coach2,$mysqli);
											
											$sq='DELETE FROM OVERALL_WAITING WHERE PNR_no='.$pnr.';';
											$mysqli->query($sq);

											$sq='UPDATE OVERALL_WAITING SET WL_no=WL_no-1 WHERE Train_no = '.$Train_no2.' AND Dates = "'.$date2.'" AND Coach_Type = '.$coach2.' AND WL_no >'.$wl.';';
											$mysqli->query($sq);
											echo "<script type='text/javascript'>alert('Your Ticket has been cancelled');</script>";
										}
									}
								}
								else{
									/*$sq3 = 'SELECT WL_no FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = "'.$date.'" AND Coach_Type = '.$coach.' AND PNR_no='.$PNR.';';*/
									
									// $sq3 = 'lock tables OVERALL_WAITING write;';
									// $mysqli->query($sq3);

									$sq3 = 'SELECT WL_no FROM OVERALL_WAITING WHERE PNR_no='.$PNR.';';
									$result3 = $mysqli->query($sq3);
									$row3 = $result3->fetch_assoc();
									$wl3 = $row3['WL_no'];
									#echo "<script type='text/javascript'>alert('Your WL Number is $wl10 ');</script>";
									
									$sq3='DELETE FROM OVERALL_WAITING WHERE PNR_no='.$PNR.';';
									$mysqli->query($sq3);

									$sq3='UPDATE OVERALL_WAITING SET WL_no=WL_no-1 WHERE Train_no = '.$Train_no.' AND Dates = "'.$date.'"AND Coach_Type = '.$coach.' AND WL_no >'.$wl.';';
									$mysqli->query($sq3);
								}
							}
							else{
								echo "<script type='text/javascript'>alert('The PNR number : $PNR does not exist or You are not eligible to Cancel this ticket');</script>";
							}
							// $sq='unlock tables;COMMIT; ';
							// $mysqli->query($sq);	

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
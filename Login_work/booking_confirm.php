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
function book_normal($train_no,$source_no,$dest_no,$date,$coach,$mysqli){
	$sq='Select Station_no from RAILWAY_PATH where Train_no='.$train_no.' and Sequence_number BETWEEN '.$source_no.' and '.($dest_no-1).';';
	$result = $mysqli->query($sq);
	while ($row = $result->fetch_assoc()){
		$sq2='SELECT Total_available_seats as TOT from TICKET_AVAILABLITY where Train_no='.$train_no.' and Station_no='.$row["Station_no"].' and Date="'.$date.'" and Coach_Type="'.$coach.'";';
		$result2 = $mysqli->query($sq2);
		$row2 = $result2->fetch_assoc();
		$row2 = $row2["TOT"] -1;
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
								<h2>Booking Confirmed</h2>
								<p>Come In As Guests. Leave As Family.</p>
							</div>
						</div>

						<?php
							$Train_no = $_GET['Train_no'];
							$Train_name = $_GET['Train_name'];
							$username = $_GET['username'];
							$source = $_GET['source'];
							$dest = $_GET['destination'];
							$coach = $_GET['coach'];
							$date = $_GET['date'];
							$name = $_POST['sel1'];
							$age = $_POST['sel2'];
							$dob = $_POST['sel3'];
							$gen = $_POST['sel4'];
							$ins = $_POST['sel5'];

							$sq='start Transaction;lock tables RAILWAY_PATH READ;lock tables STATIONS write;lock tables TRAIN_INFO READ; ';
							$mysqli->query($sq);

							$sq='SELECT T.Sequence_number as source_no,S.Sequence_number as dest_no FROM 
							(SELECT Train_no,Sequence_number,Day_offset,Distance,Departure_time from RAILWAY_PATH,STATIONS where Station_name="'.$source.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)T,(
							SELECT Train_no,Sequence_number,Day_offset,Distance,Arrival_time from RAILWAY_PATH,STATIONS where Station_name="'.$dest.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)S,TRAIN_INFO where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number and T.Train_no=TRAIN_INFO.Train_no and T.Train_no='.$Train_no.';';

							$result = $mysqli->query($sq);
								
							$sq6='unlock tables;commit; ';
							$mysqli->query($sq6);

							$row3=-1;

							while ($row = $result->fetch_assoc()){
								$source_no=$row["source_no"];
								$dest_no=$row["dest_no"];


								$seats=find_min_seats($Train_no,$source_no,$dest_no,$date,$coach,$mysqli);
								if($seats!=0){
									book_normal($Train_no,$source_no,$dest_no,$date,$coach,$mysqli);
									$sq3 = 'SELECT MAX(PNR_no) AS MA FROM BOOKING;';
									$result3 = $mysqli->query($sq3);
									$row3 = $result3->fetch_assoc();
									$row3 = $row3['MA'];
									if ($row3==null){
										$row3=0;
									}
									
									$row3 = $row3 + 1;
									$sq3='INSERT INTO BOOKING values("'.$row3.'","'.$username.'","'.$name.'",'.$age.',"'.$dob.'","'.$gen.'",1,"'.$Train_no.'","'.$coach.'","'.$source.'","'.$dest.'","'.$date.'","CNF");';
									echo "<script type='text/javascript'>alert('".$sq3."');</script>";
									$mysqli->query($sq3);
								}
								else{
									$sq4 = 'SELECT MAX(WL_no) AS MA FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = '.$date.'AND Coach_Type = '.$coach.';';
									$result4 = $mysqli->query($sq4);
									$row4 = $result4->fetch_assoc();
									$row4=$row4['MA'];
									if ($row4==null){
										$row4=0;
									}
									$row4 = $row4['MA'] + 1;

									$sq3 = 'SELECT MAX(PNR_no) AS MA FROM BOOKING';
									$result3 = $mysqli->query($sq3);
									$row3 = $result3->fetch_assoc();
									$row3=$row3['MA'];
									if ($row3==null){
										$row3=0;
									}
									$row3 = $row3 + 1;

									$sq3='INSERT INTO BOOKING values('.$row3.','.$username.','.$name.','.$age.','.$dob.','.$gen.','.$ins.','.$Train_no.','.$coach.','.$source.','.$dest.','.$date.',WL);';
									$mysqli->query($sq3);

									$sq3 = 'INSERT INTO OVERALL_WAITING values('.$row3.', '.$Train_no.', '.$date.', '.$coach.', '.$row4.');';
									$mysqli->query($sq3);
								}
						}
						echo "<script type='text/javascript'>alert('PNR number is $row3');</script>";

						?>
						
						<form action="pnr.php?username=<?php echo $username;?>" method="post">
							<div class="form-btn">
								<button class="submit-btn">Go check the status with PNR</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->


</html>
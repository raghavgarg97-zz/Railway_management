<?php
include_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V05</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="img/train_list_images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/train_list_vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/train_list_fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/train_list_vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/train_list_vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/train_list_vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/train_list_css/util.css">
	<link rel="stylesheet" type="text/css" href="styles/train_list_css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1">
				<table id="table1">
								<thead>
									<tr class="row100 head">
										<th class="cell100 column2">Confirmation Status</th>
										<th class="cell100 column3">Train name</th>
										<th class="cell100 column4">Source Station</th>
										<th class="cell100 column5">Destination station</th>
										<th class="cell100 column6">Coach Type</th>
										<th class="cell100 column7">Date</th>

									</tr>
								</thead>
								<tbody>
								<?php
										
										// $username=$_GET['username'];
										// $source=$_POST[''];
										// $destination=$_POST[''];
										// $coach=$_POST[''];
										// $date=$_POST[''];
										$PNR = $_POST['PNR'];
										$sq='SELECT * FROM BOOKING WHERE PNR_no='.$PNR.';';
										$result=$mysqli->query($sq);
										$row = $result->fetch_assoc();
										$Train_no=$row['Train_no'];
										$source_no=$row['Source_station_no'];
										$dest_no=$row['Destination_station_no'];
										$date=$row['Boarding_Date'];
										$coach=$row['Coach_Type'];
										$status=$row['Booking_Status'];

										$sq = 'SELECT * FROM OVERALL_WAITING WHERE Train_no = '.$Train_no.' AND Dates = '.$date.'AND Coach_Type = '.$coach.' AND PNR_no='.$PNR.';';
										$result = $mysqli->query($sq);
										$row = $result->fetch_assoc();
										$WL = $row['Wl_no'];
										if($status == "CNF"){
											echo "<script type='text/javascript'>alert('Your booking is confirmed');</script>";
										}
										else{
											echo "<script type='text/javascript'>alert('Your waiting list number is $WL');</script>";
										}

										// $dt = strtotime($date);
										// $day = date("D", $dt);

										// $sq = 'SELECT DISTINCT T.Train_no from 
										// (SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Saturday_avail=true)T ,
										// (SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Saturday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// $result = $mysqli->query($sq);				
										
										// while ($row = $result->fetch_assoc()){
										//     $c=$c+1;
										//     echo '<tr class="row100 head">';
										// 	echo '<td class="cell100 column2">'.$row["Train_no"].'</th>';
										// 	echo '<td><input type = "radio" id="id1" name = "select" value = "1" required onclick="getAllData('.$c.')"></td>';
										// 	echo '</tr>';
										// }
								?>
								</tbody>
							</table>
						
				</div>
			</div>
		</div>
	</div>

<!-- <script type="text/javascript">
   function getAllData(id_value){
   var table = document.getElementById("table1");
   Train_no = table.rows[id_value].cells[0].innerHTML;                
   Train_name = table.rows[id_value].cells[1].innerHTML;
    alert("You are being redirected......");
    // ALso edit this link
  window.location.href="../booking_data.php?Train_no="+Train_no+"&Train_name="+Train_name;
   }
</script> -->
<!--===============================================================================================-->	
	<script src="styles/train_list_vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	 <script src="styles/train_list_vendor/bootstrap/js/popper.js"></script>
	<script src="styles/train_list_vendor/bootstrap/js/bootstrap.min.js"></script>
 <!-- =============================================================================================== -->
	 <script src="styles/train_list_vendor/select2/select2.min.js"></script> 
<!--===============================================================================================-->
	<script src="styles/train_list_vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})

			$(this).on('ps-x-reach-start', function(){
				$(this).parent().find('.table100-firstcol').removeClass('shadow-table100-firstcol');
			});

			$(this).on('ps-scroll-x', function(){
				$(this).parent().find('.table100-firstcol').addClass('shadow-table100-firstcol');
			});

		});
	</script>
<!--===============================================================================================-->
	<script src="js/train_list_js/main.js"></script>

</body>
</html>
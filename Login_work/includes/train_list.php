<?php
include_once 'db_connect.php';

function find_min_seats($train_no,$source_no,$dest_no,$date,$coach,$mysqli){
	$sq='Select Station_no from  RAILWAY_PATH where Train_no='.$train_no.' and Sequence_number BETWEEN '.$source_no.' and '.($dest_no-1).';';
	$result = $mysqli->query($sq);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V05</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../img/train_list_images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../styles/train_list_vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../styles/train_list_fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../styles/train_list_vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../styles/train_list_vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../styles/train_list_vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../styles/train_list_css/util.css">
	<link rel="stylesheet" type="text/css" href="../styles/train_list_css/main.css">
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
										<th class="cell100 column2">Train_no</th>
										<th class="cell100 column3">Train_name</th>
										<th class="cell100 column4">Source_Station</th>
										<th class="cell100 column5">Destination_station</th>
										<th class="cell100 column6">Total Seats Available</th>
										<th class="cell100 column6">Distance</th>
										<th class="cell100 column6">Dept_time</th>
										<th class="cell100 column6">Arr_time</th>
										<th class="cell100 column6">Price</th>
									</tr>
								</thead>
								<tbody>
								<?php
										
											$username=$_GET['username'];
											$source=$_POST['sel1'];
											$destination=$_POST['sel2'];
											$coach=$_POST['sel3'];
											$date=$_POST['date'];
										$dt = strtotime($date);
										$day = date("D", $dt);
										$sq='SELECT DISTINCT T.Train_no as Train_num,Train_name ,date_format(date_add("'.$date.'",interval -T.Day_offset day), "%W") AS day,date_add("'.$date.'",interval -T.Day_offset day) as date,T.Sequence_number as source_no,S.Sequence_number as dest_no,
										S.Distance-T.Distance as Distance,T.Departure_time as Dept_time,S.Arrival_time as Arr_time FROM 
										(SELECT Train_no,Sequence_number,Day_offset,Distance,Departure_time from RAILWAY_PATH,STATIONS where Station_name="'.$source.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)T,(
										SELECT Train_no,Sequence_number,Day_offset,Distance,Arrival_time from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)S,TRAIN_INFO where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number and T.Train_no=TRAIN_INFO.Train_no;';

											$result = $mysqli->query($sq);
											$c=0;

											 while ($row = $result->fetch_assoc()){
											 	$train_no=$row["Train_num"];
											 	$train_name=$row["Train_name"];
											 	$day=$row["day"];
											 	$date=$row["date"];
											 	$source_no=$row["source_no"];
											 	$dest_no=$row["dest_no"];
											 	$Distance=$row["Distance"];
											 	$time1=$row["Dept_time"];
											 	$time2=$row["Arr_time"];

											 	$sq2='SELECT '.$day.'_avail from TRAIN_INFO where Train_no='.$train_no.';';
											 	$result2 = $mysqli->query($sq2);
											 	$row2 = $result2->fetch_assoc();
											 	
											 	if ($row2["$day_avail"]=true){
											 		$sq3='SELECT price from TRAIN_SCHEDULE where Train_no='.$train_no.' and Coach_Type="'.$coach.'";';
												 	$result3 = $mysqli->query($sq3);
												 	$row3 = $result3->fetch_assoc();
												 	$seats=find_min_seats($train_no,$source_no,$dest_no,$date,$coach,$mysqli);
												 	if ($seats == false){
												 		echo "<script type='text/javascript'>alert('No such Coach for given Train');</script>";
												 	}elseif($seats<0){
												 		//Upadte $seats to show Waiting list no' for train
												 	}else{
												 	$c=$c+1;
												    echo '<tr class="row100 head">';
													echo '<td class="cell100 column2">'.$train_no.'</th>';
													echo '<td class="cell100 column2">'.$train_name.'</th>';
													echo '<td class="cell100 column2">'.$source.'</th>';
													echo '<td class="cell100 column2">'.$destination.'</th>';
													echo '<td class="cell100 column2">'.$seats.'</th>';
													echo '<td class="cell100 column2">'.$Distance.'</th>';
													echo '<td class="cell100 column2">'.$time1.'</th>';
													echo '<td class="cell100 column2">'.$time2.'</th>';
													echo '<td class="cell100 column2">'.($Distance*$row3["price"]).'</th>';
													/*echo '<td><input type = "radio" id="id1" name = "select" value = "1" required onclick="getAllData('.$c.')"></td>';*/
													echo '<td><input type = "radio" id="id1" name = "select" value = "1" required onclick="getAllData('.$c.',\''.$username.'\',\''.$source.'\',\''.$destination.'\',\''.$date.'\')"></td>';
													echo '</tr>';
													}
													}

											 	}
							
								?>
								</tbody>
							</table>
						
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
   
   function getAllData(id_value,user_name,source,destination,date){
   	//alert(id_value);
   var table = document.getElementById("table1");
   Train_no = table.rows[id_value].cells[0].innerHTML;                
   Train_name = table.rows[id_value].cells[1].innerHTML;
    alert("You are being redirected......");
    // ALso edit this link
      window.location.href="../booking_data.php?Train_no="+Train_no+"&Train_name="+Train_name+"&username="+user_name+"&source="+source+"&destination="+destination+"&date="+date;

   }
</script>
<!--===============================================================================================-->	
	<script src="../styles/train_list_vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../styles/train_list_vendor/bootstrap/js/popper.js"></script>
	<script src="../styles/train_list_vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../styles/train_list_vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../styles/train_list_vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
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
	<script src="../js/train_list_js/main.js"></script>

</body>
</html>
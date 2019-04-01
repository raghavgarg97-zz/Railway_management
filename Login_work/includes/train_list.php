<?php
include_once 'db_connect.php';
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
										<th class="cell100 column6">Distance</th>
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
										$sq='SELECT DISTINCT T.Train_no as Train_num,date_format(date_add("'.$date.'",interval -T.Day_offset day), "%W") AS day FROM 
										(SELECT Train_no,Sequence_number,Day_offset from RAILWAY_PATH,STATIONS where Station_name="'.$source.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)T,(
										SELECT Train_no,Sequence_number,Day_offset from RAILWAY_PATH,STATIONS where
										Station_name="'.$destination.'"  and RAILWAY_PATH.Station_no=STATIONS.Station_no)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';

											$result = $mysqli->query($sq);

											 while ($row = $result->fetch_assoc()){
											 	$train_no=$row["Train_num"];
											 	$day=$row["day"];

											 	$sq='SELECT '.$day.'_avail from TRAIN_INFO where Train_no='.$train_no.';';
											 	$result2 = $mysqli->query($sq);
											 	$row2 = $result2->fetch_assoc();
											 	
											 	if ($row2["$day_avail"]=true){
											 		
											 		
											 	}
											 }
										
										

										// if (strtoupper($day) == "SAT"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Saturday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Saturday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);				
											
										//     }
										//     if (strtoupper($day) == "SUN"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Sunday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Sunday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);				
											
										//     }
										//     if (strtoupper($day) == "MON"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Monday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Monday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);				
											
										//     }
										//     if (strtoupper($day) == "TUE"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Tuesday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Tuesday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);				
											
										//     }
										//     if (strtoupper($day) == "WED"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Wednesday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Wednesday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);				
											
										//     }
										//     if (strtoupper($day) == "THU"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Thursday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Thursday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);				
											
										//     }
										//     if (strtoupper($day) == "FRI"){
										// 	$sq = 'SELECT DISTINCT T.Train_no from 
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$source.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no  and Friday_avail=true)T ,
										// 	(SELECT Train_no,Sequence_number from RAILWAY_PATH,STATIONS where Station_name="'.$destination.'" and RAILWAY_PATH.Station_no=STATIONS.Station_no and Friday_avail=true)S where T.Train_no=S.Train_no and T.Sequence_number <S.Sequence_number;';
										// 	$result = $mysqli->query($sq);		
											
											
										//     }
										 //    while ($row = $result->fetch_assoc()){
										 //    $c=$c+1;
										 //    echo '<tr class="row100 head">';
											// echo '<td class="cell100 column2">'.$row["Train_no"].'</th>';
											// echo '<td><input type = "radio" id="id1" name = "select" value = "1" required onclick="getAllData('.$c.')"></td>';
											// echo '</tr>';

											// }
								?>
								</tbody>
							</table>
						
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
   function getAllData(id_value){
   var table = document.getElementById("table1");
   Train_no = table.rows[id_value].cells[0].innerHTML;                
   Train_name = table.rows[id_value].cells[1].innerHTML;
    alert("You are being redirected......");
    // ALso edit this link
  window.location.href="../booking_data.php?Train_no="+Train_no+"&Train_name="+Train_name;
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
<?php
include_once './includes/db_connect.php';
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
								<!-- <thead>
									<tr class="row100 head">
										<th class="cell100 column2">Train_no</th>
										<th class="cell100 column3">Train_name</th>
										<th class="cell100 column4">Source_Station</th>
										<th class="cell100 column5">Destination_station</th>
										<th class="cell100 column6">Total Seats Available</th>
										<th class="cell100 column6">Distance</th>
										<th class="cell100 column6">Price</th>
									</tr>
								</thead> -->
								<tbody>
								<!-- Need to make dynamic table here -->
								<?php
										$table_header = '<thead> <tr class = "row100 head">';
										$table_body = '';
										$table_footer = '</tr> </thead>';
										$idx = 2;

										$sq = $_POST["general_query"];
										$sq = 'SELECT * FROM STATIONS;';

										$result = $mysqli->query($sq);

										$temp_row = $result->fetch_assoc();
										foreach ($temp_row as $key => $value) {
												$temp = '<th class = "cell 100 column">'.$idx.'>'.$key.'</th>';
												$idx = $idx + 1;
												$table_body = $table_body.$temp;
											}
										
										$table = $table_header.$table_body.$table_footer;
										echo $table;	

										
										while ($row = $result->fetch_assoc()){
											echo '<tr class="row100 head">';
										 	foreach ($row as $key => $value) {
												echo '<td class = "cell100 column"'.$c.'>'.$value.'</th>';
											}
											echo '</tr>';
										}
										
							
								?>
								</tbody>
							</table>
						
				</div>
			</div>
		</div>
	</div>

<!-- <script type="text/javascript">
   
   function getAllData(id_value,user_name,source,destination,date){
   	//alert(id_value);
   var table = document.getElementById("table1");
   Train_no = table.rows[id_value].cells[0].innerHTML;                
   Train_name = table.rows[id_value].cells[1].innerHTML;
    alert("You are being redirected......");
    // ALso edit this link
      window.location.href="../booking_data.php?Train_no="+Train_no+"&Train_name="+Train_name+"&username="+user_name+"&source="+source+"&destination="+destination+"&date="+date;

   }
</script> -->
<!--===============================================================================================-->	
	<script src="/styles/train_list_vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/styles/train_list_vendor/bootstrap/js/popper.js"></script>
	<script src="/styles/train_list_vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/styles/train_list_vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/styles/train_list_vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
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
	<script src="/js/train_list_js/main.js"></script>

</body>
</html>
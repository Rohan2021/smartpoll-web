<?php
	session_start();
	include_once("api.php");
	if($_SESSION['login'] != true){
		header('location:index.php');
		exit();
	}
	$udetail = getUserDetail($_SESSION['username']);
	$name = explode(" ",$udetail[0]['fullname']);
	$email = $udetail[0]['email'];
	$id = $udetail[0]['uID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Smartpolling | Web</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="res/bs/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="res/css/custom.css"></link>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito|Righteous" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">
		<div class="header row">
			<div class="col-lg-5 col-md-5 col-sm-5"><i class="glyphicon glyphicon-user"></i>&nbsp;<b><?php echo $name[0];?></b></div>
			<div class="col-lg-7 col-md-7 col-sm-7 logout-btn text-right">
				<a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a>
			</div>
		</div><br>
	</div>
	<div class="container">
		<div class="main" style="padding: 20px 50px 50px 50px!important;">
			<div class="well well-sm"><a href="home.php" style="text-decoration: none;">Home</a>	/	History</div>
			<span style="font-size: 20px;"><i class="glyphicon glyphicon-th"></i>&nbsp<b>Your Polling History</b></span>
			<hr>
			<table class="table table-hover">
				<thead>
					<tr>
					<th>Presentation Name</th>
					<th class="text-center">Creation Date</th>
					<th class="text-center">Poll Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$presentation = getRecentPresentaion($id,50);
						if(empty($presentation)){
						?>
						<div class="alert alert-danger">
							There is no recent polling
						</div>
					<?php	}
						else
						foreach ($presentation as $key) {
							echo "<tr>";
							echo "<td><a href='presentation.php?a=".$key['pID']."'>".$key['p_name']."</a></td>";
							echo "<td class='text-center'>".$key['day']."/".$key['month']."/".$key['year']."</td>";
							if($key['status'] == 1){
								echo "<td class='text-center'><b style='color:green;'>Running</b></td>";
							}
							else{
								echo "<td class='text-center'><b style='color:#d21919;'>Stopped</b></td>";
							}
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php 
		include('footer.php');
	?>
	<script type="text/javascript" src="res/bs/js/jquery.min.js"></script>
	<script type="text/javascript" src="res/bs/js/bootstrap.min.js"></script>
</body>
</html>
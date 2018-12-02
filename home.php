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
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5"><i class="glyphicon glyphicon-user"></i>&nbsp;<b><?php echo $name[0];?></b></div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs logout-btn text-right">
				<a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a>
			</div>
		</div>
		<div class="main">
			<div class="dash row text-center">
				<div class="col-lg-4">
					<a href="createpolling.php"><div class="dash-btn"><i class="glyphicon glyphicon-plus btn-ico"></i><br>Create Polling</div></a>
				</div>
				<div class="col-lg-4">
					<a href="history.php"><div class="dash-btn"><i class="glyphicon glyphicon-th btn-ico"></i><br>Your History</div></a>
				</div>
				<div class="col-lg-4">
					<a href="accountsetting.php"><div class="dash-btn"><i class="glyphicon glyphicon-cog btn-ico"></i><br>Setting</div></a>
				</div>
			</div>
			<div class="recent row">
				<h4>Your Recent Polling</h4>
				<br>
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
							$presentation = getRecentPresentaion($id,4);
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
									echo "<td class='text-center'><b style='color:red;'>Stopped</b></td>";
								}
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php 
		include('footer.php');
	?>
	<script type="text/javascript" src="res/bs/js/jquery.min.js"></script>
	<script type="text/javascript" src="res/bs/js/bootstrap.min.js"></script>
</body>
</html>
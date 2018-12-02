<?php
	$page_name = "Home";
	session_start();
	include_once("api.php");
	if(isset($_SESSION['login'])){
		if($_SESSION['login']){
			header('location:home.php');
			exit();
		}
	}
	if(isset($_POST['login'])){	
		$login_username = $_POST['user'];
		$login_pass = md5($_POST['pass']);	 
		if(checkUser($login_username,$login_pass)){
			$_SESSION['username'] = $_POST['user'];
			$_SESSION['login'] = true;
			header('location:home.php');
			exit();
		}
		else{
			$ERROR_MSG = "Wrong username or password";
		}
	}

	if(isset($_SESSION['login_msg'])){
		$login_msg = $_SESSION['login_msg'];
		unset($_SESSION['login_msg']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Smart Poll | <?php echo $page_name;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="res/bs/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="res/css/custom.css"></link>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito|Righteous" rel="stylesheet">
</head>
<body>
	<?php 
		include('header.php');
	?>
	<div class="container">
		<div class="main row">
			<div class="col-lg-7 text-center">
				<img src="res/img/logo.png" width="250" height="250"><br>
				<h4><b>tried, <span style='color:#165669;'>Smart</span>Polling ?</b></h4>
			</div>
			<div class="col-lg-5">
				<form class="form-login text-center" action="" method="post">
					<h3><i class="glyphicon glyphicon-user"></i><b>User Login</b></h3><br>
					<input type="text" name="user" placeholder="Email Id"><br>
					<input type="password" name="pass" placeholder="Password">
					<input type="submit" class="btn btn-primary" name="login" value="Login"><br>
					<span>need an account?<a href="register.php"> click here</a></span>
					<?php
						if(isset($ERROR_MSG)){
							echo "<div class='alert alert-danger text-center' style='margin-top: 10px;'>";
				  			echo "<strong>Error!</strong> ".$ERROR_MSG."</div>";
						}
					?>
					<?php
						if(isset($login_msg)){
					?>
						<div class="alert alert-success">
							<?php echo $login_msg;?>
						</div>
					<?php
						}
					?>

				</form>
			</div>
		</div>
		<div class="row features" style="padding: 50px 0px;">
			<div class="col-md-12 text-center" style="padding-bottom: 20px;">
				<h1>
					Our App Features
				</h1>
			</div>
			<div class="col-md-4 col-sm-12 text-center" style="font-size: 17px">
				<i class="fa fa-television" style="font-size: 35px;padding-bottom: 10px"></i><br>
				Get Real Time Update
			</div>
			<div class="col-md-4 col-sm-12 text-center" style="font-size: 17px">
				<i class="fa fa-users" style="font-size: 35px;padding-bottom: 10px"></i><br>
				Free Polling in large group of people
			</div>
			<div class="col-md-4 col-sm-12 text-center" style="font-size: 17px">
				<i class="fa fa-history" style="font-size: 35px;padding-bottom: 10px"></i><br>
				Manage you all poll history
			</div>
		</div>
	</div>
	<?php 
		include('footer.php');
	?>
	<script type="text/javascript" src="res/bs/js/jquery.min.js"></script>
	<script type="text/javascript" src="res/bs/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="res/btn-cstm.js"></script>
</body>
</html>
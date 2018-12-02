<?php
	session_start();
	include_once("api.php");
	if(isset($_SESSION['login'])){
		if($_SESSION['login'] == true){
			header('location:home.php');
			exit();
		}
	}
	if(isset($_POST['signup'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$name = $_POST['fname'];
		$actype = "SP";
		if($password == $repassword){
			$registe = registerUser($email,md5($password),$name,$actype);
			$_SESSION['login_msg'] = "You have successfully signup.";
			header('location:index.php');
			exit();
		}
		else{
			$ERROR_MSG = 'Password not match';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mobpolling | Web</title>
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
	<div class="container-fluid">
		<div class="main row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 login-form text-center">
				<form action="" method="post" style='border: 1px solid #9a9a9a; padding: 20px 50px 30px 50px;'>
					<h3><b><i class="glyphicon glyphicon-list-alt"></i>&nbsp;User Registration</b></h3>
					<input type="email" placeholder="Email"" name="email" required="true" /><br><br>
					<input type="password" placeholder="Password" name="password" required="true" /><br><br>
					<input type="password" placeholder="Confirm Password" name="repassword" required="true" /><br><br>
					<input type="text" placeholder="Full Name" name="fname" required="true" /><br><br>
					<?php
						if(isset($ERROR_MSG)){
							echo "<div class='alert alert-danger text-center' style='margin-top: 10px;'>";
				  			echo "<strong>Error!</strong> ".$ERROR_MSG."</div>";
						}
					?>
					<input type="submit" value="Signup" name="signup">
				</form>
				<br>
				<span class="text-center">Already have an account?<a href="index.php" class="signup"> Log in!</a></span><br><br>
			</div>
			<div class="col-lg-3"></div>
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
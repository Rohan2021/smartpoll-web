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

	if(isset($_POST['changename'])){
		$cname = $_POST['name'];
		if(empty($cname)){
			$err_msg = "New Name is required.";
		} else {
			$db->execute("UPDATE user SET fullname = '".$cname."' where uID = '".$id."'");
			$_SESSION['login_msg'] = "Your name is updated.Please login again.";
			header("location:logout.php");
			exit();
		}

	}
	if(isset($_POST['changepass'])){
		$pass = $_POST['pass'];
		$repass = $_POST['repass'];
		if(empty($pass)){
			$err_msg2 = "New Password field is required";
		} else if(empty($repass)){
			$err_msg2 = "Re-enter Password field is required";
		} else if($pass != $repass){
			$err_msg2 = "Password not match";
		} else {
			$db->execute("UPDATE user SET password = '".md5($pass)."' where uID = '".$id."'");
			$_SESSION['login_msg'] = "Your name is updated.Please login again.";
			header("location:logout.php");
			exit();
		}

	}
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
		</div>
	</div>
	<div class="container">
		<div class="main">	
			<div class="well well-sm"><a href="home.php" style="text-decoration: none;">Home</a>	/	Account Setting</div>
			<form class="acc-form" action="" method="post">
				<label>Change your profile name</label><br>
				<?php
					if(isset($err_msg)){
				?>
				<div class="alert alert-danger">
					<?php echo $err_msg;?>
				</div>
				<?php
					}
				?>
				<input class="accin" type="text" name="name" placeholder="New name" value="<?php echo $name[0]." ".$name[1];?>">
				<button class="btn btn-primary" type="submit" name="changename">Change</button>
			</form><hr>
			<form class="acc-form" action="" method="post">
				<label>Change your password</label><br>
				<?php
					if(isset($err_msg2)){
				?>
				<div class="alert alert-danger">
					<?php echo $err_msg2; ?>
				</div>
				<?php
					}
				?>
				<input class="accin" type="password" name="pass" placeholder="New password">
				<input class="accin" type="password" name="repass" placeholder="Re-enter password">
				<button class="btn btn-primary" type="submit" name="changepass">Change</button>
			</form>		
		</div>
	</div>
	<?php 
		include('footer.php');
	?>
	<script type="text/javascript" src="res/bs/js/jquery.min.js"></script>
	<script type="text/javascript" src="res/bs/js/bootstrap.min.js"></script>
</body>
</html>
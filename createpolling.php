<?php
ini_set('display_errors', 1);
error_reporting(-1);
?>

<?php
	session_start();
	include_once("api.php");
	if($_SESSION['login']!= true){
		header('location:index.php');
		exit();
	}
	$udetail = getUserDetail($_SESSION['username']);
	$name = explode(" ",$udetail[0]['fullname']);
	$email = $udetail[0]['email'];
	$id = $udetail[0]['uID'];

	if(isset($_POST['submit_polling'])){
		$day = (int)date('d');
		$month = (int)date('m'); 
		$year = (int)date('y');
		$status = 1;
		$pcode = getCode();
		$optiontype = $_POST['optiontype'];
		$flag = True;
		$pid = "";
		//Create Secrate code
		if(empty($_POST['p_name'])){
			$ERROR_MSG_PRES = "Presentation name feild is empty.";
		}
		else if(empty($_POST['qus'])){
			$ERROR_MSG_PRES = "Question feild is empty.";
		}
		else if($optiontype == "null"){
			$ERROR_MSG_PRES = "Select option type.";
		}
		else{
			$pres = savePresentation($_POST['qus'],$id,$day,$month,$year,$status,$_POST['p_name'],$pcode,$optiontype);
			if($pres==true){
				$pid = getPid();
				// $pid[0]['LAST_INSERT_ID()']
				$iter = (int)$_POST['default'];
				for($i = 1; $i<=$iter ; $i++ ){
					if($optiontype == '0'){
						$value = "option".$i;
						if(empty($_POST[$value])){
							$ERROR_MSG_PRES = $value." feild is empty.";
							$flag = false;
							break;
						}
						else{
							$res_op = saveOptions($_POST[$value],$pid[0]['LAST_INSERT_ID()'],"NULL");
						}
					} else if($optiontype == '1'){
						$value = "option".$i;
						$value2 = "video".$i;
						if(empty($_POST[$value])){
							$ERROR_MSG_PRES = "option".$value." feild is empty.";
							$flag = false;
							break;
						} else if(empty($_POST[$value2])){
							$ERROR_MSG_PRES = "Video embedde link ".$value2." feild is empty.";
							$flag = false;
							break;
						} else{
							$res_op = saveOptions($_POST[$value],$pid[0]['LAST_INSERT_ID()'],$_POST[$value2]);
						}
					} else if($optiontype == '2'){
						$value = "option".$i;
						$value2 = "image".$i;
						$target_dir = "res/img/poll-image/";
						$file_name = basename($_FILES[$value2]["name"]);
						$imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
						$newname = time().".".$imageFileType;

						if(empty($_POST[$value])){
							$ERROR_MSG_PRES = "option".$value." feild is empty.";
							$flag = false;
							break;
						} else if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
						    $ERROR_MSG_PRES = "Sorry, only JPG or JPEG files are allowed.";
						    $flag = false;
							break;
						}
						else{
							if (move_uploaded_file($_FILES[$value2]["tmp_name"], $target_dir.$newname)) {
								$res_op = saveOptions($_POST[$value],$pid[0]['LAST_INSERT_ID()'],$newname);
							}
							else{
								$ERROR_MSG_PRES = "Image not uploding, please try again.";
								$flag = false;
								break;
							}
						}
					}
					
				}
			}
			else{
				$ERROR_MSG_PRES = "Presentation Not Created, Please Try Again.";
				$flag = false;
			}

			if($flag){
				header("location:presentation.php?a=".$pid[0]['LAST_INSERT_ID()']);
			}
			
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
		<div class="well well-sm"><a href="home.php" style="text-decoration: none;">Home</a>	/	Make a Poll</div>
		<div class="main" style="padding: 20px 50px 50px 50px!important;">
			<span style="font-size: 20px;"><i class="fa fa-bar-chart"></i>&nbsp<b>Make a Polling</b></span>
			<br><br><br>
			<?php
				if(isset($ERROR_MSG_PRES)){
					?>
					<div class="alert alert-danger">
						<?php echo $ERROR_MSG_PRES; ?>
					</div>
					<?php
				}
			?>
			<form class="poll" method='post' action="" enctype="multipart/form-data">
				Enter title of poll<br>
				<input type="text" name="p_name" placeholder="Presentation Name" required=""><br>
				<br>Question / Description of poll<br>
				<textarea name="qus" placeholder="Your Question..." rows="3" cols="150" required=""></textarea><br>
				Select Option Type&nbsp;&nbsp;&nbsp;
				<select id="selectOptionType" name="optiontype" required="">
					<option value="null" selected="true">Select Type</option>
					<option value="0">Text</option>
					<option value="1">Video</option>
					<option value="2">Image</option>
				</select><br><hr>
				Enter Options<br>
				<div id="option">
					<input type="text" name="option1" placeholder="option1" required=""><br>
					<input type="text" name="option2" placeholder="option2" required=""><br>
				</div>
				
				<div id="addmoreoption">
					<input type="text" name="default" value="2" hidden="">
				</div>
				<br>
				<input type="submit" class="btn" name="submit_polling" value="Make Polling"><br><br>
			</form>
			<button onclick="addOption()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add More Option</button><i class="text-danger" id="maxoption"></i>
		</div> 
	</div>
	<?php 
		include('footer.php');
	?>
	<script type="text/javascript" src="res/bs/js/jquery.min.js"></script>
	<script type="text/javascript" src="res/bs/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		var count = 0;
		var name = [3456789];
		var max = 0;
		var type = null;
		var options = null;

		$('#selectOptionType').on('change',function(){
			type = this.value
			if(type == 0){
				max = 8;
				var val = max+1;
				$('#maxoption').html(
					'(Max option is '+val+')'
					);
				$('#option').html(
					"<input type='text' name='option1' placeholder='option1' required=''><br><input type='text' name='option2' placeholder='option2' required=''>&nbsp;<br>"
					);
				$('#addmoreoption').html('<input type="text" name="default" value="2" hidden="">');
				options = "";
				count = 0;

				
			} else if(type == 1){
				max = 3;
				var val = max +1
				$('#maxoption').html(
					'(Max Video option is '+val+')'
					);

				$('#option').html(
					"<input type='text' name='option1' placeholder='Video option1' required=''>&nbsp;<input type='text' name='video1' placeholder='Embedded Link' required=''><br><input type='text' name='option2' placeholder='Video  option2' required=''>&nbsp;<input type='text' name='video2' placeholder='Embedded Link' required=''><br>"
					);
				$('#addmoreoption').html('<input type="text" name="default" value="2" hidden="">');
				options = "";
				count = 0;
			} else if( type == 2 ){
				max = 3;
				var val = max+1;
				$('#maxoption').html(
					'(Max Image option is '+val+')'
					);
				$('#option').html(
					"<input type='text' name='option1' placeholder='Image option1' required=''>&nbsp;"
					+"<input type='file' name='image1' required=''><br>"
					+"<input type='text' name='option2' placeholder='Image option2' required=''>&nbsp;"
					+"<input type='file' name='image2' required=''><br>"
					);
				$('#addmoreoption').html('<input type="text" name="default" value="2" hidden="">');
				options = "";
				count = 0;
			}
		});
		function addOption(){
			count += 1;
			setOption(count);
		}
		function removeOption(){
			count -= 1;
			setOption(count);
		}
		function setOption(c){
			options = "";
			
			for(var i = 0 ; i < c ; i++){
				if(c < max){
					if(type == 0){
						options += "<input type='text' name='option"+name[i]+"' placeholder='option"+name[i]+"' required=''>&nbsp;&nbsp;"
						+"<i class='glyphicon glyphicon-remove' onclick='removeOption()'></i><br>";
					} else if( type==1 ){
						options += "<input type='text' name='option"+name[i]+"' placeholder='Video option"+name[i]+"' required=''>&nbsp;"
						+"<input type='text' name='video"+name[i]+"' placeholder='Enter Embedded Link' required=''>&nbsp;"
						+"<i class='glyphicon glyphicon-remove' onclick='removeOption()'></i><br>";
					} else if( type==2 ){
						options += "<input type='text' name='option"+name[i]+"' placeholder='Image option"+name[i]+"' required=''><br>"
						+"<input type='file' name='image"+name[i]+"' required=''>&nbsp;"
						+"<i class='glyphicon glyphicon-remove' onclick='removeOption()'></i><br>";
					}
					
				}
				else{
					return;
				}
			}
			newc = c+2
			options +="<input type='text' name='default' value='"+newc+"' hidden=''>"
			$("#addmoreoption").html(options);
		}
	</script>
</body>
</html>
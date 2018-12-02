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
	if(isset($_GET['a'])){
		$_SESSION['pid'] = $_GET['a'];
	}
	$p = getPresentaionOfId($_SESSION['pid'],$id);
	$options = getOptions($_SESSION['pid']);	
	if(isset($_GET['end_p'])){
		updatePresentationStatus($_SESSION['pid']);
		header('location:presentation.php');
		exit();
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
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<style type="text/css">
		iframe{
			width: 100% !important;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="header row">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12"><i class="glyphicon glyphicon-user"></i>&nbsp;<b><?php echo $name[0];?></b></div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 logout-btn text-right">
				<a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a>
			</div>
		</div>
	</div>
	<div class="main container" style="background-color: #ececec;">
		<div class="well well-sm">
			<a href="home.php" style="text-decoration: none;">
				Home
			</a>	/	<?php echo $p[0]['p_name'];?>
		</div>
		<span style="font-size: 20px;">
			<i class="glyphicon glyphicon-blackboard"></i>&nbsp
			<b>
				<?php echo $p[0]['p_name'];?>
			</b>
		</span><br>
		<h2>
			<?php echo $p[0]['question'];?>
		</h2>
		<div class="row option">
			<?php
				for($x = 0; $x < sizeof($options); $x++){
					if($p[0]['option_type'] == "1"){
					?>
					<div class="col-md-3 text-center">
						<?php echo $options[$x]['link'];?><br>
						<h3><?php echo $options[$x]['options'];?></h3>
					</div>
			<?php
					}
					else if($p[0]['option_type'] == "2"){
			?>
					<div class="col-md-3 text-center">
						<img src="res/img/poll-image/<?php echo $options[$x]['link'];?>" class="img-responsive"><br>
						<h3><?php echo $options[$x]['options'];?></h3>
					</div>
			<?php
					}
				}
			?>
		</div>
		<div class="row presentation_box">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 chart">
				<div id="chartContainer" style="height: 430px;"></div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 option" style='height: 430px;'>
				<h4><b>Status</b><?php 
					if($p[0]['status'] == 1){
						echo "<b style='color:green;'>&nbsp;Running</b>";
					}
					else{
						echo "<b style='color:#d21919;'>&nbsp;Stopped</b>";
					}
				?></h4><br>
				<h2>Code <b><?php echo $p[0]['p_code'];?></b></h2>
				<b>Presentation Option</b><hr>
				<div class="text-center btn1" onclick="barView()"><i class="glyphicon glyphicon-stats" style="color: #000;"></i><br>Bar View</div>
				<div class="text-center btn2" onclick="pieView()"><img src="res/img/pie.png" style='height: 15px;'><br>Pie View</div>
				<button class="btn btn-primary" onclick="setFullScr()" style='padding:15px 10px;width:100%;margin-top: 10px;'>Set Full Screen</button>
				<form method="get" action="">
					<?php
						if($p[0]['status'] == 0){
							echo "<button class='btn btn-danger' name='end_p' disabled='' value='aFBydgdF$&FBDH&F^%DKFD%&DFH' style='padding:15px 10px;width:100%;margin-top: 10px;'>End Presentation</button>";
						}
						else{
							echo "<button class='btn btn-danger' name='end_p' value='aFBydgdF$&FBDH&F^%DKFD%&DFH' style='padding:15px 10px;width:100%;margin-top: 10px;'>End Presentation</button>";
						}
					?>
				</form>
			</div>
		</div>
		<div id="demo"></div>
	</div>
		<?php 
			include('footer.php');
		?>
	<script type="text/javascript" src="res/bs/js/jquery.min.js"></script>
	<script type="text/javascript" src="res/bs/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		var code = <?php echo "\"".$p[0]['p_code']."\"";?>;
		
		//enviroment mode
		//var content = httpGet("htttp://smartpolling.000webhostapp.com/app/app_key.php?request="+code);
		
		//development mode
		var content = httpGet("app/app_key.php?request="+code);
		
		var obj = JSON.parse(content);
		var optionlen = Object.keys(obj).length - 1;
		var chartflag = 1
		var datapoints = [];
		var datapoints2 = [];
		var res = [];
		//document.getElementById("demo").innerHTML = JSON.stringify(datapoints);

		function updateValue(){
			datapoints = [];
			datapoints2 = [];
			res = [];
			for(var i = 1; i <= optionlen; i++){
		 		res.push(httpGet("app/app_key.php?result="+obj[i].oID));
			}
			for(var i = 1; i <= optionlen; i++){
				datapoints.push({label:obj[i].options, y:parseInt(res[i-1])});
				datapoints2.push({y:res[i-1],label:obj[i].options});
			}
		}
		updateValue();
		
		barView();
		function barView() {
			var chart = new CanvasJS.Chart("chartContainer",
			{
				title:{
					text: "Result"
				},
				data: [
					{
						type: "column",
						dataPoints: datapoints
					}
				]
			});
			chartflag = 1;
			chart.render();
		}
		function pieView() {
			var chart = new CanvasJS.Chart("chartContainer",
			{
				title:{
					text: obj[0].question
				},
				legend: {
					maxWidth: 350,
					itemWidth: 120
				},
				data: [
					{
					type: "pie",
					showInLegend: true,
					legendText: "{indexLabel}",
					dataPoints: datapoints2
					}
				]
			});
			chartflag=0;
			chart.render();
		}
		function setFullScr(){
			var el = document.documentElement
			, rfs = // for newer Webkit and Firefox
			el.requestFullScreen
			|| el.webkitRequestFullScreen
			|| el.mozRequestFullScreen
			|| el.msRequestFullScreen
			;
			if(typeof rfs!="undefined" && rfs){
				rfs.call(el);
			} 
			else if(typeof window.ActiveXObject!="undefined"){
				// for Internet Explorer
				var wscript = new ActiveXObject("WScript.Shell");
				if (wscript!=null) {
					wscript.SendKeys("{F11}");
				}
			}
		}
		function httpGet(theUrl){
		    var xmlHttp = new XMLHttpRequest();
		    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
		    xmlHttp.send( null );
		    return xmlHttp.responseText;
		}
		setInterval(function(){
			updateValue();
			if(chartflag==1)
				barView();
			else
				pieView();
		},10000);
</script>
</body>
</html>
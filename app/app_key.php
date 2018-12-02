<?php
	//get key from app using url
	//http://localhost/smartpoling.com/app_key?key=30205060
	include_once("../api.php");
	if(isset($_GET['key'])){
		echo checkPCode($_GET['key']);
	}
	if(isset($_GET['request'])){
		echo json_encode(getOptionForApp($_GET['request']));
	}
	if(isset($_GET['result'])){
		$res = getResult($_GET['result']);
		echo $res[0]['count(*)'];
	}
	if(isset($_GET['set_result'])){
		setResult($_GET['set_result']);
	}
?>

<?php
	require("db/config.php");
	require("db/database.php");

	$db = new Database();

	function getUserDetail($uname){
		global $db;
		return $db->query("select * from user where email = '".$uname."'");
	}

	function checkUser($username,$password){
		global $db;
		if($db->query("select * from user where email = '".$username."' and password = '".$password."'")){
			return true;
		}
		else{
			return false;
		}
	}
	function authentication($login){
		if($login==true){
			header('location:home.php');
		}	
		else{
			header('location:index.php');
		}
	}
	function registerUser($email,$password,$name,$atype){
		global $db;
		if($db->execute("INSERT INTO user(email, fullname, password, account_type) VALUES ('".$email."','".$name."','".$password."','".$atype."')")){
			return true;
		}
		else{
			return false;
		}
	}
	function savePresentation($ques,$uid,$day,$month,$year,$s,$pname,$code,$optiontype){
		global $db;
		if($db->execute("INSERT INTO presentation(question, uID, day, month, year, status,p_name,p_code,option_type) VALUES ('".$ques."','".$uid."','".$day."','".$month."','".$year."','".$s."','".$pname."','".$code."','".$optiontype."')")){
			return "ture";
		}
		else{
			return "false";
		}
	}
	function saveOptions($option,$pid,$link){
		global $db;
		if($db->execute("INSERT INTO optionstable(options, pID,link) VALUES ('".$option."','".$pid."','".$link."')")){
			return true;
		}
		else{
			return false;
		}
	}
	function getPid(){
		global $db;
		return $db->query("select LAST_INSERT_ID()");
	}

	function getRecentPresentaion($uid,$lim){
		global $db;
		return $db->query("select * from presentation where uID = '".$uid."' order by pID DESC limit ".$lim."");
	}

	function getPresentaionOfId($id,$uid){
		global $db;
		return $db->query("select * from presentation where pID = '".$id."' and uID = '".$uid."'");
	}

	function updatePresentationStatus($id){
		global $db;
		$db->execute("update presentation set status = 0 where pID = '".$id."'");
	}
	function getOptions($id){
		global $db;
		return $db->query("SELECT oID, options,link FROM optionstable WHERE pID = '".$id."'");
	}
	function checkPCode($code){
		global $db;
		$res = $db->query("select * from presentation where p_code = '".$code."'");
		if($res){
			//return json_encode($res);
			if($res[0]['status']==1){
				return "0";
			}
			else
				return "1";
		}
		else{
			return "2";
		}
		// 0[vote],1[polling_close],2[code unmatch]
	}
	function getOptionForApp($key){
		global $db;
		$p = $db->query("select pID,question from presentation where p_code = '".$key."'");
		$o = $db->query("select oID,options from optionstable where pID = '".$p[0]['pID']."'");
		unset($p[0]['pID']);
		return array_merge($p,$o);
	}
	function getResult($id){
		global $db;
		return $db->query("select count(*) from result where oID ='".$id."'");
	}
	function setResult($id){
		global $db;
		$db->execute("INSERT INTO result (oID) VALUES ('".$id."')");
		echo "true";
	}

	function getCode(){
		$code = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		global $db;
		if( $db->query("select * from presentation where p_code ='".$code."'")){
		    getCode();
		}
		else{
		    return $code;
		}
	}
?>
</p>
 <?php 
	function login(){
		session_start();
		$this->lib_include();
		$api = new Google_Client();
		$api->setApplicationName("InfoTuts");
		$api->setClientId('1041474373386-gmoujcff3d77nudp4j4nhp9kfs6upb7d.apps.googleusercontent.com');
		$api->setClientSecret('f9zK5Br43uMQ87udF0SlwVAn');
		$api->setAccessType('online');
		$api->setScopes(array('https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
		$api->setRedirectUri('http://www.infotuts.com/demo/googlelogin/login.php');
		$service = new Google_PlusService($api);
		$oauth2 = new Google_Oauth2Service($api);
		$api->authenticate();
		$_SESSION['<span id="IL_AD5" class="IL_AD">token</span>'] = $api->getAccessToken();
		if (isset($_SESSION['token'])) {
			$set_asess_token = $api->setAccessToken($_SESSION['token']);
		}
		if ($api->getAccessToken()) {
			$data = $service->people->get('me');
			$user_data = $oauth2->userinfo->get(); 
		}
	}
 ?>
<p style="text-align: justify;">


<?php 



require_once 'vendor/autoload.php';

		$clientID = '502277265797-3v9t3fipp6pd4njmgqq39gmqrmnhovn4.apps.googleusercontent.com';
		$clientSecret = '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'; 
		$redirectUrl = 'http://localhost/google_drive_file_upload_php/index.php';
		//creating client request

		$client = new Google_Client();
		$client->setClientID($clientID);
		$client->setClientSecret($clientSecret);
		$client->setRedirectUri($redirectUrl);
		$client->addScope('profile');
		$client->addScope('email');

		if(isset($_GET['code'])){

			$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
			$client->setAccessToken($token);

			$gauth = new Google_Service_Oauth2($client);
			$google_info = $gauth->userinfo->get();
			$email = $google_info->email;
			$name = $google_info->name;

			echo "Welcome". $name. "You are register using email: ". $email;

		}else{
			echo "<a href = '".$client->createAuthUrl()."'>Login with Google</a>";
		}



 ?>
<?php

session_start();
	
	include("connection.php");
	include("functions.php");

	if($_SERVER['REQUEST_METHOD']=="POST"){

		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name)&& !empty($password) && !is_numeric($user_name)){

			//read from database 
			

			$query = "select * from users where user_name = '$user_name' limit 1";

			//read

		$result =	mysqli_query($con,$query);

			if($result){

				if($result && mysqli_num_rows($result) > 0){

					$user_data = mysqli_fetch_assoc($result);
					if($user_data['password'] === $password){

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: index.php");
						die;

					}
				}
			}
					echo "wrong username or password!";

		}else{
			echo "wrong username or password!";
		}


	}

// using google login

	require_once 'vendor/autoload.php';

		$clientID = '502277265797-3v9t3fipp6pd4njmgqq39gmqrmnhovn4.apps.googleusercontent.com';
		$clientSecret = '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'; 
		$redirectUrl = 'http://localhost/login/login.php';
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

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
</head>
<body>

	<style type="text/css">


		#text{
			height: 25px;
			border-radius: 5px;
			padding: 4px;
			border: solid thin #aaa;
			width: 100%;
		}

		
		#button{

			paddign: 10px;
			width: 100px;
			color: white;
			background-color: purple ;
			border: none;

		}

		#box{
			background-color: #87CEFA;
			margin: auto;
			width: 300px;
			padding: 20px;
		}



	</style>

	<div id ="box">

		<form method="post">

			<div style="font-size: 20px;margin: 10px; color: black;">Login</div>

			<input id="text" type = "text" name= "user_name" placeholder="Email"><br><br>
			
			<input id="text"  type = "password" name= "password" placeholder="Password"><br><br>

			<input id="button"  type = "submit" name= "Login"><br><br>

			<a href="signup.php">Click to Signup</a><br><br>


		</form>
		

	</div>

</body>
</html>
<?php
require("config.php");
//print_r($_POST); exit();
if(empty($_POST['username'])) die("Username required");
if(empty($_POST['password'])) die("Password required");	

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['username'];
$remember_token = $_POST['token'];
$password = md5($password);

//setup query for either email or username log in
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$query = "SELECT 1 FROM users WHERE email = :userName AND password = :password";
		$query_params = array(':userName' => $email, ':password' => $password);
	} else {
		$query = "SELECT 1 FROM users WHERE username = :userName AND password = :password";
		$query_params = array(':userName' => $username, ':password' => $password);
	};  

//server connection
    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error connecting to database!  ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		exit();
    } 
	
//grab the user
	$row = $stmt->fetch();
	//if user
    if($row) {	  
		$query = "SELECT id, username, name, email FROM users WHERE username = :userName OR email = :userName";
		$query_params = array(':userName' => $username);

    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
		
		$outData = array();
		while($row = $stmt->fetch()) {
			$thisOne = $row["id"]; // set id for matching the remember
			$outData[] = $row; // outdata is appending to it // array of rows
		} 
		//if token is !=1 from global, then the remember was clicked - update user
		if ($remember_token != 1) {

			$query = "UPDATE users SET remember_token = :remember_token where id = :id";
			$query_params = array(':remember_token' => $remember_token, ':id' => $thisOne);
			//echo json_encode($outData);

			try { 
			   $stmt = $db->prepare($query); 
			   $result = $stmt->execute($query_params);
		   } catch(PDOException $ex){ 
			   http_response_code(500);
			   echo json_encode(array(
				   'error' => array(	
				   'msg' => 'Error updating user! ' . $ex->getMessage(),
				   'code' => $ex->getCode(),
				   ),
			   ));
			   exit();
		   } 
	   }
		//echo json_encode($outData);
		echo '{"user":' . json_encode($outData) . '}';  // puts in javascript language 

		exit();
		
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on select user: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		
		exit();
	} 
	// if no row is returned, credentials are incorrect
} else {
	if(!$row) { 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(
				'msg' => 'Credentials are incorrect!  ' . 'Try again!  '  . '601'
			),
		));
	}
}
	?>
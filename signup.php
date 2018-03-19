<?php
  require("config.php");

//print_r($_POST); exit();
if(empty($_POST['username'])) die("Username required");
if(empty($_POST['password'])) die("Password required");	
if(empty($_POST['name'])) die("First name required");	
if(empty($_POST['email'])) die("Email required");	
    
	$username = $_POST['username'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$hash = md5($password);
	
	//does username exist already query
    $query = "SELECT 1 FROM users WHERE username = :username";
	$query_params = array(':username' => $username);

	//server connection
    try { 
        $stmt = $db->prepare($query); 
		$result = $stmt->execute($query_params); 
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error connecting to database! ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		exit();
    } 
	
	//does username exist   
    $row = $stmt->fetch(); 
    if($row) { 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(
				'msg' => 'This username is already registered!',
			),
		));
        
        exit();
    } 

	//if username is good to go, insert into database
	$sql = 'INSERT INTO users (name, username, email, raw_password, password) 
	VALUES (:name, :username, :email, :rawPassword, :password)';
	
	$query_params = array(
		':username' => $username, 
		':name' => $name, 
		':email' => $email, 
		':rawPassword' => $password, 		
		':password' => $hash
	); 	
		
	try {  
            $stmt = $db->prepare($sql); 
			$result = $stmt->execute($query_params); 
			
    } catch(PDOException $ex) { 
			http_response_code(500);
			echo json_encode(array(
					'error' => array(
					'msg' => 'Error on insert of new user: ' . $ex->getMessage(),
					'code' => $ex->getCode(),
				),
			));
			exit();
    } 	  

	//grab user again for login
	$query = "SELECT id, username, name, email FROM users WHERE username = :userName";
	$query_params = array(':userName' => $username);

    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
		
		$outData = array();
		while($row = $stmt->fetch()) {
			//take rows and put in array to send
			$outData[] = $row; // 
		} 
		//echo json_encode($outData);
		//send it json home
		echo '{"user":' . json_encode($outData) . '}';  

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

?>
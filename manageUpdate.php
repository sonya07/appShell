<?php
  require("config.php");

//print_r($_POST); exit();
if(empty($_POST['username'])) die("Username required");
if(empty($_POST['name'])) die("Name required");	
if(empty($_POST['email'])) die("Email required");	
    
	$username = $_POST['username'];
	$name = $_POST['name'];
    $email = $_POST['email'];
    $id = $_POST['id'];
	$changeIt = $_POST['changeIt'];

	//if username did not change, just update, return json, load user
	if ($changeIt == "false") {
		$sql = 'UPDATE users SET name = :name, email = :email where id = :id';
		$query_params = array(':id' => $id, ':name'  => $name, ':email' => $email);

		try {  
				$stmt = $db->prepare($sql); 
				$result = $stmt->execute($query_params); 
				
		} catch(PDOException $ex) { 
				http_response_code(500);
				echo json_encode(array(
						'error' => array(
						'msg' => 'Error on update of new user: ' . $ex->getMessage(),
						'code' => $ex->getCode(),
					),
				));
				exit();
		} 
		
		//grab user again for login
		$query = "SELECT id, username, name, email FROM users WHERE id = :id";
		$query_params = array(':id' => $id);
	
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
//if user name changed, run this, check username, then load user
} else if ($changeIt == "true") {

	$query = "SELECT 1 FROM users WHERE username = :username";
	$query_params = array(':username' => $username);
	$stmt = $db->prepare($query); 
	$result = $stmt->execute($query_params); 

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
		$sql = 'UPDATE users SET name = :name, email = :email, username = :username where id = :id';
		$query_params = array(':id' => $id, ':name'  => $name, ':email' => $email, ':username' => $username);

		try {  
				$stmt = $db->prepare($sql); 
				$result = $stmt->execute($query_params); 
				
		} catch(PDOException $ex) { 
				http_response_code(500);
				echo json_encode(array(
						'error' => array(
						'msg' => 'Error on update of new user: ' . $ex->getMessage(),
						'code' => $ex->getCode(),
					),
				));
				exit();
		}
	
		//grab user again for login
		$query = "SELECT id, username, name, email FROM users WHERE id = :id";
		$query_params = array(':id' => $id);
	
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
	}
	?>
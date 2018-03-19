<?php
require("config.php");
//print_r($_POST); exit();
if(empty($_GET['token'])) die("Token required");

$remember_token = $_GET['token'];

	$query = "SELECT 1 FROM users WHERE remember_token = :remember_token";
	$query_params = array(':remember_token' => $remember_token);  

//first try is all about whether or not the php makes to mysql
    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on SELECT checking for dupes: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		exit();
	} 
		  
	$row = $stmt->fetch();

    if($row) {	  
		$query = "SELECT id, username, name, email FROM users WHERE remember_token = :remember_token";
		$query_params = array(':remember_token' => $remember_token); 
    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
		

		$outData = array();
		while($row = $stmt->fetch()) {
			$thisOne = $row["id"]; // set id for matching the remember
			$outData[] = $row; // outdata is appending to it // array of rows
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
}
	?>
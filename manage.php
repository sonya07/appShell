<?php
require("config.php");
//print_r($_POST); exit();
if(empty($_POST['id'])) die("Id required");

$id = $_POST['id'];

	$query = "SELECT id, username, name, email FROM users WHERE id = :id";
	$query_params = array(':id' => $id);

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
			'msg' => 'Error loading user: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		
		exit();
	} 

	?>
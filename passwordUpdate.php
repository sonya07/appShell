<?php
  require("config.php");

//print_r($_POST); exit();
if(empty($_POST['id'])) die("Id required");
    
$id = $_POST['id'];
$currentPassword = $_POST['currentPassword'];
$currentHash = md5($currentPassword);
$newPassword = $_POST['newPassword'];
$newHash = md5($newPassword);

$query = "SELECT 1 FROM users WHERE password = :password";
$query_params = array(':password' => $currentHash);

$stmt = $db->prepare($query); 
$result = $stmt->execute($query_params); 

//password correct?  
$row = $stmt->fetch(); 
if(!$row) { 
    http_response_code(500);
    echo json_encode(array(
        'error' => array(
            'msg' => 'Incorrect password!',
        ),
    ));
} else if($row)  {
    //Update the user passwords
    $sql = 'UPDATE users SET password = :newPassword, raw_password = :rawPassword where
    id = :id and password = :currentPassword';

    $query_params = array(
        ':id' => $id,
        ':rawPassword' => $newPassword, 		
        ':newPassword' => $newHash,
        ':currentPassword' => $currentHash
    ); 	

    $stmt = $db->prepare($sql); 
    $result = $stmt->execute($query_params); 

    //grab user again for login
    $query = "SELECT id FROM users WHERE id = :id";
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
            'msg' => 'Error on load user: ' . $ex->getMessage(),
            'code' => $ex->getCode(),
            ),
        ));
        
        exit();
    }
}
?>
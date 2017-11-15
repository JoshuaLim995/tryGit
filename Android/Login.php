<?php 

require_once 'DbConnect.php';

$response = array();

if(isset($_GET['apicall']) == "login"){

	if(isTheseParametersAvailable(array('Name', 'Password'))){

		$Name = $_POST['Name'];
//		$Password = md5($_POST['Password']); 
		$Password = $_POST['Password']; 

		//LATER WILL HAVE TO ADD MORE
		$stmt = $conn->prepare("SELECT id, Name, regisType FROM users WHERE Name = ? AND Password = ?");
		$stmt->bind_param("ss",$Name, $Password);

		$stmt->execute();

		$stmt->store_result();

		if($stmt->num_rows > 0){

			$stmt->bind_result($id, $username, $regisType);
			$stmt->fetch();

			$user = array(
				'id'=>$id, 
				'Name'=>$username, 
				'regisType'=>$regisType
				);

			$response['error'] = false; 
			$response['message'] = 'Login successfull'; 
			$response['user'] = $user; 
		}else{
			$response['error'] = true; 
			$response['message'] = 'Invalid username or password';
		}
	}
}else{
	$response['error'] = true; 
	$response['message'] = 'Invalid API Call';
}

echo json_encode($response);

function isTheseParametersAvailable($params){

	foreach($params as $param){
		if(!isset($_POST[$param])){
			return false; 
		}
	}
	return true; 
}
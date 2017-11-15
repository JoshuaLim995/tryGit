<?php 

require_once 'DbConnect.php';

$response = array();

if(isset($_GET['apicall']) == "REGISTER"){

//NEED TO CONSIDER ABOUT THE USER ID
	if(isTheseParametersAvailable(array('Name','IC','Gender', 'Birthyear', 'Contact','Address','regisDate','regisType'))){
		$Name = $_POST['Name'];
		$IC = $_POST['IC'];
		$Gender = $_POST['Gender'];
		$Birthyear = $_POST['Birthyear'];	//Birthyear maybe need to change
		$Contact = $_POST['Contact'];
		$Address = $_POST['Address'];
		$regisDate = $_POST['regisDate'];
		$regisType = $_POST['regisType'];
		$Password = md5($_POST['IC']);



		$stmt = $conn->prepare("SELECT id FROM users WHERE IC = ? ");
		$stmt->bind_param("s", $IC);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 0){
			$response['error'] = true;
			$response['message'] = 'User already registered';
			$stmt->close();
		}else{			


			$stmt = $conn->prepare("INSERT INTO users (Name, IC, Gender, Birthyear,Contact, Address, regisDate, regisType, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssss", $Name, $IC, $Gender, $Birthyear, $Contact, $Address, $regisDate, $regisType, $Password);
			$stmt->execute();



			$stmt->close();

			$response['error'] = false; 
			$response['message'] = 'User registered successfully'; 

		}

	}else{
		$response['error'] = true; 
		$response['message'] = 'required parameters are not available'; 
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
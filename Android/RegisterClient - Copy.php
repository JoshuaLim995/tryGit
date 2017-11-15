<?php 

require_once 'DbConnect.php';

$response = array();

if(isset($_GET['apicall']) == "REGISTER"){

//NEED TO CONSIDER ABOUT THE client ID
	if(isTheseParametersAvailable(array('Name','IC','Gender', 'Birthyear', 'Contact','Address','regisDate','regisType', 'Patient_ID'))){
		$Name = $_POST['Name'];
		$IC = $_POST['IC'];
		$Gender = $_POST['Gender'];
		$Birthyear = $_POST['Birthyear'];	//Birthyear maybe need to change
		$Contact = $_POST['Contact'];
		$Address = $_POST['Address'];
		$regisDate = $_POST['regisDate'];
		$regisType = $_POST['regisType'];
		$Password = md5($_POST['IC']);
		$Patient_ID = $_POST['Patient_ID'];



		$stmt = $conn->prepare("SELECT id FROM clients WHERE IC = ? ");
		$stmt->bind_param("s", $IC);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 0){
			$response['error'] = true;
			$response['message'] = 'Client already registered';
			$stmt->close();
		}else{			


			$stmt = $conn->prepare("INSERT INTO clients (Name, IC, Gender, Birthyear,Contact, Address, regisDate, regisType, Password, Patient_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssssss", $Name, $IC, $Gender, $Birthyear, $Contact, $Address, $regisDate, $regisType, $Password, $Patient_ID);
			$stmt->execute();



			$stmt->close();

			$response['error'] = false; 
			$response['message'] = 'Client registered successfully'; 

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
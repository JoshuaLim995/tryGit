<?php 

require_once 'DbConnect.php';

$response = array();

if(isset($_GET['apicall'])){
	
	switch($_GET['apicall']){
		
		case 'signup':
		
		if(isTheseParametersAvailable(array('name','ic','Birthyear','gender','bloodType','address','contact','meals','allergic','sickness','regType','regDate','margin'))){

			$name = $_POST['name'];
			$ic = $_POST['ic'];
			$Birthyear = $_POST['Birthyear'];
			$gender = $_POST['gender'];
			$bloodType = $_POST['bloodType'];
			$address = $_POST['address'];
			$contact = $_POST['contact'];
			$meals = $_POST['meals'];
			$allergic = $_POST['allergic'];
			$sickness = $_POST['sickness'];
			$regType = $_POST['regType'];
			$regDate = $_POST['regDate'];
			$margin = $_POST['margin'];




		$stmt = $conn->prepare("INSERT INTO patients (name, ic, Birthyear, gender, bloodType, address, contact, meals, allergic, sickness, regType, regDate, margin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			$stmt->bind_param("sssssssssssss", $name, $ic, $Birthyear, $gender, $bloodType, $address, $contact, $meals, $allergic, $sickness, $regType, $regDate, $margin);


			if($stmt->execute()){
				$stmt->close();
				$response['error'] = false; 
				$response['message'] = 'User registered successfully'; 
			}

		}else{
			$response['error'] = true; 
			$response['message'] = 'required parameters are not available'; 
		}


		break;
		default: 
		$response['error'] = true; 
		$response['message'] = 'Invalid Operation Called';

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



?>
<?php 

require_once 'DbConnect.php';

$response = array();
$users = array();

// $sql = null;

if(isset($_GET['apicall'])){

	switch ($_GET['apicall']) {
		//TO GET USERS DATA FROM DATABASE
		case 'users':
		$sql = "SELECT ID, Name, IC, Contact, BirthYear, Address, Gender, RegisDate, RegisType FROM users";
		break;

		case 'patients':
		$sql = "SELECT * FROM patients";
		break;

		case 'clients':
			//JOIN Client and Patient tables
		$sql = "SELECT c.ID, c.Name, c.IC, c.Contact, c.BirthYear, c.Address, c.Gender, c.RegisDate, c.RegisType, c.Patient_ID, p.Name FROM clients c, patients p WHERE c.Patient_ID = p.ID";	
	//	$sql = "SELECT ID, Name, IC, Contact, BirthYear, Address, Gender, RegisDate, RegisType, Patient_ID FROM clients";
		break;

		default:
		$sql = null;
		break;
	}

	if($sql != null){
		$result=$conn->query($sql);
		if($result -> num_rows > 0){
			while($e = mysqli_fetch_assoc($result)){
				$output[]=$e;
			}

			echo json_encode($output);
		}
		else{
	//		echo json_encode("No record");
		}
	}
	else{

//		echo json_encode("Invalid Operation Called");
	}



}else{
	//echo json_encode("Invalid Apicall!!");
}


		function isTheseParametersAvailable($params){

			foreach($params as $param){
				if(!isset($_POST[$param])){
					return false; 
				}
			}
			return true; 
		}

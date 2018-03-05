<?php
	require 'Login.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$data = json_decode(file_get_contents("php://input"),true);
		$response = Register::InsertNewData($data["Id"],$data["Password"]);

		if($response){
			echo "The data was entered correctly";
		}
		else{
			echo "Sorry, an error occurred";
		}
	}

?>
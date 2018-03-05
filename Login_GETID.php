<?php
	require 'Login.php';

	if($_SERVER['REQUEST_METHOD']=='GET'){

		if(isset($_GET['Id'])){//if a user exist
			$identify = $_GET['Id'];//identify is a user

			$answer = Register::GetDataById($identify);

			$container = array();

			if($answer){

				$container["Answer"] = "AC"; //AC = answer correct

				$container["data"] = $answer;

				echo json_encode($container);
			}
			else{
				echo json_encode(array('Answer'=>'A user not exist'));
			}
		}
		else{
			echo json_encode(array('Answer'=>'Missing identifier'));
		}

	}



?>
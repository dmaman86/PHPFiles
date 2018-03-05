<?php
	require 'Data.php';

	if($_SERVER['REQUEST_METHOD']=='GET'){

		if(isset($_GET['Id'])){//if a user exist
			$identify = $_GET['Id'];//identify is a user

			$answer = Data::DataGetAll($identify);

			$container = array();

			if($answer){

				$container["result"] = $answer;

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
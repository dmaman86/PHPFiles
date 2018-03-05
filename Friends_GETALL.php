<?php

	require 'Friends.php';//a father is "Login.php"

	if($_SERVER['REQUEST_METHOD']=='GET'){//this function manages all users
		try{
			$identify = $_GET['Id'];
			$Answer = Friends::GetAllUsers('Friends_'.$identify);
			echo json_encode(array('result' => $Answer));
		}catch(PDOException $e){
			echo json_encode(array('result' => 'something wrong, please try again later'));
		}
	}

	/*try and catch because maybe have problems and we need to know*/
	/*if we have a problems we see "an error ocurred......."*/
?>
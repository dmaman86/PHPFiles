<?php

	require 'Login.php';//a father is "Login.php"

	if($_SERVER['REQUEST_METHOD']=='GET'){//this function manages all users
		try{
			$Answer = Register::GetAllUsers();
			echo json_encode($Answer);
		}catch(PDOException $e){
			echo json_encode(array('result' => 'something wrong, please try again later'));
		}
	}

	/*try and catch because maybe have problems and we need to know*/
	/*if we have a problems we see "an error ocurred......."*/
?>
<?php
	
	require 'Users.php';//a father is "Login.php"

	if($_SERVER['REQUEST_METHOD']=='GET'){//this function manages all users
		try{
			$Answer = Users::GetAllUsers();
			echo json_encode(array('result' => $Answer));
		}catch(PDOException $e){
			echo json_encode(array('result' => 'something wrong, please try again later'));
		}
	}



?>
<?php

	require 'Token.php';

	if($_SERVER['REQUEST_METHOD']=='GET'){
		try{
			$Answer = Token::GetAllUsers();
			echo json_encode($Answer);
		}catch(PDOException $e){
			echo "an error occurred, please try gain later from token";
		}
	}



?>
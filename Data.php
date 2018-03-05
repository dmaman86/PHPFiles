<?php
	require 'Database.php';

	class Data{
		function __construct(){
		}
		/* join to build table of mutual data between 2 users, this table have all messages */
		public static function DataGetAll($id){//this function accepts and manages all users
			$table_friends = "Friends_".$id;
			$table_message = "Messages_".$id;
			$consult = "SELECT P.id, P.name, 
							P.last_name, 
							F.status, 
							F.date_friends,
							 M.message, 
							 M.hour_sms,
							 M.kind_message
			            FROM PersonalInfo P
			            LEFT JOIN $table_friends F ON F.Id = P.id
			            LEFT JOIN $table_message M ON M.user = P.id
			            AND M.Id = (SELECT MAX(M2.Id) FROM $table_message M2 WHERE M2.user = M.user)";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute();

			$list = $result->fetchAll(PDO::FETCH_ASSOC);

			return $list;

		}
	}

?>
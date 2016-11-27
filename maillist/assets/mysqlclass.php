<?php

include_once('PDO.inc.php');

class processMySQL
{

	//TODO: Make SQL connections persist instead of creating a new one every function call.

	function processNewUser($name,$email,$major,$gratuateDate)
	{
		$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);

		$stmt = $db->prepare("INSERT INTO users (name, email, major, gratuation) VALUES (:name, :email, :major, :gratuation)");

		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':major', $major);
		$stmt->bindParam(':gratuation', $gratuateDate);

		$stmt->execute();
	}

	function countUsersByMajor($major)
	{

		if(!empty($major))
		{

			$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);
	
			$sth = $db->prepare("SELECT name FROM users WHERE major = :major");
			$sth->bindValue(':major', $major, PDO::PARAM_STR);
	
			$sth->execute();
	
	
			$result = $sth->rowCount();

			return $result;
		}
		else
		{
			return "Error: Not provided with a major";
		}
	}
}

?>
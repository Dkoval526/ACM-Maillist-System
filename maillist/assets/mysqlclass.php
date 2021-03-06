<?php

include_once('PDO.inc.php');

class processMySQL
{

	//TODO: Make SQL connections persist instead of creating a new one every function call.

	function saveEmailToHistory($target, $subject, $content)
	{
		$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);

		$stmt = $db->prepare("INSERT INTO sent_emails (send_date, target, subject, content) VALUES (now(), :target, :subject, :content)");

		$stmt->bindParam(':target', $target);
		$stmt->bindParam(':subject', $subject);
		$stmt->bindParam(':content', $content);

		$stmt->execute();
	}

	function processNewUser($name,$email,$major,$graduateDate)
	{
		$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);

		$stmt = $db->prepare("INSERT INTO users (name, email, major, graduation) VALUES (:name, :email, :major, :graduation)");

		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':major', $major);
		$stmt->bindParam(':gratuation', $graduateDate);

		$stmt->execute();
	}


	function getEmailAddressesByMajor($major)
	{

		$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);

		//If we get a string of 'everyone' as the parameter, do a different query
		if($major == 'everyone') {
			$sth = $db->prepare("SELECT email from users");
		}

		else {
			$sth = $db->prepare("SELECT email FROM users WHERE major = :major");
			$sth->bindValue(':major', $major, PDO::PARAM_STR);
		}

		$sth->execute();

		$result = $sth->fetchAll(PDO::FETCH_COLUMN, 0);

		return $result;
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

	function getCurrentSettings($database)
	{
		if ($database == "settings")
		{
			$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);
			$settings = $db->prepare("SELECT * FROM settings");
			$settings->execute();
			$settings = $settings->fetchAll();
			$settings = $settings["0"];

			return $settings;
		}
		else if ($database == "users") 
		{
			$db = new PDO(ML_PDO_CON_STRING, ML_PDO_USERNAME, ML_PDO_PASSWORD);
			$users = $db->prepare("SELECT * FROM users ORDER BY last_name ASC");
			$users->execute();
			$users = $users->fetchAll();

			return $users;
		}
		else if ($database == "ulog")
		{
			$login_db = new PDO('mysql:host=127.0.0.1;dbname=psbhosti_ulogin', 'psbhosti_ulogin', 'cR1_}LPyFo.9');
			$login_info = $login_db->prepare("SELECT username, password FROM ul_logins");
			$login_info->execute();
			$login_info = $login_info->fetchAll();
			$login_info = $login_info["0"];

			return $login_info;
		}
		else
		{
			print("You shouldn't be here. You're a moron!");
		}
	}
}

?>
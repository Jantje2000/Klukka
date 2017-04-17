<?php
	$db = new PDO("mysql:host=10.3.1.189;dbname=starre_test123",
                 "starre_test123", "test123"); // An connection with the database.
	
	$employee = $_GET["uid"]; //the Unique IDentifier that will be send with requests.
	
	$employees = $db->prepare("SELECT personal_id FROM personal_data WHERE uid=:uid"); // Select the ID of a person who's UID is sent.
	$employees->execute(array(":uid"=>$employee));
	$employee = $employees->fetch(PDO::FETCH_ASSOC); //execute and get the ID back.
	
	$employeeHours = $db->prepare("SELECT * FROM workingtimes WHERE personal_id=:id ORDER BY time_id DESC"); //get the workingtimes of the employees.
	$employeeHours->execute(array(":id"=>$employee["personal_id"]));
	$employeeHours = $employeeHours->fetchAll(PDO::FETCH_ASSOC);
	if($employeeHours[0]["stop_time"] == null){ //If the stop time isn't filled in
		$inserttime = $db->prepare("UPDATE workingtimes SET stop_time=NOW()"); // Set stop time to now. (You are stopped working)
		$inserttime->execute();
	} else if($employeeHours[0]["stop_time"] != null){ //else if the stop time isnt null
		$inserttime = $db->prepare("INSERT INTO workingtimes(personal_id, start_time)
											VALUES(:personal_id, NOW())"); // then add a new record at the time of now. (You are started working)
		$inserttime->execute(array(":personal_id"=>$employee["personal_id"]));
	}
?>
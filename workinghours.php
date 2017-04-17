<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM personal_data WHERE personal_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$employee = $auth_user->runQuery("SELECT * FROM employees WHERE personal_id=:user_id");
	$employee->execute(array(":user_id"=>$user_id));
	
	$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	$employee = $employee->fetch(PDO::FETCH_ASSOC);
	
	$employees = $auth_user->runQuery("SELECT * FROM personal_data");
	$employees->execute();
	$employees = $employees->fetchAll(PDO::FETCH_ASSOC);
	
	function getWorkinghours(){
		global $_POST;
		global $auth_user;
		$starttime = date("Y-m-d H:i:s", strtotime($_POST["starttime"]));
		$stoptime = date("Y-m-d H:i:s", strtotime($_POST["stoptime"]));
		
		$getworkinghours = $auth_user->runQuery("SELECT * FROM workingtimes WHERE personal_id=:id AND start_time >= :start AND start_time <= :stop AND stop_time <= :stop");
		$getworkinghours->execute(array(":id"=>$_POST["employee"], ":start"=>$_POST["starttime"], ":stop"=>$_POST["stoptime"]));
		$workinghours = $getworkinghours->fetchAll(PDO::FETCH_ASSOC);
		
		$getemployee = $auth_user->runQuery("SELECT name FROM personal_data WHERE personal_id = :id");
		$getemployee->execute(array(":id"=>$_POST["employee"]));
		$employee = $getemployee->fetch(PDO::FETCH_ASSOC);
		
		foreach($workinghours as $workinghours){
			$first_date = new DateTime($workinghours["start_time"]);
			$second_date = new DateTime($workinghours["stop_time"]);
			$difference = $first_date->diff($second_date);
			$day_hours = intval($difference->format("%a")) * 24;
			$hours = intval($difference->format("%h"));
			$totalhours = $day_hours + $hours;
			echo '<tr><td>' . $employee["name"] . '</td><td>' . $workinghours["start_time"] . '</td><td>' . $workinghours["stop_time"] . '</td><td>' . $totalhours . '</td></tr>';
		}
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
		<link rel="stylesheet" href="style.css" type="text/css"  />
		<title>Get worked hours | Klukka</title>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="logo" style=" width:1175px ;margin: auto;"><a href="home.php"><img src="klukka.png"></a></div>
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li class="active"><a href="workinghours.php">Worked hours</a></li>
						<li><a href="employee.php">Data of employees</a></li>
						<li><a href="colleague.php">Add new employees</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								&nbsp;<?php echo $employee['name']; ?>&nbsp;<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="logout.php?logout=true">&nbsp;Log out</a></li>
							</ul>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>
		<div class="clearfix"></div>   
		
		<div class="container-fluid" style="margin-top:330px;">
			<div class="container">
				<form method="post" action="">
					<select id="employee" name="employee" class="form-control">
						<option selected hidden disabled>Persoon</option>
						<?php
							foreach($employees as $person){ //choose which work data you want to get
								echo '<option value="' . $person["personal_id"] . '">' . $person["name"] . '</option>';
							}
						?>
					</select></br >
					<input placeholder="From date" class="form-control" name="starttime" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" autocomplete="off"><br />
					<input placeholder="To date" class="form-control" name="stoptime" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" autocomplete="off"><br />
					<input type="submit" name="submit" class="btn btn-default" value="Krijg overzicht">
					<div style="float:right;"><input type="button" name="loonstrookje" onclick="getLoonstrook()" class="btn btn-default" value="Print a payslip"></div>
				</form>
				<table id="tablehours" class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Start time</th>
							<th>Stop time</th>
							<th>Worked hours</th>
						</tr>
					</thead>
					<tbody>
						<?php
							getWorkinghours(); //print here the hours he worked
						?>
					</tbody>
				</table>
			</div>
		</div>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script>
			var name = document.getElementById("tablehours").rows[1].cells[0].innerHTML
			var hours = 0;
			for (var i = 1, cell; cell = document.getElementById("tablehours").rows[i].cells[3].innerHTML; i++) {
				hours += parseFloat(cell);
			}
			function getLoonstrook(){
				window.open("get_loonstrook.php?name=" + name + "&hours=" + hours);
				xhttp.send();
			}
		</script>
	</body>
</html>
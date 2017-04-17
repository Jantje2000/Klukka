<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM personal_data WHERE personal_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$employee = $auth_user->runQuery("SELECT * FROM employees WHERE personal_id=:user_id");
	$employee->execute(array(":user_id"=>$user_id));
	
	$employees = $auth_user->runQuery("SELECT * FROM personal_data");
	$employees->execute();
	
	
	$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	$employee = $employee->fetch(PDO::FETCH_ASSOC);
	$employees = $employees->fetchAll(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
		<link rel="stylesheet" href="style.css" type="text/css"  />
		<title>Get employee data | Klukka</title>
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
						<li><a href="workinghours.php">Worked hours</a></li>
						<li class="active"><a href="employee.php">Data of employees</a></li>
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
					<select name="employee" class="form-control">
						<option selected value="all">All</option>
							<?php
								foreach($employees as $person){
									echo '<option value="' . $person["personal_id"] . '">' . $person["name"] . '</option>';
								}
							?>
					</select>
					<br />
					<input type="submit" name="submit" class="btn btn-default" value="Haal gegevens op">
				</form>
				<?php
					function getEmployeeData($employee){
						global $auth_user;
						if($employee == "all"){ 
							$employeedata = $auth_user->runQuery("SELECT * FROM personal_data");
							$employeedata->execute();
							$employeedata = $employeedata->fetchAll(PDO::FETCH_ASSOC);
							echo '<table class="table table-striped"><thead><tr><th>Name</th><th>E-Mail</th><th>Wage per uur</th><th>Phonenumber</th><th>Street</th><th>Housenumber</th><th>Zipcode</th><th>Place of residence</th></tr></thead><tbody>'; 
							foreach($employeedata as $employee){
								echo '<tr><td>' . $employee["name"] . '</td><td>' . $employee["email"] . '</td><td>' . $employee["wage"] . '</td><td>' . $employee["phonenumber"] . '</td><td>' . $employee["street"] . '</td><td>' . $employee["housenumber"] . '</td><td>' . $employee["zipcode"] . '</td><td>' . $employee["placeofresidence"] . '</td></tr>';
							}
						}else{
							$employeedata = $auth_user->runQuery("SELECT * FROM personal_data WHERE personal_id=:id");
							$employeedata->execute(array(":id"=>$employee));
							$employeedata = $employeedata->fetchAll(PDO::FETCH_ASSOC);
							echo '<table class="table table-striped"><thead><tr><th>Name</th><th>E-Mail</th><th>Wage per uur</th><th>Phonenumber</th><th>Street</th><th>Housenumber</th><th>Zipcode</th><th>Place of residence</th></tr></thead><tbody>'; 
							foreach($employeedata as $employee){
								echo '<tr><td>' . $employee["name"] . '</td><td>' . $employee["email"] . '</td><td>' . $employee["wage"] . '</td><td>' . $employee["phonenumber"] . '</td><td>' . $employee["street"] . '</td><td>' . $employee["housenumber"] . '</td><td>' . $employee["zipcode"] . '</td><td>' . $employee["placeofresidence"] . '</td></tr>';
							}
						}
					}
					if(isset($_POST["submit"])){
						getEmployeeData($_POST["employee"]);
					}	
				?>
			</div>
		</div>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
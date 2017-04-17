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
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
		<link rel="stylesheet" href="style.css" type="text/css"  />
		<title>Home | Klukka</title>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top"> <!-- the menu balk -->
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
						<li class="active"><a href="home.php">Home</a></li>
						<li><a href="workinghours.php">Worked hours</a></li>
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
				<!-- Here you can add the content on the homepage -->
			</div>
		</div>

	<script src="bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>
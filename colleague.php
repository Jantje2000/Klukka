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
	
	if(isset($_POST["submit"])){ //if you want to add a colleague/new employee
		$name = $_POST["name"]; //the name
		$uid = $_POST["uid"]; //the unique identifier which is on the RFID card.
		$bsn = $_POST["bsn"]; // an unique number used in the Netherlands to identify citizen.
		$birthdate = date("Y-m-d", strtotime($_POST["birthdate"])); //the birthdate
		$email = $_POST["email"]; //your email
		$zipcode = $_POST["zipcode"]; //the zipcode 
		$housenumber = $_POST["housenumber"]; // his house number
		$street = $_POST["street"]; //the street where he is living
		$placeofresidence = $_POST["placeofresidence"]; //the place of residence where he is living
		$wage = $_POST["wage"]; //the wage this person will earn.
		$phonenumber = $_POST["phonenumber"]; //his phonenumber
		$car = $_POST["car"] || 0; //a boolean or this person wil get a car of the company or not.
		$insertemployee = $auth_user->runQuery("INSERT INTO personal_data(BSN, uid, name, email, birthdate, wage, phonenumber, zipcode, housenumber, street, placeofresidence, car)
												VALUES(:bsn, :uid, :name, :email, :birthdate, :wage, :phonenumber, :zipcode, :housenumber, :street, :place, :car)");
		$insertemployee->execute(array(":bsn"=>$bsn, ":uid"=>$uid, ":name"=>$name, ":email"=>$email, ":birthdate"=>$birthdate, ":wage"=>$wage, ":phonenumber"=>$phonenumber, ":zipcode"=>$zipcode, ":housenumber"=>$housenumber, ":street"=>$street, ":place"=>$placeofresidence, ":car"=>$car));
		
		$getemployeeid = $auth_user->runQuery("SELECT personal_id FROM personal_data ORDER BY personal_id DESC LIMIT 1"); //get the latest inserted id.
		$getemployeeid->execute();
		$employeeid = $getemployeeid->fetch(PDO::FETCH_ASSOC);
		$insertworkingtimes = $auth_user->runQuery("INSERT INTO workingtimes(personal_id, start_time, stop_time)
												VALUES(:personalid, NOW(), NOW())"); //add an record so that this program won't break later.
		$insertworkingtimes->execute(array(":personalid"=>$employeeid["personal_id"]));
		
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <!-- meta data -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> <!-- the bootstrap css -->
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> <!-- the bootstrap css -->
		<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script> <!-- the bootstrap javascript -->
		<link rel="stylesheet" href="style.css" type="text/css" /> <!-- the custom css -->
		<title>Add colleagues | Klukka</title> <!-- the title, (klukka is the name of this system) -->
	</head>
	<body>
		<script>
			function getAddress() { //This is written in dutch. That is not bad, because this is searching the adresses bij dutch zipcodes. It won't work abroad.
			var postcode = document.getElementById("postcode").value;
			var huisnummer = document.getElementById("huisnummer").value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var data = JSON.parse(this.responseText);
					var plaats = data["_embedded"]["addresses"][0]["city"]["label"];
					var straat = data["_embedded"]["addresses"][0]["street"];
					document.getElementById("straat").value = straat;
					document.getElementById("woonplaats").value = plaats;
					console.log("Dit was de woonplaats in het inputfield");
				}
			};
			xhttp.open("GET", "getaddress.php?postcode=" + postcode + "&huisnummer=" + huisnummer, true);
			xhttp.send();
			}
		</script>

		<nav class="navbar navbar-default navbar-fixed-top"> <!-- the navigation of this website -->
			<div class="logo" style=" width:1175px ;margin: auto;"><a href="home.php"><img src="klukka.png"></a></div> <!-- the logo -->
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
						<li><a href="home.php">Home</a></li> <!-- the menu buttons -->
						<li><a href="workinghours.php">Worked hours</a></li>
						<li><a href="employee.php">Data of employees</a></li>
						<li class="active"><a href="colleague.php">Add new employees</a></li>
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
				<div class="form">
					<form method="post" action="">
						<input type="text" name="name" placeholder="Name" class="form-control" required autocomplete="off"/><br />
						<input type="text" name="uid" placeholder="UID (Unique IDentiefier)" class="form-control" required autocomplete="off"/><br />
						<input type="number" name="bsn" placeholder="BSN" class="form-control" required autocomplete="off"><br />
						<input type="email" name="email" placeholder="Email-adres" class="form-control" required autocomplete="off"/><br />
						<input placeholder="Birthdate" class="form-control" name="birthdate" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" autocomplete="off"><br />
						<input type="number" name="phonenumber" placeholder="Phonenumber" class="form-control" min="1900-01-01" required autocomplete="off"><br />
						<input type="text" name="zipcode" id="postcode" onchange="getAddress()" placeholder="Zipcode" class="form-postcode" required autocomplete="off"/>
						<input type="number" name="housenumber" id="huisnummer" onchange="getAddress()" placeholder="Housenumber" class="form-postcode" required autocomplete="off"/>				
						<input type="text" name="street" id="straat" placeholder="Street" class="form-control" autocomplete="off"/>	
						<input type="text" name="placeofresidence" id="woonplaats" placeholder="Place of residence" class="form-control" autocomplete="off"/><br />
						<input type="number" name="wage" placeholder="Wage per hour" class="form-control" min="1" required autocomplete="off"><br />
						<input type="checkbox" name="car" value="1"> This employee gets a car of the company
						<input type="submit" name="submit" value="Add new collegaue" class="form-control">
					</form>
				</div>
			</div>
		</div> <!-- This is the form where you can add new employees. -->

		<script src="bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>
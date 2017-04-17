<?php
session_start();
require_once("class.user.php");
$login = new USER();

if($login->is_loggedin()!="") //if you are logged in you will be send to the homepage
{
	$login->redirect('home.php');
}

if(isset($_POST['btn-login'])) //if you click on the button to login, you will login, or not if you had not the good combination of password and username
{
	$uname = strip_tags($_POST['txt_uname_email']);
	$umail = strip_tags($_POST['txt_uname_email']);
	$upass = strip_tags($_POST['txt_password']);
		
	if($login->doLogin($uname,$umail,$upass))
	{
		$login->redirect('home.php');
	}
	else
	{
		$error = "Sorry, but this combination of username and password isn't correct!";
	}	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Login | Klukka</title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="style.css" type="text/css"  />
	</head>
	<body>
		<div class="signin-form">
			<div class="container">
				<form class="form-signin" method="post" id="login-form">
					<h2 class="form-signin-heading"></h2> 
					<div id="error">
						<?php
							if(isset($error)){
						?>
							<div class="alert alert-danger">
							<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
							</div>
						<?php
							}
						?>
					</div>
        
					<div class="form-group">
						<input type="text" class="form-control" name="txt_uname_email" placeholder="Username" required /> <!-- a username input -->
						<span id="check-e"></span>
					</div>
        
					<div class="form-group">
						<input type="password" class="form-control" name="txt_password" placeholder="Password" /> <!-- a password input -->
					</div>
					<div class="form-group">
						<button type="submit" name="btn-login" class="btn btn-default btn-login">
							&nbsp; Log in <!-- the login button -->
						</button>
						<br />
					</div>  
				</form>
			</div>
		</div>
	</body>
</html>
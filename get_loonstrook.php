<?php
// INCLUDE THE phpToPDF.php FILE
require("phpToPDF.php"); 
require_once("session.php");
require_once("class.user.php");

$name = $_GET["name"]; //the name of the person who's payslip has to be printed out

$auth_user = new USER();
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM personal_data WHERE name=:name");
$stmt->execute(array(":name"=>$name)); 
$userRow = $stmt->fetch(PDO::FETCH_ASSOC); //select the data of the person who's payslip has to be printed out

$wage_finally = $userRow["wage"] * $_GET["hours"] + $userRow["wage"] * 40 * 0.08 + $userRow["wage"] * 40 * 0.09717; //the wage for working + the wage for holiday days + the wage for the payout of holiday days.

function car(){ //or you get a car of the company or not
	global $userRow;
	if($userRow["car"] == 0){ //if boolean says no
		return "No";
	} else if($userRow["auto"] == 1){ //if boolean says yes
		return "Yes";
	}
}

$car = car(); //or you get a car or not

// the html to generate a pdf
$my_html = 
'
<html>
	<head>
	<style>
		table, th, td{
			border: 1px solid black;
			border-collapse: collapse;
			font-size: 10px;
		}
		div{
			font-size: 10px;
		}
	</style>
	</head>
	<body>
		<div style="margin-top:70px;"> <!--DIT IS DE HEADER, WAAR DE GEGEVENS STAAN VAN WERKGEVER EN WERKNEMER-->
			<div style="float:left; margin-left:100px;">
				' . $name . '<br />
				' . $userRow["street"] . '&nbsp;' . $userRow["housenumber"] . '<br />
				' . $userRow["zipcode"] . '&nbsp;' . $userRow["placeofresidence"] . '<br />
			</div>
			<div style="float:left; margin-left:100px;">
				Klukka<br />
				<br />
				<br />
			</div>
		</div>
		<div style="clear:both"></div>
		<div style="margin-left:100px; margin-top:20px; font-size:10px;">
			<table border="1" style="float:left;">
				<tr>
					<th colspan="3">Employee data</th>
				</tr>
				<tr>
					<td>
						<div style="float:left; width:80px;">
							Function<br />
							Department<br />
							BSN<br />
							Birthdate<br />
						</div>
						<div style="float:right;">
							General<br />
							General<br />
							' . $userRow["BSN"] . '<br />
							' . $userRow["birthdate"] . '<br />
							<div style="clear:both"></div>
						</div>
					</td>
					<td>
						<div style="float:left; width:110px;">
							Scale/Step<br />
							Hourly wage<br />
							Car of the company<br />
							Hours a week<br />
						</div>
						<div style="float:right;">
							0<br />
							' . $userRow["wage"] . '<br />
							' . $car . '<br />
							0
							<div style="clear:both"></div>
						</div>
					</td>
					<td>
						<div style="float:left; width:130px;">
							Time period<br />
							Social insurance<br />
							Table/Payroll tax<br />
							Percentage special rate<br />
						</div>
						<div style="float:right;">
							Monthly<br />
							WW/ZW/WIA ' . /* Dutch insurances. */ '<br />
							White/Yes<br />
							0%<br />
							<div style="clear:both"></div>
						</div>
					</td>
				</tr>
			</table>
			<div style="clear:both"></div>
			<table style="float:left;"><br />
				<tr>
					<th colspan="3">
						Salary calculation
					</th>
				</tr>
				<tr>
					<td style="width:200px;">
						<b>Description</b>
					</td>
					<td style="width:95px;">
						<b>Number</b>
					</td>
					<td style="width:132px;">
						<b>Normal</b>
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						Salary
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						&euro;&nbsp;' . $userRow["wage"] * $_GET["hours"] . '
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						Periodic holiday payment
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						&euro;&nbsp;' . $userRow["wage"] * 40 * 0.08 . '
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						Periodic holiday days payment
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:135px;">
						&euro;&nbsp;' . $userRow["wage"] * 40 * 0.09717 . '
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						&nbsp;
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						<b>Wage tax</b>
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						&euro;&nbsp; <b>' . $wage_finally . '</b>
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						<b>Net pay</b>
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						&euro;&nbsp; <b>' . $wage_finally . '</b>
					</td>
				</tr>
				<tr>
					<td style="border:0px; width:200px;">
						<b>Net to get wage</b>
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						&euro;&nbsp; <b>' . $wage_finally . '</b>
					</td>
				</tr>
				<tr>
					<td style="height:200px; border:0px; width:200px;">
						<b>To receive in cass</b>
					</td>
					<td style="border:0px; width:95px;">
						
					</td>
					<td style="border:0px; width:132px;">
						&euro;&nbsp; <b>' . $wage_finally . '</b>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
';
/*
<td>
						<div style="width:100px;">
							Tabel<br />
						</div>
						<div style="float:right">
							Wit<br />
						</div>
					</td>
					<div style="clear:both"></div>
					<td>
						<div style="width:150px;">
							Auto van de zaak<br />
						</div>
						<div style="">' . 
							$auto
						. '</div>
					</td>
					<div style="clear:both"></div>
*/
// SET YOUR PDF OPTIONS -- FOR ALL AVAILABLE OPTIONS, VISIT HERE:  http://phptopdf.com/documentation/
$pdf_options = array(
  "source_type" => 'html',
  "source" => $my_html,
  "action" => 'download',
  "file_name" => 'loonstrook.pdf', 
  "page_size" => 'A4');

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
phptopdf($pdf_options);

?>
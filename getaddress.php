<?php
	$postcode = $_GET["postcode"]; // your zipcode
	$huisnummer = $_GET["huisnummer"]; //the housnumber

	$headers = array();
	$headers[] = 'X-Api-Key: xxxxxxxxxxxxxxxxxxxxxxxxx'; //the api key for postcodeapi.nu
		
	$url = 'https://postcode-api.apiwise.nl/v2/addresses/?postcode=' . $postcode . '&number=' . $huisnummer; //the request
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	// JSON response
	echo $response = curl_exec($curl);

	curl_close($curl);
?>
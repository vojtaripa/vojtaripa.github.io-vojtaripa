<?php
function geocode($address)
{
    define('GOOGLE_GEOCODE', 'http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&address=');
    $urlAddress = urlencode( $address );
    $geocodeUrl = GOOGLE_GEOCODE . $address;
    $xmlResponse = simplexml_load_file(GOOGLE_GEOCODE . $urlAddress);		 
	//echo "Address: " . $address . "<br>";	 
	//echo "Status: " . $xmlResponse->status . "<br>";	
	if($xmlResponse->status != "OK")      
		return false;  	
	//echo "Count: " . $xmlResponse->count() . "<br>";	
	if($xmlResponse->count() != 2)      
		return false;	  
    $lat = $xmlResponse->result->geometry->location->lat;
    $lng = $xmlResponse->result->geometry->location->lng;
    $ret= $lat . "," . $lng;
    return $ret;
}
?>

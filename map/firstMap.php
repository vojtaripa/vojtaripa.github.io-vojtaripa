<?php
// MAPPING RACES ON THE MAP one race and location at a time.
// NEED TO MAKE SOME CHANGES HERE.

function geocode($address)
{
  define('GOOGLE_GEOCODE', 'http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&address=');
  
  $urlAddress = urlencode( $address );
  
  $geocodeUrl = GOOGLE_GEOCODE . $address;
  $xmlResponse = simplexml_load_file(GOOGLE_GEOCODE . $urlAddress);
  
  $lat = $xmlResponse->result->geometry->location->lat;
  $lng = $xmlResponse->result->geometry->location->lng;
  
  $ret['lat'] = $lat;
  $ret['lng'] = $lng;
  return $ret;
}

include_once("GoogleMap.php");
include_once("JSMin.php");


//TO DO: ***********************************************************************************
require_once('../database.php');

// Get team ID
if (!isset($TeamID)) {
    $TeamID = filter_input(INPUT_GET, 'TeamID', 
            FILTER_VALIDATE_INT);
    if ($TeamID == NULL || $TeamID == FALSE) {


        $PlayerID = 1;
    }
}

if($TeamID==NULL)
{

// Get players for all teams
$queryplayer1 = 'SELECT * FROM player ORDER BY PlayerID';
$statement4 = $db->prepare($queryplayer1);
$statement4->execute();
$player = $statement4->fetchAll();
$statement4->closeCursor();
}
else
{
$queryplayer = 'SELECT * FROM player  WHERE TeamID = :TeamID ORDER BY PlayerID';
$statement3 = $db->prepare($queryplayer);
$statement3->bindValue(':TeamID', $TeamID);
$statement3->execute();
$player = $statement3->fetchAll();
$statement3->closeCursor();
}

//**********************************************************************************



$MAP_OBJECT = new GoogleMapAPI(); 
$MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;
//$MAP_OBJECT->setDSN("mysql://user:password@localhost/db_name");

/*//address 1
$MAP_OBJECT->addMarkerByAddress("1550 Pacific Ave, Santa Rosa, CA","", "First Presbyterian Church Santa Rosa<br>1550 Pacific Ave.<br> Santa Rosa, CA 95409"); //by address

//address 2
$MAP_OBJECT->addMarkerByCoords(-122.717198,38.454611,"", "Santa Rosa Junior College<br>1501 Mendocino Avenue<br>Santa Rosa, CA 95401-4395 "); //by longitude and latitude

//ADDRESS 3
$workAddress = "451 Aviation Blvd, Santa Rosa CA";
$workLatLng = geoCode($workAddress);
 
$MAP_OBJECT->addMarkerByCoords($workLatLng['lng'], $workLatLng['lat'],"", "Work<br>451 Aviation Blvd<br>Santa Rosa CA");


//my address
$MAP_OBJECT->addMarkerByAddress("2260 Apollo Way, Santa Rosa, CA","", "whoot<br>2260 Apollo Way<br> Santa Rosa, CA 95407");

//Test
$address="555 Dexter, Santa Rosa, CA";
$description="Brother<br>555 Dexter<br> Santa Rosa, CA 95405";
$MAP_OBJECT->addMarkerByAddress($address,"",$description);
*/


// TODO:
//plotting players on map
//echo "<b>PLAYER ADDRESSES: </b> <br> ";
	foreach ($player as $player)
	{
		 $name=$player['Name'];
		 //echo $name. "<br>";
		 $addressnum=$player['AddressNum'];
		 $addressst=$player['AddressSt'];
		 $addressstate=$player['AddressState'];
		 $addresscity=$player['AddressCity'];
		 $addresszip=$player['AddressZip'];
		 
		 //Players
		$address=$addressnum . " " . $addressst . "," . $addresscity . "," . $addressstate; //"555 Dexter, Santa Rosa, CA"; 
		//echo $address. "<br>";
		$description=$name . "<br>". $addressnum . " " . $addressst . "<br>" . $addresscity . "," . $addressstate. " " . $addresszip;//"Brother<br>555 Dexter<br> Santa Rosa, CA 95405";
		$MAP_OBJECT->addMarkerByAddress($address,"",$description);	
		//echo "<br>";
	}

//GRAPHING STUFF**********************************

    require_once('graphs/Person.php');
    
    // Using the php wrapper for google charts
    function draw_bar_graph($width, $height, $data, $max_value)
    {
        require_once('graphs/gChart.php');

        // Need to separate the y values from the x labels
        // The labels are the keys, the values are the y values
        $myArray = array_values($data);
        $xLabels = array_keys($data);

        // This sets up the chart of google charts
        $barChart = new gBarChart();
        $barChart->addDataSet($myArray);            // add the y values
        $barChart->setAutoBarWidth();
        $barChart->setColors(array("ff3344", "11ff11", "22aacc"));
        $barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
        $barChart->setDimensions($width, $height);
        $barChart->setVisibleAxes(array('x','y'));
        $barChart->setDataRange(0, $max_value);
        $barChart->addAxisRange(1, 0, $max_value);
        $barChart->addAxisLabel(0, $xLabels);       // Add the labels

        // Interesting, google charts creates an image from their site
        echo "<img src=" . $barChart->getUrl() . " /> <br>";

    } // End of draw_bar_graph() function
	
	
    require_once('graphs/Header.php');
//***************************************************************************	
?>
<html>
<head>
<div align="center">
 <link rel="stylesheet" type="text/css" href="../main.css" />
<?=$MAP_OBJECT->getHeaderJS();?>
<?=$MAP_OBJECT->getMapJS();?>
</head>
<body>
<H1>Example of using Google Map API</H1>
<?=$MAP_OBJECT->printOnLoad();?>
<?=$MAP_OBJECT->printMap();?>
<?=$MAP_OBJECT->printSidebar();?>

 <!-- start the table. -->
    <table width='800px' border='1' cellspacing='0' cellpadding='0'><tr><th width='50px'>Name</th><th width='50px'>Address</th><th width='75px'>ZIP code</th>
	</tr> 

<?php 
    //$people = Person::getList();
    
			//***********************************************************************************
		require_once('../database.php');

		// Get team ID
		if (!isset($TeamID)) {
			$TeamID = filter_input(INPUT_GET, 'TeamID', 
					FILTER_VALIDATE_INT);
			if ($TeamID == NULL || $TeamID == FALSE) {


				$PlayerID = 1;
			}
		}

		if($TeamID==NULL)
		{

		// Get players for all teams
		$queryplayer1 = 'SELECT * FROM player ORDER BY PlayerID';
		$statement4 = $db->prepare($queryplayer1);
		$statement4->execute();
		$player = $statement4->fetchAll();
		$statement4->closeCursor();
		}
		else
		{
		$queryplayer = 'SELECT * FROM player  WHERE TeamID = :TeamID ORDER BY PlayerID';
		$statement3 = $db->prepare($queryplayer);
		$statement3->bindValue(':TeamID', $TeamID);
		$statement3->execute();
		$player = $statement3->fetchAll();
		$statement3->closeCursor();
		}

		//**********************************************************************************

	
	$title = 'Player that live in same Zip Code';
	echo "<br> <h2> $title </h2> <br>";
	
    $graphData = array();
    $graphData2 = array(array());
	//echo $name;
    foreach ($player as $player)
	{
		 $name=$player['Name'];
		 //echo $name . "<br>";
		 $addressnum=$player['AddressNum'];
		 $addressst=$player['AddressSt'];
		 $addressstate=$player['AddressState'];
		 $addresscity=$player['AddressCity'];
		 $addresszip=$player['AddressZip'];
		 
		 //Players
		$address=$addressnum . " " . $addressst . "," . $addresscity . "," . $addressstate; //"555 Dexter, Santa Rosa, CA"; 
		//echo $address. "<br>";
		$description=$name . "<br>". $addressnum . " " . $addressst . "<br>" . $addresscity . "," . $addressstate. " " . $addresszip;//"Brother<br>555 Dexter<br> Santa Rosa, CA 95405";
			
		echo "<td>$name</td>";
        echo "<td>$address</td>";
        echo "<td>$addresszip</td></tr>";
		
	   /* echo "<tr><td><form method=\"POST\" action=\"delete.php?id=$person->id\"> ";
        echo "<input type='submit' value='Delete' name='delete' /></form></td>";
        
        echo "<td><form method=\"POST\" action=\"edit.php?id=$person->id\"> ";
        echo "<input type='submit' value='Edit' name='edit' /></form></td>";
         
        echo "<td>$person->firstname</td>";
        echo "<td>$person->lastname</td><td>$person->grade</td>";
        echo "<td>$person->email</td><td>$person->comments </td></tr>";*/

		
        // One way to count the number of students with each grade
        //   This method does not assume the data is sorted
        // Does an entry with that grade as key already exist
        if(array_key_exists($addresszip, $graphData))
            $graphData[$addresszip]++;       // Yes, increment it
        else
            $graphData[$addresszip] = 1;     // No, set it to one*/ 1
			
    } 
?>
 
<!-- close the table. --> 
   </table><br />

<br><br> 

<?php
    draw_bar_graph(480, 240, $graphData, 10); //prints graph

    // Dump the data just so we can see how it is organized
    var_dump($graphData);

?>



<p><a href="../index.php">Home</a></p>


</div>
</body>
</html>


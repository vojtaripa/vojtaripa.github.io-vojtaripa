<?php

// ** MySQL settings ** //
define('DB_NAME', 'vojta_data');    // The name of the database
define('DB_USER', 'vojta_data-all');     // Your MySQL username
define('DB_PASSWORD', '590d05cd'); // ...and password
define('DB_HOST', 'vojta-data.db.sonic.net');
/* OLD SETTINGS from old site:
define('DB_NAME', 'kog_fgckeoglig');
define('DB_USER', 'vojtaripa');
define('DB_PASSWORD', 'track1');
define('DB_HOST', 'nightvestcom.ipagemysql.com'); 
*/
$i=0;
$arr1 = array();

$event = array();
$mark  = array();
$points= array();


$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if(!$link) 
{
	die('could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $link);

if(!$db_selected)
{
	die('Can\'t use ' . DB_NAME . ': '  .  mysql_error());
}

echo 'Connected Successfully';
echo "<br/>";



$event1 = $_POST['event1'];
$time1 = $_POST['time1'];
$time1change=('%' . $_POST['time1'] . '%');

$event2 = $_POST['event2']; //value3
$time2 = $_POST['time2']; //value4
$time2change=($_POST['time2'] . '%');

$event3 = $_POST['event3']; //value3
$time3 = $_POST['time3']; //value4
$time3change=($_POST['time3'] . '%');

$event4 = $_POST['event4']; //value3
$time4 = $_POST['time4']; //value4
$time4change=($_POST['time4'] . '%');

$event5 = $_POST['event5']; //value3
$time5 = $_POST['time5']; //value4
$time5change=($_POST['time5'] . '%');

$event6 = $_POST['event6']; //value3
$time6 = $_POST['time6']; //value4
$time6change=($_POST['time6'] . '%');

$event7 = $_POST['event7']; //value3
$time7 = $_POST['time7']; //value4
$time7change=($_POST['time7'] . '%');

$event8 = $_POST['event8']; //value3
$time8 = $_POST['time8']; //value4
$time8change=($_POST['time8'] . '%');

$event9 = $_POST['event9']; //value3
$time9 = $_POST['time9']; //value4
$time9change=($_POST['time9'] . '%');

$event10 = $_POST['event10']; //value3
$time10 = $_POST['time10']; //value4
$time10change=($_POST['time10'] . '%'); //value9


//echo "<br> Inputs: <br>";

function findPoints($eventX,$timeXchange,&$event,&$mark,&$points, &$i) 
{
		//IF BLANK, EXIT
		if($eventX=="" || $timeXchange=="")
			return;
		
		$sex = $_POST['sex'];
		//echo "inside function <br>";
//FEMALE!!! ************************************************************************************************************************************************************ 		
		if($sex == "female") //female table
		{
			$pointsXtemp = mysql_query('SELECT points FROM WomansTimes WHERE ' . $eventX . '  like ' . "'$timeXchange'" . ' ORDER BY ' . $eventX . ' LIMIT 1');
			$pointsX = mysql_fetch_array($pointsXtemp);
			$mypointsX = $pointsX[0];
			
			if($mypointsX<="1398" && $timeXchange!="" && $timeXchange!="%")
			{	
				$find="%";
				$replace="";
				$pos = strpos($timeXchange, $find);
					
				if($pos >= 0)
				{	
					$timeXchange = str_replace($find, $replace, $timeXchange);
					//echo "With <b>event: </b>$eventX and <b>mark:</b> $timeXchange <b>POINTS</b> are: $mypointsX <br>";
					array_push($event,$eventX);
					array_push($mark, $timeXchange);
					array_push($points, $mypointsX);
					$i++;
				}
				else
				{	
					//echo "With <b>event: </b>$eventX and <b>mark:</b> $timeXchange <b>POINTS</b> are: $mypointsX <br>";
					array_push($event,$eventX);
					array_push($mark, $timeXchange);
					array_push($points, $mypointsX);
					$i++;
				}
			}
			
			if($mypointsX=="")
			{
				for ($x=8; $x>1; $x--)
				{
					if($mypointsX=="")
					{
						$timeXchange = substr($timeXchange,0,$x);
						$timeXchange =($timeXchange . '%');
						$pointsXtemp = mysql_query('SELECT points FROM WomensTimes WHERE ' . $eventX . '  like ' . "'$timeXchange'" . ' ORDER BY ' . $eventX . ' LIMIT 1');
						$pointsX = mysql_fetch_array($pointsXtemp);
						$mypointsX = $pointsX[0];
					}
					else
						$x=0;
				}
			}
			//echo "The number is: $pointsXtemp <br>";
			return $mypointsX;
		}
//MALE!!! ************************************************************************************************************************************************************  
		
		else if($sex == "male") //male table
		{		
			$pointsXtemp = mysql_query('SELECT points FROM MenTimes WHERE ' . $eventX . '  like ' . "'$timeXchange'" . ' ORDER BY ' . $eventX . ' LIMIT 1');
			$pointsX = mysql_fetch_array($pointsXtemp);
			//echo "$pointsXtemp<br>";
			$mypointsX = $pointsX[0];
			
			if($mypointsX<="1398" && $timeXchange!="" && $timeXchange!="%")
			{	
				$find="%";
				$replace="";
				$pos = strpos($timeXchange, $find);
					
				if($pos >= 0)
				{	
					$timeXchange = str_replace($find, $replace, $timeXchange);
					//echo "With <b>event: </b>$eventX and <b>mark:</b> $timeXchange <b>POINTS</b> are: $mypointsX <br>";
					array_push($event,$eventX);
					array_push($mark, $timeXchange);
					array_push($points, $mypointsX);
					$i++;
				}
				else
				{	
					//echo "With <b>event: </b>$eventX and <b>mark:</b> $timeXchange <b>POINTS</b> are: $mypointsX <br>";
					array_push($event,$eventX);
					array_push($mark, $timeXchange);
					array_push($points, $mypointsX);
					$i++;
				}
			}

			if($mypointsX=="")
			{
				for ($x=8; $x>1; $x--)
				{
					if($mypointsX=="")
					{
						$timeXchange = substr($timeXchange,0,$x);
						$timeXchange =($timeXchange . '%');
						$pointsXtemp = mysql_query('SELECT points FROM MenTimes WHERE ' . $eventX . '  like ' . "'$timeXchange'" . ' ORDER BY ' . $eventX . ' LIMIT 1');
						$pointsX = mysql_fetch_array($pointsXtemp);
						$mypointsX = $pointsX[0];
					}
					else
						$x=0;
				}
			}
			
			return $mypointsX;
		}
		else
		{}
		  
		  //echo $mypointsX;
	//return "10"; //$mypointsX;
}

   $mypoints1=findPoints($event1,$time1change,$event,$mark,$points,$i); 
   $mypoints2=findPoints($event2,$time2change,$event,$mark,$points,$i);
   $mypoints3=findPoints($event3,$time3change,$event,$mark,$points,$i); 
   $mypoints4=findPoints($event4,$time4change,$event,$mark,$points,$i);
   $mypoints5=findPoints($event5,$time5change,$event,$mark,$points,$i); 
   $mypoints6=findPoints($event6,$time6change,$event,$mark,$points,$i);
   $mypoints7=findPoints($event7,$time7change,$event,$mark,$points,$i); 
   $mypoints8=findPoints($event8,$time8change,$event,$mark,$points,$i);
   $mypoints9=findPoints($event9,$time9change,$event,$mark,$points,$i); 
$mypoints10=findPoints($event10,$time10change,$event,$mark,$points,$i);


$sql = "DELETE FROM MultiEvents";
$result=mysql_query($sql);

if(!$time1=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints1' , '$event1','$time1')";
$result=mysql_query($sql);
}
if(!$time2=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints2' , '$event2','$time2')";
$result=mysql_query($sql);
}
if(!$time3=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints3' , '$event3','$time3')";
$result=mysql_query($sql);
}
if(!$time4=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints4' , '$event4','$time4')";
$result=mysql_query($sql);
}
if(!$time5=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints5' , '$event5','$time5')";
$result=mysql_query($sql);
}
if(!$time6=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints6' , '$event6','$time6')";
$result=mysql_query($sql);
}
if(!$time7=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints7' , '$event7','$time7')";
$result=mysql_query($sql);
}
if(!$time8=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints8' , '$event8','$time8')";
$result=mysql_query($sql);
}
if(!$time9=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints9' , '$event9','$time9')";
$result=mysql_query($sql);
}
if(!$time10=="")
{
$sql = "INSERT INTO MultiEvents (points,events,marks) VALUE ('$mypoints10' , '$event10','$time10')";
$result=mysql_query($sql);
}
/*
if(!mysql_query($sql))
{
die('ERROR: ' . mysql_error());
}
*/

mysql_close();




//PRINT:
//echo " <br><br>AFTER SORTING:<br>";

//SORT
array_multisort($points, $mark, $event);

echo "<center><br><br><tr><th><h2> * BEST EVENT RANKER: * </th></tr></h2>
      <table><tr><th> EVENT </th><th> MARK </th><th> POINTS </th></tr> ";
	  

$length = count($event);
//PRINT 
for($i=0; $i<$length; $i++)
{
	echo "<tr><td>". array_pop($event) ."</td> <td>" . array_pop($mark) . "</td> <td>" . array_pop($points) . " </td></tr>";
}

echo "</table></h2></center><br><br>";

//Header( 'Location:  http://vojta.users.sonic.net/RaceResults/pages/functions.php#Best Event Selector' ); // FIX WHICH PAGE IT GOES TO... 
include('functionsResult.php');

?>
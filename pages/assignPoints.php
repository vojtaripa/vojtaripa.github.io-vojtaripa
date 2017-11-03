<?php
//BEST EVENT
//Header( 'Location:  http://sonic.net/~vojta/RaceResults/indexAdmin.php' );

require_once('database.php');
require ('indexPHP.php');

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

// TO GET IN AS ADMIN AGAIN ***********************************************************************************  
$username="vojtaripa";
$queryuser = 'SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1'; 
$statement5 = $db->prepare($queryuser);
$statement5->bindValue(':username', $username);
$statement5->execute();
$theuser = $statement5->fetchAll();
$statement5->closeCursor();

$username = $theuser['0']['username'];
$password =	$theuser['0']['password'];
echo"Username: $username, Password: $password<br>";

/*
$username = "vojtaripa";
$password =	"Runfa$t1";
echo"Username: $username, Password: $password<br>";
*/
//****************************************************************************** 

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


// This should be working, returns an array of race results.
function queryRaces2($queryrace, $Distance, $Year) 
{
    
	$dsn = 'mysql:host=vojta-data.db.sonic.net; dbname=vojta_data';
    $username = 'vojta_data-all';
    $password = '590d05cd';

    try 
	{
        $db = new PDO($dsn, $username, $password);
    } 
	catch (PDOException $e) 
	{
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    } 

	//echo $queryrace;
	$statement3 = $db->prepare($queryrace);
	if($Distance!=NULL && $Distance!='All')
	{
		$statement3->bindValue(':Distance', $Distance);
	}
	if($Year!=NULL && $Year!='All')
	{
		$statement3->bindValue(':Year', $Year);
	}
	$statement3->bindValue(':Year', $Year);
	$statement3->execute();
	$myrace = $statement3->fetchAll();
	//$race=$myrace;
	//echo $Distance;
	
	$statement3->closeCursor();
	//echo "not NULL";
	return $myrace;
} 

// GETTING ALL RACES READY
$queryrace1 = 'SELECT * FROM MyRaceResults order by Date DESC'; // order by index? 
$race = queryRaces2($queryrace1, $Distance, $Year);





//NEED TO TRANSLATE DISTANCE! NOTE: NOT ALL MY DISTANCES WILL HAVE A POINT VALUE... :/
function translateDistance($output, $value4)
{ 
			switch($output)
			{ 
			
				case '0.06'	:
				$distanceName='100m';
				break;
				
				case '0.12'	:
				$distanceName='200m';
				break;
				
				case '0.25'	:
				$distanceName='400m';
				break;
				
				case '0.37'	:
				$distanceName='600m';
				break;
				
				case '0.50'	:
				$distanceName='800m';
				break;
				
				case '0.62'	:
				$distanceName='1000m';
				break;
				
				case '0.93'	:
				$distanceName='1500m';
				break;
				
				case '1.00'	:
				$distanceName='Mile';
				break;
				
				case '1.86'	:
				$distanceName='3000m';
				break;
				
				case '2.00'	:
				$distanceName='2Miles';
				break;
				
				case '3.10'	:
				$distanceName='5000m';
				break;
				
				case '6.00'	:
				//can try to convert this to 10k time add 71 seconds for 6min pace
				$value4=TimeToSeconds($value4);
				$value4=$value4+71;
				$value4=SecondsToTime($value4);
				echo "6MI convertion!!! time is now: $value4 ";
				$distanceName='10km';
				break;
				
				case '6.20'	:
				$distanceName='10km';
				break;
				
				case '10.00':	
				$distanceName='10Miles';
				break;
				
				case '13.10':	
				$distanceName='HM';
				break;
				
				case '26.20':	
				$distanceName='Marathon';
				break;
				
				default:
				$distanceName="none";

			} 
			return array($distanceName,$value4); //$distanceName
		
} 
//NOW GET VALUES
/*
$value1 = $_POST['name'];
$value2 = $_POST['sex'];
$value3 = $_POST['event1'];
$value4 = $_POST['time1'];
$value9 =($_POST['time1'] . '%');
*/


foreach ($race as $race)
{
   $myIndex = $race['Index'];
	$value1 = $race['Race'];
	$value2 = "male";
	$value3 = $race['Distance'];
	$Dist   = $value3;
	$value4 = $race['Time'];
	
	//Sending distance and time into function, and getting the right distance and time to use. (time is ususally the same).
	list($value3,$value4)=translateDistance($value3, $value4);
	
	$value9 = $value4 . '%';
	
	while($value9!="")
	{
		if(substr($value9,0,1)=="0" || substr($value9,0,1)==":")
		$value9 = substr($value9,1);
		else{break;}
	}

	//need to put values in array and pop them later. Then while there is item in array pop.. OR i can include fuction in here.

	echo "The name is: $value1 <br>";
	echo "The sex is: $value2 <br>";
	echo "The Distance is: $value3 <br>";
	echo "The time is: $value9 <br>";
	
	if($value3=="none")
	{
		//DO NOTHING
		$points1temp=0;
	}
	else
	{

		//first rank
		$rank = '0';

		//FEMALE (I WONT NEED THIS BUT MIGHT USE IT LATER.....other accounts) ****************************************************************************** 
		/*
		if($value2 == "female") //female table
		{
		$points1temp = mysql_query('SELECT points FROM WomansTimes WHERE ' . $value3 . '  like ' . "'$value9'" . ' ORDER BY ' . $value3 . ' LIMIT 1');
		$points1 = mysql_fetch_array($points1temp);
		$mypoints1 = $points1[0];
		if($mypoints1=="")
			{
				for ($x=8; $x>1; $x--)
				{
					if($mypoints1=="")
					{
						$value9 = substr($value9,0,$x);
						$value9=($value9 . '%');
						echo "The loop val9 is: $value9 <br>";
						$points1temp = mysql_query('SELECT points FROM WomensTimes WHERE ' . $value3 . '  like ' . "'$value9'" . ' ORDER BY ' . $value3 . ' LIMIT 1');
						$points1 = mysql_fetch_array($points1temp);
						$mypoints1 = $points1[0];
					}
					else
						$x=0;
				}
			}
			echo "The number is: $points1temp <br>";

		}
		*/

		//MALE ***************************************************************************** 
		if($value2 == "male") //male table
		{
		echo "Distance is $value3.<br>";
		$points1temp = mysql_query('SELECT points FROM MenTimes WHERE ' . $value3 . '  like ' . "'$value9'" . ' ORDER BY ' . $value3 . ' LIMIT 1');
		$points1 = mysql_fetch_array($points1temp);
		$mypoints1 = $points1[0];
		if($mypoints1=="")
			{
				$x=5;
				while((strlen($value9)>2) && $x!=0)
				{
					if($mypoints1=="")
					{
						$value9 = substr($value9,0,$x);
						$x--;
						$value9=($value9 . '%');
						
						echo "The loop val9 is: $value9 <br>";
						
						$points1temp = mysql_query('SELECT points FROM MenTimes WHERE ' . $value3 . '  like ' . "'$value9'" . ' ORDER BY ' . $value3 . ' LIMIT 1');
						$points1 = mysql_fetch_array($points1temp);
						$mypoints1 = $points1[0];
					}
					else
						$x=0;
				}
				if(strlen($value9)==2)
					$mypoints1 =0;
			}
			echo "The points is: $mypoints1 <br>";
		}
		//****************************************************************************** 
		else
		{}


		echo "The points is: $mypoints1 <br><br>";


		//put points back into my database
		$sql = "UPDATE `MyRaceResults` SET `Points` = '$mypoints1' WHERE `MyRaceResults`. `Index`=$myIndex";
		
		// Prepare statement
		$stmt = $db->prepare($sql);

		// execute the query
		$stmt->execute();

		// echo a message to say the UPDATE succeeded
		echo $stmt->rowCount() . " records UPDATED successfully<br><br>";
	
		//TEST:  INSERT INTO MyRaceResultsCOPY (Points) VALUE ('100') where Index=1
		//TEST2: UPDATE `MyRaceResultsCOPY` SET `Points` = '1' WHERE `MyRaceResultsCOPY`.`Index` = 1;
	}
}

	if(!mysql_query($sql))
		{
			die('ERROR: ' . mysql_error());
		}
		mysql_close();

?>
<!DOCTYPE html>
<html>
 </body>
		<p style="display: inline;"><a class="button" href="index.php" >Back Home to Races</a></p>
 </body>
</html>
<?php
require_once ('../map/geocode.php');
require_once ('../image/file_util.php'); // the get_file_list function
require_once ('../image/image_util.php'); // the process_image function
require_once ('database.php');

/*
Index	
Date		
Race		
Time
Distance	
Place	
Pace	
Location	
Type	
Picture				
LinkToResults				
LinkToActivity		
shoes		
Notes	
*/

//***NEED TO CHANGE!!!****
//$myusername="test";

//USERNAME LOGGED IN and SECURITY:
if($myusername=="" && $mypassword=="")
{	
	$myusername = filter_input(INPUT_POST, 'username');
	$mypassword = filter_input(INPUT_POST, 'password');

	//echo "<h1 style='color:red'> SORRY, invalid username or password. </h1>";
	if($myusername=="" && $mypassword=="")
	{
		?>		
		<script type="text/javascript">location.href = 'http://www.vojtaripa.com/finishline';</script>
		<?php
	}
	//header("Location: http://www.vojtaripa.com/finishline");
}
else
{}



if($mypassword=="")
{
	echo "<h1 style='color:red'> SORRY, invalid password. </h1>";
    //include("RaceResults.php?choice=search&user=".urlencode($myusername)."&Year=".urlencode('All')."&Distance=".urlencode('All'));
    exit();
}
else
{
	//finds which user is logged on:
	$queryuser = 'SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1'; 
	$statement5 = $db->prepare($queryuser);
	$statement5->bindValue(':username', $myusername);
	$statement5->execute();
	$theuser = $statement5->fetchAll();
	$statement5->closeCursor();
	
	$theusername = $theuser['0']['username'];
	$thepassword =	$theuser['0']['password'];
	
	/*echo "THEUSERNAME: $theusername <br>";
	echo "MYUSERNAME: $myusername <br>";
	echo "THEPASSWORD: $thepassword <br>";
	echo "MYPASSWORD: $mypassword <br>";*/
	
	//IF USERNAME AND PASSWORD ARE NOT RIGHT
	if($myusername!=$theusername || $mypassword!=$thepassword)
	{
		//echo "<h1 style='color:red'>SORRY INVALID LOGIN</h1>";
		?>		
		<script type="text/javascript">location.href = 'http://www.vojtaripa.com/finishline';</script>
		<?php
	}
	else
	$usernameCheck==true; //correct user logged in.
}
//ELSE RUN PAGE.
//****************************************************************************** 

// TO GET IN AS ADMIN AGAIN ***********************************************************************************  
/*
$queryuser = "SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1"; 
$statement5 = $db->prepare($queryuser);
$statement5->bindValue(':username', $myusername);
$statement5->execute();
$theuser = $statement5->fetchAll();
$statement5->closeCursor();

$myusername =   $theuser['0']['username'];
$mypassword =	$theuser['0']['password'];
echo"Username: $myusername <br>Password: $mypassword<br>";
*/

/*
$myusername = 'vojtaripa';
$mypassword =	'Runfa$t1';
echo"Username: $myusername, Password: $mypassword<br>";
*/

//MY NEW FIELDS:

$Index = filter_input(INPUT_POST, 'Index', FILTER_VALIDATE_INT);

$Date = filter_input(INPUT_POST, 'Date');

$Race = filter_input(INPUT_POST, 'Race'); //, FILTER_VALIDATE_INT

$H = filter_input(INPUT_POST, 'Hours');
$M = filter_input(INPUT_POST, 'Minutes');
$S = filter_input(INPUT_POST, 'Seconds');
$Time = "$H:$M:$S";

$Distance = filter_input(INPUT_POST, 'Distance');

$Place = filter_input(INPUT_POST, 'Place', FILTER_VALIDATE_INT);

$Pace = filter_input(INPUT_POST, 'Pace');

$Location =	filter_input(INPUT_POST, 'Location');

$Type = filter_input(INPUT_POST, 'Type');	

//$Picture = filter_input(INPUT_POST, 'Action');				

$LinkToResults = filter_input(INPUT_POST, 'ResultsLink');				

$LinkToActivity	= filter_input(INPUT_POST, 'ActivityLink');	

$shoes = filter_input(INPUT_POST, 'Shoes');		

$Notes = filter_input(INPUT_POST, 'Comments');

$Feel = filter_input(INPUT_POST, 'feel');

$DateAdded = date("Y-m-d");


//*** TESTING  INPUTS ***************************************************************************************

//TESTING INPUTS


/*
$Index = "50";

$Date = "2015-01-01";

$Race = "TESTING RACE"; //, FILTER_VALIDATE_INT

$Time = "0:05:50";

$Distance = "1.00";

$Place = "1";

$Pace = "0:05:50";
*/

//INDEX ************************************************************************************************************************************************************ DONE
$myquery = "Select COUNT(*) FROM $myusername LIMIT 1";
$statement2 = $db->prepare($myquery);
$statement2->execute();
$usernameX = $statement2->fetchAll();//$statement2->mysql_result( $statement2, 0 );
$statement2->closeCursor();

foreach ($usernameX as $usernameX) : 
		$myquery = ($usernameX[0]+1); 
endforeach; 


//echo "My Query: $myquery Index: $Index";

if($Index < $myquery)
{
	
	$message = "<br><h2>ERROR: This result has already been added, please refresh the page and try again. (for Index: $Index)</h2>";
	echo $message;
    include('add_race_form.php');
    exit();
}




//PACE ************************************************************************************************************************************************************ WORKS

//GETS TIME in TIME FORMAT AND CONVERTS IT TO SECONDS.
function TimeToSecondsCopy($inputTime) 
{	
	//now i need to strip h i s from this 
	$s= substr($inputTime, (strlen($inputTime)-2)); // makes seconds the last 2 chars
    $inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
	$m= substr($inputTime, (strlen($inputTime)-2)); 
	$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
	$h= $inputTime; 
	
	//USE THIS FOR TOTALS? add each individual piece
	$totalH=($h*60*60);
	$totalM=($m*60);
	$totalS=($s);
	
	//Then send updated totals back to user	
	
	return ($totalH+$totalM+$totalS);
}

$PaceInSeconds = TimeToSecondsCopy($Pace);

if( (188 > $PaceInSeconds) || ($PaceInSeconds> 540) )
{
	$message = "<br><h2>ERROR: Please check your time and distance, pace seems to be too fast or too slow. (for pace: $Pace)</h2>";
    echo $message;
	include('add_race_form.php');
    exit();
}

//Date ************************************************************************************************************************************************************ DONE
//further than todays date

$todaysDate = date('Y-m-d');

$default_date = new DateTime();

$todaysDate = date_create($todaysDate);
$myDate    = date_create($Date);

//echo "<br>TODAY:" . date_format($todaysDate, 'Y-m-d');
//echo "<br>YOU PUT:". date_format($myDate,'Y-m-d');

$DateDifference = date_diff($myDate, $todaysDate);
//echo $DateDifference->format("<br>%R%a<br>");
$DateDifference = $DateDifference->format('%R%a');


if( $DateDifference < 0)
{
	$message = "<br><h2>ERROR: Please check your Date, you are " . abs($DateDifference) . " in the future, this race did not happen yet. (For Date: $Date)</h2>";
    echo $message;
	include('add_race_form.php');
    exit();
}

//Distance ************************************************************************************************************************************************************ DONE (will not happen.. )

if( ( 0>$Distance) || ($Distance>26.2))
{
	$message = "<br><h2>ERROR: Please check your distance, its either 0 or bigger than a Marathon. (Your input: $Distance)</h2>";
    echo $message;
	include('add_race_form.php');
    exit();
}

// Place Finished************************************************************************************************************************************************************  DONE
// Integer between 1 and 999
//$Place;
if(!((1 <= $Place) && ($Place <= 999)))
{
	$message = "<br><h2>ERROR: Please check the place you finished, it should be between 1 and 999. (Your input: $Place)</h2>";
    echo $message;
	include('add_race_form.php');
    exit();
}

// RACE LOCATION ****************************************************************************** ****************************************************************************** DONE
// GEOCODE, and figure out if its valid (reuse function from other page)
//$Location;
if (geocode($Location) != true) 
{
    $message = "<br><h2>ERROR: Please check your address, geocode failed for: ($Location)</h2>";
    echo $message;
	include('add_race_form.php');
    exit();
}


// RACE NAME ****************************************************************************** ****************************************************************************** DONE
//RACE: must be longer than 5 letters  
//$Race;
$regexRace = "/.{5,}/";
if (!(preg_match($regexRace, $Race))) 
{
    $message = "<br><h2>ERROR: Please check your race name, it needs to be at least 5 characters long. (for race title: $Race).</h2>";
    echo $message;
	include('add_race_form.php');
    exit();
}

//IMAGES************************************************************************************************************************************* DONE
				$image_dir = 'image/racePics';
				//echo "image dir: $image_dir_path <br>";

				$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;
				//echo "image dir path: $image_dir_path <br>";

				$action = filter_input(INPUT_POST, 'action');
				if ($action == NULL)
				{
					$action = filter_input(INPUT_GET, 'action');
					if ($action == NULL) 
					{
						$action = '';
					}
				}

				//Checking if file exists....
				if (isset($_FILES['image_uploads'])) 
				{
					//gets name of file uploaded.
					$filename = $_FILES['image_uploads']['name'];
					
					//if its empty.. (do nothing)
					if (empty($filename)) 
					{
						//USE DEFAULT.
						//echo "no file <br>";
					} 
					
					else 	
					{
						//FROM:
						$source = $_FILES['image_uploads']['tmp_name'];
						//echo "source: $source <br>";
						
						//TO:
						$image_dir_path = str_replace("/pages","",$image_dir_path);
						//make new directory with username as name (NO NEED HERE).
						//mkdir($image_dir_path . "/". $myusername, 0700);
						//adding that to destination path of image. (where image will go)
						$image_dir_path = $image_dir_path ."/".$myusername;
						//echo "image_dir_path: $image_dir_path <br>";						
						$target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
						//echo "target: $target <br>";
						
						//MOVE IMAGE:
						move_uploaded_file($source, $target);
						
						// create the '400' and '100' versions of the image and replace image with the smaller one.
						process_image($image_dir_path, $filename);
						
						//now delete original: (dont do it since i'm renaming the file to orininal name in "image_util.php"
						//unlink($target);
					}
					
					//makes myimage the directory where image is located
					/*
					$myimage      = $target;
					echo "MyImage: $myimage <br>";
					//define sting to delete
					$deleteString = "/home/look4ter/public_html/php7294/Ass14/";
					//deletes part of string
					$myimage      = str_replace($deleteString, "", $myimage);
					echo "Pt 1 newstring: $myimage <br>";
					//makes data the string, then gets what extension the image is
					$data         = $myimage;
					$whatIWant    = substr($data, strpos($data, ".") + 1);
					echo "WhatIWant: $whatIWant <br>";
					
					//deletes that extension, then adds the _100 for smaller image size and adds extension of image back
					$myimage = str_replace("." . $whatIWant, "", $myimage) . "_400." . $whatIWant;				
					echo "myimage: $myimage <br>";
					echo "filename: $filename <br>";
					*/
					
					/* RESUTLTS:
					source: /tmp/phpRAoCia 
					image_dir_path: /nfs/www/WWW_pages/vojta/finishline/image/racePics 
					target: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot.JPG 
					MyImage: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot.JPG 
					Pt 1 newstring: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot.JPG 
					WhatIWant: JPG 
					myimage: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot_400.JPG 
					*/
				} 

				//IF IT DOESNT EXIST:
				else 
				{
					$filename="";
					//echo "no image";
				}
				// DONE IMAGE ******************************************************************************************************************* 



//echo "INSERT INTO $myusername(`Index`, `Date`, `Race`, `Time`, `Distance`, `Place`, `Pace`, `Location`, `Type`, `Picture`, `LinkToResults`, `LinkToActivity`, `shoes`, `Notes`)<br>";
//echo "RACE DETAILS:              $Index,  $Date,  $Race,  $Time,  $Distance,  $Place,  $Pace,  $Location,  $Type,  $filename,  $LinkToResults,  $LinkToActivity,  $shoes,  $Notes <br><br>";
//echo "Pace: $Pace, Picture: $myimage";




// POINTS  ****************************************************************************** ****************************************************************************** 
define('DB_NAME', 'vojta_data');    // The name of the database
define('DB_USER', 'vojta_data-all');     // Your MySQL username
define('DB_PASSWORD', '590d05cd'); // ...and password
define('DB_HOST', 'vojta-data.db.sonic.net');

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

//echo '<br>Connected Successfully';
//echo "<br/>";



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
				//echo "6MI convertion!!! time is now: $value4 ";
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



    $myIndex = $Index;
	$value1 =  $Race;
	$value2 =  "male";
	$value3 =  $Distance;
	$Dist   =  $value3;
	$value4 =  $Time;
	
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

	//echo "The name is: $value1 <br>";
	//echo "The sex is: $value2 <br>";
	//echo "The Distance is: $value3 <br>";
	//echo "The time is: $value9 <br>";
	
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
		//echo "Distance is $value3.<br>";
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
						
						//echo "The loop val9 is: $value9 <br>";
						
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
			//echo "The points is: $mypoints1 <br>";
		}
		//****************************************************************************** 
		else
		{}


	}
	
	//echo "The points is: $mypoints1 <br><br>";
	$Points=$mypoints1;
		/*if(!mysql_query($sql))
		{
			die('ERROR: ' . mysql_error());
		}
		mysql_close();*/
//****************************************************************************** ****************************************************************************** 


//RANK

$myquery = "Select * FROM $myusername ORDER BY Points desc";
$statement3 = $db->prepare($myquery);
$statement3->execute();
$PointsArray = $statement3->fetchAll();//$statement2->mysql_result( $statement2, 0 );
$statement3->closeCursor();
//var_dump($PointsArray);

$RankCount=0;
foreach ($PointsArray as $PointsArray) : 
		//echo "HIT: ".$PointsArray['Points']."<br>";
		
		if($PointsArray['Points'] > $Points)
		{
			$RankCount++;	
		}
		else
		{
		break;}
	
		//$myquery = ($$myusername[0]+1); 
endforeach; 
//echo "Rank: $RankCount Index: $Index<br>";

$Rank=round((($RankCount/$Index)*100), 2);
$Modified="";




//Rank based on Distance ************************************************************************************************************************************************************ DONE
$myquery2 = "Select Points FROM $myusername where Distance=$Distance ORDER BY Points DESC";
$statement6 = $db->prepare($myquery2);
$statement6->execute();
$username2 = $statement6->fetchAll();//$statement2->mysql_result( $statement2, 0 );
$statement6->closeCursor();

$myPlaceCount=0;
$myPlaceTotal=0;
foreach ($username2 as $username2) : 
		if($username2['Points']>$Points){
			$myPlaceCount++;
		    $myPlaceTotal++;
		}
		else
			$myPlaceTotal++;
endforeach; 







// ADDING RACE TO DB ******************************************************************************* ****************************************************************************** ****************************************************************************** 

// Validate inputs

if ($Index == null || $Date == false || $Race == null || $Time == null || $Distance == null || $Place == null || $Pace == null) 
{
    
    $error = "Invalid RACE data. Check all fields and try again.";
    
    include('error.php');
    exit();
}


else 
{
      
    // Add the Races to the database  
    
    //$query = 'INSERT INTO $myusername( Index,	Date, Race, Time, Distance, Place, Pace, Location, Type, Picture, LinkToResults, LinkToActivity, shoes, Notes) VALUES ( :Index, :Date, :Race, :Time, :Distance, :Place, :Pace, :Location, :Type, :Picture, :LinkToResults, :LinkToActivity, :shoes, :Notes )';
	$query = "INSERT INTO `$myusername`(`Index`, `Date`, `Race`, `Time`, `Distance`, `Place`, `Pace`, `Location`, `Type`, `Picture`, `LinkToResults`, `LinkToActivity`, `shoes`, `Notes`, `Points`, `Modified`, `DateAdded`, `Feel`) VALUES ( '" . $Index . "','" . $Date . "','" . $Race . "','" . $Time . "','" . $Distance . "','" . $Place . "','" . $Pace . "','" . $Location . "','" . $Type . "','" . $filename . "','" . $LinkToResults . "','" . $LinkToActivity . "','" . $shoes . "','" . $Notes . "','" . $Points . "','" . $Modified . "','" . $DateAdded . "','" . $Feel ."')";
	//echo "Query: $query<br><br>";
	
    $statement = $db->prepare($query);
    /*
    $statement->bindValue(':Index', $Index);
    
    $statement->bindValue(':Date', $Date);
    
    $statement->bindValue(':Race', $Race);
    
    $statement->bindValue(':Time', $Time);
    
    $statement->bindValue(':Distance', $Distance);
	
	$statement->bindValue(':Place', $Place);
    
    $statement->bindValue(':Pace', $Pace);
	
	$statement->bindValue(':Location', $Location);
	
	$statement->bindValue(':Type', $Type);
	
	$statement->bindValue(':Picture', $filename);
	
	$statement->bindValue(':LinkToActivity', $LinkToActivity);
	
	$statement->bindValue(':LinkToResults', $LinkToResults);
	
	$statement->bindValue(':shoes', $shoes);
	
	$statement->bindValue(':Notes', $Notes);
    */
	//var_dump($statement);
	
    $statement->execute();
    
    $statement->closeCursor();
    
	//header('Location: http://sonic.net/~vojta/RaceResults/index.php');
	//die();
	
	//adding one for current race.
    $myPlaceCount++;
	$myPlaceTotal++;
	
    echo "<center><br><br><tr><th><h2> * THANK YOU FOR SUBMITTING YOUR RACE: $Race!* </th></tr></h2>
	<table><tr><td>NUMBER: $Index </td></tr> 
	<tr><td> Points for this race are: $Points/1400 </tr></td> 
	<tr><td>which is ranked at: $Rank% of all your events.</tr></td> 
	<tr><td>In event: $Distance, you placed $myPlaceCount/$myPlaceTotal runs.</tr></td></table></h2></center>";
	
    // Display the Race Results again after processing and adding new race
    
    include('RaceResults.php');

}   



?>
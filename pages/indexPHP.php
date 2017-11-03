<?php
/*   VARIABLES **************************************************************

$Distance     is the distance given float value, (number)
$Index        is the first item in my database
$Year         is the selected year (number)
$dist         is array of distances 
$Name         is name of each distance ex. 3.1 is 5k
$DistanceName is array of distance names
$queryrace    is a string that will then be used as a query

DB:
$dsn          is the database system name
$username     is the username for my DB
$password     is my password
$db           is the query that will be executed? OR the results?

RACE ARRAYS:
$myrace       is array of value from a specific race, given back by the function "queryRaces"
$raceTotals   is a specific version of $myrace
$race         is also a specific version of $myrace but I need it twice to run my foreach loop 2x (one for totals and one to spit rows)

TOTALS:
$totalCount   is the total count / number of races (number)
$TotalDistance is the total distace run 
$AvgPlace      is average place that I got.

TIME:			
$AvgTime       is average time run  
$TotalTime     is total time run
$AvgPace       is average pace run

*****************************************************************************/


// USER INFO: (if im not already setting $myusername in previous file, dont overwrite it!
if($myusername=="")
{
	$myusername = $_GET["user"];
	$myusername = "$myusername";
}
	
$user_query = "SELECT * FROM users WHERE username='".$myusername."'";
$user_query_Array=queryRaces($user_query,"","");

foreach($user_query_Array as $user):
{
	$first_name = $user['first_name'];
	$last_name  = $user['last_name'];
	$userimage  = $user['Picture'];
	$about      = $user['about'];
}
endforeach;

	
//echo "Race Results for: ". $myusername;

//****************************************************************************** 


//USERNAME LOGGED IN and SECURITY:
if($myusername=="" && $mypassword=="")
{	
	//echo "<h1 style='color:red'> SORRY, invalid username or password. </h1>";
	?>	
	<script type="text/javascript">location.href = 'http://www.vojtaripa.com/finishline';</script>	
	<?php
	//header("Location: http://www.vojtaripa.com/finishline");
}
if($mypassword=="")
{
	/*echo "<h1 style='color:red'> SORRY, invalid password. </h1>";
    include("RaceResults.php?choice=search&user=".urlencode($myusername)."&Year=".urlencode('All')."&Distance=".urlencode('All'));
    exit();*/
	$mypassword = $_GET["password"]; //now gets password from URL if its not passed one...
	if($mypassword=="")
		$usernameCheck=false; //correct user logged in.
	
}

//finds which user is logged on:
$queryuser = 'SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1'; 
$statement5 = $db->prepare($queryuser);
$statement5->bindValue(':username', $myusername);
$statement5->execute();
$theuser = $statement5->fetchAll();
$statement5->closeCursor();

$theusername = $theuser['0']['username'];
$thepassword =	$theuser['0']['password'];
/*
echo "THEUSERNAME: $theusername <br>";
echo "MYUSERNAME: $myusername <br>";
echo "THEPASSWORD: $thepassword <br>";
echo "MYPASSWORD: $mypassword <br>";
*/
if($theusername=="")
{
	?>	
	<script type="text/javascript">location.href = 'http://www.vojtaripa.com/finishline';</script>	
	<?php
}
//IF USERNAME AND PASSWORD ARE NOT RIGHT
if($myusername!=$theusername || $mypassword!=$thepassword)
{
	//echo "<h1 style='color:red'>SORRY INVALID LOGIN</h1>";
	$usernameCheck=false; //correct user logged in.
}
else
$usernameCheck=true; //correct user logged in.

//ELSE RUN PAGE.
//****************************************************************************** 

//3 ARRAYS that hold some activity info:
$year=array(); //ACTIVITY YEAR
$event=array(); //ACTIVITY DISTANCE
$mark=array(); //ACTIVITY MARK

$SortIsActive = false;

// Get Distance
if (!isset($Distance)) 
{
    $Distance = filter_input(INPUT_GET, 'Distance'); //, FILTER_VALIDATE_INT //, FILTER_VALIDATE_FLOAT
    if ($Distance == NULL || $Distance == FALSE)
	{
        $Index = 1;
	}	
}

$YearSet=TRUE;
// Get Year
if (!isset($Year)) 
{
    $Year = filter_input(INPUT_GET, 'Year'); //, FILTER_VALIDATE_INT //, FILTER_VALIDATE_FLOAT
    if ($Year == NULL)
	{
        //$Year = ""; // might need to change
		$Index = 1;
		$YearSet=FALSE;
	}	
}


//SPITS OUT "ALL" if no distance was selected. WORKS
//****************************************************************************** 
//echo "Distance: $Distance ";
if($Distance==NULL || $Distance == FALSE || $Distance=="All")
{
	$queryraces = 'SELECT * FROM MyDistances ORDERBY "Date"';
	$statement1 = $db->prepare($queryraces);
	$statement1->execute();
	$dist = $statement1->fetch();
	
	$Name = "All";

	$statement1->closeCursor();
	
	//echo "Dist is NULL or FALSE<br>";
}

else
{
	// IF DISTANCE IS SELECTED, Spits out distance name.

	$queryraces = 'SELECT * FROM MyDistances WHERE Distance = :Distance';
	$statement1 = $db->prepare($queryraces);
	$statement1->bindValue(':Distance', $Distance);
	//$statement1->bindValue(':Year', $Year);
	$statement1->execute();
	$dist = $statement1->fetch();
	//var_dump($dist);

	$Name = $dist['distName'];
	//echo "my name is: $Distance"; //works.

	$statement1->closeCursor();

    //echo "Dist is *NOT* NULL or FALSE<br>";
} 


//****************************************************************************** 




/* MY DATABASE CONNECTION:

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
*/	
	

// Get all distances WORKS
//****************************************************************************** 
$query = 'SELECT * FROM MyDistances ORDER BY Distance';
$statement = $db->prepare($query);
$statement->execute();
$DistanceName = $statement->fetchAll();
$AllDistances = $DistanceName;
$PRDistances  = $DistanceName;
$PRdist       = $DistanceName;
$PRdist2	  = $DistanceName;

$statement->closeCursor();
//****************************************************************************** 




// Get races for all distances
//****************************************************************************** 
//$race;


// This should be working, returns an array of race results.
function queryRaces($queryrace, $Distance, $Year) 
{
    //echo"QUERY: $queryrace Distance: $distance Year: $Year";
	
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
	
	if($Year=="%")
		$Year="";
	//DISTANCE NOT NULL
	if($Distance!=NULL && $Distance!='All')
	{
		$statement3->bindValue(':Distance', $Distance);
	}
	
	//YEAR NOT NULL or not equal to All
	if($Year!=NULL && $Year!='All')
	{
		$statement3->bindValue(':Year', $Year);
	}
	
	/*if($Year=="")
	{
		$statement3->bindValue(':Year', "All");
	}
	
	if($Distance=="")
	{
		$statement3->bindValue(':Distance', "All");
	}*/
	
	
	//$statement3->bindValue(':Year', $Year);
	$statement3->execute();
	$myrace = $statement3->fetchAll();
	//$race=$myrace;
	//echo $Distance;
	
	$statement3->closeCursor();
	//echo "not NULL";
	return $myrace;
} 

$raceMap=0;
//echo "Distance: $Distance";
//echo "Year: $Year";




//GETTING ALL RACES QUERIED UP....
//****************************************************************************** 

//IF ALL and ALL
if($Distance=='All' && $Year=='All')
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' order by Date DESC'; // order by index? 
	$race = queryRaces($queryrace1, $Distance, $Year);
	$raceTotals=$race;
	$raceMap=$race;
	//echo "HELLO";
}

// IF ALL DISTANCE
else if($Distance=='All')
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' WHERE (Date LIKE :Year) order by Date DESC'; // order by index? 
	$race = queryRaces($queryrace1, $Distance, $Year."%");
	$raceTotals=$race;
	$raceMap=$race;
	//echo "$Date";
}

//IF ALL YEAR
else if($Year=='All')
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' WHERE (Distance LIKE :Distance) order by Date DESC'; // order by index? 
	$race = queryRaces($queryrace1, $Distance, $Year);
	$raceTotals=$race;
	$raceMap=$race;
	//echo "HELLO";
}

// LIMITING TO 10 IF NOTHING HAS BEEN SELECTED.
else if($Distance==NULL && $Year==NULL)
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' order by Date DESC LIMIT 10'; // order by index? 
	$race = queryRaces($queryrace1, "All", "All"); //$Distance, $Year."%"
	$raceTotals=$race;
	$raceMap=$race;
	//echo "HELLO";
} 

//IF only distance is not selected.
else if($Distance==NULL)
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' WHERE (Date LIKE :Year) order by Date DESC'; // order by index? 
	$race = queryRaces($queryrace1, $Distance, $Year."%"); 
	$raceTotals=$race;
	$raceMap=$race;
	//echo "HELLO";
	
}

//IF only year is not selected.
else if($Year==NULL)
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' WHERE (Distance LIKE :Distance) order by Date DESC'; // order by index? 
	$race = queryRaces($queryrace1, $Distance, $Year."%"); 
	$raceTotals=$race;
	$raceMap=$race;
	//echo "HELLO";
	
}

// Get races for selected distance and year. (if index is given)
else
{
	$queryrace1 = 'SELECT * FROM '.$myusername.' WHERE (Distance = :Distance AND Date LIKE :Year) order by Date DESC';  //SELECT * FROM $myusername WHERE (Distance = '1.00' AND Date LIKE '2015%') MAY NEED QUOTES?
	$race = queryRaces($queryrace1, $Distance, $Year."%");
	$raceTotals=$race;
	$raceMap=$race;
	//echo "ELSE";
}

//echo "Year: $Year" . $Year;


//****************************************************************************** 




/* NEED TO IMPLEMENT THIS WHEN I HAVE A LOG IN PAGE
//finds which user is logged on:
$myusername = filter_input(INPUT_POST, 'myusername');
//echo $myusername;
$queryuser = 'SELECT username FROM users where username=:myusername'; //ORDER BY idusers DESC limit 1
$statement5 = $db->prepare($queryuser);
$statement5->bindValue(':myusername', $myusername);
$statement5->execute();
$theuser = $statement5->fetchAll();
$statement5->closeCursor();
*/






// MORE CALCULATIONS  ****************************************************************************** 

//INITIAL VALUES -->
 $totalCount=0; $TotalDistance=0; $TotalPlace =0;
 //PRINT ARRAY OR CALCULATIONS:
$printArray = array();
$timeArray  = array();
$paceArray  = array();
			
function addTime($inputTime, &$totalH, &$totalM, &$totalS, $CurrentDistance, &$printArray) //$inputH,$inputM,$inputS
{	
	//now i need to strip h i s from this 
	$s= substr($inputTime, (strlen($inputTime)-2)); // makes seconds the last 2 chars
    $inputTime=substr($inputTime,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
	$m= substr($inputTime, (strlen($inputTime)-2)); 
	$inputTime=substr($inputTime,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
	$h= $inputTime; 
	
	//PRINT
	array_push($printArray, "<br>addTime, inputTime: $inputTime (before adding) H: $totalH M: $totalM S: $totalS Dist: $CurrentDistance. ADDING: $h:$m:$s after multiplying it by $CurrentDistance<br>");
	
	//USE THIS FOR TOTALS? add each individual piece
	$totalH+=($h*$CurrentDistance);
	$totalM+=($m*$CurrentDistance);
	$totalS+=($s*$CurrentDistance);
	
	//PRINT
	array_push($printArray, "Time Totals(after adding): H: $totalH M: $totalM S: $totalS X   ". (($totalM*60)+$totalS))."<br><br>";
	array_push($printArray, "$h*$CurrentDistance=". ($h*$CurrentDistance)." $m*$CurrentDistance= ".($m*$CurrentDistance) ." $s*$CurrentDistance=".($s*$CurrentDistance)."<br>");
	
	
	//Then send updated totals back to user	
	return array($totalH,$totalM,$totalS);
}

//GETS TIME in TIME FORMAT AND CONVERTS IT TO SECONDS.
function TimeToSeconds($inputTime, &$printArray) 
{	
	//now i need to strip h m s from this 
	$s= substr($inputTime, (strlen($inputTime)-2)); // makes seconds the last 2 chars
    $inputTime=substr($inputTime,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
	$m= substr($inputTime, (strlen($inputTime)-2)); 
	$inputTime=substr($inputTime,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
	$h= $inputTime; 
	
	//PRINT
	array_push($printArray,"TimeToSeconds(adding/before): $h:$m:$s <br>");
	
	//USE THIS FOR TOTALS? add each individual piece
	$totalH=($h*60*60);
	$totalM=($m*60);
	$totalS=($s);
	
	//Then send updated totals back to user	
	
	//PRINT
	array_push($printArray,"TimeToSeconds: TotalTime- $totalH:$totalM:$totalS, Total: (". ($totalH+$totalM+$totalS) .") <br>");
	
	return ($totalH+$totalM+$totalS);
}

//GETS SECONDS AND CONVERTS BACK TO TIME FORMAT
function SecondsToTime($inputTime, &$printArray) 
{	
	//echo nl2br("Seconds are now: $Seconds \n");
	if($inputTime>=(60*60))
	{
		$CaryOver=$inputTime%(60*60);
		$Hours=floor($inputTime/(60*60));
		$inputTime=$CaryOver;
		//echo nl2br("Seconds are now: $CarryOver \n");
				
	}

	if($inputTime>=60)
	{
		$CaryOver=$inputTime%60; //Remainder
		$Minutes=floor($inputTime/60);
		$inputTime=$CaryOver;
		//echo nl2br("Minutes are now: $CarryOver \n");
		
	}
	$Seconds=$inputTime;
	
	array_push($printArray,"SecToTime: ","$Hours:$Minutes:$Seconds","<br>");
	
	//NOW Correct the FORMAT
	if($Hours<10)
	{$Hours="0".$Hours;}	
	if($Minutes<10)
	{$Minutes="0".$Minutes;}
	if($Seconds<10)
	{$Seconds="0".$Seconds;}
	
	
	return ("$Hours:$Minutes:$Seconds");
}

/* MEAN MEDIAN MODE ****************************************************************************** */
//The function mmmr (Mean, Median, Mode, Range) will calculate the Mean, Median, Mode, or Range of an array. 
//It automatically defaults to Mean (average). 

function mmmr($array, $output = 'mean')
{ 
    if(!is_array($array))
	{ 
        return FALSE; 
    }
	else
	{ 
        switch($output)
		{ 
            //MEAN
			case 'mean': 
                $count = count($array); 
                $sum = array_sum($array); 
				if($totalCount==0)
					$total=0;
				else
					$total = $sum / $count; 
            break; 
            //MEDIAN
			case 'median': 
                rsort($array); 
				//echo "After Rsort: ";
				//var_dump($array);
				//echo "<br>";
				//echo "Count: ". count($array)." <br>";
                $middle = round(count($array)/ 2);
				//echo "Middle: $middle <br>";
                $total = $array[$middle-1]; 
				//echo "Total: $total <br>";
            break; 
            //MODE
			case 'mode': 
                $v = array_count_values($array); 
                arsort($v); 
                foreach($v as $k => $v){$total = $k; break;} 
            break; 
            //RANGE
			case 'range': 
                sort($array); 
                $sml = $array[0]; 
                rsort($array); 
                $lrg = $array[0]; 
                $total = $lrg - $sml; 
            break;
			//BEST VALUE (lowest)
			case 'best': 
			    sort($array); 
                $sml = $array[0]; 
                $total = $sml; 
            break;
			//WORST VALUE (highest)
			case 'worst': 		    
				rsort($array); 				
                $lrg = $array[0]; 
                $total = $lrg; 
            break;
        } 
        return $total; 
    } 
} 
/* END MEAN MEDIAN MODE ****************************************************************************** */


//Arrays for storing raw values
$RaceRunArray  = array();
$TimeArray     = array();
$DistanceArray = array();
$PlaceArray    = array();
$PaceArray     = array();
$Totalpoints = 0;

// NEED TO GET TOTALS / DATA, jumping through each race and getting values:
foreach ($raceTotals as $raceTotals) :
	$Totalpoints+=$raceTotals['Points'];
	
	array_push ($year,substr($raceTotals['Date'],0,4)); //ACTIVITY YEAR (just get the year)
	
	//Race count
	$totalCount++;
	array_push($RaceRunArray, $totalCount);
	
	//Time
	array_push ($mark,$raceTotals['Time']); //ACTIVITY MARK
	array_push($printArray,"$totalCount. ****************************************************************************** ******************************************************************************<br><br> ");
	array_push($TimeArray, $raceTotals['Time']);
	array_push($printArray,("TIME LOOP (after itteration): RaceTotal-".$raceTotals['Time'].", TimeH-$TimeTotalH, TimeM-$TimeTotalM, TimeS-$TimeTotalS, 1 <br><br>"));
	array_push($timeArray, $raceTotals['Time']);
	list($TimeTotalH,$TimeTotalM,$TimeTotalS) = addTime($raceTotals['Time'],&$TimeTotalH, &$TimeTotalM, &$TimeTotalS, 1, $printArray); // incrementing / adding hours minutes seconds
		
	
	//Pace
	array_push($printArray,"$totalCount. ****************************************************************************** ******************************************************************************<br><br> ");
	array_push($PaceArray, $raceTotals['Pace']);
	array_push($printArray,("PACE LOOP (after itteration): RaceTotals-".$raceTotals['Pace'].", PaceH-$PaceTotalH, PaceM-$PaceTotalM, PaceS-$PaceTotalS, raceDistance(of one race)-".$raceTotals['Distance']." <br><br>"));
	array_push($paceArray, $raceTotals['Pace']);
	list($PaceTotalH,$PaceTotalM,$PaceTotalS) = addTime($raceTotals['Pace'],&$PaceTotalH, &$PaceTotalM, &$PaceTotalS, $raceTotals['Distance'], $printArray); // incrementing / adding hours minutes seconds
	
	
	//Distance
	array_push($event,$raceTotals['Distance']); //ACTIVITY DISTANCE
	array_push($DistanceArray, $raceTotals['Distance']);		
	$TotalDistance=$TotalDistance+$raceTotals['Distance']; 
	//Place
	array_push($PlaceArray, $raceTotals['Place']);
	$TotalPlace=$TotalPlace+$raceTotals['Place'];
	
endforeach;

$MPHarray = $PaceArray; 
//print_r($MPHarray);
//print_r($RaceRunArray);

//Cleaning up times: if greater than 60 add to next column
function correctTime($Hours,$Minutes,$Seconds, &$printArray)
{
	array_push($printArray,"CorrectTime (before loops):  H:$Hours M:$Minutes S:$Seconds <br>");
	//echo nl2br("Seconds are now: $Seconds \n");
	if($Seconds>=60)
	{
		$CaryOver=$Seconds%60;
		$Minutes+=floor($Seconds/60);
		$Seconds=$CaryOver;
		//echo nl2br("Seconds are now: $CarryOver \n");
		
	}

	if($Minutes>=60)
	{
		$CaryOver=$Minutes%60; //Remainder
		$Hours+=floor($Minutes/60);
		$Minutes=$CaryOver;
		//echo nl2br("Minutes are now: $CarryOver \n");
		
	}
	
	//NOW Correct the FORMAT
	if($Hours<10)
	{$Hours="0".$Hours;}	
	if($Minutes<10)
	{$Minutes="0".$Minutes;}
	if($Seconds<10)
	{$Seconds="0".$Seconds;}
	

    array_push($printArray,"CorrectTime (after):  H:$Hours M:$Minutes S:$Seconds <br><br>");
	
	return array($Hours,$Minutes,$Seconds);
}

list($TimeTotalH,$TimeTotalM,$TimeTotalS)=correctTime($TimeTotalH,$TimeTotalM,$TimeTotalS, $printArray); //Correcting total time
list($PaceTotalH,$PaceTotalM,$PaceTotalS)=correctTime($PaceTotalH,$PaceTotalM,$PaceTotalS, $printArray); //correcting pace

//YEARS ****************************************************************************** 
//start year:
//$StartYear=2005;
$queryStartYear = "SELECT MIN(Date) FROM ". $myusername;
$queryStartYearArray=queryRaces($queryStartYear,"","");
$StartYear=substr($queryStartYearArray[0][0], 0, 4);//gets year
//var_dump($queryStartYearArray);

//current year:
//$CurrentYear=2017;
$todaysDate = date('Y');
//$default_date = new DateTime();
$CurrentYear=$todaysDate;

if($StartYear=="")
	$StartYear=$CurrentYear;

//echo "Start year: $StartYear. End Year: $CurrentYear";
//****************************************************************************** 

if($YearSet==FALSE or $Year=='All')
$TotalYears=($CurrentYear-$StartYear)+1;
else
$TotalYears=1;

//Just adding Days 
$Days=0;

if($TimeTotalH>=24)
{
	$CaryOverX=$TimeTotalH%24;
	$Days+=floor($TimeTotalH/24);
	$TimeTotalH=$CaryOverX;
	
	if($Hours<10)
	{$Hours="0".$Hours;}
}

//MORE TOTALS: Put Times back together
if($Days!=0)
{$TotalTime="$Days Days $TimeTotalH Hours $TimeTotalM Minutes $TimeTotalS Seconds.";}
else
{$TotalTime="$TimeTotalH:$TimeTotalM:$TimeTotalS";}

$TotalPace="$PaceTotalH:$PaceTotalM:$PaceTotalS"; // need to get total before average.

//my totals array
$TOTALS  = array("TOTALS", $totalCount, $TotalTime, $TotalDistance, $TotalPlace, $TotalPace, "Total of all values." );




// Getting Averages
//$AvgPace = $AvgPace/$totalCount;
$AvgRacesPerYear = floor($totalCount/$TotalYears);
//$AvgTime = $AvgTime/$totalCount;
if($totalCount==0)
$AvgPlace=0;
else
$AvgPlace = floor($TotalPlace/$totalCount);

if($totalCount==0)
$AvgDistance=0;
else
$AvgDistance = round($TotalDistance/$totalCount, 2);

if($totalCount==0)
$AvgPoints=0;
else
$AvgPoints = round($Totalpoints/$totalCount, 2);


if($totalCount==0)
$AvgTime=0;
else
{
list($avgTimeTotalH,$avgTimeTotalM,$avgTimeTotalS)= correctTime(0,0,((($Days*60*60*24)+($TimeTotalH*60*60)+($TimeTotalM*60)+$TimeTotalS)/$totalCount),$printArray); // total number of seconds.
$AvgTime= "$avgTimeTotalH:$avgTimeTotalM:".round($avgTimeTotalS,2);
}
array_push($printArray,"AVG TIME: ","correctTime(0,0,((($Days*60*60*24)+($TimeTotalH*60*60)+($TimeTotalM*60)+$TimeTotalS)/$totalCount))" ,"<br><br>");


if($totalCount==0)
$AvgPace=0;
else 
{
list($avgPaceTotalH,$avgPaceTotalM,$avgPaceTotalS)= correctTime(0,0,(((($PaceTotalH)*60*60)+(($PaceTotalM)*60)+($PaceTotalS))/($TotalDistance)),$printArray);   //works now, instead of getting average, I had to factor in the distance run at that pace to make it more accurate.
$AvgPace= "$avgPaceTotalH:$avgPaceTotalM:".round($avgPaceTotalS,2);
}
array_push($printArray,"AVG. PACE: ","correctTime(0,0,(((($PaceTotalH)*60*60)+(($PaceTotalM)*60)+($PaceTotalS))/($TotalDistance)))" ,"<br><br>");


//my average array
$AVERAGE = array("AVERAGE", $AvgCount, $AvgTime, $AvgDistance, $AvgPlace, $AvgPace );




//MEAN is the average.

$MEAN    = array("MEAN" , mmmr($RaceRunArray, 'mean'), $AvgTime, mmmr($DistanceArray, 'mean'), round(mmmr($PlaceArray, 'mean'),2), $AvgPace, "The average of each value.");

//MEDIAN
$MEDIAN  = array("MEDIAN" , mmmr($RaceRunArray, 'median'), mmmr($TimeArray, 'median'), mmmr($DistanceArray, 'median'), mmmr($PlaceArray, 'median'), mmmr($PaceArray, 'median'), "The middle of all the values, after sorting them.");
/*var_dump($RaceRunArray);
echo"<br>";
var_dump(mmmr($RaceRunArray, 'median'));
echo"<br>";
echo"<br>";
var_dump($TimeArray);
echo"<br>";
var_dump($DistanceArray);
echo"<br>";
var_dump($PlaceArray);
echo"<br>";
var_dump($PlaceArray);*/

//MODE
$MODE    = array("MODE" , mmmr($RaceRunArray, 'mode'), mmmr($TimeArray, 'mode'), mmmr($DistanceArray, 'mode'), mmmr($PlaceArray, 'mode'), mmmr($PaceArray, 'mode'), "The most occured value.");

//RANGE
$RangeTime= SecondsToTime(TimeToSeconds((mmmr($TimeArray, 'worst')),$printArray) - TimeToSeconds((mmmr($TimeArray, 'best')),$printArray),$printArray);
$RangePace= SecondsToTime(TimeToSeconds((mmmr($PaceArray, 'worst')),$printArray) - TimeToSeconds((mmmr($PaceArray, 'best')),$printArray),$printArray); 

$RANGE   = array("RANGE" , mmmr($RaceRunArray, 'range'), $RangeTime , mmmr($DistanceArray, 'range'), mmmr($PlaceArray, 'range'), $RangePace, "The range of value beween the largest and smallest.");

//BEST (create functions)
$BEST    = array("BEST" , mmmr($RaceRunArray, 'best'), mmmr($TimeArray, 'best'), mmmr($DistanceArray, 'best'), mmmr($PlaceArray, 'best'), mmmr($PaceArray, 'best'), "The best / lowest value.");

//WORST (create functions)
$WORST   = array("WORST" , mmmr($RaceRunArray, 'worst'), mmmr($TimeArray, 'worst'), mmmr($DistanceArray, 'worst'), mmmr($PlaceArray, 'worst'), mmmr($PaceArray, 'worst'), "The worst / highest value.");


// Pace to MPH conversion

$max = sizeof($MPHarray);
for($i=0;$i<$max;$i++)
{
	$PaceToMPH = array_pop($MPHarray); 
	$PaceToMPH = (1/(TimeToSeconds($PaceToMPH,$printArray))) *60 *60;
	array_unshift($MPHarray, "$PaceToMPH"); 
}	
//print_r($MPHarray);

for($i=0;$i<$max;$i++)
{
	$TotalMPH+=$MPHarray[$i];
}

if($totalCount==0)
$AverageMPH=0;
else
$AverageMPH=$TotalMPH/$totalCount;


//MPH FUNCTION:
function PaceToMPH($PaceMPH, &$printArray)
{
	$PaceMPH=(1/(TimeToSeconds($PaceMPH, &$printArray))) *60 *60;
	return $PaceMPH;
}


//echo "Total MPH: $TotalMPH, Avg: $AverageMPH";
//Query for biggest year (just use current year):

//Query for smallest year:

//Number of years difference:
				
		

// USING NEXT FEW FUNTIONS TO FIND TIME DIFFERENCES: **********************************************************************************************************************************************************************************************
//****************************************************************************** ****************************************************************************** 


//1. TimeToSeconds: GETS TIME in TIME FORMAT AND CONVERTS IT TO SECONDS.
function TimeToSecondsNEW($inputTime) 
{	
	//now i need to strip h m s from this 
	$s= substr($inputTime, (strlen($inputTime)-2)); // makes seconds the last 2 chars
    $inputTime=substr($inputTime,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
	$m= substr($inputTime, (strlen($inputTime)-2)); 
	$inputTime=substr($inputTime,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
	$h= $inputTime; 
	
	//USE THIS FOR TOTALS? add each individual piece
	$totalH=($h*60*60);
	$totalM=($m*60);
	$totalS=($s);
	
	//Then send updated totals back to user		
	return ($totalH+$totalM+$totalS);
}

//2. SUBTRACT: SUBTRACTS 2 numbers and returns result
function subtract($time1, $time2)
{
	$total=$time1-$time2;
	return $total;
}

//3. GETS SECONDS AND CONVERTS BACK TO TIME FORMAT
function SecondsToTimeNEW($inputTime) 
{	
	//echo nl2br("Seconds are now: $Seconds \n");
	//HOUR
	if($inputTime>=(60*60))
	{
		$CaryOver=$inputTime%(60*60);
		$Hours=floor($inputTime/(60*60));
		$inputTime=$CaryOver;
		
	}
    //MIN
	if($inputTime>=60)
	{
		$CaryOver=$inputTime%60; //Remainder
		$Minutes=floor($inputTime/60);
		$inputTime=$CaryOver;
		//echo nl2br("Minutes are now: $CarryOver \n");
		
	}
	//SEC
	$Seconds=$inputTime;
		
	//NOW Correct the FORMAT
	if($Hours<10)
	{$Hours="0".$Hours;}	
	if($Minutes<10)
	{$Minutes="0".$Minutes;}
	if($Seconds<10)
	{$Seconds="0".$Seconds;}
	
	
	return ("$Hours:$Minutes:$Seconds");
}

function mypaceNEW($Time, $Distance)
{
	//total seconds / dist, then convert back to time
	$seconds=TimeToSecondsNEW($Time);
	$pace=$seconds/$Distance;
	$paceTime=SecondsToTimeNEW($pace);
	
	return $paceTime;
}

		
//******************************************************************************  *************************************************************************************************************************
/******************************************************************************************************************************************************************************************************************************************** 


END PHP STARTING HTMLS


****************************************************************************** ****************************************************************************** ****************************************************************************** 
****************************************************************************** ************************************************************************************************************************************************************ */



//$Year = $Year . "%"; // need to make it wild card for query search


//PRINT ARRAY:
  sort($timeArray); //arsort rsort
  sort($paceArray); //arsort rsort

?>
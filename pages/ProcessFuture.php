<?php
require_once ('database.php');

//FIRST DELETE ALL EXISTING DATA IN DB:
$myraceTEST = filter_input(INPUT_POST, ('race0'));

if($myraceTEST=="")
{
	include("future.php");
	exit(-1);
}

$sql1 = "DELETE FROM futureRaces";
$query1 = $sql1;
$statement2 = $db->prepare($query1);
$statement2->execute();
$statement2->closeCursor();
//****************************************************************************** 


//GET VARIABLES from previous page:

$amount = filter_input(INPUT_POST, 'amount');
//echo "Amount of races: ".$amount."<br>";



//FORLOOP TO GET rest of races pulled in.
for($i=0;$i<$amount;$i++)
{
	$myrace = filter_input(INPUT_POST, ('race'.$i));
    
	
	//$lastChar = substr(strrchr($myrace, 1), 1 );
	$length=strlen ( $myrace );
	$lastChar = substr($myrace, ($length-1), 1);
	
	//echo "->" . $lastChar . "******************************************************************************<br>";
	
	$DATE= get_string_between($myrace,"Date: "," Race Name:");
	//echo "date: $DATE <br>";
	
	//$DATE= substr ( $DATE,0, -1);
	
	$NAME= get_string_between($myrace,"Name: ",$lastChar);
	
	//echo "my race: $myrace <br> date: $DATE and name: $NAME <br>";
	// INPUT RACE
	
  if($DATE=='' || $NAME=='')
  {
	 $sql="";
  }
  
  else
  {
	  $checked=filter_input(INPUT_POST, ('checked'.$i));//GET VARIABLE
	  
	  if(preg_match("/checked/", $checked)) //javascript /checked/.test($checked)
	  {
		  $sql = "INSERT INTO futureRaces VALUES(NULL,'". $NAME ."',0,'". $DATE ."');"; //$myrace
	  }
	  else
	  {
		  $sql = "INSERT INTO futureRaces VALUES(NULL,'". $NAME ."',1,'". $DATE ."');"; //$myrace
	  }
	  //$sql="";
	  //echo "$i. INSERT INTO futureRaces VALUES(NULL,'". $NAME ."',0,'". $DATE ."'); <br>"; //$race
  }
  
// ADDING RACE TO DB ******************************************************************************* ****************************************************************************** ****************************************************************************** 

	$query = $sql;
	
    $statement = $db->prepare($query);

    $statement->execute();
    
    $statement->closeCursor();
}


//used to get date and name from string given. 
function get_string_between($string, $start, $end){
    $string = " ".$string;
     $ini = strpos($string,$start);
     if ($ini == 0) return "";
     $ini += strlen($start);     
     $len = strpos($string,$end,$ini) - $ini;
     return substr($string,$ini,$len);
}

//THEN make it go back to previous page...
include('future.php');
?>



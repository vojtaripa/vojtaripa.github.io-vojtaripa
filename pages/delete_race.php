<?php

require_once('database.php');

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

//need to trim white space ect:
	$myusername=trim($myusername," \t\n\r\0\x0B");
	$mypassword=trim($mypassword," \t\n\r\0\x0B");

if($mypassword=="")
{
	echo "<h1 style='color:red'> SORRY, invalid password. </h1>";
    //include("RaceResults.php?choice=search&user=".urlencode($myusername)."&Year=".urlencode('All')."&Distance=".urlencode('All'));
    exit();
}
else
{
	//finds which user is logged on:
	$queryuserNEW = "SELECT * FROM users WHERE username = '".$myusername."' ORDER BY idusers DESC limit 1"; 
	$statement6 = $db->prepare($queryuserNEW);
	//$statement5->bindValue(':username', $myusername);
	$statement6->execute();
	$theuserX = $statement6->fetchAll();
	$statement6->closeCursor();
	//var_dump($theuserX);
	
	$theusername = $theuserX['0']['username'];
	$thepassword =	$theuserX['0']['password'];
	
	//DISPLAY OUTPUTS OF VARS:	
	/*
	echo "THEUSERNAME: $theusername <br>";
	echo "MYUSERNAME: *$myusername* <br>";
	echo "THEPASSWORD: $thepassword <br>";
	echo "MYPASSWORD: $mypassword <br>";
	*/
	
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


// STILL NEED TO MODIFY IF I WANT TO DELETE RACES.


// Get IDs

$Index = filter_input(INPUT_POST, 'Index', FILTER_VALIDATE_INT);
$Race = filter_input(INPUT_POST, 'Race'); //, FILTER_VALIDATE_INT
//echo "Index: $Index, Race: $Race";

// Delete the race from the database

if ($Index != false){ // && $category_id != false) {

    $query = "DELETE FROM `$myusername` WHERE `$myusername`.`Index` =". $Index;
	        //DELETE FROM `MyRaceResults` WHERE `MyRaceResults`.`Index` = 332
    //echo "Query: $query";
    $statement = $db->prepare($query);

    $statement->bindValue(':Index', $Index);

    $success = $statement->execute();

    $statement->closeCursor();    

}

echo "<center><h2>DELETED: $Race </h2></center>";


// Display the player List page

include('RaceResults.php');
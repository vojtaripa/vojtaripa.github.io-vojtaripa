<?php
require_once('../database.php');
//require('secure_conn.php');


// start the session with a persistent cookie of 1 year
/*
$lifetime = 60 * 60 * 24 * 365;             // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();

// get the array of tasks from the session
if (isset($_SESSION['tasklist'])) 
{
    $task_list = $_SESSION['tasklist'];
}
else 
{
    $task_list = array();
}
*/
//***********************************************************************

//GET ALL VARIABLES
$team1=filter_input(INPUT_POST, 'TeamID');
$team2=filter_input(INPUT_POST, 'TeamID2');
$date=filter_input(INPUT_POST, 'new_matchup');

//TEAM 1
if($team1==1)
$team1="packers";
else if($team1==2)
$team1="49ers";
else if($team1==3)
$team1="panthers";
else if($team1==4)
$team1="colts";
else if($team1==5)
$team1="raders";
else
$team1=1;

//TEAM 2
if($team2==1)
$team2="packers";
else if($team2==2)
$team2="49ers";
else if($team2==3)
$team2="panthers";
else if($team2==4)
$team2="colts";
else if($team2==5)
$team2="raders";
else
$team2=10;


$new_match="$team1" . " VS. " . "$team2" . " on ". "$date";

//echo $new_match;
//echo $team1;
//echo $team2;
//echo $date;

//OLD ASS 6?
//get tasklist array from POST
$task_list = filter_input(INPUT_POST, 'tasklist', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

//Get all entries from database
if ($task_list === NULL) 
{
   /* $task_list = array();
    $task_list[] = 'Packers VS. Steelers on 7/4/2015';
    $task_list[] = 'Panthers VS. Steelers on 6/2/2015';
    $task_list[] = 'Bills VS. Jaguars on 6/10/2015';
	$task_list[] = 'Raiders VS. Jets on 7/10/2015';
    $task_list[] = 'Bucs VS. 49ers on 6/14/2015';
    $task_list[] = 'Staints VS. Seahawks on 6/22/2015';*/
	//require('../database.php');

	$query = 'SELECT * FROM matchups ORDER BY date';
	$statement = $db->prepare($query);
	$statement->execute();
	$matchups = $statement->fetchAll();
	$statement->closeCursor();

	$task_list = array();
	
	foreach ($matchups as $matchups) :
		$task_list[]= "$matchups[team1]" . " VS. " . "$matchups[team2]". " on ". "$matchups[date]"; //"$matchups[idmatchups]" .
	endforeach;
	//$query = mysql_query("UPDATE users SET imagelocation='.$location.' WHERE user_name='.$_SESSION['user_name'].'"); 
	//$query = mysql_query("UPDATE users SET `imagelocation`='".$location."' WHERE `user_name`='".$_SESSION['user_name']."'"); 
	//require_once('database.php');

}

//get action variable from POST
$action = filter_input(INPUT_POST, 'action');

//initialize error messages array
$errors = array();




//********Inputting in array ******************************************************************



//process
switch( $action ) 
{
   //SAVE ALL MATCHUPS
   //delete database, add all new entries in. 
   //parse array to get each entry back into database
   //loop and input all array values into database forloop using array index as counter
   case 'SAVE ALL MATCHUPS':
        //$new_match = filter_input(INPUT_POST, 'new_matchup');
        if (empty($new_match)) 
		{
            $errors[] = 'The new task cannot be empty.';
        } 
		else 
		{
			//delete all entries in database for matche-ups 
			$query = 'DELETE FROM matchups ';

			$statement = $db->prepare($query);

			$success = $statement->execute();

			$statement->closeCursor();    
			//************************************************
			//parse array to get each entry back into database
			
			//ex 49ers VS. packers on 1/1/2016
            $myid=0;
			foreach( $task_list as $task ) :
              $wholestring=$task;
			  //echo $wholestring."<br>";
			  $firstspace=strpos($wholestring, ' '); //find first space occurrence
			  //echo $firstspace."<br>";
			  $arrayteam1= substr($wholestring, 0, $firstspace); //gets word all the way to first space
			  //echo $arrayteam1."<br>";
			  $deletepart1="$arrayteam1"." VS. ";
			  //echo $deletepart1."<br>";
			  
			  $wholestring=str_replace($deletepart1, "", $wholestring); //gets rid of first part of string
			  
			  //string should look like this: 'packers on 1/1/2016'
			  $firstspace=strpos($wholestring, ' '); //find first space occurrence
			  //echo $firstspace."<br>";
			  $arrayteam2= substr($wholestring, 0, $firstspace); //gets word all the way to first space
			  //echo $arrayteam2."<br>";
			  
			  //string should look like this: '1/1/2016'
			  $wholestring=str_replace($arrayteam2 . " on ", "", $wholestring); //gets rid of first part of string
			  $arraydate=$wholestring;
			  //echo $arraydate."<br>";
			   // Add the matchup to the database  
	
				$query = 'INSERT INTO matchups (idmatchups, team1, team2, date) VALUES
							 (:id, :team1, :team2,:date)'; //idmatchups

				$statement = $db->prepare($query);

				$statement->bindValue(':team1', $arrayteam1);

				$statement->bindValue(':team2', $arrayteam2);
				 
				$statement->bindValue(':date', $arraydate);
				
				$statement->bindValue(':id', $myid);

				$statement->execute();

				$statement->closeCursor();

				$myid++;
            endforeach; 
			//**************************************************
			//now that I have all the variables I can put them into my database
			
			
        }
        break;
   
   //ADD   
   case 'Add Match-up':
        //$new_match = filter_input(INPUT_POST, 'new_matchup');
		if($team1 == $team2)
		{
			$message = 'Same team can\'t play it-self. Please select two different teams.';
            include('matchup.php');
			exit();
		}
		//************************ DATE TESTER *************************************************************

		//set default value
		$message = '';

        $default_date = new DateTime();
       // $default_date->sub($interval);
        $match = $default_date->format('n/j/Y');

        $match = filter_input(INPUT_POST, 'new_matchup');
        //$due_date_s = filter_input(INPUT_POST, 'due_date');

        // make sure the user enters both dates
        if (empty($match)){ //|| empty($due_date_s)) {
            $message = 'You must enter date. Please try again.';
            include('matchup.php');
			exit();
        }

        // convert date strings to DateTime objects
        // and use a try/catch to make sure the dates are valid
        try 
		{
            $matchdate_new = new DateTime($match);
            $cur_date = new DateTime();
        } 
		catch (Exception $e) 
		{
            $message = 'Date must be in a valid format. Please check date and try again.';
            include('matchup.php');
			exit();
        }

        // make sure the due date is after the invoice date
        if ($cur_date > $matchdate_new) 
		{
            $message = 'The Match Date must come after today. Please try again.';
            include('matchup.php');
			exit();
        }

        // set a format string for all dates
        $format_string = 'F j, Y';

        // format both dates
        $match_newnew = $matchdate_new->format($format_string);
       
		$finalDate=$match_newnew;


        if (empty($new_match)) 
		{
            $errors[] = 'The new task cannot be empty.';
        } 
		else 
		{
            // $task_list[] = $new_match;
			
            array_push($task_list, $new_match);
        }
        break;
		
	//DELETE	
    case 'Delete Match-up':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) 
		{
            $errors[] = 'The task cannot be deleted.';
        } 
		else 
		{
            unset($task_list[$task_index]);
            $task_list = array_values($task_list);
        }
        break;
		
	//MODIFY	
    case 'Modify Match-up':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) 
		{
            $errors[] = 'The task cannot be modified.';
        } 
		else 
		{
            $task_to_modify = $task_list[$task_index];
        }
        break;
		
	//SAVE	
    case 'Save Match-up':
        $i = filter_input(INPUT_POST, 'modifiedtaskid', FILTER_VALIDATE_INT);
        $modified_task = filter_input(INPUT_POST, 'modifiedtask');
        if (empty($modified_task)) 
		{
            $errors[] = 'The modified task cannot be empty.';
        } 
		elseif($i === NULL || $i === FALSE) 
		{
            $errors[] = 'The task cannot be modified.';        
        }
		else 
		{
            $task_list[$i] = $modified_task;
            $modified_task = '';
        }
        break;
		
	//Cancel	
    case 'Cancel Match-up':
        $modified_task = '';
        break;
		
	//PROMOTE (move up)	
    case 'Promote Match-up':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) 
		{
            $errors[] = 'The task cannot be promoted.';
        } 
		elseif ($task_index == 0) 
		{
            $errors[] = 'You can\'t promote the first task.';
        } 
		else 
		{
            // get the values for the two indexes
            $task_value = $task_list[$task_index];
            $prior_task_value = $task_list[$task_index-1];

            // swap the values
            $task_list[$task_index-1] = $task_value;
            $task_list[$task_index] = $prior_task_value;
            break;
        }
	
	//SORT ARRAY (sort by?)
    case 'Sort Match-up':
        sort($task_list);
        break;
		

}        
// set the array of tasks in the session
$_SESSION['tasklist'] = $task_list;


include('matchup.php');
?>
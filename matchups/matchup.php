<?php

require('../database.php');

$query = 'SELECT * FROM team ORDER BY TeamID';

$myquery = 'SELECT * FROM team ORDER BY TeamID';

//$rowSQL = mysql_query( "SELECT MAX(PlayerID) AS max FROM player" );
//$row = mysql_fetch_array( $rowSQL );
//$largestNumber = $row['max'];


$statement = $db->prepare($query);

$statement2 = $db->prepare($myquery);

$statement->execute();

$statement2->execute();

$team = $statement->fetchAll();

$team2 = $statement2->fetchAll();//$statement2->mysql_result( $statement2, 0 );

$statement->closeCursor();

$statement2->closeCursor();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Task List Manager</title>
    <link rel="stylesheet" type="text/css" href="../main.css">
<style> 
.column-left{ float: left; width: 33.3333%; color:white; background:black; text-align:center;}
.column-right{ float: right; width: 33.3333%; color:white; background:black; text-align:center;}
.column-center{ display: inline-block; width: 33.3333%; color:white; background:black; text-align:center;}
.container{color:white; background:black; text-align:center;}
p {color:red;}
select {font-size:20px;}
</style> 
</head>
<body>
    <header>
        <h1>Player Match-ups</h1>
    </header>
    <main>
       <!-- <p><?php //print_r($task_list); ?></p>-->
        
        <!-- part 1: the errors -->
        <?php if (count($errors) > 0) : ?>
        <h2>Errors:</h2>
        <ul>
            <?php foreach($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <!-- part 2: the tasks -->
        <h2>Please Select Match-up:</h2>

   
   <!----------------------------------------------------------------------------->
   <div class="container">
        <form action="." method="post">
        <input type="hidden" name="action" value="process_data">
			
			<?php foreach( $task_list as $task ) : ?>
						  <input type="hidden" name="tasklist[]" value="<?php echo $task; ?>">
			<?php endforeach; ?>
			
		
			<div class="column-center"> <h3><u>Select Match Date:</u></h3>			
       
	   <label>Match-up Date:</label>
        <input type="text" name="new_matchup" id="new_matchup" placeholder="1/1/2000"> <!--//name="match_date" value="<?php //echo htmlspecialchars($invoice_date_s); ?>" placeholder="1/1/2000"> -->
        <br>
			</div>
		
		
		   <div class="column-left"><h3><u>Select Team 1:</u></h3>
				<select name="TeamID">

            <?php foreach ($team as $team) : ?>

                <option value="<?php echo $team['TeamID']; ?>">


                    <?php echo $team['Name']; ?>

                </option>

            <?php endforeach; ?>

            </select><br></div>
			
			
			
	<div class="column-right"><h3><u>Select Team 2:</u></h3>
		<select name="TeamID2">

            <?php foreach ($team2 as $team2) : ?>

                <option value="<?php echo $team2['TeamID']; ?>">


                    <?php echo $team2['Name']; ?>

                </option>

            <?php endforeach; ?>

            </select><br></div>
		
        


        <br>

        <label>&nbsp;</label>
        <input type="submit" name="action" value="Add Match-up"> <!--value="Submit">-->
        <br>

        </form>
		
		
       
        <?php if ($message != '') : ?>        
            <p><?php echo $message; ?></p>
        <?php else : ?>
		
		
        <table align=center>
            <tr>
                <td>original date:</td>
                <td><?php echo $match; ?></td>
            </tr>
            <tr>
                <td>formatted date:</td>
                <td><?php echo  $finalDate; ?></td>
         </tr>
        </table>
        <?php endif; ?>
		
     
		
		
		<h2>Match-ups:</h2>
        <?php if (count($task_list) == 0) : ?>
            <p>There are no tasks in the task list.</p>
        <?php else: ?>
            <ul>
            <?php foreach( $task_list as $id => $task ) : ?>
                <li><?php echo $id + 1 . '. ' . $task; ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <br>


        <!-- part 4: the modify/promote/delete form -->
        <?php if (count($task_list) > 0 && empty($task_to_modify)) : ?>
        <h2>Select Team or Date to Modify:</h2>
        <form action="." method="post" >
            <?php foreach( $task_list as $task ) : ?>
              <input type="hidden" name="tasklist[]" 
                     value="<?php echo $task; ?>">
            <?php endforeach; ?>
            
			<label>Match-up:</label>
            <select name="taskid">
                <?php foreach( $task_list as $id => $task ) : ?>
                    <option value="<?php echo $id; ?>">
                        <?php echo $task; ?>
                    </option>
                <?php endforeach; ?> 
            </select>
            <br>
            <label>&nbsp;</label>
            <input type="submit" name="action" value="Modify Match-up">
           <!-- <input type="submit" name="action" value="Promote Task">-->
            <input type="submit" name="action" value="Delete Match-up">
            <input type="submit" name="action" value="Sort Match-up by Date">
			<input type="submit" name="action" value="SAVE ALL MATCHUPS">
            <br>
            <label>&nbsp;</label>
        </form>
        <?php endif; ?>

        <!-- part 5: the modify form -->
        <?php if (!empty($task_to_modify)) : ?>
        <h2>Task to Modify:</h2>
        <form action="." method="post" >
            <?php foreach( $task_list as $task ) : ?>
              <input type="hidden" name="tasklist[]" value="<?php echo $task; ?>">
            <?php endforeach; ?>
            <label>Match-up:</label>
            <input type="hidden" name="modifiedtaskid" value="<?php echo $task_index; ?>">
            <input type="text" name="modifiedtask" value="<?php echo $task_to_modify; ?>"><br>
            <label>&nbsp;</label>
            <input type="submit" name="action" value="Save Changes">
            <input type="submit" name="action" value="Cancel Changes">
        </form>
		
        <?php endif; ?>
		
		
   </div>
   <p><a href="../index.php">View Player List</a></p>
   <!----------------------------------------------------------------------------->
   
   

    </main>
</body>
</html>
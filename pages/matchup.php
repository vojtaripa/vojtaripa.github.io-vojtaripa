<!DOCTYPE html>
<html>
<head>
    <title>Compare Races</title>
    <link rel="stylesheet" type="text/css" href="main.css">
<style> 
.column-left{ float: left; width: 33.3333%; color:white; background:black; }
.column-right{ float: right; width: 33.3333%; color:white; background:black;}
.column-center{ display: inline-block; width: 33.3333%; color:white; background:black;}
</style> 
</head>
<body>
    <header>
        <h1>Compare Races</h1>
    </header>
    <main>
        <p><?php print_r($matchup); ?></p>
        
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
        <h2>Please Select Races:</h2>
		<div class="container">
   <div class="column-center"  ><h3>Race 1:</h3></div>
   <div class="column-left"><h3>Distance:</h3></div>
   <div class="column-right"><h3>Race 2:</h3></div>
</div>
        <?php if (count($matchup) == 0) : ?>
            <p>There are no tasks in the task list.</p>
        <?php else: ?>
            <ul>
            <?php foreach( $matchup as $id => $task ) : ?>
                <li><?php echo $id + 1 . '. ' . $task; ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <br>

        <!-- part 3: the add form -->
        <h2>Results:</h2>
        <form action="task_execute.php" method="post" >
		
            <?php if (is_array($matchup))foreach( $matchup as $task ) : ?>
              <input type="hidden" name="tasklist[]" 
                     value="<?php// echo $task; ?>">
            <?php endforeach; ?>
			
            <label>Input:</label>
            <input type="text" name="newtask" id="newtask"> <br>
            <label>&nbsp;</label>
            <input type="submit" name="action" value="Add Task">
        </form>
        <br>

        <!-- part 4: the modify/promote/delete form -->
        <?php if (count($matchup) > 0 && empty($task_to_modify)) : ?>
        <h2>Select Task:</h2>
        <form action="." method="post" >
            <?php foreach( $matchup as $task ) : ?>
              <input type="hidden" name="tasklist[]" 
                     value="<?php echo $task; ?>">
            <?php endforeach; ?>
            <label>Task:</label>
            <select name="taskid">
                <?php foreach( $matchup as $id => $task ) : ?>
                    <option value="<?php echo $id; ?>">
                        <?php echo $task; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
			<br>
            <label>&nbsp;</label>
			
            <input type="submit" name="action" value="Modify Task">
            <input type="submit" name="action" value="Promote Task">
            <input type="submit" name="action" value="Delete Task">
            <input type="submit" name="action" value="Sort Tasks">
			
			<br>
			<br>
        </form>
        <?php endif; ?>

        <!-- part 5: the modify form -->
        <?php if (!empty($task_to_modify)) : ?>
        <h2>Task to Modify:</h2>
        <form action="." method="post" >
            <?php foreach( $matchup as $task ) : ?>
              <input type="hidden" name="tasklist[]" value="<?php echo $task; ?>">
            <?php endforeach; ?>
            <label>Task:</label>
            <input type="hidden" name="modifiedtaskid" value="<?php echo $task_index; ?>">
            <input type="text" name="modifiedtask" value="<?php echo $task_to_modify; ?>"><br>
            <label>&nbsp;</label>
            <input type="submit" name="action" value="Save Changes">
            <input type="submit" name="action" value="Cancel Changes">
        </form>
        <?php endif; ?>

    </main>
</body>
</html>
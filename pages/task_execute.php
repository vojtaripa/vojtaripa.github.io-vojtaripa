<?php
//get tasklist array from POST
$matchup = filter_input(INPUT_POST, 'tasklist', FILTER_DEFAULT, 
        FILTER_REQUIRE_ARRAY);
if ($matchup === NULL) {
    $matchup = array();
    $matchup[] = 'Write chapter';
    $matchup[] = 'Edit chapter';
    $matchup[] = 'Proofread chapter';
}

//get action variable from POST
$action = filter_input(INPUT_POST, 'action');

//initialize error messages array
$errors = array();

//process
switch( $action ) {
    case 'Add Task':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            // $matchup[] = $new_task;
            array_push($matchup, $new_task);
        }
        break;
    case 'Delete Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            unset($matchup[$task_index]);
            $matchup = array_values($matchup);
        }
        break;
    case 'Modify Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be modified.';
        } else {
            $task_to_modify = $matchup[$task_index];
        }
        break;
    case 'Save Changes':
        $i = filter_input(INPUT_POST, 'modifiedtaskid', FILTER_VALIDATE_INT);
        $modified_task = filter_input(INPUT_POST, 'modifiedtask');
        if (empty($modified_task)) {
            $errors[] = 'The modified task cannot be empty.';
        } elseif($i === NULL || $i === FALSE) {
            $errors[] = 'The task cannot be modified.';        
        } else {
            $matchup[$i] = $modified_task;
            $modified_task = '';
        }
        break;
    case 'Cancel Changes':
        $modified_task = '';
        break;
    case 'Promote Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be promoted.';
        } elseif ($task_index == 0) {
            $errors[] = 'You can\'t promote the first task.';
        } else {
            // get the values for the two indexes
            $task_value = $matchup[$task_index];
            $prior_task_value = $matchup[$task_index-1];

            // swap the values
            $matchup[$task_index-1] = $task_value;
            $matchup[$task_index] = $prior_task_value;
            break;
        }
    case 'Sort Tasks':
        sort($matchup);
        break;
}

include('matchup.php');
?>
<?php
    require_once('Person.php');

    $title = 'Change Student Info';
    require_once('Header.php');

    # set up variables
    $id=$_GET['id'];
    $output_form = true;   

    // Create an instance of the person class
    $person = new Person();

    if (isset($_POST['update']))
    {
        # set up variables
        $person->InitFromPost();

        $output_form = $person->UpdateDb();  
    }
    else
        $person->InitFromDb($id);
    
    if ($output_form)
    {  
        # prints information to screen
        echo " <h3>Edit information & press Update</h3> ";
        echo " <form action=' " . $_SERVER['PHP_SELF'] . "' method='post'> ";
        echo "  <input type='hidden' name='id' value='$person->id'> ";
        echo "   <label for='firstname'>Student first name:</label> ";
        echo "   <input type='text' name='firstname' value='$person->firstname'><br> ";
        echo "   <label for='lastname'>Student last name:</label> ";
        echo "   <input type='text' name='lastname' value='$person->lastname'><br> ";
        echo "   <label for='grade'>Student grade:   </label> ";
        echo "   <input type='text' name='grade' value='$person->grade'><br> ";
        echo "   <label for='email1'>email address:   </label> ";
        echo "   <input type='text' name='email1' value='$person->email'><br> ";
        echo "   <label for='comments'>Comments:   </label> ";
        echo "   <textarea id='comments' name='comments' >$person->comments</textarea><br />";
        echo "   <input type='hidden' name='guid' value='$person->uniqueId'> ";
        echo "   <input type='Submit' value='Update' name='update'>  ";
        echo " </form> ";

        
    }
    
    require_once('Footer.php');
?>
        
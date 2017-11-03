<?php
    require_once('Person.php');

    $title = 'Add Student';
    require_once('Header.php');

    if (isset($_POST['submit']))
    {
        # set up variables
        $person = new Person();
        $person->InitFromPost();
       
        $output_form = $person->AddToDb();;
    }
    else 
    {
        $output_form = true;
    }
 	
    if ($output_form)
    { 
?>

        <p>Please provide the following information:</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="firstname">Student's first name:</label>
                <input type="text" id="firstname" name="firstname" /><br />
            <label for="lastname">Student's last name:</label>
                <input type="text" id="lastname" name="lastname" /><br />
            <label for="grade">Student's grade:   </label>
                6th <input id="grade" name="grade" type="radio" value="6" />
                7th <input id="grade" name="grade" type="radio" value="7" />
                8th <input id="grade" name="grade" type="radio" value="8" /><br />
            <label for="email1">Parents email address</label>
                <input type="text" id="email1" name="email1" /><br />
            <label for="comments">Comments</label>
                <textarea id="comments" name="comments"></textarea><br />
            <input type="submit" value="Submit Information" name="submit" />
        </form>

<?php 
    }
require_once('Footer.php'); 
?>

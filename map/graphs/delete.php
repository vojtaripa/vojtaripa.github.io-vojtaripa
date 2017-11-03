<?php
require_once('Person.php');

$title = 'Delete Student';
require_once('Header.php');

# set up variables
  $id = $_GET['id'];

# <!-- confirm record to be deleted  -->
  echo "Are you sure you want to delete student no. $id ? <br />";
  echo "<form method=\"LINK\" action=\"index.php\"> ";
  echo "<input type='submit' value='NO!' name='keep' />Return to list of students</form><br /> ";
  echo "<form method=\"POST\" action=\"\"> ";  
  echo "<input type='submit' value='Yes' name='banana' />Delete student </form> <br />";
  
    if (isset($_POST['banana']))
    {
        #delete record     
        Person::DeleteFromDb($id);   
           
        # message to user after deletion
          echo "<p style=\"color:red\">Record $id  deleted</p>";  
          echo "<a href='add.php'>Enter new student</a><br />";
          echo "<a href='index.php'>View</a> student list to delete or change entries.<br />";
        
        # end record deletion
    }

    require_once('Footer.php');
?>

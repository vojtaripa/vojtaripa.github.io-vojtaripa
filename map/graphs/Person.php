<?php

require_once('connectvars.php');

	class Person
	{
	    public $id;
		public $firstname;
		public $lastname;
		public $grade;
		public $email;
		public $comments;
		public $uniqueId;
	
		//----------------------------------------------------------------------------------------
		function __construct()
		{
		    $this->uniqueId = uniqid();
		}
		
	    //----------------------------------------------------------------------------------------
	    public function InitFromPost()
	    {
	        if(isset($_POST['id']))
	            $this->id = $_POST['id'];
	        
	        $this->firstname = $_POST['firstname'];
	        $this->lastname = $_POST['lastname'];
	        $this->grade = $_POST['grade'];
	        $this->email = $_POST['email1'];
	        $this->comments = $_POST['comments'];
	        
	        if(isset($_POST['guid']))
	            $this->uniqueId = $_POST['guid'];
	    }
	    
	    //----------------------------------------------------------------------------------------
	    public function EditFields()
	    {
	        $errorInField = false;
	        
	        if (empty($this->firstname))
	        {
	            // There is no first name
	            echo '<p style="color:red">Student\'s first name cannot be blank.</p>';
	            $errorInField = true;
	        }
	        
	        if (empty($this->lastname))
	        {
	            // There is no last name
	            echo '<p style="color:red">Student\'s last name cannot be blank.<p>';
	            $errorInField = true;
	        }
	        
	        
	        if (empty($this->grade))
	        {
	            // There is no grade checked
	            echo '<p style="color:red">Grade cannot be blank.<p>';
	            $errorInField = true;
	        }
	        
	        if (empty($this->email))
	        {
	            // There is no email address
	            echo '<p style="color:red">We need an email address!</p>';
	            $errorInField = true;
	        }
	        
	        return $errorInField;
	    }
	    
	    //----------------------------------------------------------------------------------------
	    public function AddToDb()
	    {
	        // connect to database
	        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error connecting to MySQL server.');
	        
	        $this->firstname = mysqli_real_escape_string($dbc, trim($this->firstname));
	        $this->lastname = mysqli_real_escape_string($dbc, trim($this->lastname));
	        $this->email = mysqli_real_escape_string($dbc, trim($this->email));
	        $this->comments = mysqli_real_escape_string($dbc, trim($this->comments));
	        
	        $error = $this->EditFields();
	        if($error)
	        {
	        # closes the database
	            mysqli_close($dbc);
	            return true;
	        }
	        
	        # Gets the information for the query to INSERT
	        $query = "INSERT INTO student_info (first_name, last_name, grade, email1, comments, guid) " .
                "VALUES ('$this->firstname', '$this->lastname', '$this->grade', '$this->email', '$this->comments', '$this->uniqueId')";
	         
	        # Issue the INSERT query on the database
	        $result = mysqli_query($dbc, $query)
	            or die('Error querying database.');
	        
	        # close the database
	        mysqli_close($dbc);
	        
	        echo "<p>Record successfully entered </p>";
	    }
	    
	    //----------------------------------------------------------------------------------------
	    public function UpdateDb()
	    {
            # Connect to database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Uh oh, something went wrong while connecting to MySQL server.');
            
	        $this->firstname = mysqli_real_escape_string($dbc, trim($this->firstname));
	        $this->lastname = mysqli_real_escape_string($dbc, trim($this->lastname));
	        $this->email = mysqli_real_escape_string($dbc, trim($this->email));
	        $this->comments = mysqli_real_escape_string($dbc, trim($this->comments));
	        
	        $error = $this->EditFields();
	        if($error)
	        {
	            # closes the database
	            mysqli_close($dbc);
	            return true;
	        }
	    
            # Lock the student_info table
            $lockQuery = "LOCK TABLES student_info WRITE";
            $result  = mysqli_query($dbc, $lockQuery)
                or die('<br>Error locking table.<br>' .
                    $lockQuery . "<br>");
            
            # Get the current guid in the table
            $getGuidQuery = "SELECT guid from student_info WHERE id='$this->id'";
            $result  = mysqli_query($dbc, $getGuidQuery)
                or die('<br>Error getting GUID.<br>' .
                        $getGuidQuery . "<br>");
            $row = mysqli_fetch_array($result);
            $currentGuid = $row['guid'];

            // Check to see if it has changed
            if($currentGuid == $this->uniqueId)
            {
                # Update information
                $newGuid = uniqid();
                $query =  "UPDATE student_info SET first_name ='$this->firstname', last_name ='$this->lastname'," .
                    "grade ='$this->grade', email1 ='$this->email', comments ='$this->comments', guid='$newGuid'  WHERE id ='$this->id'";
                
                # Issue the update query on the database
                $result  = mysqli_query($dbc, $query)
                    or die('<br>Error updating data.<br>' .
                        $query . "<br>");

                echo "You have successfully updated the record<br />";

                $error = false;
            }
            else
          {
                echo "Data has changed since you tried update, try again.<br>";
                $error = true;
            }

            # Lock the student_info table
            $unlockQuery = "UNLOCK TABLES";
            $result  = mysqli_query($dbc, $unlockQuery)
                or die('<br>Error unlocking table.<br>' .
                    $unlockQuery . "<br>");

            # closes the database
            mysqli_close($dbc);
            
            return $error;
	    }
	    
	    //----------------------------------------------------------------------------------------
	    public static function DeleteFromDb($id)
	    {
	        # Connect to database
	        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
	            or die('Uh oh, something went wrong while connecting to MySQL server.');
	            
            $query = "DELETE FROM student_info WHERE id = '$id'";
            
            # Issue the DELETE query on the database
            $result = mysqli_query($dbc, $query)
                or die('Error querying database.');
            
            # closes the database
            mysqli_close($dbc);
	    }
	    
	    //----------------------------------------------------------------------------------------
	    public function InitFromDb($id)
	    {
	        # Connect to server
	        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
	            or die('Uh oh, something went wrong while connecting to MySQL server.');
	        
	        # Gets information for the query to database
	        $query = "SELECT * FROM student_info WHERE id='$id'";
	        $result = mysqli_query($dbc, $query)
	            or die('Error querying database.');
	        
	        $this->id = $id;
	        
	        # get information
	        while ($row = mysqli_fetch_array($result))
	        {
    	        $this->firstname = $row['first_name'];
    	        $this->lastname = $row['last_name'];
    	        $this->grade = $row['grade'];
    	        $this->email = $row['email1'];
    	        $this->comments = $row['comments'];
    	        $this->uniqueId = $row['guid'];
	        }

	        # closes the database
	        mysqli_close($dbc);
	    }
	    
	    public function getList()
	    {
	        # Connect to server
	        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
	            or die('Uh oh, something went wrong while connecting to MySQL server.');
	        
	        # Gets information for the query to database
	        $query = "SELECT * FROM student_info ORDER BY grade, last_name";
	        $result = mysqli_query($dbc, $query)
	            or die('Error querying database.');
	        
            # Get each person and add to array
            $people = array();
            while ($row = mysqli_fetch_array($result))
            {
                $person = new Person();
                $person->id = $row['id'];
                $person->firstname = $row['first_name'];
                $person->lastname = $row['last_name'];
                $person->grade = $row['grade'];
                $person->email = $row['email1'];
                $person->comments = $row['comments'];
                
                $people[] = $person;
	        }
	        
	        # closes the database
	        mysqli_close($dbc);
	        
	        return $people;
	    }
	    
	    //------------------------------------------------------------------------------------------
	    public function PrintContents()
	    {
	        echo "<br>Person contents -<br>";
	        echo "id: " . $this->id . "<br>";
	        echo "firstname: " . $this->firstname . "<br>";
	        echo "lastname: " . $this->lastname . "<br>";
	        echo "grade: " . $this->grade . "<br>";
	        echo "email: " . $this->email . "<br>";
	        echo "comments: " . $this->comments . "<br>";
	        echo "uniqueId: " . $this->uniqueId . "<br><br>";
	    }
	}
?>

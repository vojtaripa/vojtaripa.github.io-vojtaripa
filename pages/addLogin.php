<?php
// Start session management and include necessary functions
session_start();
require_once ('../image/file_util.php'); // the get_file_list function
require_once ('../image/image_util.php'); // the process_image function
require_once('database.php');
//include 'indexPHP.php';
//require_once('model/admin_db.php');

// This should be working, returns an array of race results.
function queryRaces($queryrace) 
{
    
	$dsn = 'mysql:host=vojta-data.db.sonic.net; dbname=vojta_data';
    $username = 'vojta_data-all';
    $password = '590d05cd';

    try 
	{
        $db = new PDO($dsn, $username, $password);
    } 
	catch (PDOException $e) 
	{
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    } 

	//echo $queryrace;
	$statement3 = $db->prepare($queryrace);
	$statement3->execute();
	$myrace = $statement3->fetchAll();
	//$race=$myrace;
	//echo $Distance;
	
	$statement3->closeCursor();
	//echo "not NULL";
	return $myrace;
} 

// Get the action to perform
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'show_admin_menu';
    }
}

// If the user isn't logged in, force the user to login
if (!isset($_SESSION['is_valid_admin'])) 
{
    $action = 'login';
}


// Check the CAPTCHA pass-phrase for verification
    $user_pass_phrase = SHA1($_POST['verify']);
	/*$testblank = SHA1("jquscn"); //2690e0ec4aab8d23a16d7a1688fbc69fe7ed5a0b 
	
	//echo "Session: $_SESSION['pass_phrase'] <br>";
	//echo "User: $user_pass_phrase <br>";
	$test = $_POST['verify'];
	$sesh = $_SESSION['pass_phrase'];
	echo "the post string: $test <br>";
	echo "the captcha string: $sesh <br>";
	echo "passphrase: $pass_phrase <BR>";	
	echo "user hashed pass phrase: $user_pass_phrase <br>";
	echo "my pass phrase b4 hash: $mypass_phrase <br>";
	echo "Test Blank: $testblank <br>";*/

	
		
//INPUTS:
//****************************************************************************** 	
$myusername = filter_input(INPUT_POST, 'myusername');
$pass1 = filter_input(INPUT_POST, 'password1');
$pass2 = filter_input(INPUT_POST, 'password2');
$first_name = filter_input(INPUT_POST, 'first_name');
$last_name  = filter_input(INPUT_POST, 'last_name');
$email      = filter_input(INPUT_POST, 'email');
$sex        = filter_input(INPUT_POST, 'gender');
$age        = filter_input(INPUT_POST, 'age');
$webpage    = filter_input(INPUT_POST, 'webpage');
$about      = filter_input(INPUT_POST, 'About');

$todaysDate = date('Y-m-d');
$default_date = new DateTime();
//$todaysDate = date_create($todaysDate);
//$todaysDate="";

//date user ADDED
/*echo $myusername. "<br>";
echo $pass1. "<br>";
echo $pass2. "<br>";
echo $age. "<br>";
echo $first_name. "<br>";
echo $last_name. "<br>";
echo $email. "<br>";
echo $sex. "<br>";
echo $webpage . "<br>";
echo $todaysDate."<br>";*/
//****************************************************************************** 


/*   might need to add checker if USER already exists.   */
//SPITS OUT "ALL" users and info
//****************************************************************************** 

	$queryusers = "SELECT * FROM users WHERE username='" . $myusername ."'";

	//ALL USERS STORED IN HERE:
	$username_taken=queryRaces($queryusers);
	//var_dump($queryusers);
	//var_dump($users);
	if($username_taken!=NULL)
	{
		echo "<h1 style='background-color:red; color:white'>Sorry, username already taken.</h1>";
		include('create_account.php');
		exit();
	}
	
	//for()
//****************************************************************************** 




	// Captcha Verified
	if ($_SESSION['pass_phrase'] == $user_pass_phrase) 
	{
	//*********** Validate Password ******************************************
	//$email = "abc123@lolhaha"; // Invalid email address 
	//echo "Captcha Verified";
			
			//PASSWORD DONT MATCH
			if($pass1 != $pass2) 
			{
				 echo "<h1 style='background-color:red; color:white'>Passwords do not match, please try again.</h1>";
				 include('create_account.php');
				 exit();
			} 
			
			//IF ANYTHING IS BLANK
			else if ($myusername == null || $myusername == false || $pass1 == null || $pass1 == false ) 
			{
				echo "<h1 style='background-color:red; color:white'>Invalid username or password. Check all fields and try again.</h1>";
				$error = "<h1 style='background-color:red; color:white'>Invalid username or password. Check all fields and try again.</h1>";
				include('error.php');
				exit();
			} 

			//GOOD!
			else 
			{
				/*Send Email to ME (vojta)*/
				$to      = 'vojtaripa@yahoo.com';
				$subject = "Finishline: New user $myusername";
				$message = "A new user: $myusername signed up for Finishline.";
				$message = $message . "Variables: \n ".$myusername. "\r\n".$pass1. "\r\n". $first_name. "\r\n". $last_name. "\r\n".$age. "\r\n".$email. "\r\n".$sex. "\r\n" . $webpage . "\r\n";
				$headers = 'From: finishline@sonic.com' . "\r\n" .'Reply-To: webmaster@example.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);
				
				/*Send Email USER*/
				$to      = $email;
				$subject = "Welcome to Finishline!";
				$message = "Welcome to Finishline $first_name! \n Please let me know what you think of the website. If you can give me any feedback what you like, dont like, want added/ changed that would be greatly appreciated!
				            \n Your username is: $myusername and password is: $pass1 \n Please keep these for your reference. \n\n 
							Enjoy the website! \n\n
							-Vojta Ripa";
				$headers = 'From: finishline@sonic.com' . "\r\n" .'Reply-To: vojtaripa@yahoo.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);
				
				/*HASH PASSWORD*/
				require_once('database.php');			
				//echo "Password: " . $pass1 . "....<br>";
				
				$pass1 = SHA1($pass1); //hashing password
				$mypassword = $pass1;
				//echo "Hashed Password: " . $pass1;
				
				
				
				//IMAGES************************************************************************************************************************************* DONE
				$image_dir = 'image/racePics';
				//echo "image dir: $image_dir_path <br>";

				$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;
				//echo "image dir path: $image_dir_path <br>";

				$action = filter_input(INPUT_POST, 'action');
				if ($action == NULL)
				{
					$action = filter_input(INPUT_GET, 'action');
					if ($action == NULL) 
					{
						$action = '';
					}
				}

				//Checking if file exists....
				if (isset($_FILES['image_uploads'])) 
				{
					//gets name of file uploaded.
					$filename = $_FILES['image_uploads']['name'];
					
					//if its empty.. (do nothing)
					if (empty($filename)) 
					{
						//USE DEFAULT.
						//echo "no file <br>";
					} 
					
					else 	
					{
						//FROM:
						$source = $_FILES['image_uploads']['tmp_name'];
						//echo "source: $source <br>";
						
						//TO:
						$image_dir_path = str_replace("/pages","",$image_dir_path);
						//make new directory with username as name
						mkdir($image_dir_path . "/". $myusername, 0700);
						//adding that to destination path of image. (where image will go)
						$image_dir_path = $image_dir_path ."/".$myusername;
						//echo "image_dir_path: $image_dir_path <br>";						
						$target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
						//echo "target: $target <br>";
						
						//MOVE IMAGE:
						move_uploaded_file($source, $target);
						
						// create the '400' and '100' versions of the image and replace image with the smaller one.
						process_image($image_dir_path, $filename);
						
						//now delete original: (dont do it since i'm renaming the file to orininal name in "image_util.php"
						//unlink($target);
					}
					
					//makes myimage the directory where image is located
					/*
					$myimage      = $target;
					echo "MyImage: $myimage <br>";
					//define sting to delete
					$deleteString = "/home/look4ter/public_html/php7294/Ass14/";
					//deletes part of string
					$myimage      = str_replace($deleteString, "", $myimage);
					echo "Pt 1 newstring: $myimage <br>";
					//makes data the string, then gets what extension the image is
					$data         = $myimage;
					$whatIWant    = substr($data, strpos($data, ".") + 1);
					echo "WhatIWant: $whatIWant <br>";
					
					//deletes that extension, then adds the _100 for smaller image size and adds extension of image back
					$myimage = str_replace("." . $whatIWant, "", $myimage) . "_400." . $whatIWant;				
					echo "myimage: $myimage <br>";
					echo "filename: $filename <br>";
					*/
					
					/* RESUTLTS:
					source: /tmp/phpRAoCia 
					image_dir_path: /nfs/www/WWW_pages/vojta/finishline/image/racePics 
					target: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot.JPG 
					MyImage: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot.JPG 
					Pt 1 newstring: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot.JPG 
					WhatIWant: JPG 
					myimage: /nfs/www/WWW_pages/vojta/finishline/image/racePics/hillheadshot_400.JPG 
					*/
				} 

				//IF IT DOESNT EXIST:
				else 
				{
					$filename="";
					//echo "no image";
				}
				// DONE IMAGE ******************************************************************************************************************* 

				
				
				
				
				// Add the user to the database  
				
				$query = 'INSERT INTO users (username, password, Picture, first_name, last_name, email, sex, age, webpage, about, Date_Added) VALUES(:myusername, :pass1, :filename, :first_name, :last_name, :email, :sex, :age, :webpage, :about, :todaysDate)';
				$statement = $db->prepare($query);
				$statement->bindValue(':myusername', $myusername);
				$statement->bindValue(':pass1', $pass1);
				//NEW INPUTS
				$statement->bindValue(':filename', $filename);
				$statement->bindValue(':first_name', $first_name);
				$statement->bindValue(':last_name', $last_name);
				$statement->bindValue(':email', $email);
				$statement->bindValue(':sex', $sex);
				$statement->bindValue(':age', $age);
				$statement->bindValue(':webpage', $webpage);	
				$statement->bindValue(':about', $about);
				$statement->bindValue(':todaysDate', $todaysDate);							
				
				$statement->execute();
				$statement->closeCursor();
				
				
				//now I need to add new table with new username as name
				$query_add_table= "
				 CREATE TABLE `$myusername` (
					  `Index` int(11) NOT NULL,
					  `Date` date NOT NULL,
					  `Race` varchar(50) NOT NULL,
					  `Time` time NOT NULL,
					  `Distance` decimal(5,2) NOT NULL,
					  `Place` int(11) NOT NULL,
					  `Pace` time NOT NULL,
					  `Location` varchar(100) NOT NULL,
					  `Type` varchar(10) NOT NULL,
					  `Picture` varchar(100) NOT NULL,
					  `LinkToResults` varchar(150) NOT NULL,
					  `LinkToActivity` varchar(100) NOT NULL,
					  `shoes` varchar(15) NOT NULL,
					  `Notes` text NOT NULL,
					  `Feel` int(2) NOT NULL,
					  `Points` int(4) NOT NULL,
					  `Modified` date NOT NULL,
					  `DateAdded` date NOT NULL
					) 

					ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='';

					ALTER TABLE `$myusername`
					  ADD PRIMARY KEY (`Index`);";
				$statement2 = $db->prepare($query_add_table);
				$statement2->execute();
				$statement2->closeCursor();


				// Display the Product List page
				//echo $email . "Welcome $myusername";
				
				echo "<h1 style='background-color:red; color:white'>Thank you for signing up!<br><br><b><u>STEP 2:</u></b><br> Please add your first race.</h1>";
				
				include('add_race_form.php'); 
			    
			}
	}	
	
	//Captcha WRONG
    else 
	{
      echo "<h1 style='background-color:red; color:white'>Please enter the verification pass-phrase exactly as shown.</h1>";
	  include 'create_account.php';
    }
	
	//include 'login.php';
	
?>
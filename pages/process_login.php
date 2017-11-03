<?php


// Start session management and include necessary functions
session_start();
require_once('database.php');
//require_once('model/admin_db.php');



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
    
	//CAPTCHA
	
	//$user_pass_phrase = SHA1($_POST['verify']);
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

	
    /*if ($_SESSION['pass_phrase'] == $user_pass_phrase) 
	{
	*/
// Perform the specified action
//switch($action) {
    //case 'login':
        $username = filter_input(INPUT_POST, 'myusername');
        $password = filter_input(INPUT_POST, 'password1');
		
        if (isset($username) && isset($password)) 
		{
			//finds which user is logged on:
			$queryuser = 'SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1'; 
			$statement5 = $db->prepare($queryuser);
			$statement5->bindValue(':username', $username);
			$statement5->execute();
			$theuser = $statement5->fetchAll();
			$statement5->closeCursor();
			
			$theusername = $theuser['0']['username'];
			$thepassword =	$theuser['0']['password'];
			//echo "Password before SHA1: " . $password . "....<br>";
			$password =SHA1($password); //hashing password
			//$test=SHA1('111');
			
			//displaying values in database
			//echo "this is the user in DB: $theusername <br>";
			//echo "this is the password in DB: $thepassword <br>";
			
			//displaying values user put in
			//echo "<br>this is the user put in by USER: $username <br>";
			//echo "this is the passwordput in by USER: $password <br>";
			
			//echo "Test is: $test";
			
			// need to varify username and password
			if($username==$theusername && $password==$thepassword)
			{
				$login_message = 'Success!';
				//redirect('/nfs/WWW_pages/vojta/RaceResults/indexAdmin.php');
				//include("Location: ". $url); /* Redirect browser */
				$myusername=$username;
				$mypassword=$password;
				include("RaceResults.php");	

				
				/*<!--
				<script type="text/javascript">
					window.location.href = 'RaceResults.php';
				</script>-->
				*/
				
				//$url="http://vojta.users.sonic.net/RaceResults/indexAdmin.php";
				exit();
			}
			else
			{
				$login_message = 'Username or password is incorrect, please try again.';
				
				include('login.php');
			}
        } 
		else 
		{
            echo "this is the username you put: $username <br>";
			echo "this is the password you put: $password ";
			$login_message = 'You must login to view this page.';
			//$url="http://vojta.users.sonic.net/RaceResults/login2.php";
            include('login.php');
        }
       // break;
    /*case 'show_admin_menu':
        include('view/admin_menu.php');
        break;
    case 'show_product_manager':
        include('view/product_manager.php');
        break;
    case 'show_order_manager':
        include('view/order_manager.php');
        break;*/
   /* case 'logout':
        $_SESSION = array();   // Clear all session data from memory
        session_destroy();     // Clean up the session ID
        $login_message = 'You have been logged out.';
        include('login2.php');
        break;*/
//}

/*	
else 
{
      echo '<p class="error">Please enter the verification pass-phrase exactly as shown.</p>';
	  include 'login2.php';
} */
?>
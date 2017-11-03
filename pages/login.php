<?php
    //require_once('../util/secure_conn.php');  // require a secure connection
	
	//https://www.w3schools.com/howto/howto_css_coming_soon.asp
	require_once('../captcha/appvars.php');
	require_once('../captcha/connectvars.php');
?>
<!DOCTYPE html>
<html>
    <style>
		body, html {
			height: 100%;
			margin: 0;
		}

		.bgimg {
			background-image: url('/w3images/forestbridge.jpg');
			height: 100%;
			background-position: center;
			background-size: cover;
			position: relative;
			color: white;
			font-family: "Courier New", Courier, monospace;
			font-size: 25px;
			-webkit-text-stroke: 1px black;
		}

		.topleft {
			position: absolute;
			top: 0;
			left: 16px;
		}

		.bottomleft {
			position: absolute;
			bottom: 0;
			left: 16px;
		}

		.middle {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			text-align: center;
		}

		hr {
			margin: auto;
			width: 40%;
		}
	</style>
			
	<head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="../main.css"/>
    </head>
    <body>
	
	
	<center>
   <span class="myButtons" style="display: inline;">
   
   <h2> Links: </h2>
   
   <a class="button" href="login.php" style="background-color:red;">Admin</a> <!--indexAdmin.php -->
   <a class="button" href="../index.php" >View All Users</a>
   <a class="button" href="functions.php">Other Functions / Conversions</a>
   <a class="button" href="distance_list.php">List distances</a>     
   <a class="button" href="signup.php" >Sign up for updates</a>
   
   <a class="button" href="http://vojta.users.sonic.net/blog/"> Vojta's Main Page </a>
   <a class="button" href="about.html">Vojta's Bio</a>
   
   </span>
   
    <br>
   <hr  >
   <br>
   </center>
	
	<div class="bgimg">
  <div class="topleft">
    <!--<p>Logo</p>-->
  </div>
  <div class="middle" style="background-color: rgba(96, 96, 96, 0.5);">
    <h2><b>LOG IN<b></h2>
    <hr>
    <!--<p id="demo" style="font-size:30px"></p>-->
	<h2>Please Login</h2>


	
	<center>
            <form action="process_login.php" method="post" id="login_form" class="aligned" >
                <input type="hidden" name="action" value="login">

               <table>
                <tr>
				<td width="20%" scope="row"><label>Username        :</label></td>
                <td><input type="text" class="text" name="myusername" placeholder="username"></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
                <label>Password        :</label></td>
                <td><input type="password" class="text" name="password1" placeholder="password"></td>
                <br>
				</tr>
				
				
				</table>
				<br><br>
                <label>&nbsp;</label>
                <input type="submit" value="Login">
				<br><br>
            </form>			
			
			<p style="display: inline;"><a class="button" href="../index.php" >Back Home to Users</a></p>
			
			<h1>Dont have an Account?</h1>
			<br>
			<a class="button" href="create_account.php" >Create Account</a>
			<a class="button" href="../index.php" >View All Users</a>
			

            <p><?php echo $login_message;?></p>
			</center>
	
	
	
  </div>
  <div class="bottomleft">
    <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, Inc.</p>
  </div>
</div>

<!-- JAVASCRIPT -->
<script>
	// Set the date we're counting down to
	var countDownDate = new Date("Jan 5, 2018 15:37:25").getTime();

	// Update the count down every 1 second
	var countdownfunction = setInterval(function() {

		// Get todays date and time
		var now = new Date().getTime();
		
		// Find the distance between now an the count down date
		var distance = countDownDate - now;
		
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		// Output the result in an element with id="demo"
		document.getElementById("demo").innerHTML = days + "d " + hours + "h "
		+ minutes + "m " + seconds + "s ";
		
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(countdownfunction);
			document.getElementById("demo").innerHTML = "EXPIRED";
		}
	}, 1000);
</script>


        </main>
    </body>
</html>

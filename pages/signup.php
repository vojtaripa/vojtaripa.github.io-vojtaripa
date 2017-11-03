<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Form</title>
    <link rel="stylesheet" type="text/css" href="../main.css"/>
	<style>
	legend
	{	
		color: white;
	}
	
	</style>
</head>

<body>
    <main>
	
	<center>
   <span class="myButtons" style="display: inline;">
   
   <h2> Links: </h2>
   
   <a class="button" href="login.php" >Admin</a> <!--indexAdmin.php -->
   <a class="button" href="../index.php" >View All Users</a>
   <a class="button" href="functions.php">Other Functions / Conversions</a>
   <a class="button" href="distance_list.php">List distances</a>     
   <a class="button" href="signup.php" style="background-color:red;" >Sign up for updates</a>
   
   <a class="button" href="http://vojta.users.sonic.net/blog/"> Vojta's Main Page </a>
   <a class="button" href="about.html">Vojta's Bio</a>
   
   </span>
   
    <br>
   <hr  >
   <br>
   </center>
   
   
   
    <h1>Sign Up Form</h1>
    <form action="display_results.php" method="post">

    <fieldset>
    <legend>Sign-up Information</legend>
	<table style="width:100%">
	<tr>
       <td> <label>E-Mail:</label/td>
        <td><input type="text" name="email" value="" class="textbox" style="width:100%"></td>
        <br>
</tr>

<tr>
       <td> <label>Phone Number:</label> </td>
        <td><input type="text" name="phone" value="" class="textbox" style="width:100%"> </td>
    </fieldset>
	</tr>
</table>
<br>
    <fieldset>
    <legend>Settings</legend>

        <p>How did you hear about us?</p>
        <p><input type="radio" name="heard_from" value="Search Engine">
        Search engine</p><br>
        <p><input type="radio" name="heard_from" value="Friend">
        Word of mouth</p><br>
        <p><input type=radio name="heard_from" value="Other">
        Other</p><br>

        <p>Would you like to receive announcements about new products
           and special offers?</p>
        <p><input type="checkbox" name="wants_updates">YES, I'd like to receive
        information about new products and special offers.</p><br>

        <p>Contact via:</p>
        <select name="contact_via">
                <option value="email">Email</option>
                <option value="text">Text Message</option>
                <option value="phone">Phone</option>
        </select>

        <p>Comments:</p>
        <textarea name="comments" rows="4" cols="50"></textarea>
    </fieldset>

    <input type="submit" value="Submit">
    <br>

    </form>    
	
	<p><a href="../index.php">Back to View Races</a></p>
    </main>
</body>
</html>
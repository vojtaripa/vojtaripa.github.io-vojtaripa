<?php
require('database.php');

/*
$dsn = 'mysql:host=vojta-data.db.sonic.net; dbname=vojta_data';
$username = 'vojta_data-all';
$password = '590d05cd';


mysql_select_db( "vojta_data",mysql_connect($dsn, $username, $password) );
*/


//USERNAME LOGGED IN and SECURITY:
if($myusername=="" && $mypassword=="")
{	
	//echo"USERNAME: $myusername PASSWORD: $mypassword";
	$myusername = filter_input(INPUT_POST, 'username');
	$mypassword = filter_input(INPUT_POST, 'password');

	//echo "<h1 style='color:red'> SORRY, invalid username or password. </h1>";
	if($myusername=="" && $mypassword=="")
	{
		?>		
		<script type="text/javascript">location.href = 'http://www.vojtaripa.com/finishline';</script>
		<?php
	}
	//header("Location: http://www.vojtaripa.com/finishline");
}
else
{}



if($mypassword=="")
{
	echo "<h1 style='color:red'> SORRY, invalid password. </h1>";
    //include("RaceResults.php?choice=search&user=".urlencode($myusername)."&Year=".urlencode('All')."&Distance=".urlencode('All'));
    exit();
}
else
{
	//finds which user is logged on:
	$queryuser = "SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1"; 
	$statement5 = $db->prepare($queryuser);
	$statement5->bindValue(':username', $myusername);
	$statement5->execute();
	$theuser = $statement5->fetchAll();
	$statement5->closeCursor();
	
	$theusername = $theuser['0']['username'];
	$thepassword =	$theuser['0']['password'];
	
	/*
	echo "THEUSERNAME: $theusername <br>";
	echo "MYUSERNAME: $myusername <br>";
	echo "THEPASSWORD: $thepassword <br>";
	echo "MYPASSWORD: $mypassword <br>";*/
	
	//IF USERNAME AND PASSWORD ARE NOT RIGHT
	if($myusername!=$theusername || $mypassword!=$thepassword)
	{
		//echo "<h1 style='color:red'>SORRY INVALID LOGIN</h1>";
		?>		
		<script type="text/javascript">location.href = 'http://www.vojtaripa.com/finishline';</script>
		<?php
	}
	else
	$usernameCheck==true; //correct user logged in.
}
//ELSE RUN PAGE.
//****************************************************************************** 

//GETTING ALL RACES and ALL DISTANCES
$query = 'SELECT * FROM MyDistances ORDER BY Distance';
$myquery = "Select COUNT(*) FROM ". $myusername ." LIMIT 1";


$statement = $db->prepare($query);
$statement2 = $db->prepare($myquery);

$statement->execute();
$statement2->execute();

$Distance = $statement->fetchAll();
$MyRaceResults = $statement2->fetchAll();//$statement2->mysql_result( $statement2, 0 );

$statement->closeCursor();
$statement2->closeCursor();

?>

<!DOCTYPE html>

<html>

<!-- the head section -->
<head>
    <title>Add Race</title>
    <link rel="stylesheet" type="text/css" href="../main.css">
	<style>
		* {
			padding: 1px;
			size: 16px;
			align: center;
		}
		input
		{
			width:100%;
		}
		select
		{
			width:30%;
			text-align:center; 
			align:center;
			margin-left:auto; 
			margin-right:auto; 
		}
		td{
			border: 1px solid #ddd;
			margin-top: -1px;
			padding: 12px;
		}
	</style>
	
	<!-- FOR LIVE GEOCODING -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<script src="jquery.geocomplete.js"></script>
			<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
		

	<script>
	    //FOR LIVE GEOCODING
		//LINK: http://www.jqueryscript.net/other/jQuery-Geocoding-Places-Autocomplete-with-Google-Maps-API-geocomplete.html
		$(function()
		{

			$("#geocomplete").geocomplete()

		});
	
	        
		//GETS SECONDS AND CONVERTS BACK TO TIME FORMAT
		function SecondsToTime(inputTime) 
		{	
			//echo nl2br("Seconds are now: $Seconds \n");
			var CaryOver=0, Hours=0, Minutes=0, Seconds=0;
			//var inputTime=3000;
			
			if(inputTime>=(60*60))
			{
				CaryOver=inputTime%(60*60);
				Hours=Math.floor(inputTime/(60*60));
				inputTime=CaryOver;
				//echo nl2br("Seconds are now: CarryOver \n");
				
			}

			if(inputTime>=60)
			{
				CaryOver=inputTime%60; //Remainder
				Minutes=Math.floor(inputTime/60);
				inputTime=CaryOver;
				//echo nl2br("Minutes are now: CarryOver \n");
				
			}
			else{}
			
			Seconds=Math.floor(inputTime);
			
			//NOW Correct the FORMAT
			if(Hours<10)
			{Hours="0" + Hours;}	
			if(Minutes<10)
			{Minutes="0" + Minutes;}
			if(Seconds<10)
			{Seconds="0" + Seconds;}
			else{}
			
			return (Hours + ":" + Minutes + ":" + Seconds);
		}
		
		
		
		// MY LIVE PACE CALCULATOR:
		//LINK: https://www.daniweb.com/programming/web-development/threads/305789/javascript-calculate-time-between-times
		function FindPace () 
		{
            var startHSelect = document.getElementById ("starttimehour");
            var startMSelect = document.getElementById ("starttimemin");
			var startSSelect = document.getElementById ("starttimesec");
						
			var distance     = document.getElementById ("distance");
			
			// convert string values to integers
			var startH = parseInt (startHSelect.value);
			var startM = parseInt (startMSelect.value);
			var startS = parseInt (startSSelect.value);
			
			var distVal= distance.value;
			
			// create Date objects from start and end
			var start = new Date ();	// the current date and time, in local time.
			var end = new Date ();

			//setting stand and end date (formatting) so we can use getTime() function
			start.setHours (startH, startM, startS);
			end.setHours (00, 00, 00);
			
			//Now setting result AKA elapsed time
			var elapsedInS = start.getTime () - end.getTime ();
			
			//Gets total amount of sec.
			var totalSec = (elapsedInS / (1000*distVal));
			
			//uses function to convert sec to time again.
			var pace = SecondsToTime (totalSec);
			
			//Gets value of result field
			var elapsedSpan = document.getElementById ("elapsed");
							  
			
			//changes the value of the result field
			elapsedSpan.value = "" + (pace); //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
        }
		
		function Feel ()
		{
			//Gets value of slider field
			var slider = document.getElementById ("slider");
			
			//Gets value of feel field
			var myfeel = document.getElementById ("feel");	

            //Get actual value of feel
            var actualFeel = slider.value;			
			
			//changes the value of the result field
			myfeel.value = "" + (actualFeel); //";//slider.value; 
		}
		
		 
        function Init () 
		{
			FindPace ();
			Feel ();
        }
		
		
    </script>
	
</head>

<main>

<!-- the body section -->

<body onload="Init ()">
	<center>
   <span class="myButtons" style="display: inline;">
   
   <h2> Links: </h2>
   
   <a class="button" href="login.php" >Admin</a> <!--indexAdmin.php -->
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
    <header><h1>Adding a New Race Result</h1></header>
	</center>
	
    
        <center><h2>Please Add Your Race Results:</h2>
		<center><img src="../image/finishline_runner.jpg" alt="Finish" align="center" style="width: 40%; height: 40%" ></center> <br>
		
 <h2>If you need help finding your results, you can start with these links:</h2>
        <select id="links" name="links" class="selectboxkl">
					<option value="#" ><a href="#"><i>Select Webpage Below</i></a></option>
					<option value="https://www.athlinks.com/" ><a href="https://www.athlinks.com/">Athlinks</a></option>
					<option value="https://results.active.com/" ><a href="https://results.active.com/">Active</a></option>
					<option value="http://www.onlineraceresults.com/" ><a href="http://www.onlineraceresults.com/">Online Race Results</a></option>
					<option value="https://www.directathletics.com/" ><a href="https://www.directathletics.com/">Direct Athletics</a></option>
					<option value="http://www.coolrunning.com/engine/1/" ><a href="http://www.coolrunning.com/engine/1/">Cool Running</a></option>
					
				</select>
				<script type="text/javascript">
				 var urlmenu = document.getElementById( 'links' );
				 urlmenu.onchange = function() {
					  window.open(  this.options[ this.selectedIndex ].value );
				 };
				</script>
				
				
				<h2>- or -</h2>

<p style="font-size:20px">
If you have a Excel file with all of your races, 
please send it to me and I can upload it.
</p>

<h1 style="color:white; background-color:red;">Adding image to your race:</h1>
<!--IMAGE-->
		<h2>Image to be upload</h2>
        <form action="add_race.php" method="post" id="add_race_form" enctype="multipart/form-data">
			
			<!--IMAGE-->
			
			<style>
				  
				  .upload
				  {
					color: black;
					width: 40%;
					background: #ccc;
					margin: 0 auto;
					padding: 1.5%;
				  }

				   ol.upload {
					  color: black;
					padding-left: 0;
				  }

				   li.upload {
					color: black;
					background: #eee;
					display: flex;
					justify-content: space-between;
					margin-bottom: 10px;
					list-style-type: none;
				  }

				   img.upload {
					color: black;
					height: 64px;
					margin-left; 20px;
					order: 1;
				  }

				   p.upload {
					color: black;
					line-height: 32px;
					padding-left: 5px;
				  }

				   label.upload, button.upload {
					background-color: black;
					background-image: linear-gradient(to bottom, rgba(255, 0, 0, 0), rgba(255, 0, 0, 0.4) 40%, rgba(255, 0, 0, 0.4) 60%, rgba(255, 0, 0, 0));
					color: #ccc;
					padding: 5px 10px;
					border-radius: 5px;
					border: 1px ridge gray;
				  }

				   label:hover, button:hover {
					background-color: #222;
				  }

				   label:active, button:active {
					background-color: #333;
				  }
			</style>


			<center>
			  <div class="upload">
				<label class="upload" for="image_uploads">Choose images to upload (PNG, JPG)</label>
				<input class="upload" type="file" id="image_uploads" name="image_uploads" accept=".jpg, .jpeg, .png" multiple>
			  </div>
			  
			  <div class="preview upload">
				<p class="upload">
				<?php
				if($Picture!=NULL)
					echo "$Picture";
				else
					echo "No files currently selected for upload";
				?>
				</p>
				
			  </div>
			  <input class="upload" type="text" id="myFile" name="file1" value="<?php echo $Picture; ?>" readonly>
			</center>
			

			<script>
			var input = document.querySelector('input');
			var preview = document.querySelector('.preview');

			input.style.visibility = 'hidden';
			input.addEventListener('change', updateImageDisplay);
			
			function updateImageDisplay() 
			{
			  while(preview.firstChild) 
			  {
				preview.removeChild(preview.firstChild);
			  }

			  var curFiles = input.files;
			  if(curFiles.length === 0) 
			  {
				var para = document.createElement('p');
				var x = document.getElementById("myFile").value;
				
				para.textContent = 'No files currently selected for upload';
				
				preview.appendChild(para);
				
			  } 
			  else 
			  {
				var list = document.createElement('ol');
				preview.appendChild(list);
				
				for(var i = 0; i < curFiles.length; i++) 
				{
				  var listItem = document.createElement('li');
				  var para = document.createElement('p');
				  
				  if(validFileType(curFiles[i])) 
				  {
					para.textContent = 'File name ' + curFiles[i].name + ', file size ' + returnFileSize(curFiles[i].size) + '.';
					document.getElementById("myFile").value = curFiles[i].name;
					
					var image = document.createElement('img');
					image.src = window.URL.createObjectURL(curFiles[i]);

					listItem.appendChild(image);
					listItem.appendChild(para);

				  } 
				  
				  else 
				  {
					para.textContent = 'File name ' + curFiles[i].name + ': Not a valid file type. Update your selection.';
					listItem.appendChild(para);
				  }

				  list.appendChild(listItem);
				}
			  }
			}var fileTypes = [
			  'image/jpeg',
			  'image/pjpeg',
			  'image/png'
			]

			function validFileType(file) {
			  for(var i = 0; i < fileTypes.length; i++) {
				if(file.type === fileTypes[i]) {
				  return true;
				}
			  }

			  return false;
			}function returnFileSize(number) {
			  if(number < 1024) {
				return number + 'bytes';
			  } else if(number > 1024 && number < 1048576) {
				return (number/1024).toFixed(1) + 'KB';
			  } else if(number > 1048576) {
				return (number/1048576).toFixed(1) + 'MB';
			  }
			}
			</script>


						<!--<input type="hidden" name="action" value="upload">
						<input type="file" name="file1"><br>-->

<h3> Fill in the following, please follow format shown. </h3>        			


<table style="align:center;width:70%;border: 4px solid red;">

<!-- 	

Index
Date
Race
Time
Distance
Place
Pace
Location
Type
Picture
LinkToResults
LinkToActivity
shoes
Notes

-->
<!-- CHANGE VALUE TO placeholder= -->

			<tr>
			<td><label>Race ID</label></td>
			<td>
			<?php foreach ($MyRaceResults as $MyRaceResults) : ?>
				<input type="text" name="Index" value="<?php echo $MyRaceResults[0]+1; ?>" readonly>
			 <?php endforeach; ?>
			 </td>
			 </tr>


			<tr>
           <td><label>Race Name:</label></td>
           <td> <input type="text" name="Race" placeholder="Running of the Warriors" required></td><br>		   
		   </tr><tr>
			
			<td><label>Date of Race:</label></td>
           <td> <input type="date" name="Date" value="01/01/2017" required ></td><br>		   
		   </tr><tr>

           <!--<td><label>Distance Run:</label></td>
            <td><input type="number" name="quantity" min=".01" max="26.20" name="Distance" value="13.1" required></td><br>
			</tr><tr>	-->	   
			
			 <td><label>Distance</label></td>
             <td><select id="distance" name="Distance" onchange="FindPace ()" class="selectboxkl">
				<?php foreach ($Distance as $Distance) : ?>
					<option value="<?php echo $Distance['Distance']; ?>">
						<?php echo $Distance['distName']; ?>
					</option>
				<?php endforeach; ?>
            </select></td></tr>
			
			<!--<tr>
			 <td><label>Time Run:</label></td>
            <td><input type="text" name="Time" value="1:10:09" required></td><br>
			</tr><tr> -->
			
			<td><label>Time Run:</label></td>
            <td>
			<pre><b>Hours                       Minutes                       Seconds</b></pre>
				<select id="starttimehour" name="Hours" onchange="FindPace ()" class="selectboxkl">
					<option value="00" selected="selected">00</option>
					<option value="01" >01</option>
					<option value="02" >02</option>
					<option value="03" >03</option>
					<option value="04" >04</option>
					<option value="05" >05</option>
					<option value="06" >06</option>
					<option value="07" >07</option>
					<option value="08" >08</option>
					<option value="09" >09</option>
					<option value="10" >10</option>
				</select>
				:
				<select id="starttimemin" name="Minutes" onchange="FindPace ()" class="selectboxkl">
					<option value="00" selected="selected">00</option>
					<option value="01" >01</option>
					<option value="02" >02</option>
					<option value="03" >03</option>
					<option value="04" >04</option>
					<option value="05" >05</option>
					<option value="06" >06</option>
					<option value="07" >07</option>
					<option value="08" >08</option>
					<option value="09" >09</option>
					<option value="10" >10</option>
					<option value="11" >11</option>
					<option value="12" >12</option>
					<option value="13" >13</option>
					<option value="14" >14</option>
					<option value="15" >15</option>
					<option value="16" >16</option>
					<option value="17" >17</option>
					<option value="18" >18</option>
					<option value="19" >19</option>
					<option value="20" >20</option>
					<option value="21" >21</option>
					<option value="22" >22</option>
					<option value="23" >23</option>
					<option value="24" >24</option>
					<option value="25" >25</option>
					<option value="26" >26</option>
					<option value="27" >27</option>
					<option value="28" >28</option>
					<option value="29" >29</option>
					<option value="30" >30</option>
					<option value="31" >31</option>
					<option value="32" >32</option>
					<option value="33" >33</option>
					<option value="34" >34</option>
					<option value="35" >35</option>
					<option value="36" >36</option>
					<option value="37" >37</option>
					<option value="38" >38</option>
					<option value="39" >39</option>
					<option value="40" >40</option>
					<option value="41" >41</option>
					<option value="42" >42</option>
					<option value="43" >43</option>
					<option value="44" >44</option>
					<option value="45" >45</option>
					<option value="46" >46</option>
					<option value="47" >47</option>
					<option value="48" >48</option>
					<option value="49" >49</option>
					<option value="50" >50</option>
					<option value="51" >51</option>
					<option value="52" >52</option>
					<option value="53" >53</option>
					<option value="54" >54</option>
					<option value="55" >55</option>
					<option value="56" >56</option>
					<option value="57" >57</option>
					<option value="58" >58</option>
					<option value="59" >59</option>
				</select>
				:
				<select id="starttimesec" name="Seconds" onchange="FindPace ()" class="selectboxkl">
					<option value="00" selected="selected">00</option>
					<option value="01" >01</option>
					<option value="02" >02</option>
					<option value="03" >03</option>
					<option value="04" >04</option>
					<option value="05" >05</option>
					<option value="06" >06</option>
					<option value="07" >07</option>
					<option value="08" >08</option>
					<option value="09" >09</option>
					<option value="10" >10</option>
					<option value="11" >11</option>
					<option value="12" >12</option>
					<option value="13" >13</option>
					<option value="14" >14</option>
					<option value="15" >15</option>
					<option value="16" >16</option>
					<option value="17" >17</option>
					<option value="18" >18</option>
					<option value="19" >19</option>
					<option value="20" >20</option>
					<option value="21" >21</option>
					<option value="22" >22</option>
					<option value="23" >23</option>
					<option value="24" >24</option>
					<option value="25" >25</option>
					<option value="26" >26</option>
					<option value="27" >27</option>
					<option value="28" >28</option>
					<option value="29" >29</option>
					<option value="30" >30</option>
					<option value="31" >31</option>
					<option value="32" >32</option>
					<option value="33" >33</option>
					<option value="34" >34</option>
					<option value="35" >35</option>
					<option value="36" >36</option>
					<option value="37" >37</option>
					<option value="38" >38</option>
					<option value="39" >39</option>
					<option value="40" >40</option>
					<option value="41" >41</option>
					<option value="42" >42</option>
					<option value="43" >43</option>
					<option value="44" >44</option>
					<option value="45" >45</option>
					<option value="46" >46</option>
					<option value="47" >47</option>
					<option value="48" >48</option>
					<option value="49" >49</option>
					<option value="50" >50</option>
					<option value="51" >51</option>
					<option value="52" >52</option>
					<option value="53" >53</option>
					<option value="54" >54</option>
					<option value="55" >55</option>
					<option value="56" >56</option>
					<option value="57" >57</option>
					<option value="58" >58</option>
					<option value="59" >59</option>
				</select>
				<br>
							
			</td><br>
			</tr><tr> 
			
				<td> <label>Pace Run </label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="Pace" id="elapsed" readonly value="00:01:00"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr><tr>

           <td> <label>Place Finished:</label></td>
           <td> <input name="Place" placeholder="1" type="number" min="1" max="1000" pattern="[0-9]{3}" required ></td><br>
		   </tr><tr>
			 	
			
			<td> <label>Location</label></td>
           <td> <input id="geocomplete" type="text" name="Location" placeholder="Santa Rosa, Ca" required ></td><br>
		   </tr><tr>
		   
		   	<td><label>Type of Race</label></td>
             <td>
			 <select name="Type">
					<option value="XC">XC</option>
					<option value="Track">Track</option>
					<option value="Road" selected="selected" >Road</option>
					<option value="Tri">Tri</option>
            </select>
			</td></tr>
			
			<!--<td>Picture: </td>
			<td><input type="image" src="img_submit.gif" alt="Submit" width="48" height="48"></td>
			</tr><tr>-->
			
			<td>Add link to your results: </td>
			<td><input type="url" name="ResultsLink" placeholder="Directathletics.com"></td>
			</tr><tr>
			
			<td>Add link to your activity: <br><a href="https://www.strava.com/dashboard?feed_type=my_activity">My Strava Activities</a></td>
			<td><input type="url" name="ActivityLink" placeholder="strava.activity.com"></td>
			</tr><tr>
			
			<td>Shoe Model/ Brand </td>
			<td><input type="text" name="Shoes" placeholder="Ex. Nike Lunar Racer"></td>
			</tr>
			
			<tr>
			<td> <label>How did you feel? (Scale 1 to 10, 10 being the best)</label></td>
           <td> 
		   Felt like a: <input type="range" name="feel" min="0" max="10" value="0" onchange="Feel ()" id="slider">
		   <input type="text" name="feeltext" value="0" readonly id="feel"><br>
		  <pre> 0 (Worst)                                                                       10 (Best) </pre>
			</td><br>
		   </tr>
		   
		   <tr>
			<td> <label>Notes:</label></td>
           <td> <textarea rows="8" cols="75" name="Comments" value="" placeholder="Please write a note about the race..."> </textarea></td><br>
		   </tr>
		   
		   
		   <input type="hidden" name="username" value="<? echo $myusername?>" >
		   <input type="hidden" name="password" value="<? echo $mypassword?>" > 
		   </table></center>
		   
		   
  
			
            <label>&nbsp;</label>

            <input class="button" type="submit" value="Add Race">  <br><br> <input class="button" type=reset value="Clear">
			<br>
        </form>

        <p><a href="<?php echo "RaceResults.php?choice=search&user=".urlencode($myusername)."&password=".urlencode($mypassword)."&Year=".urlencode('All')."&Distance=".urlencode('All'); ?>">Back</a> <a href="../index.php">View Users</a></p>

    </main>



    <footer>
        <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, 2017, Inc.</p>
    </footer>

</body>

</html>
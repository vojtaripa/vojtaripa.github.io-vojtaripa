
<?php

require('database.php');


//USERNAME LOGGED IN and SECURITY:
if($myusername=="" && $mypassword=="")
{	
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

//need to trim white space ect:
	$myusername=trim($myusername," \t\n\r\0\x0B");
	$mypassword=trim($mypassword," \t\n\r\0\x0B");

if($mypassword=="")
{
	echo "<h1 style='color:red'> SORRY, invalid password. </h1>";
    //include("RaceResults.php?choice=search&user=".urlencode($myusername)."&Year=".urlencode('All')."&Distance=".urlencode('All'));
    exit();
}
else
{
	//finds which user is logged on:
	$queryuserNEW = "SELECT * FROM users WHERE username = '".$myusername."' ORDER BY idusers DESC limit 1"; 
	$statement6 = $db->prepare($queryuserNEW);
	//$statement5->bindValue(':username', $myusername);
	$statement6->execute();
	$theuserX = $statement6->fetchAll();
	$statement6->closeCursor();
	//var_dump($theuserX);
	
	$theusername = $theuserX['0']['username'];
	$thepassword =	$theuserX['0']['password'];
	
	//DISPLAY OUTPUTS OF VARS:	
	/*
	echo "THEUSERNAME: $theusername <br>";
	echo "MYUSERNAME: *$myusername* <br>";
	echo "THEPASSWORD: $thepassword <br>";
	echo "MYPASSWORD: $mypassword <br>";
	*/
	
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


$query = 'SELECT * FROM MyDistances ORDER BY Distance';
$myquery = 'Select COUNT(*) FROM MyRaceResults LIMIT 1';


$statement = $db->prepare($query);
$statement2 = $db->prepare($myquery);

$statement->execute();
$statement2->execute();

$Distance = $statement->fetchAll();
$MyRaceResults = $statement2->fetchAll();//$statement2->mysql_result( $statement2, 0 );

$statement->closeCursor();
$statement2->closeCursor();



//MY NEW FIELDS:

$Index = filter_input(INPUT_POST, 'Index', FILTER_VALIDATE_INT);

$Date = filter_input(INPUT_POST, 'Date');
$Date = trim($Date," \t\n\r\0\x0B");

$Race = filter_input(INPUT_POST, 'Race'); //, FILTER_VALIDATE_INT
$Race=substr($Race, 2,-1);

$Time = filter_input(INPUT_POST, 'Time');
//$Time= substr($Time, 2,-1); // makes seconds the last 2 chars
$Time = trim($Time, " \t\n\r\0\x0B");


	//echo"*$Time*";
	$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
    $Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
	$Timem= substr($Time, (strlen($Time)-2)); 
	$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
	$Timeh= $Time; 
	//echo" H:$Timeh,M:$Timem,S:$Times<br>";

$MyDistance = filter_input(INPUT_POST, 'Distance');
$MyDistance=trim($MyDistance, " \t\n\r\0\x0B");

//$MyDistance=substr($MyDistance, 2,-1);
//echo "*".$MyDistance."*";

$Place = filter_input(INPUT_POST, 'Place', FILTER_VALIDATE_INT);
//$Place=substr($Place, 2,0);

//DONT NEED PACE IT WILL RE-Calculate
/*$Pace = filter_input(INPUT_POST, 'Pace');
$Pace=substr($Pace, 2,-1); */

$Location =	filter_input(INPUT_POST, 'Location');
$Location=substr($Location, 2);

$Type = filter_input(INPUT_POST, 'Type');
$Type=trim($Type, " \t\n\r\0\x0B");

$Picture = filter_input(INPUT_POST, 'Picture');	
$Picture=substr($Picture, 2);	
//echo "*$Picture*<br>";			

$LinkToResults = filter_input(INPUT_POST, 'LinkToResults');				
$LinkToResults = substr($LinkToResults, 2,-1);
//echo "*".$MyDistance."*<br>";

$LinkToActivity	= filter_input(INPUT_POST, 'LinkToActivity');	
$LinkToActivity=substr($LinkToActivity, 2,-1);
//echo "*".$LinkToResults."*<br>";

$shoes = filter_input(INPUT_POST, 'shoes');		
$shoes=substr($shoes, 2);

$feel = filter_input(INPUT_POST, 'Feel');		
$feel = trim($feel, " \t\n\r\0\x0B");
//echo "*".$shoes."*<br>";

//$Notes = filter_input(INPUT_POST, 'Comments');

$TimeStamp = time();

//$Comments= filter_input(INPUT_POST,'Comments' );

    $Comments = filter_input(INPUT_POST, 'Notes');
	$Comments = trim($Comments, " \t\n\r\0\x0B");
    $Comments = htmlspecialchars($Comments);  // NOTE: You must code htmlspecialchars before nl2br for this to work correctly
    $Comments = nl2br($Comments, false);    
	//echo "*".$Comments."*<br>";

// END IN PUTS ***********************************************************************************************************************************************************   
  
  
//puts Current date and time in database


/*

$query ='UPDATE player SET TimeStamp=:TimeStamp WHERE PlayerID=:PlayerID';//'SELECT GETDATE() AS TimeStamp';

$statement = $db->prepare($query);

    //$statement->bindValue(':CurrentDateTime', $CurrentDateTime);
	
	$statement->bindValue(':PlayerID', $PlayerID);
	
	$statement->bindValue(':TimeStamp', $TimeStamp);
	
	$success = $statement->execute();

    $statement->closeCursor(); 

	
 // echo GETDATE();
  

//query

if ($PlayerID != false  && $category_id != false) {

    $query = 'Select PlayerID FROM player WHERE PlayerID = :PlayerID';

    $statement = $db->prepare($query);

    $statement->bindValue(':PlayerID', $PlayerID);

    $success = $statement->execute();

    $statement->closeCursor();    
*/



?>

<!DOCTYPE html>

<html>

<!-- the head section -->
<head>
    <title>Modify Race</title>
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
	
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<script src="../jquery.geocomplete.js"></script>
			<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
		

	<script>
	
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
		function RecalculateElapsedTime () 
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
		
		/*function SelectTime(valueToSelect,valueToSelect2,valueToSelect3)
		{    
			var element = document.getElementById('starttimesec');
			element.value = valueToSelect;

			var element = document.getElementById('starttimemin');
			element.value = valueToSelect2;
			
			var element = document.getElementById('starttimehour');
			element.value = valueToSelect3;
		}*/
		
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
		
		//RUN IT WHEN VALUES CHANGE
        function Init () 
		{
			RecalculateElapsedTime ();
			Feel ();
			//SelectTime($Times,$Timem,$Timeh); // this is PHP.. bleh..
        }
    </script>
	
</head>


<!-- the body section -->

<body onload="Init ()">

    <header><h1>Adding a New Race Result</h1></header>
    <main>
	
        <center><h2>Please Add Your Race Results:</h2>
		<center><img src="<?php echo "$Picture"; ?>" alt="WaterToWine" align="center" style="width: 40%; height: 40%" ></center> <br>
		
		<h2>Image to be upload</h2>
        <form action="modify_race.php" method="post" id="modify_race_form" enctype="multipart/form-data">
			
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
				<!--<input type="hidden" name="action" value="upload">-->
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
			  
			  <input class="upload" type="input" id="myFile" name="file1" value="<?php echo $Picture; ?>" readonly>
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
				<input type="text" name="Index" value="<?php echo $Index; ?>" readonly>
			 </td>
			 </tr>
	 
			 

			<!-- Learn about this code on MDN: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file -->

			
						<?php

						/*if($Picture!=NULL)
						{
							echo "$Picture";
						}	
						else
						{
							echo "No files currently selected for upload";
						}*/
						?>
				
					
				   <!-- <form id="add_MyRaceResults.php" action="." method="POST" enctype="multipart/form-data">-->
						<!--<input type="hidden" name="action" value="<?php echo $Picture; ?>">
						<input type="file" name="file1"    value="<?php echo $Picture; ?>" accept=".jpg, .jpeg, .png" ><br>-->
						<!--<input id="upload_button" type="submit" value="Upload"> -->
					  <!--</form> -->

			
			</tr>
			

			<tr>
           <td><label>Race Name:</label></td>
           <td> <input type="text" name="Race" placeholder="Running of the Warriors" value="<?php echo $Race; ?>" required></td><br>		   
		   </tr><tr>
			
			<td><label>Date of Race:</label></td>
			
			<?php
			/*
				$d= substr($Date, (strlen($Date)-2)); // makes seconds the last 2 chars
				$inputTime=substr($Date,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
				$m= substr($Date, (strlen($Date)-2)); 
				$Date=substr($Date,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
				$y= $Date; 
			$myDate="$m/$d/$y"; //TEST
			*/
			//$Date=substr($Date, 2,-1);
			
			/*if($Date=="2017-07-04")
			 echo"SAME! Date:$Date. and Text:2017-07-04.";
		    else 
			 echo"NOT SAME... Date:$Date. and Text:2017-07-04.";*/
			?>
			
           <td> <input type="date" name="Date" value="<?php echo"$Date"; ?>" required ></td><br>		   
		   </tr><tr>

           <!--<td><label>Distance Run:</label></td>
            <td><input type="number" name="quantity" min=".01" max="26.20" name="Distance" value="13.1" required></td><br>
			</tr><tr>	-->	   
			
			 
			 <!-- NEED TO FIGURE OUT HOW TO SELECT THE CURRENT DISTACE -->
			 <td><label>Distance</label></td>
             <td><select id="distance" name="Distance" onchange="RecalculateElapsedTime ()" class="selectboxkl">
				<?php foreach ($Distance as $Distance) : ?>
				    <!--https://stackoverflow.com/questions/1336353/how-do-i-set-the-selected-item-in-a-drop-down-box?newreg=d27b59304f42448e88b80762d4ca2b61-->
					<option value="<?php echo $Distance['Distance']; ?>"<?=$Distance['Distance'] == "$MyDistance" ? ' selected="selected"' : '';?>><?php echo $Distance['distName']; ?></option> <!--WORKS!!!! :) -->				
				<?php endforeach; ?>
            </select></td></tr>
			
			<!--<tr>
			 <td><label>Time Run:</label></td>
            <td><input type="text" name="Time" value="1:10:09" required></td><br>
			</tr><tr> -->
			
			
			<!-- NEED TO FIGURE OUT HOW TO SELECT THE TIME -->
			<?php
			$Hours   = array();
			$Minutes = array();
			$Seconds = array();
			
			for($i=0; $i<60; $i++)
			{
				array_push($Hours   , $i);
			    array_push($Minutes , $i);
			    array_push($Seconds , $i);
			}
			
			
			?>
			<td><label>Time Run:</label></td>
            <td>
			<pre><b>Hours                       Minutes                       Seconds</b></pre>
				<select id="starttimehour" name="Hours" onchange="RecalculateElapsedTime ()" class="selectboxkl">
					<?php foreach ($Hours as $Hours) : ?>
						<option value="<?php echo $Hours; ?>"<?=$Hours == "$Timeh" ? ' selected="selected"' : '';?>><?php echo "$Hours"; ?></option> 
					<?php endforeach; ?>
				</select>
				:
				<select id="starttimemin" name="Minutes" onchange="RecalculateElapsedTime ()" class="selectboxkl">
					<?php foreach ($Minutes as $Minutes) : ?>
						<option value="<?php echo $Minutes; ?>"<?=$Minutes== "$Timem" ? ' selected="selected"' : '';?>><?php echo "$Minutes"; ?></option> <!--WORKS!!!! :) -->
					<?php endforeach; ?>
				</select>
				:
				<select id="starttimesec" name="Seconds" onchange="RecalculateElapsedTime ()" class="selectboxkl">
					<?php foreach ($Seconds as $Seconds) : ?>
						<option value="<?php echo $Seconds; ?>"<?=$Seconds == "$Times" ? ' selected="selected"' : '';?>><?php echo "$Seconds"; ?></option> <!--WORKS!!!! :) -->
				    <?php endforeach; ?>
				</select>
				<br>
							
			</td><br>
			</tr><tr> 
			
				<td> <label>Pace Run </label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="Pace" id="elapsed" readonly value="<?php echo $Pace; ?>"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr><tr>

           <td> <label>Place Finished:</label></td>
           <td> <input name="Place" placeholder="1" value="<?php echo $Place; ?>" type="number" min="1" max="1000" pattern="[0-9]{3}" required ></td><br>
		   </tr><tr>
			 	
			
			<td> <label>Location</label></td>
           <td> <input id="geocomplete" type="text" name="Location" placeholder="Santa Rosa, Ca" value="<?php echo $Location; ?>" required ></td><br>
		   </tr><tr>
		   
		   	<!-- NEED TO FIGURE OUT HOW TO SELECT THE CURRENT Type -->
			<?php
			$Types  = array("XC","Track","Road","Tri");
			?>
			<td><label>Type of Race</label></td>
             <td>
			 <select name="Type">
				<?php foreach ($Types as $Types) : ?>	
					<option value="<?php echo $Types; ?>"<?=$Types == "$Type" ? ' selected="selected"' : '';?>><?php echo "$Types"; ?></option> <!--WORKS!!!! :) -->
				<?php endforeach; ?>	
            </select>
			</td></tr>
			
			<!--<td>Picture: </td>
			<td><input type="image" src="img_submit.gif" alt="Submit" width="48" height="48"></td>
			</tr><tr>-->
			
			<td>Add link to your results: </td>
			<td><input type="url" name="ResultsLink" placeholder="Directathletics.com" value="<?php echo $LinkToResults; ?>"></td> 
 
			</tr><tr>
			
			<td>Add link to your activity: <br><a href="https://www.strava.com/dashboard?feed_type=my_activity">My Strava Activities</a></td>
			<td><input type="url" name="ActivityLink" placeholder="strava.activity.com" value="<?php echo $LinkToActivity; ?>"></td>
			</tr><tr>
			
			<td>Shoe Model/ Brand </td>
			<td><input type="text" name="Shoes" placeholder="Ex. Nike Lunar Racer" value="<?php echo $shoes; ?>"></td>
			</tr>
			
			<tr>
			<td> <label>Notes:</label></td>
           <td> <textarea rows="8" cols="75" name="Comments" placeholder="Please write a note about the race..." ><?php echo $Comments; ?></textarea></td><br>
		   </tr>
		   
		      <tr>
			<td> <label>How did you feel? (Scale 1 to 10, 10 being the best)</label></td>
           <td> 
		   Felt like a: 
		   <input type="range" name="feel" min="0" max="10" value="<?php echo $feel; ?>" onchange="Feel ()" id="slider">
		   <input type="text" name="feeltext" value="0" readonly id="feel"><br>
		  <pre> 0 (Worst)                                                                       10 (Best) </pre>
			</td><br>
		   </tr>
		   
		   <!--FOR PASSING PASSWORD INFO FOR USER TO FORM-->
		   <input type="hidden" name="username" value="<? echo $myusername?>" >
		   <input type="hidden" name="password" value="<? echo $mypassword?>" > 
		   
		   </table></center>
		   
		
  
			
            <label>&nbsp;</label>

            <input class="button" type="submit" value="Modify Race">  <br><br> <input class="button" type=reset value="Clear">
			<br>
        </form>

        <p><a href="<?php echo "RaceResults.php?choice=search&user=".urlencode($myusername)."&password=".urlencode($mypassword)."&Year=".urlencode('All')."&Distance=".urlencode('All'); ?>">Back</a> <a href="../index.php">View Users</a></p>
    </main>



    <footer>
        <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, 2017, Inc.</p>
    </footer>

</body>

</html>

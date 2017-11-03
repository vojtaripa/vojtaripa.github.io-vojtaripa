<?php
require('database.php');
//require('database.php');
/*$dsn = 'mysql:host=vojta-data.db.sonic.net; dbname=vojta_data';
$username = 'vojta_data-all';
$password = '590d05cd';

mysql_select_db( "vojta_data",mysql_connect($dsn, $username, $password) );*/

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

?>

<!DOCTYPE html>

<html>

<!-- the head section -->
<head>
    <title>Functions</title>
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
	
	
	
	<!-- JAVASCRIPT -->
	<script>
	   
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
		
		function FindMPH () 
		{
            var startHSelect = document.getElementById ("startpacehour");
            var startMSelect = document.getElementById ("startpacemin");
			var startSSelect = document.getElementById ("startpacesec");
						
			//var distance     = document.getElementById ("distance");
			
			// convert string values to integers
			var startH = parseInt (startHSelect.value);
			var startM = parseInt (startMSelect.value);
			var startS = parseInt (startSSelect.value);
			
		    var totalSec = (startH*60*60)+(startM*60)+startS;
			var PaceToMPH = (1/totalSec) *60 *60;
			
					
			//Gets value of result field
			var elapsedSpan = document.getElementById ("myMPH");
							  
			
			//changes the value of the result field
			elapsedSpan.value = "" + (PaceToMPH); //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
        }
		
		function TimeToSeconds () 
		{
            var startHSelect = document.getElementById ("starttimesechour2");
            var startMSelect = document.getElementById ("starttimesecmin2");
			var startSSelect = document.getElementById ("starttimesecsec2");
						
			//var distance     = document.getElementById ("distance");
			
			// convert string values to integers
			var startH = parseInt (startHSelect.value);
			var startM = parseInt (startMSelect.value);
			var startS = parseInt (startSSelect.value);
			
		    var totalSec = (startH*60*60)+(startM*60)+startS;		
			
					
			//Gets value of result field
			var elapsedSpan = document.getElementById ("totalSec");
							  
			
			//changes the value of the result field
			elapsedSpan.value = "" + (totalSec); //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
        }
		
		function SecToTime () 
		{
		    var startHSelect = document.getElementById ("SecondsRun");
			var startH = parseInt (startHSelect.value);
			
			var totalSec = SecondsToTime(startH);
								
			//Gets value of result field
			var elapsedSpan = document.getElementById ("TimeRun");			  
			
			//changes the value of the result field
			elapsedSpan.value = "" + (totalSec); //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
        }
		
		function DistanceConv () 
		{
		    var startHSelect = document.getElementById ("DistanceToConv");
			var DIST = startHSelect.value;
			
			//var totalSec = SecondsToTime(DIST);
								
			//Gets value of result field
			var RESULTSpan = document.getElementById ("ConvDistance");			  
			
			//changes the value of the result field
			RESULTSpan.value = (DIST); //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
        }
		
		function VO2MAX () 
		{
	   
		   //GETS INPUT ELEMENTS
			var maleX   = document.getElementById ("male2");
			var femaleX = document.getElementById ("female2");
			var hourX   = document.getElementById ("starttimehour2");
			var minX    = document.getElementById ("starttimemin2");
			var secX    = document.getElementById ("starttimesec2");
			var ageX    = document.getElementById ("age");
			var bmiX    = document.getElementById ("BMI");
			
			//GETS INPUT VALUES
			var male   = maleX.value;
			var female = femaleX.value;
			var hour   = parseInt (hourX.value);
			var min    = parseInt (minX.value);
			var sec    = parseInt (secX.value);
			var age    = parseInt (ageX.value);
			var BMI    = parseInt (bmiX.value);
			
			if(document.getElementById("male2").checked == true)
			{
				var sex=1;
			}
			else
			{
				var sex=0;
			}		
			
			//var sex = 1; //or 0...
			var totalSec = (hour*60*60)+(min*60)+(sec);
			var time= totalSec/60;
			
			var Result = (.21*(age * sex)) - (.84 * BMI) - (8.41 * time) + (.34 * (time*time)) + 108.94;		
		    
			//Gets value of result field
			var RESULTSpan = document.getElementById ("text");			  
			
			//changes the value of the result field
			RESULTSpan.value = ""+ Result; //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
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
			VO2MAX ();
			//FindMPH ():
        }
		
		
    </script>
	
</head>



<!-- the body section -->

<body onload="Init ()">
     <main>
	 
	 
 <center>
   <span class="myButtons" style="display: inline;">
   
   <h2> Links: </h2>
   
   <a class="button" href="login.php" >Admin</a> <!--indexAdmin.php -->
   <a class="button" href="../index.php" >View All Users</a>
   <a class="button" href="functions.php" style="background-color:red;" >Other Functions / Conversions</a>
   <a class="button" href="distance_list.php">List distances</a>     
   <a class="button" href="signup.php" >Sign up for updates</a>
   
   <a class="button" href="http://vojta.users.sonic.net/blog/"> Vojta's Main Page </a>
   <a class="button" href="about.html">Vojta's Bio</a>
   
   </span>
   
    <br>
   <hr  >
   <br>
    <header><h1>Useful Functions and Conversions</h1></header>

</center>

        	
			
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
			
<div style="background-color: rgba(0,0,0,.5); ">
	    <center><h2>Here are some useful functions:</h2>
		<table style="background: rgb(0,0,0); ">
		
		  <tr><td><a class="button" href="#Pace Calculator">Pace Calculator</a>       </td> <td>Given a time and distance, this function will give you the pace per mile needed to achive this goal. </td></tr>
		  <tr><td><a class="button" href="#Best Event Selector">Best Event Selector</a>   </td> <td>If you have a few races with different distances and different times, its hard to compare those activities and know which one is better. This function will decide for you!	  </td></tr>
		  <tr><td><a class="button" href="#Points Converter">Points Converter</a>      </td> <td>This function is based on the one above, given a distance run and time you ran it in, it will spit out the amount of points (0 - 1400) </td></tr>
		  <tr><td><a class="button" href="#Pace to MPH">Pace to MPH</a>           </td> <td>Converts the Pace you ran to Miles Per Hour for you. </td></tr>
		  <tr><td><a class="button" href="#Time to Seconds">Time to Seconds</a>       </td> <td>Tells you how many seconds a given time is. </td></tr>
		  <tr><td><a class="button" href="#Seconds to Time">Seconds to Time</a>       </td> <td>Given the amount of seconds, it converts it to an actual time. </td></tr>
		  <tr><td><a class="button" href="#Distance converter">Distance converter</a>	   </td> <td>Select the distance you ran and the metrics, then chose which metrics you want to convert it to. </td></tr>	  
		  <tr><td><a class="button" href="#Distance converter">VO2MAX calculator</a>	   </td> <td>VO2 max represents your maximal oxygen consumption and varies from athlete to athlete depending on your cardiovascular fitness. It's often expressed in milliliters of oxygen per kilogram of body weight per minute and is the single best measure of cardiovascular fitness. Think of VO2 max as a measure of how efficiently your body uses oxygen. </td></tr>
		</table>
        
			<center>
			
</div>
</body>
</main>


<br><br><br>

<main>
<body>
<div id='Pace Calculator'>
<u><h1>Pace Calculator</h1></u><br>
<h3>Please select a distance and time:</h3>	
		
<table style="align:center;width:70%;border: 4px solid red;">
				
			 <td><label>Distance</label></td>
             <td><select id="distance" name="Distance" onchange="FindPace ()" class="selectboxkl">
				<?php foreach ($Distance as $Distance) : ?>
					<option value="<?php echo $Distance['Distance']; ?>">
						<?php echo $Distance['distName']; ?>
					</option>
				<?php endforeach; ?>
            </select></td></tr>
			
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
		   </tr>
		   
		   </table></center>
		
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
</div>		
</body> 
</main>


<br><br><br>

<main>
	<body>
		<div id='Best Event Selector'>
			<u><h1>Best Event Selector</h1></u><br>
			<center><h3>Please put in your best times in associated distances:</h3>	</center>
			
			
			<!-- ******************************************************************************  -->
			<h1 id="ranker10"></h1>
				<h1 style="text-align: center;"><span style="text-decoration: underline;">Whats the best event?</span></h1>
				<h2 style="text-align: center;"><strong>Please put in your best events:</strong></h2>
				
				
				<form action="bestEvent.php" method="post" id="best_event" enctype="multipart/form-data">
				<center><table style="width: 1200px; text-align: center;">
				<tbody>
				<tr>
				<th>Instructions:</th>
				<th>Please Complete:</th>
				</tr>
				<tr>
				<td>Please select your gender</td>
				<td>
				<div class="switch-bar"><input id="male3" checked="checked" name="sex" type="radio" value="male"/><label for="male3">Male</label><input id="female3" name="sex" type="radio" value="female" /><label for="female3">Female</label></div></td>
				</tr>
				<tr>
				<td>Please select your <strong>BEST </strong>event</td>
				<td><select name="event1">
				<option selected="selected" value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your time accordingly</td>
				<td><input name="time1" type="text" placeholder="10.29" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>2nd</strong> best event</td>
				<td><select name="event2">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option selected="selected" value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your time accordingly</td>
				<td><input name="time2" type="text" placeholder="1:18.2" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>3rd</strong> best event</td>
				<td><select name="event3">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option value="800m">800m</option>
				<option selected="selected" value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your time accordingly</td>
				<td><input name="time3" type="text" placeholder="2:15.2" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>4th</strong><strong> </strong>event</td>
				<td><select name="event4">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option selected="selected" value="600m">600m</option>
				<option value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter the mark accordingly</td>
				<td><input name="time4" type="text" placeholder="1:09.2" /></td>
				</tr>
				<tr>
				<td>Please select <strong>5th</strong> event</td>
				<td><select name="event5">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option selected="selected" value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your mark accordingly</td>
				<td><input name="time5" type="text" placeholder="1:18.2" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>6th</strong> event</td>
				<td><select name="event6">
				<option selected="selected" value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your time accordingly</td>
				<td><input name="time6" type="text" placeholder="10.29" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>7th</strong> event</td>
				<td><select name="event7">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option selected="selected" value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your time accordingly</td>
				<td><input name="time7" type="text" placeholder="1:18.2" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>8th</strong> best event</td>
				<td><select name="event8">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option value="800m">800m</option>
				<option selected="selected" value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your time accordingly</td>
				<td><input name="time8" type="text" placeholder="2:15.2" /></td>
				</tr>
				<tr>
				<td>Please select your <strong>9th</strong><strong></strong> event</td>
				<td><select name="event9">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option selected="selected" value="600m">600m</option>
				<option value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter the mark accordingly</td>
				<td><input name="time9" type="text" placeholder="1:09.2" /></td>
				</tr>
				<tr>
				<td>Please select <strong>10th</strong> event</td>
				<td><select name="event10">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option selected="selected" value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
				</tr>
				<tr>
				<td>Please enter your mark accordingly</td>
				<td><input name="time10" type="text" placeholder="1:18.2" /></td>
				</tr>
				<tr>
				<td><button type="reset" value="Reset">Reset</button></td>
				<td><button type="submit" value="Submit">Submit</button></td>
				</tr>
				</tbody>
				
				
				</table></center>
				</form>
				<h2></h2>
				<!-- <span id="results3" style="color: #444444;">[SQLREPORT name="compare-event-marks-results"]</span>  NEED TO FIX THIS -->

<!-- ******************************************************************************  -->
			
		</div>
	</body> 
 </main>

<br><br><br> 
 
 
<main>
	<body>
		<div id='Points Converter'>
			<u><h1>Points Converter</h1></u><br>
			<h3>Please put in a time and distance, and it will determine how many points the effort is worth scale (0 - 1400):</h3>	
	 
	<form action="bestEvent.php" method="post" id="best_event" enctype="multipart/form-data">
	<table style="align:center;width:70%;border: 4px solid red;">
			

			<tr>
				<td>Please select your gender</td>
				<td>
				<div class="switch-bar"><input id="male3" checked="checked" name="sex" type="radio" value="male"/><label for="male3">Male</label><input id="female3" name="sex" type="radio" value="female" /><label for="female3">Female</label></div></td>
			</tr>
				
			 <td><label>Distance</label></td>
             			 
			 <td><select name="event1">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option selected="selected" value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td>
			 
			 </td></tr>
			
			<tr>
				<td>Please enter your mark accordingly</td>
				<td><input name="time1" type="text" placeholder="1:18.2" /></td>
			</tr>
			
		   <tr>
				<td><button type="reset" value="Reset">Reset</button></td>
				<td><button type="submit" value="Submit">Submit</button></td>
		   </tr>
		   
		   </table></center>
		   </form>
		   
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
		
		</div>
	</body>
 </main>

<br><br><br> 



<main>
	<body>
		<div id='Pace to MPH'>
			<u><h1>Pace to MPH</h1></u><br>
			<h3>Please put in a pace:</h3>	
		
		<table style="align:center;width:70%;border: 4px solid red;">
				
			 
			
			<td><label>Pace Run:</label></td>
            <td>
			<pre><b>Hours                       Minutes                       Seconds</b></pre>
				<select id="startpacehour" name="Hours" onchange="FindMPH ()" class="selectboxkl">
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
				<select id="startpacemin" name="Minutes" onchange="FindMPH ()" class="selectboxkl">
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
				<select id="startpacesec" name="Seconds" onchange="FindMPH ()" class="selectboxkl">
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
			
				<td> <label>MPH Run </label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="Pace" id="myMPH" readonly value="0 MPH"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   </table></center>
		
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
		
		</div>
	</body> 
 </main>

<br><br><br> 

<main>
	<body>
		<div id='Time to Seconds'>
			<u><h1>Time to Seconds</h1></u><br>
			<h3>Please put in a time:</h3>	 
		
		<table style="align:center;width:70%;border: 4px solid red;">
				
			 
			
			<td><label>Time Run:</label></td>
            <td>
			<pre><b>Hours                       Minutes                       Seconds</b></pre>
				<select id="starttimesechour2" name="Hours" onchange="TimeToSeconds ()" class="selectboxkl">
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
				<select id="starttimesecmin2" name="Minutes" onchange="TimeToSeconds ()" class="selectboxkl">
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
				<select id="starttimesecsec2" name="Seconds" onchange="TimeToSeconds ()" class="selectboxkl">
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
			
				<td> <label>Seconds Run:</label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="Pace" id="totalSec" readonly value="0 Seconds"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   </table></center>
		
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
		
		</div>
	</body> 
 </main>

<br><br><br> 

<main>
	<body>
		<div id='Seconds to Time'>
			<u><h1>Seconds to Time</h1></u><br>
			<h3>Please put in Seconds run:</h3>	
			
			<table style="align:center;width:70%;border: 4px solid red;">
	
			 <tr> 
				<td> <label>Seconds Run </label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="Time" id="SecondsRun" value="25 Sec" onchange="SecToTime ()"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   <tr> 
				<td> <label>Time Run </label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="Pace" id="TimeRun" readonly value="00:00:25"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   </table></center>
		
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
			
		</div>
	</body> 
 </main>

<br><br><br> 

<main>
	<body>
		<div id='Distance converter'>
			<u><h1>Distance converter <br><i>(*does not work yet*)</i></h1></u><br>
			<h3>Please select a distance:</h3>	 
			
			<table style="align:center;width:70%;border: 4px solid red;">
				
			 <tr> 
			 <td>Distance:</td>
			 
			 <td><select name="events" id="DistanceToConv" onchange="DistanceConv ()">
				<option value="100m">100m</option>
				<option value="100mH">100mH</option>
				<option value="200m">200m</option>
				<option value="300m">300m</option>
				<option value="400m">400m</option>
				<option value="400mH">400mH</option>
				<option value="600m">600m</option>
				<option selected="selected" value="800m">800m</option>
				<option value="1000m">1000m</option>
				<option value="1500m">1500m</option>
				<option value="Mile">Mile</option>
				<option value="2000m">2000m</option>
				<option value="2000mSC">2000mSC</option>
				<option value="3000m">3000m</option>
				<option value="3000mSC">3000mSC</option>
				<option value="2Miles">2Miles</option>
				<option value="5000m">5000m</option>
				<option value="10000m">10000m</option>
				<option value="10km">10km</option>
				<option value="15km">15km</option>
				<option value="10Miles">10Miles</option>
				<option value="20Miles">20Miles</option>
				<option value="HM">HM</option>
				<option value="25km">25km</option>
				<option value="30km">30km</option>
				<option value="Marathon">Marathon</option>
				<option value="100km">100km</option>
				<option value="HJ">High Jump</option>
				<option value="PV">Pole Vault</option>
				<option value="LJ">Long Jump</option>
				<option value="TJ">Triple Jump</option>
				<option value="SP">Shot-put</option>
				<option value="DT">Discus Throw</option>
				<option value="HT">High Jump</option>
				<option value="JT">Javelin Throw</option>
				<option value="Heptathlon">Heptathlon</option>
				<option value="4x100m">4x100m</option>
				<option value="4x200m">4x200m</option>
				<option value="4x400m">4x400m</option>
				</select></td></tr>
			
			<tr> 
			
				<td> <label>Distance in Miles </label></td>
           <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="DistanceX" id="ConvDistance" readonly value="0.50"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   </table></center>
		
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
			
		</div>
	</body> 
 </main>

<br><br><br> 

<main>
	<body>
		<div id='VO2MAX'>
			<u><h1>VO2MAX</h1></u><br>
			<h3>VO2 max represents your maximal oxygen consumption and varies from athlete to athlete depending on your cardiovascular fitness. It's often expressed in milliliters of oxygen per kilogram of body weight per minute and is the single best measure of cardiovascular fitness. Think of VO2 max as a measure of how efficiently your body uses oxygen.</h3>
	        <pre style="color:white;">   Variables:		
- man(1) or woman (0)
- age (years)
- BMI (weight and height)
- Time (mile)
- Distance (mile only?) CAN USE PACE?

Formula:
[.21(age * sex)] - [.84 * BMI (previously determined) ] - [8.41*time(in min)] + [.34 *time^2] + 108.94 </pre>
		
		
		<table style="align:center;width:70%;border: 4px solid red;">
			
            <tr>
				<td>Select One</td>
				<td><div class="switch-bar">
				
				<input onchange="VO2MAX ()" id="male2" checked="checked" name="sex" type="radio" value="male"/>
				<label for="male2">Male</label>
				
				<input onchange="VO2MAX ()" id="female2" name="sex" type="radio" value="female" />
				<label for="female2">Female</label>
				
				</div></td>
            </tr>			
			<tr> 		
				<td> <label>Age </label></td>
                <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="age" id="age" placeholder="28" onchange="VO2MAX ()"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		
			<tr>
			<td><label>Mile Time Run:</label></td>
            <td>
			<pre><b>Hours                       Minutes                       Seconds</b></pre>
				<select onchange="VO2MAX ()" id="starttimehour2" name="Hours"  class="selectboxkl">
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
				<select onchange="VO2MAX ()" id="starttimemin2" name="Minutes" class="selectboxkl">
					<option value="00" >00</option>
					<option value="01" >01</option>
					<option value="02" >02</option>
					<option value="03" >03</option>
					<option value="04" selected="selected" >04</option>
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
				<select onchange="VO2MAX ()" id="starttimesec2" name="Seconds" class="selectboxkl">
					<option value="00" >00</option>
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
					<option value="20" selected="selected">20</option>
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
			</tr>
			
			<tr> 		
				<td> <label>BMI (Body Mass Index) </label></td>
                <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="BMI" id="BMI" onchange="VO2MAX ()" placeholder="20.1" > </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   <tr> 		
				<td> <label>Your VO2MAX <br> (efficientcy) </label></td>
                <td> <!--<input type="text" name="Pace" value="0:05:09">--> <input name="VO2MAX" id="text" readonly value="65 ml/kg/min"> </td><br> <!-- <span name="Pace" id="elapsed"></span>  -->
		   </tr>
		   
		   </table></center>
		
            <label>&nbsp;</label>

        <p><a href="../index.php">Home</a></p>
		
		</div>
	</body> 
 </main>

<br><br><br>  

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, 2017, Inc.</p>
    </footer>


</html>
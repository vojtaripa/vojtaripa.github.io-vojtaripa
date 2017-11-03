<?php
//RaceResults.php
//(used to be index.php)

require_once('database.php');
require_once('../map/graphs/Person.php');
require ('indexPHP.php');
//require ('javascript_RaceResults.js');

//echo "Year: $Year <br>";
//echo "Distance: $Distance <br>";
?>

<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
	
	<!-- FOR SORTING TABLES!!! -->
	<script src="sorttable.js"></script> 
	<!-- INCLUDING FOR ALL JAVASCRIPT! -->
	<script src="javascript_RaceResults.js"></script> 
	
	
    <title>Here Are All My Race Results</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style> 
		h2   {text-shadow: 1px 5px 5px #FF0000; color: white}  
	</style>
	
</head>

<!-- the body section -->
<body onload="Init ()">
	



<main>

   
   <!-- <h3>Welcome: <?php echo $theuser['0']['username']; ?></h3> -->
   
   
<!-- TOP BUTTONS -->  
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
   <h3><?php echo "Race Results for: <div style='color: yellow;' >". $first_name . " ". $last_name."</div>"; ?> </h3>
   </center> 

 <!--ADMIN --------------------------------------------------------------------------------------------------------------------------->
				<?php
					if($usernameCheck==true)
					{
						echo"
						<center><h2> * LOGGED IN AS ADMIN * </h2><span class='myButtons' style='display: inline;'><a class='button' href='RaceResults.php?choice=search&user=".urlencode($myusername)."&Year=".urlencode('All')."&Distance=".urlencode('All')."' >Regular View</a></center>";
					}
				?>	
<!--END ADMIN ------------------------------------------------------------------------------------------------------------------------>
  
  
  
<!--PICTURE --> 
<?php  
//PICTURE:	
	
	//if picture exists, use picture
	if($userimage!=Null)
	{
		$userimage= "../image/racePics/".$myusername. "/" . $userimage;
	} 
	//else use default
	else
	{
		$userimage="../image/racePics/default.jpg";
	}
   
   //NOW ADDING IMAGE IN:
   if($myusername=="vojtaripa")
		echo "<center><img src='../css/finishMe.jpg' alt='finish' align='center'></center> <br>";
   else
	    echo "<center><img src='$userimage' alt='$first_name' align='center'></center> <br>";
 ?>  
   <!-- END TOP BUTTONS -------------------------------------------------------------->
   
   
   
 
 <!--ALL YEARS buttons --> 

 <!--USE $Year as the year to perate on! --> 

<h1>Race Filters: </h1>
<p>You can click on the following buttons to narrow down your results. <br>Years - will show you all the results from a specific year. <br> Distance - will show you all the results from a specific distance. <br> Other - there are other functions and links to pages available here.</p>
<hr  >

<ul class="myButtons">
	<span class="myButtons" style="display: inline;">
	   <form action="">
	         		   
		   <!-- All years -->			   
		   <li class="myButtons" style="display: inline;">	
			
			<!-- display a list of distances -->
			<h2 color=black style="display: inline;">Years:</h2>
		        				
				<?php 	
				if($Distance=="") 
					$Distance= "All"; 
				else 
					$Distance=$Distance;
				echo "<a class='button' href='RaceResults.php?choice=search&user=".urlencode($myusername)."&password=".urlencode($mypassword)."&Year=".urlencode('All')."&Distance=".urlencode($Distance)."'>All</a>"; 		
				?>  
				
		   </li>
	   
	       <!-- All other years -->
		  
			<?php for($StartYear; $StartYear<=$CurrentYear; $StartYear++ ) { ?>		
			<li style="display: inline;">			
				<!--<a class="button" href=".?Year=<?php echo "$StartYear"; ?>">   <?php echo "$StartYear"; ?> </a>-->
				
				<?php 
					if($Distance=="") 
						$Distance= "All"; 
					else 
						$Distance=$Distance;
					echo "<a class='button' href='RaceResults.php?choice=search&user=".urlencode($myusername)."&password=".urlencode($mypassword)."&Year=".urlencode($StartYear)."&Distance=".urlencode($Distance)."'>$StartYear</a>"; 
				?>  
				
		   </li<?php }?>>
	  </form>	   
	</span>	
</ul>      

 

 
		
<!-- BUTTON FOR ALL Distances-->
<ul class="myButtons" >           
	<span class="myButtons" style="display: inline;">
	<li class="myButtons" style="display: inline;">
	     <!-- display a list of distances -->
        <h2 color=black; style="display: inline;" > Distances: </h2>
		
		<!--<a class="button" href=".?Distance=<?php echo 'All'; ?>"> All <!-- put the word ALL in URL and make button say "All" -->
		<?php 
			if($Year=="") 
					$Year= "All"; 
			else 
					$Year=$Year;
			echo "<a class='button' href='RaceResults.php?choice=search&user=".urlencode($myusername)."&password=".urlencode($mypassword)."&Year=".urlencode($Year)."&Distance=".urlencode('All')."'> All </a>"; 
		?>  
		<?php  //echo $DistanceName['Distance']; ?>
		
	</li>

<!-- BUTTONS FOR REST OF DISTANCE NAMES -->
	<?php foreach ($DistanceName as $DistanceName) : ?>
		<li class="myButtons" style="display: inline;">
						
			<?php 
				if($Year=="") 
					$Year= "All"; 
				else 
					$Year=$Year;
				echo "<a class='button' href='RaceResults.php?choice=search&user=".urlencode($myusername)."&password=".urlencode($mypassword)."&Year=".urlencode($Year)."&Distance=".urlencode($DistanceName['Distance'])."'>". $DistanceName['distName']."</a>"; 
			?>  
			
		</li>
    <?php endforeach; ?> 
	</span>
	</ul>
<section>
	

	
	
	
<!-- BUTTONS FOR other queries -->

<ul class="myButtons">
	<span class="myButtons" style="display: inline;">
	 
		<li class="myButtons" style="display: inline;">
			<h2 color=black; style="display: inline;">Other: </h2>
			
				<!--ADMIN --------------------------------------------------------------------------------------------------------------------------->
				<?php
					if($usernameCheck==true)
					{
						echo"
						<form action='add_race_form.php' method='post' id='add_race_form' enctype='multipart/form-data'>
						<input type='hidden' name='username' value='".$myusername."' >
						<input type='hidden' name='password' value='".$mypassword."' > 
						<input style='background-color:red' class='button' type='submit' value='Add Race'> 
						</form><br>
						"; //<a style='background-color:red' class='button' href='add_race_form.php'>Add NEW Race</a>
						

					}
				?>	
			    <!--END ADMIN ------------------------------------------------------------------------------------------------------------------------>
				
			<a class="button" href="#PRs">Race PRs </a>
			
			<?php // ?>
			
			<a  class="button" href=<?php echo "resultquery.php?user=select+*+FROM+$myusername+where+Place=1"?> >  Races Won </a>
			<?php // ?>
			
			<a  class="button" href=<?php echo "resultquery.php?user=select+COUNT(DISTINCT+Date)+FROM+$myusername" ?> >  Amount of days run a race</a> <!-- SELECT COUNT(DISTINCT Date) FROM $myusername where Date like %2017% -->
			<?php // ?>
				
			
		</li>
    
	</span>
</ul>


<hr  >


<?php
if($myusername=='vojtaripa' && $mypassword=='aa729258764c01f0436786c83fd1c6ff17efcfaf')
{
	echo
	"<ul class='myButtons'>
		<span class='myButtons' style='display: inline;'>
		
		<li class='myButtons' style='display: inline;'>
				<h2 color=black; style='display: inline;'>Extra Pages: </h2>
		<!-- BUTTONS / LINKS----------------------------------------------------------------->
				
				<p style='display: inline;'><a class='button' href='#' class='not-active'>Watch Youtube videos about running</a></p><!--pages/youtube.php-->
				<p style='display: inline;'><a class='button' href='#' class='not-active'>Show races on Map</a></p>
				<p style='display: inline;'><a class='button' href='#' class='not-active'><b>Distance Match-up</b></a></p> <!-- pages/youtube.php--> 
				<p style='display: inline;'><a class='button' href='future.html'>Future Race Bucketlist</a></p> 
				<p style='display: inline;'><a class='button' href='assignPoints.php'>Assign Points</a></p>
			</li>
		
		</span>
	</ul><hr  >";	
}	
?>	


<!------------------------------------------------------------------->	
	
<!-- Query Races: --><br>

<!--ADMIN --------------------------------------------------------------------------------------------------------------------------->
<?php
if($usernameCheck==true)
{
	echo"
			
		<h1>Query:</h1>
		<p>Please enter query for results you are looking for: <br>Query is SQL based see below for examples.</p>



		<form name='input' action='resultquery.php' method='get'>
			<input type='text' id='query' name='user' size='210' maxlength='500' placeholder='Enter your query...'>
			<input class='button' type='submit' value='Submit Query'>

			<tr>
				   <td align = right>
					  <input class='button' type=reset value='Clear'>
				   </td>
			</tr>

		</form>

			<button class='accordion' style='font-size:20px' onclick='accordion()'>Examples: </button>
			<div class='panel'>	 
				<u><b>In English:</b></u><br><br>
				 
				Get all distances where I have run faster than a 6:00/mi but only 30 results <br><br>
				 
				<u><b>Type this in SQL: </b></u><br><br>
							  
				SELECT * <br>
				FROM <username> <br>
				WHERE Pace<'6:00' LIMIT 0, 30 ; <br>	
				<br>
				<br>
				<u><b>Other examples:</b></u><br><br>
				<u><b>In English:</b></u><br><br>
				select * FROM <username> order by Date DESC <br>
				select * FROM <username> where (Time=(select MIN(Time) from $myusername where (Distance=13.1 AND (select * from $myusername where Date LIKE 2015%))))<br>
				select * FROM <username> where Place=1 order by Place DESC || This gets all races I have won! <br>
				select * FROM <username> where Type=Track order by Date DESC || This gets all Track Races I ran <br>
			</div>
		<hr  >	

";
}
?>	
<!--END ADMIN ------------------------------------------------------------------------------------------------------------------------> 

<h1>You Selected: <?php echo $Name; ?> distance(s) run in <?php if($Year=="%")echo "all years $Limit."; else echo substr("$Year", 0, 4)." year(s) $Limit."; ?></h1> 

 <!--Dropdown sections:  -->

<button class="accordion" style="font-size:20px">Description / About</button>

  <?php
  if($about!=null)
		echo "<p style='color:white'>
				$about
			  </p>";
   else
	    echo "<p>NO INFO GIVEN.</p> <br>";
  ?>
  
<!-- Gives distance name!! -->
<?php
if($Year==NULL && $Distance==NULL)
$Limit = " Limiting to 10 Results";
else
$Limit = "";
?>
         
 
<h2>Totals and Averages:</h2> 
<p>Here are the total and averages of the races you have selected.</p>
<!-- STARTING TABLE OF TOTALS-->
<table>
			<tr>
			<th>Number of Years</th> 
			<td><?php echo $TotalYears  ?></td> <!-- query for biggest and smallest year, then convert to int, then subtract and add 1 -->
			<tr>
			
			<tr>
				<th></th>
				<th>Races Run</th> 			
				<th>Races Run / Year</th> 
				<th>Time</th>
				<th>Distance</th>
				<th>Pace</th>
				<th>MPH</th>
				<th>Points</th>
				<th>Place</th>
			</tr>
			
			<!--AVG
			<tr>
				<th>Avg. Time</th> 			 		 
				<th>Avg. Distance</th>
				<th>Avg. Place</th> 
				<th>Avg. Pace</th> 
				<th>Avg. MPH</th>
				<th>Avg. Points</th>
			</tr>-->
			
			<!-- SPITTING OUT TOTAL VALUES-->
			<tr>
				<!--TOTALS-->
				<th>Totals:</th>
				<td><?php echo $totalCount ?></td> 
				<td><?php echo ($AvgRacesPerYear*$totalCount)  ?></td>
				<td><?php echo $TotalTime  ?></td> 
				<td><?php echo $TotalDistance ?></td>
				<td><?php echo $TotalPace ?></td>
				<td><?php echo round($TotalMPH,1)  ?></td> 
				<td><?php echo round($Totalpoints,1)  ?></td> 
				<td><?php echo ($AvgPlace*$totalCount) ?></td> 
			</tr>
			
			<!--AVG-->
			<tr>
				<th>Averages:</th>
				<td><?php if($totalCount==0) echo $totalCount=0; else echo($totalCount/$totalCount); ?></td> 
				<td><?php echo $AvgRacesPerYear  ?></td>
				<td><?php echo $AvgTime  ?></td> 				 
				<td><?php echo $AvgDistance ?></td> 
				<td><?php echo $AvgPace ?></td> 
				<td><?php echo round($AverageMPH, 1) ?></td> 
				<td><?php echo round($AvgPoints, 1) ?></td> 
				<td><?php echo $AvgPlace ?></td> 
			</tr>
			<!-- END-->
</table>			
<hr  >



<h1>Races:</h1>  
<p>Below are all the races that you have selected.<br>
You can sort the races by clicking each header, to sort them by that category.<br>
Races are organized and sorted by date initially, newest to oldest.<br>
Click the description below for more info! </p>


<br>

<!-- SEARCH -->

<input type="text" id="myInput" onkeyup="myFunction();" placeholder="Search for races by name..">

<br>
<br>

				<!--ADMIN --------------------------------------------------------------------------------------------------------------------------->
				<?php
					if($usernameCheck==true)
					{
						echo"
						<h1 style='background-color: yellow; color:black;'>*
						<form action='add_race_form.php' method='post' id='add_race_form' enctype='multipart/form-data'>
						<input type='hidden' name='username' value='".$myusername."' >
						<input type='hidden' name='password' value='".$mypassword."' > 
						<input style='background-color:red' class='button' type='submit' value='Add Race'> 
						</form>
						*</h1>
						
						";
					}
				?>	
			    <!--END ADMIN ------------------------------------------------------------------------------------------------------------------------>

				
				
<!-- STARTING TABLE OF DATA -->
	<div style=" height:400px; overflow:auto; display:block;">  
	   <table id="races" class="scroll sortable" >
		  	
			<!-- MAIN TABLE HEADINGS-->
			<thead >
				<tr class="header">
					<!-- TODO
						 DOES NOT WORK WHEN PUTTING DELETE RACE AND MODIFY RACE BUTTONS FOR SOME REASON!!!...
						 ALSO will need to keep whole row together
						 only want to search tytle / race so only apply search for that!
					-->
					
					<th style="width:120px">Picture                					</th> <!-- DOES NOT EVEN MOVE -->
					<th style="width:100px">Count                 &DownArrowUpArrow;</th> <!-- DOES NOT EVEN MOVE -->
					<th style="width:150px">Date <br>(YYYY-MM-DD) &DownArrowUpArrow;</th> <!--SORTING TABLE BASED ON INPUT --> <!-- WORKS onclick="sortTable(0)" -->
					<th style="width:250px">Race Name             &DownArrowUpArrow;</th> <!-- WORKS-->
					<th style="width:150px">Time (HH:MM:SS)       &DownArrowUpArrow;</th> <!-- TIME IS NOT SORTED RIGHT... -->
					<th style="width:100px">Distance (miles)      &DownArrowUpArrow;</th> <!-- WORKS-->
					<th style="width:100px">Place (overall)       &DownArrowUpArrow;</th> <!-- DOESNT WORK???-->
					<th style="width:150px">Pace (min/mi)         &DownArrowUpArrow;</th> <!-- Also doesnt work right... -->
					<th style="width:150px">MPH (mi/hr)           &DownArrowUpArrow;</th> <!-- Also doesnt work right... -->
					<th style="width:150px">Points (0-1400)       &DownArrowUpArrow;</th> <!-- Also doesnt work right... -->
					<th style="width:150px">Feel (0-10)           &DownArrowUpArrow;</th> <!-- Also doesnt work right... -->
					<th style="width:150px">Type of Race          &DownArrowUpArrow;</th> <!-- Also doesnt work right... -->
					<th style="width:100px">Location             				    </th> <!-- DOES NOT EVEN MOVE -->

					<?php
					if($usernameCheck==true)
					{
						echo"
						<th>DELETE?</th>
						<th>MODIFY?</th>";
					}
					?>
				</tr>
			</thead>
        
		
		<!--table body -->
		 <tbody>                      
            <!-- GETS EACH RACE and Race details-->                     
            <?php $i=0; $spot=0; $myCurrentYear = array(""); $totalCount=0; foreach ($race as $race) : $myCurrentYear[$i]=substr($race['Date'], 0, 4); //echo"My Current Year is: $myCurrentYear[$i]"; 
			$i++;?>
                             
				<!-- LOOP that handles Year Sections -->
				<?php 
				 if($i==1 )
				 { ?>
					 <tr id="hidethis" ><th  colspan="13" style="font-size:24px;background-color:#696969;"><?php echo substr($race['Date'], 0, 4); $spot=$i;?></th>
					 <td style="display:none;" ></td><td style="display:none;" ></td><td style="display:none;" ></td><td style="display:none;" ></td></tr>
				 <?php }

			     elseif(substr($race['Date'], 0, 4) != $myCurrentYear[($spot-1)]) 
				 { ?>
					 <tr id="hidethis" ><th  colspan="13" style="font-size:24px;background-color:#696969;"><?php echo substr($race['Date'], 0, 4); $spot=$i;?></th>
					 <td style="display:none;" ></td><td style="display:none;" ></td><td style="display:none;" ></td><td style="display:none;" ></td></tr>
				 <?php } 
				 else
				 {}	
				
				
				//PICTURE:	
				
				//if picture exists, use picture
				if($race['Picture']!=Null)
				{
					$picture= "../image/racePics/".$myusername. "/" . $race['Picture'];
				} 
				//else use default
				else
				{
					$picture="../image/racePics/default.jpg";
				}
				
				?>	
				
				<tr>
				
				<td > <img height="70px" src="<?php echo $picture; ?>" alt="<?php echo $picture; ?>" ></td>
				<td style="width:100px">  <?php $totalCount++; echo "$totalCount";  			 ?> </td>
				<td style="width:150px">  <?php echo $race['Date'];                 			 ?> </td>
				<td style="width:250px">  <?php echo $race['Race'];                              ?> </td>
				<td style="width:150px" > <?php echo $race['Time'];                              ?> </td>
				<td style="width:100px">  <?php echo $race['Distance'];             			 ?> </td>
				<td style="width:100px">  <?php echo $race['Place'];                			 ?> </td>
				<td style="width:150px">  <?php echo $race['Pace'];               			     ?> </td>
				<td style="width:150px">  <?php echo round(array_shift($MPHarray),1);         	 ?> </td>
				<td style="width:150px">  <?php echo $race['Points'];               			 ?> </td>
				<td style="width:150px">  <?php echo $race['Feel'];                				 ?> </td>
				<td style="width:150px">  <?php echo $race['Type'];                				 ?> </td>
				<td style="width:100px">  <?php echo $race['Location'];                        	 ?> </td>
				
				<!--ADMIN --------------------------------------------------------------------------------------------------------------------------->
				<?php
					if($usernameCheck==true)
					{
						echo"
						<!-- DELETE NEED TO CHANGE!!!-->
						<td><form action='delete_race.php' method='post'>
							<input type='hidden' name='Index'       value='". $race['Index'] ."'>
							<input type='hidden' name='Race' 	    value='  ". $race['Race']."  '>
							
							<input type='hidden' name='username' value='".$myusername."' >
						    <input type='hidden' name='password' value='".$mypassword."' > 
							<input type='submit'                    value='Delete' id='buttons' ><!--disabled-->
						</form></td>
						
					   					
			
						<!-- MODIFY NEED TO CHANGE!!!-->
						<td><form action='modify_race_form.php' method='post'>
						<input type='hidden' name='Index'           value='". $race['Index'] ."           '>
								
						<input type='hidden' name='Date' 	 		value='  ". $race['Date']."           '>
						<input type='hidden' name='Race' 	 		value='  ". $race['Race']."           '>
						<input type='hidden' name='Time' 	 		value='  ". $race['Time']."           '>
						<input type='hidden' name='Distance' 		value='  ". $race['Distance']."       '>
						<input type='hidden' name='Place' 	 		value='  ". $race['Place']."          '>
						<input type='hidden' name='Pace' 	 		value='  ". $race['Pace']."           '>
						<input type='hidden' name='Type' 	 		value='  ". $race['Type']."           '>
						<input type='hidden' name='Location' 		value='  ". $race['Location']."       '>
						<!-- INCLUDE OTHERS!!! -->
						<input type='hidden' name='LinkToResults'   value='  ". $race['LinkToResults']."  '>
						<input type='hidden' name='LinkToActivity' 	value='  ". $race['LinkToActivity']." '>
						<input type='hidden' name='shoes' 	        value='  ". $race['shoes']."          '>
						<input type='hidden' name='Notes' 	        value='  ". $race['Notes']."          '>
						<input type='hidden' name='Feel' 	        value='  ". $race['Feel']."           '>
						<input type='hidden' name='Picture' 	    value='  ". $picture."                '>
						
						<input type='hidden' name='username'        value='".$myusername."				  '>
						<input type='hidden' name='password'        value='".$mypassword."			      '> 						
						<input type='submit' value='Modify' id='buttons'>
						</form></td>";
					}
				?>	
			    <!--END ADMIN ------------------------------------------------------------------------------------------------------------------------>
            </tr>					
            <?php endforeach; ?>
			
			
         </tbody> 	
		</table>
 </div>

<hr  >
<br>

		
<div id="PRs">		
<!--RACE PRs---------------------------------------------------------------------------------------->	
<?php
			$myPRs=array();
			
			if($Distance==NULL && ($Year==NULL or $Year=="%"))
			{
				$title = "Race PRs / Fastest Times:";
			}
			else if($Year=='All')
			{
				$ShowYear=substr($Year, 0, 4);
				$title = "Race PRs / Fastest Times in All Years for each distance:";
			}
			else if ($Distance=='All' or $Year!=NULL)
			{
				$ShowYear=substr($Year, 0, 4);
				$title = "Race PRs / Fastest Times in $ShowYear for each distance:";
			}
			else if ($Year==NULL or $Year=="%")
			{
				$title = "Race PRs / Fastest Times for $Distance mile:";
			}
			else
			{
				$title = "NO PRS";
			}
			// TABLE HEADERS
			echo "<br> <h2> $title </h2> <br>";
			echo "<p>Here is a list of all of my PRs (Personal Records) for each distance. </p>";
			echo "<div style=' height:400px; overflow:auto; display:block;'>  ";
			echo "<table id='races' class='scroll sortable' id='Prs' style='border: 4px solid orange; overflow:auto;'><tr class='header' >";
			echo "<th style='width:120px'>Picture</th>"; 
			echo "<th style='width:100px'>Distance </th>";
			echo "<th style='width:150px'>Time </th>";
			echo "<th style='width:100px'>Run </th>";
			echo "<th style='width:150px'>Pace </th>"; 
			echo "<th style='width:150px'>Date <br></th>";
			echo "<th style='width:250px'>Race Name </th>";
			echo "<th style='width:100px'>Place </th>";	
			echo "<th style='width:150px'>MPH (mi/hr) </th>";
			echo "<th style='width:250px'>Points (0-1400)</th>";
			echo "<th style='width:250px'>Feel (0-10)</th>";
			echo "<th style='width:150px'>Type of Race</th>"; 
			echo "<th style='width:100px'>Location </th>";
			echo "<th style='width:100px'>Link to Results</th>";
			echo "</tr>";
			

	//1.  MEANING ALL RACES (need forloop of distances)
	if($Distance=='All' or $Year=='All' or $Distance=!'' or $Year=!'')
	{
		//var_dump($AllDistances);
		foreach($AllDistances as $AllDistances)
		{
			$DistancePR = $AllDistances['Distance']; //Making distance one of 10 preset values: .5  1 2  3.1  6  6.2 10  13.1  26.2
			
			//distance not found in this year specified.
			$queryraceX = "select * from ". $myusername." where (Distance=$DistancePR)"; // order by index?  Distance
			//$Year=substr($Year, 0, 4);
			$distanceCheck = queryRaces($queryraceX, $DistancePR, ""); //$Year
			
			$countDistance=0;
			foreach($distanceCheck as $distanceCheck)
			{
				$countDistance++;
			}
			//var_dump($distanceCheck);
			//echo "MY COUNT: $countDistance";
			
			
			$queryrace = "select * FROM $myusername where (Time=(select MIN(Time) from $myusername where Distance=$DistancePR) ) AND Distance=$DistancePR LIMIT 1"; // order by index? 
			$PRrace = queryRaces($queryrace, $DistancePR, $Year);
			
			foreach ($PRrace as $PRrace)
			{
						//PICTURE:	
				
						//if picture exists, use picture
						if($PRrace['Picture']!=Null)
						{
							$picture= "../image/racePics/".$myusername. "/".$PRrace['Picture'];
						} 
						//else use default
						else
						{
							$picture="../image/racePics/default.jpg";
						}
						echo "<tr>";					
						echo "<td > <img height='70px' src='$picture' alt='$picture' ></td>";
						echo "<td style='width:100px'>" .  $AllDistances['distName']  . "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Time']  	. "</td>";
						echo "<td style='width:100px'>" .  $countDistance   	. " times</td>";
						echo "<td style='width:150px'>" .  $PRrace['Pace']      . "</td>";
						echo "<td style=width:150px>"   .  $PRrace['Date']      . "</td>";
						echo "<td style='width:250px'>" .  $PRrace['Race'] 		. "</td>";
						echo "<td style='width:100px'>" .  $PRrace['Place']     . "</td>";	
					    echo "<td style='width:150px'>"  . round(PaceToMPH($PRrace['Pace'], $printArray),1) . "</td>";
						echo "<td style='width:250px'>"  . $PRrace['Points']             . "</td>";
						echo "<td style='width:250px'>"  .  $PRrace['Feel']               . "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Type']      . "</td>";
						echo "<td style='width:100px'>" .  $PRrace['Location']  . "</td>";
						echo "<td style='width:100px'>" .  $PRrace['LinkToResults']  . "</td>";						
						echo "</tr>";
						
						array_push($myPRs, $PRrace['Time']);
			}
		}		

	}
	
	//2.  MEANING NOTHING SELECTED, Limit Results to 10
	else if($Distance==NULL && ($Year==NULL or $Year=="%") )
	{
		
		//var_dump($AllDistances);
		foreach($AllDistances as $AllDistances)
		{
			$DistancePR = $AllDistances['Distance']; //Making distance one of 10 preset values: .5  1 2  3.1  6  6.2 10  13.1  26.2
			
			//distance not found in this year specified.
			$queryraceX = "select * from $myusername where (Distance=$DistancePR)"; // order by index?  Distance
			//$Year=substr($Year, 0, 4);
			$distanceCheck = queryRaces($queryraceX, $DistancePR, "");//$Year
			
			$countDistance=0;
			foreach($distanceCheck as $distanceCheck)
			{
				$countDistance++;
			}
			//var_dump($distanceCheck);
			//echo "MY COUNT: $countDistance";
			
			
			$queryrace = "select * FROM $myusername where ((Time=(select MIN(Time) from $myusername where Distance=$DistancePR LIMIT 10)) AND Distance=$DistancePR) LIMIT 1"; // order by index? 
			$PRrace = queryRaces($queryrace, $DistancePR, ""); //$Year
			
			foreach ($PRrace as $PRrace)
			{
						//PICTURE:	
				
						//if picture exists, use picture
						if($PRrace['Picture']!=Null)
						{
							$picture= "../image/racePics/".$myusername. "/".$PRrace['Picture'];
						} 
						//else use default
						else
						{
							$picture="../image/racePics/default.jpg";
						}
						echo "<tr>";					
						echo "<td > <img height='70px' src='$picture' alt='$picture' ></td>";
						echo "<td style='width:100px'>" .  $AllDistances['distName']  . "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Time']  	. "</td>";
						echo "<td style='width:100px'>" .  $countDistance   	. " times</td>";
						echo "<td style='width:150px'>" .  $PRrace['Pace']      . "</td>";
						echo "<td style=width:150px>"   .  $PRrace['Date']      . "</td>";
						echo "<td style='width:250px'>" .  $PRrace['Race'] 		. "</td>";
						echo "<td style='width:100px'>" .  $PRrace['Place']     . "</td>";	
						echo "<td style='width:150px'>"  . round(PaceToMPH($PRrace['Pace'], $printArray),1) . "</td>";
						echo "<td style='width:250px'>"  . $PRrace['Points']              . "</td>";
						echo "<td style='width:250px'>" .   $PRrace['Feel']                . "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Type']      . "</td>";
						echo "<td style='width:100px'>" .  $PRrace['Location']  . "</td>";		
						echo "<td style='width:100px'>" .  $PRrace['LinkToResults']  . "</td>";	
						echo "</tr>";
						
						array_push($myPRs, $PRrace['Time']);
			}
		}		

	}
	
	//3.  YEAR WAS SELECTED (need forloop of distances)
	else if($Distance==NULL)
	{
		
		foreach($AllDistances as $AllDistances)
		{
			$DistancePR = $AllDistances['Distance'];
			
			//distance not found in this year specified.
			$queryraceX = "select * from $myusername where (Distance=$DistancePR) AND (Date LIKE '". $Year . "%')"; // order by index? 
			//$Year=substr($Year, 0, 4);
			$distanceCheck = queryRaces($queryraceX, $DistancePR, ""); //$Year
			
			$countDistance=0;
			foreach($distanceCheck as $distanceCheck)
			{
				$countDistance++;
			}
			//var_dump($distanceCheck);
			//echo "MY COUNT: $countDistance";
			// NEED TO JUST GET A NUMBER!!!
			
			if($countDistance==0) // IF COUNT == 0 THEN SKIP
			{
				//SKIPPINT PRS for this distance given the year.
				//echo "SKIPPING";
			}
			
			else
			{
				$queryrace = "select * FROM $myusername where ((Time=(select MIN(Time) from $myusername where ((Distance=$DistancePR) AND (Date LIKE '". $Year . "%')))) AND Distance=$DistancePR AND (Date LIKE '". $Year . "%')) LIMIT 1"; // order by index? 
				//$Year=substr($Year, 0, 4); Distance
				$PRrace = queryRaces($queryrace, $DistancePR, ""); //$Year
				
				foreach ($PRrace as $PRrace)
				{
							//PICTURE:	
				
							//if picture exists, use picture
							if($PRrace['Picture']!=Null)
							{
								$picture= "../image/racePics/".$myusername. "/". $PRrace['Picture'];
							} 
							//else use default
							else
							{
								$picture="../image/racePics/default.jpg";
							}
						    echo "<tr>";					
						    echo "<td > <img height='70px' src='$picture' alt='$picture' ></td>";
						    echo "<td style='width:100px'>" .  $AllDistances['distName']  . "</td>";
						    echo "<td style='width:150px'>" .  $PRrace['Time']  	. "</td>";
							echo "<td style='width:100px'>" .  $countDistance    	. " times</td>";
						    echo "<td style='width:150px'>" .  $PRrace['Pace']      . "</td>";
						    echo "<td style=width:150px>"   .  $PRrace['Date']      . "</td>";
						    echo "<td style='width:250px'>" .  $PRrace['Race'] 		. "</td>";
						    echo "<td style='width:100px'>" .  $PRrace['Place']     . "</td>";	
							echo "<td style='width:150px'>"  . round(PaceToMPH($PRrace['Pace'], $printArray),1) . "</td>";
							echo "<td style='width:250px'>"  . $PRrace['Points']              . "</td>";
							echo "<td style='width:250px'>"  .  $PRrace['Feel']                . "</td>";
						    echo "<td style='width:150px'>" .  $PRrace['Type']      . "</td>";
						    echo "<td style='width:100px'>" .  $PRrace['Location']  . "</td>";	
							echo "<td style='width:100px'>" .  $PRrace['LinkToResults']  . "</td>";								
						    echo "</tr>";
							
							array_push($myPRs, $PRrace['Time']);
				}
			}
		}		

	}
	
	//4.  Distance was SELECTED ****************************************************************************** 
	else if ($Year==NULL or $Year=="%")
	{
		//distance not found in this year specified.
		$queryraceX = "select * from $myusername where (Distance=$Distance)"; // order by index? 
		//$Year=substr($Year, 0, 4);
		$distanceCheck = queryRaces($queryraceX, $Distance, ""); //$Year
		
		$countDistance=0;
		foreach($distanceCheck as $distanceCheck)
		{
			$countDistance++;
		}
		//var_dump($distanceCheck);
		//echo "MY COUNT: $countDistance";
		
		
		$queryrace = "select * FROM $myusername where ((Time=(select MIN(Time) from $myusername where Distance=$Distance)) AND Distance=$Distance) LIMIT 1";  
		$PRrace = queryRaces($queryrace, $Distance, $Year."%");
		
		// NOW GOING THROUGH EACH RACE AND STRIPPING DATA
		foreach ($PRrace as $PRrace)
		{
					//PICTURE:	
				
					//if picture exists, use picture
					if($PRrace['Picture']!=Null)
					{
						$picture= "../image/racePics/".$myusername. "/". $PRrace['Picture'];
					} 
					//else use default
					else
					{
						$picture="../image/racePics/default.jpg";
					}
					echo "<tr>";					
					echo "<td > <img height='70px' src='$picture' alt='$picture' ></td>";
					echo "<td style='width:100px'>" .  $PRrace['Distance']      . "</td>";
					echo "<td style='width:150px'>" .  $PRrace['Time']  	. "</td>";
					echo "<td style='width:100px'>" .  $countDistance   	. " times</td>";
					echo "<td style='width:150px'>" .  $PRrace['Pace']      . "</td>";
					echo "<td style=width:150px>"   .  $PRrace['Date']      . "</td>";
					echo "<td style='width:250px'>" .  $PRrace['Race'] 		. "</td>";
					echo "<td style='width:100px'>" .  $PRrace['Place']     . "</td>";
					echo "<td style='width:150px'>"  . round(PaceToMPH($PRrace['Pace'], $printArray),1) . "</td>";
					echo "<td style='width:250px'>"  . $PRrace['Points']              . "</td>";
					echo "<td style='width:250px'>" .   $PRrace['Feel']                . "</td>";
					echo "<td style='width:150px'>" .  $PRrace['Type']      . "</td>";
					echo "<td style='width:100px'>" .  $PRrace['Location']  . "</td>";
					echo "<td style='width:100px'>" .  $PRrace['LinkToResults']  . "</td>";						
					echo "</tr>";
					
					array_push($myPRs, $PRrace['Time']);
		} 

	}
	else
	{
			
	}
    echo "</table></div>";
   
?>

</div>		
<hr  >
<br><br><br>










<div id="GOALs">		
<!--RACE GOALs---------------------------------------------------------------------------------------->	
<?php
			$title = "Race Goals: ";
			// TABLE HEADERS
			echo "<br> <h2> $title </h2> <br>";
			echo "<p>Below are my race goals based on fastest times that I have run. As you can see, first row is my fastest mark at a specific distance, the second row has my goal time and third row shows what I need to do to get there (how much time I need to nock-off.)</p>";
			/*echo "<th style='width:100px'> </th>";
			echo "<th style='width:100px'>Distance </th>";
			echo "<th style='width:150px'>Time </th>";
			echo "<th style='width:150px'>Pace </th>"; 
			echo "<th style='width:150px'>Date <br></th>";
			echo "<th style='width:250px'>Race Name </th>";
			echo "<th style='width:150px'>MPH (mi/hr) </th>";
			echo "<th style='width:150px'>Points (0-1400)</th>";
			echo "</tr>";*/
			

	//1.  MEANING ALL RACES (need forloop of distances)
	if($Distance=='All' or $Year=='All' )
	{
		//var_dump($PRDistances);
		foreach($PRDistances as $PRDistances)
		{
			$DistancePR = $PRDistances['Distance']; //Making distance one of 10 preset values: .5  1 2  3.1  6  6.2 10  13.1  26.2
			
			//distance not found in this year specified.
			$queryraceX = "select * from $myusername where (Distance=$DistancePR)"; // order by index?  Distance
			//$Year=substr($Year, 0, 4);
			$distanceCheck = queryRaces($queryraceX, $DistancePR, $Year);
			
			$countDistance=0;
			foreach($distanceCheck as $distanceCheck)
			{
				$countDistance++;
			}
			//var_dump($distanceCheck);
			//echo "MY COUNT: $countDistance";
			
			
			$queryrace = "select * FROM $myusername where (Time=(select MIN(Time) from $myusername where Distance=$DistancePR) ) AND Distance=$DistancePR LIMIT 1"; // order by index? 
			$PRrace = queryRaces($queryrace, $DistancePR, $Year);
			
			foreach ($PRrace as $PRrace)
			{
				/*
				$Time=$PRrace['Time'];
				$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
				$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
				$Timem= substr($Time, (strlen($Time)-2)); 
				$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
				$Timeh= $Time; */
				//echo "$Timeh:$Timem:$Times<br>";
				echo "<br>";
				
				//PRE SETTING TIME FOR DROPDOWN
				$Hours   = array();
				$Minutes = array();
				$Seconds = array();
				$selected ="selected";
				
				for($i=0; $i<60; $i++)
				{
					array_push($Hours   , $i);
					array_push($Minutes , $i);
					array_push($Seconds , $i);
				}
				//print_r($Hours);
				//echo "".print_r($Hours)."";
				
						//Start of table and Distance
						echo "<table id='races' class='scroll sortable' id='Prs' style='border: 4px solid orange;'>"; 
						echo "<tr>";
						echo "<td colspan='8' style='font-size:24px;background-color:#696969;'>" .  $PRDistances['distName']  	."</td>";
						echo "</tr>";
						
						//Table Headers
						echo "<th style='width:100px'> </th>";
						echo "<th style='width:100px'>Distance </th>";
						echo "<th style='width:150px'>Time </th>";
						echo "<th style='width:150px'>Pace </th>"; 
						echo "<th style='width:150px'>Date <br></th>";
						echo "<th style='width:250px'>Race Name </th>";
						echo "<th style='width:150px'>MPH (mi/hr) </th>";
						echo "<th style='width:150px'>Points (0-1400)</th>";
						echo "</tr>";
						
						//MY PRS
						echo "<tr>";
                        echo "<th>Current PR:</th>";					
						echo "<td style='width:100px'>" .  $PRDistances['distName']  						. "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Time']  		  						. "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Pace']      	  						. "</td>";
						echo "<td style='width:150px'>" .  $PRrace['Date']      	  						. "</td>";
						echo "<td style='width:250px'>" .  $PRrace['Race'] 			  						. "</td>";
						echo "<td style='width:150px'>" . round(PaceToMPH($PRrace['Pace'], $printArray),1)  . "</td>";
						echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>";
						echo "</tr>";
						
						//NEED TO UPDATE
						$GoalPace="00:00:01";
						
						//MY GOALS ROW:
						echo "<tr>";
						echo "<th>Goal Time/Pace:</th>";
					  //echo "<td style='width:100px' id='". $PRrace['Distance'] ."' name='Distance'  onchange=RecalculateElapsedTime ('". $PRrace['Distance'] ."') class='selectboxkl'>" .  $PRrace['Distance']  . "</td>";
						?>
						<!-- DISTANCE -->
						<td><input style='width:100px' id="<?php echo $PRrace['Distance']; ?>" name='Distance'  onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?> ','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class='selectboxkl' value='<?php echo $PRrace['Distance']; ?>'></td>
						
						
						
						<td><pre><b>H : M : S</b></pre>
						
						<?php
						//Now instead of sending it PR's, need to send it GOAL PR!
						$GOALtime="0";
						
						if($PRrace['Distance'] == "0.25")
						{
							$GOALtime="00:00:48";
						}
						if($PRrace['Distance'] == "0.50")
						{
							$GOALtime="00:01:52";
						}
						if($PRrace['Distance'] == "0.93")
						{
							$GOALtime="00:03:57";
						}
						if($PRrace['Distance'] == "1.00")
						{
							$GOALtime="00:04:18";
						}
						if($PRrace['Distance'] == "1.86")
						{
							$GOALtime="00:08:59";
						}
						if($PRrace['Distance'] == "2.00")
						{
							$GOALtime="00:09:40";
						}
						if($PRrace['Distance'] == "3.10")
						{
							$GOALtime="00:15:48";
						}
						if($PRrace['Distance'] == "6.00")
						{
							$GOALtime="00:32:05";
						}
						if($PRrace['Distance'] == "6.20")
						{
							$GOALtime="00:32:59";
						}
						if($PRrace['Distance'] == "10.00")
						{
							$GOALtime="00:53:48";
						}
						if($PRrace['Distance'] == "13.10")
						{
							$GOALtime="01:09:55";
						}
						if($PRrace['Distance'] == "26.20")
						{
							$GOALtime="02:29:48";
						}
						//PARSE H M S from desired time above time given
						$Time=$GOALtime;//$PRrace['Time'];
						$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
						$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
						$Timem= substr($Time, (strlen($Time)-2)); 
						$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
						$Timeh= $Time; 
						
						$GOALpace=mypaceNEW($GOALtime, $PRrace['Distance']);
						
						?>
						                                                                          
						<select id="starttimehour<?php echo $PRrace['Distance']; ?>" name="Hours" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class="selectboxkl">
							<?php foreach ($Hours as $Hours) : ?>
								<option value='<?php echo $Hours; ?>'<?=$Hours == $Timeh ? ' selected=selected' : '';?>><?php echo "$Hours"; ?></option> 
							<?php endforeach; ?>
						</select>
						:
						<select id="starttimemin<?php echo $PRrace['Distance']; ?>" name="Minutes" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
							<?php foreach ($Minutes as $Minutes) : ?>
								<option value="<?php echo $Minutes; ?>"<?=$Minutes== "$Timem" ? ' selected=\"selected\"' : '';?>><?php echo "$Minutes"; ?></option> <!--WORKS!!!! :) -->
							<?php endforeach; ?>
						</select>
						:
						<select id="starttimesec<?php echo $PRrace['Distance']; ?>" name="Seconds" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
							<?php foreach ($Seconds as $Seconds) : ?>
								<option value='<?php echo $Seconds; ?>'<?=$Seconds == "$Times" ? " selected=selected" : '';?>><?php echo "$Seconds"; ?></option> <!--WORKS!!!! :) -->
							<?php endforeach; ?>
						</select></td>
						
						<?php
						
					    //<select id='starttimehour". $PRrace['Distace'] ."' name='Hours'  onchange='RecalculateElapsedTime ("."test".")' class='selectboxkl'>";
						/*
						foreach ( $Hours as $Hours) : 
							echo "<option value='". $Hours."'"; 
							echo $Hours == $Timeh ? ' selected=selected': '';
							echo ">". $Hours;
							echo "</option>";
						endforeach;
						echo"</select>:";
						
                        //minutes:
						echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Minutes'  class='selectboxkl'>";
						foreach ( $Minutes as $Minutes) : 
							echo "<option value='".$Minutes."'"; 
							echo $Minutes == $Timem ? ' selected=selected': '';
							echo ">". $Minutes;
							echo "</option>";
						endforeach;
						echo"</select>:";
						
						//Seconds:
						echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Seconds'  class='selectboxkl'>";
						foreach ( $Seconds as $Seconds) : 
							echo "<option value='".$Seconds."'"; 
							echo $Seconds == $Times ? ' selected=selected': '';
							echo ">". $Seconds;
							echo "</option>";
						endforeach;
						echo"</select></td>";
				        */
				       
						//REST OF GOAL ROW
						//Pace
						echo "<td style='width:150px'>" .  "<input name='Pace' id='elapsed".  $PRrace['Distance'] ."' readonly value='".  $GOALpace ."'></td>"; //NEED TO CHANGE!!!
						//REST of results
						echo "<td style='width:150px'>" .  "SOON!"     	  									. "</td>";
						echo "<td style='width:250px'>" .  "???"        			  						. "</td>";
						echo "<td style='width:150px'>" . round(PaceToMPH($GoalPace, $printArray),1)        . "</td>"; // CONVERT? need Javascript function! (not PHP)
						echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>"; // CONVERT/ calculate?
						echo "</tr>";
											
						
						//Difference ROW ****************************************************************************** 
						//$TimeDifference="00:00:00";
						$PaceDifference="00:00:01";
						$PointDifference="0";
						
						echo "<tr>";
						echo "<th>Difference:</th>";
						echo "<td style='width:100px'>" .  $PRrace['Distance']  						    . "</td>";
						
						
						//problem: javascript only does calculations if an event is changed, if not i need to make an initial value... precalculate it??? 
                        //solution: make php difference function and pace function for this?
						
						//PHP FUNCTION TO GET TIME DIFF AND PACE DIFF
						//Time:
						$TimeDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Time']) - TimeToSecondsNEW($GOALtime));
						//Pace
						$PaceDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Pace']) - TimeToSecondsNEW($GOALpace));
						?>
						
						<td style='width:150px'><h4>Need to run this much faster: <h4><input name='Time' id='<?php echo 'time'.$PRrace['Distance']; ?>' readonly value="<?php echo $TimeDiffSTART; ?>" ></td> <!--<?php echo $GOALtime; ?>-->
						<td style='width:150px'><h4>Need to run this much faster per mile:</h4><input name='Pace' id='<?php echo 'pace'.$PRrace['Distance']; ?>' readonly value="<?php echo $PaceDiffSTART; ?>" ></td>
						
						<?php
						echo "<td style='width:150px'>" .  "   "     	  									. "</td>";
						echo "<td style='width:250px'>" .  "   "        			  						. "</td>";
						echo "<td style='width:150px'>" . round(PaceToMPH($PaceDifference, $printArray),1)  . "</td>";
						echo "<td style='width:150px'>" . $PointDifference                                  . "</td>";
						echo "</tr>";
						
						//BLANK ROW
						echo "<tr>";
						echo "<td colspan='8' style='font-size:24px;background-color:#696969;'></td>";
						echo "</tr>";
						
						//END TABLE
						echo "</table>"; 
						
			}
		}		

	}
	
	//2.  MEANING NOTHING SELECTED, Limit Results to 10
	else if($Distance==NULL && ($Year==NULL or $Year=="%") )
	{
		foreach($PRDistances as $PRDistances)
		{
			$DistancePR = $PRDistances['Distance']; //Making distance one of 10 preset values: .5  1 2  3.1  6  6.2 10  13.1  26.2
			
			//distance not found in this year specified.
			$queryraceX = "select * from $myusername where (Distance=$DistancePR)"; // order by index?  Distance
			//$Year=substr($Year, 0, 4);
			$distanceCheck = queryRaces($queryraceX, $DistancePR, $Year);
			
			$countDistance=0;
			foreach($distanceCheck as $distanceCheck)
			{
				$countDistance++;
			}
			//var_dump($distanceCheck);
			//echo "MY COUNT: $countDistance";
			
			
			$queryrace = "select * FROM $myusername where (Time=(select MIN(Time) from $myusername where Distance=$DistancePR) ) AND Distance=$DistancePR LIMIT 1"; // order by index? 
			$PRrace = queryRaces($queryrace, $DistancePR, $Year);
		
			foreach ($PRrace as $PRrace)
			{
					/*
					$Time=$PRrace['Time'];
					$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
					$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
					$Timem= substr($Time, (strlen($Time)-2)); 
					$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
					$Timeh= $Time; */
					//echo "$Timeh:$Timem:$Times<br>";
					echo "<br>";
					
					//PRE SETTING TIME FOR DROPDOWN
					$Hours   = array();
					$Minutes = array();
					$Seconds = array();
					$selected ="selected";
					
					for($i=0; $i<60; $i++)
					{
						array_push($Hours   , $i);
						array_push($Minutes , $i);
						array_push($Seconds , $i);
					}
					//print_r($Hours);
					//echo "".print_r($Hours)."";
					
							//Start of table and Distance
							echo "<table id='races' class='scroll sortable' id='Prs' style='border: 4px solid orange;'>"; 
							echo "<tr>";
							echo "<td colspan='8' style='font-size:24px;background-color:#696969;'>" .  $PRDistances['distName']  	."</td>";
							echo "</tr>";
							
							//Table Headers
							echo "<th style='width:100px'> </th>";
							echo "<th style='width:100px'>Distance </th>";
							echo "<th style='width:150px'>Time </th>";
							echo "<th style='width:150px'>Pace </th>"; 
							echo "<th style='width:150px'>Date <br></th>";
							echo "<th style='width:250px'>Race Name </th>";
							echo "<th style='width:150px'>MPH (mi/hr) </th>";
							echo "<th style='width:150px'>Points (0-1400)</th>";
							echo "</tr>";
							
							//MY PRS
							echo "<tr>";
							echo "<th>Current PR:</th>";					
							echo "<td style='width:100px'>" .  $PRDistances['distName']  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Time']  		  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Pace']      	  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Date']      	  						. "</td>";
							echo "<td style='width:250px'>" .  $PRrace['Race'] 			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($PRrace['Pace'], $printArray),1)  . "</td>";
							echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>";
							echo "</tr>";
							
							//NEED TO UPDATE
							$GoalPace="00:00:01";
							
							//MY GOALS ROW:
							echo "<tr>";
							echo "<th>Goal Time/Pace:</th>";
						  //echo "<td style='width:100px' id='". $PRrace['Distance'] ."' name='Distance'  onchange=RecalculateElapsedTime ('". $PRrace['Distance'] ."') class='selectboxkl'>" .  $PRrace['Distance']  . "</td>";
							?>
							<!-- DISTANCE -->
							<td><input style='width:100px' id="<?php echo $PRrace['Distance']; ?>" name='Distance'  onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?> ','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class='selectboxkl' value='<?php echo $PRrace['Distance']; ?>'></td>
							
							
							
							<td><pre><b>H : M : S</b></pre>
							
							<?php
							//Now instead of sending it PR's, need to send it GOAL PR!
							$GOALtime="0";
							
							if($PRrace['Distance'] == "0.25")
							{
								$GOALtime="00:00:48";
							}
							if($PRrace['Distance'] == "0.50")
							{
								$GOALtime="00:01:52";
							}
							if($PRrace['Distance'] == "0.93")
							{
								$GOALtime="00:03:57";
							}
							if($PRrace['Distance'] == "1.00")
							{
								$GOALtime="00:04:18";
							}
							if($PRrace['Distance'] == "1.86")
							{
								$GOALtime="00:08:59";
							}
							if($PRrace['Distance'] == "2.00")
							{
								$GOALtime="00:09:40";
							}
							if($PRrace['Distance'] == "3.10")
							{
								$GOALtime="00:15:48";
							}
							if($PRrace['Distance'] == "6.00")
							{
								$GOALtime="00:32:05";
							}
							if($PRrace['Distance'] == "6.20")
							{
								$GOALtime="00:32:59";
							}
							if($PRrace['Distance'] == "10.00")
							{
								$GOALtime="00:53:48";
							}
							if($PRrace['Distance'] == "13.10")
							{
								$GOALtime="01:09:55";
							}
							if($PRrace['Distance'] == "26.20")
							{
								$GOALtime="02:29:48";
							}
							//PARSE H M S from desired time above time given
							$Time=$GOALtime;//$PRrace['Time'];
							$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
							$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
							$Timem= substr($Time, (strlen($Time)-2)); 
							$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
							$Timeh= $Time; 
							
							$GOALpace=mypaceNEW($GOALtime, $PRrace['Distance']);
							
							?>
																									  
							<select id="starttimehour<?php echo $PRrace['Distance']; ?>" name="Hours" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class="selectboxkl">
								<?php foreach ($Hours as $Hours) : ?>
									<option value='<?php echo $Hours; ?>'<?=$Hours == $Timeh ? ' selected=selected' : '';?>><?php echo "$Hours"; ?></option> 
								<?php endforeach; ?>
							</select>
							:
							<select id="starttimemin<?php echo $PRrace['Distance']; ?>" name="Minutes" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
								<?php foreach ($Minutes as $Minutes) : ?>
									<option value="<?php echo $Minutes; ?>"<?=$Minutes== "$Timem" ? ' selected=\"selected\"' : '';?>><?php echo "$Minutes"; ?></option> <!--WORKS!!!! :) -->
								<?php endforeach; ?>
							</select>
							:
							<select id="starttimesec<?php echo $PRrace['Distance']; ?>" name="Seconds" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
								<?php foreach ($Seconds as $Seconds) : ?>
									<option value='<?php echo $Seconds; ?>'<?=$Seconds == "$Times" ? " selected=selected" : '';?>><?php echo "$Seconds"; ?></option> <!--WORKS!!!! :) -->
								<?php endforeach; ?>
							</select></td>
							
							<?php
							
							//<select id='starttimehour". $PRrace['Distace'] ."' name='Hours'  onchange='RecalculateElapsedTime ("."test".")' class='selectboxkl'>";
							/*
							foreach ( $Hours as $Hours) : 
								echo "<option value='". $Hours."'"; 
								echo $Hours == $Timeh ? ' selected=selected': '';
								echo ">". $Hours;
								echo "</option>";
							endforeach;
							echo"</select>:";
							
							//minutes:
							echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Minutes'  class='selectboxkl'>";
							foreach ( $Minutes as $Minutes) : 
								echo "<option value='".$Minutes."'"; 
								echo $Minutes == $Timem ? ' selected=selected': '';
								echo ">". $Minutes;
								echo "</option>";
							endforeach;
							echo"</select>:";
							
							//Seconds:
							echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Seconds'  class='selectboxkl'>";
							foreach ( $Seconds as $Seconds) : 
								echo "<option value='".$Seconds."'"; 
								echo $Seconds == $Times ? ' selected=selected': '';
								echo ">". $Seconds;
								echo "</option>";
							endforeach;
							echo"</select></td>";
							*/
						   
							//REST OF GOAL ROW
							//Pace
							echo "<td style='width:150px'>" .  "<input name='Pace' id='elapsed".  $PRrace['Distance'] ."' readonly value='".  $GOALpace ."'></td>"; //NEED TO CHANGE!!!
							//REST of results
							echo "<td style='width:150px'>" .  "SOON!"     	  									. "</td>";
							echo "<td style='width:250px'>" .  "???"        			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($GoalPace, $printArray),1)        . "</td>"; // CONVERT? need Javascript function! (not PHP)
							echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>"; // CONVERT/ calculate?
							echo "</tr>";
												
							
							//Difference ROW ****************************************************************************** 
							//$TimeDifference="00:00:00";
							$PaceDifference="00:00:01";
							$PointDifference="0";
							
							echo "<tr>";
							echo "<th>Difference:</th>";
							echo "<td style='width:100px'>" .  $PRrace['Distance']  						    . "</td>";
							
							
							//problem: javascript only does calculations if an event is changed, if not i need to make an initial value... precalculate it??? 
							//solution: make php difference function and pace function for this?
							
							//PHP FUNCTION TO GET TIME DIFF AND PACE DIFF
							//Time:
							$TimeDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Time']) - TimeToSecondsNEW($GOALtime));
							//Pace
							$PaceDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Pace']) - TimeToSecondsNEW($GOALpace));
							?>
							
							<td style='width:150px'><h4>Need to run this much faster: <h4><input name='Time' id='<?php echo 'time'.$PRrace['Distance']; ?>' readonly value="<?php echo $TimeDiffSTART; ?>" ></td> <!--<?php echo $GOALtime; ?>-->
							<td style='width:150px'><h4>Need to run this much faster per mile:</h4><input name='Pace' id='<?php echo 'pace'.$PRrace['Distance']; ?>' readonly value="<?php echo $PaceDiffSTART; ?>" ></td>
							
							<?php
							echo "<td style='width:150px'>" .  "   "     	  									. "</td>";
							echo "<td style='width:250px'>" .  "   "        			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($PaceDifference, $printArray),1)  . "</td>";
							echo "<td style='width:150px'>" . $PointDifference                                  . "</td>";
							echo "</tr>";
							
							//BLANK ROW
							echo "<tr>";
							echo "<td colspan='8' style='font-size:24px;background-color:#696969;'></td>";
							echo "</tr>";
							
							//END TABLE
							echo "</table>"; 
						
			}
		}
	
	}
	
	
	//3.  YEAR WAS SELECTED (need forloop of distances)
	else if($Distance==NULL)
	{
		
		foreach($PRDistances as $PRDistances)
		{
			$DistancePR = $PRDistances['Distance'];
			
			//distance not found in this year specified.
			$queryraceX = "select * from $myusername where (Distance=$DistancePR) AND (Date LIKE '". $Year . "%')"; // order by index? 
			//$Year=substr($Year, 0, 4);
			$distanceCheck = queryRaces($queryraceX, $DistancePR, $Year);
			
			$countDistance=0;
			foreach($distanceCheck as $distanceCheck)
			{
				$countDistance++;
			}
			//var_dump($distanceCheck);
			//echo "MY COUNT: $countDistance";
			// NEED TO JUST GET A NUMBER!!!
			
			if($countDistance==0) // IF COUNT == 0 THEN SKIP
			{
				//SKIPPINT PRS for this distance given the year.
				//echo "SKIPPING";
			}
			
			else
			{
				$queryrace = "select * FROM $myusername where ((Time=(select MIN(Time) from $myusername where ((Distance=$DistancePR) AND (Date LIKE '". $Year . "%')))) AND Distance=$DistancePR AND (Date LIKE '". $Year . "%')) LIMIT 1"; // order by index? 
				//$Year=substr($Year, 0, 4); Distance
				$PRrace = queryRaces($queryrace, $DistancePR, $Year);
				
				foreach ($PRrace as $PRrace)
				{
				
					/*
					$Time=$PRrace['Time'];
					$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
					$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
					$Timem= substr($Time, (strlen($Time)-2)); 
					$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
					$Timeh= $Time; */
					//echo "$Timeh:$Timem:$Times<br>";
					echo "<br>";
					
					//PRE SETTING TIME FOR DROPDOWN
					$Hours   = array();
					$Minutes = array();
					$Seconds = array();
					$selected ="selected";
					
					for($i=0; $i<60; $i++)
					{
						array_push($Hours   , $i);
						array_push($Minutes , $i);
						array_push($Seconds , $i);
					}
					//print_r($Hours);
					//echo "".print_r($Hours)."";
					
							//Start of table and Distance
							echo "<table id='races' class='scroll sortable' id='Prs' style='border: 4px solid orange;'>"; 
							echo "<tr>";
							echo "<td colspan='8' style='font-size:24px;background-color:#696969;'>" .  $PRDistances['distName']  	."</td>";
							echo "</tr>";
							
							//Table Headers
							echo "<th style='width:100px'> </th>";
							echo "<th style='width:100px'>Distance </th>";
							echo "<th style='width:150px'>Time </th>";
							echo "<th style='width:150px'>Pace </th>"; 
							echo "<th style='width:150px'>Date <br></th>";
							echo "<th style='width:250px'>Race Name </th>";
							echo "<th style='width:150px'>MPH (mi/hr) </th>";
							echo "<th style='width:150px'>Points (0-1400)</th>";
							echo "</tr>";
							
							//MY PRS
							echo "<tr>";
							echo "<th>Current PR:</th>";					
							echo "<td style='width:100px'>" .  $PRDistances['distName']  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Time']  		  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Pace']      	  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Date']      	  						. "</td>";
							echo "<td style='width:250px'>" .  $PRrace['Race'] 			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($PRrace['Pace'], $printArray),1)  . "</td>";
							echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>";
							echo "</tr>";
							
							//NEED TO UPDATE
							$GoalPace="00:00:01";
							
							//MY GOALS ROW:
							echo "<tr>";
							echo "<th>Goal Time/Pace:</th>";
						  //echo "<td style='width:100px' id='". $PRrace['Distance'] ."' name='Distance'  onchange=RecalculateElapsedTime ('". $PRrace['Distance'] ."') class='selectboxkl'>" .  $PRrace['Distance']  . "</td>";
							?>
							<!-- DISTANCE -->
							<td><input style='width:100px' id="<?php echo $PRrace['Distance']; ?>" name='Distance'  onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?> ','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class='selectboxkl' value='<?php echo $PRrace['Distance']; ?>'></td>
							
							
							
							<td><pre><b>H : M : S</b></pre>
							
							<?php
							//Now instead of sending it PR's, need to send it GOAL PR!
							$GOALtime="0";
							
							if($PRrace['Distance'] == "0.25")
							{
								$GOALtime="00:00:48";
							}
							if($PRrace['Distance'] == "0.50")
							{
								$GOALtime="00:01:52";
							}
							if($PRrace['Distance'] == "0.93")
							{
								$GOALtime="00:03:57";
							}
							if($PRrace['Distance'] == "1.00")
							{
								$GOALtime="00:04:18";
							}
							if($PRrace['Distance'] == "1.86")
							{
								$GOALtime="00:08:59";
							}
							if($PRrace['Distance'] == "2.00")
							{
								$GOALtime="00:09:40";
							}
							if($PRrace['Distance'] == "3.10")
							{
								$GOALtime="00:15:48";
							}
							if($PRrace['Distance'] == "6.00")
							{
								$GOALtime="00:32:05";
							}
							if($PRrace['Distance'] == "6.20")
							{
								$GOALtime="00:32:59";
							}
							if($PRrace['Distance'] == "10.00")
							{
								$GOALtime="00:53:48";
							}
							if($PRrace['Distance'] == "13.10")
							{
								$GOALtime="01:09:55";
							}
							if($PRrace['Distance'] == "26.20")
							{
								$GOALtime="02:29:48";
							}
							//PARSE H M S from desired time above time given
							$Time=$GOALtime;//$PRrace['Time'];
							$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
							$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
							$Timem= substr($Time, (strlen($Time)-2)); 
							$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
							$Timeh= $Time; 
							
							$GOALpace=mypaceNEW($GOALtime, $PRrace['Distance']);
							
							?>
																									  
							<select id="starttimehour<?php echo $PRrace['Distance']; ?>" name="Hours" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class="selectboxkl">
								<?php foreach ($Hours as $Hours) : ?>
									<option value='<?php echo $Hours; ?>'<?=$Hours == $Timeh ? ' selected=selected' : '';?>><?php echo "$Hours"; ?></option> 
								<?php endforeach; ?>
							</select>
							:
							<select id="starttimemin<?php echo $PRrace['Distance']; ?>" name="Minutes" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
								<?php foreach ($Minutes as $Minutes) : ?>
									<option value="<?php echo $Minutes; ?>"<?=$Minutes== "$Timem" ? ' selected=\"selected\"' : '';?>><?php echo "$Minutes"; ?></option> <!--WORKS!!!! :) -->
								<?php endforeach; ?>
							</select>
							:
							<select id="starttimesec<?php echo $PRrace['Distance']; ?>" name="Seconds" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
								<?php foreach ($Seconds as $Seconds) : ?>
									<option value='<?php echo $Seconds; ?>'<?=$Seconds == "$Times" ? " selected=selected" : '';?>><?php echo "$Seconds"; ?></option> <!--WORKS!!!! :) -->
								<?php endforeach; ?>
							</select></td>
							
							<?php
							
							//<select id='starttimehour". $PRrace['Distace'] ."' name='Hours'  onchange='RecalculateElapsedTime ("."test".")' class='selectboxkl'>";
							/*
							foreach ( $Hours as $Hours) : 
								echo "<option value='". $Hours."'"; 
								echo $Hours == $Timeh ? ' selected=selected': '';
								echo ">". $Hours;
								echo "</option>";
							endforeach;
							echo"</select>:";
							
							//minutes:
							echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Minutes'  class='selectboxkl'>";
							foreach ( $Minutes as $Minutes) : 
								echo "<option value='".$Minutes."'"; 
								echo $Minutes == $Timem ? ' selected=selected': '';
								echo ">". $Minutes;
								echo "</option>";
							endforeach;
							echo"</select>:";
							
							//Seconds:
							echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Seconds'  class='selectboxkl'>";
							foreach ( $Seconds as $Seconds) : 
								echo "<option value='".$Seconds."'"; 
								echo $Seconds == $Times ? ' selected=selected': '';
								echo ">". $Seconds;
								echo "</option>";
							endforeach;
							echo"</select></td>";
							*/
						   
							//REST OF GOAL ROW
							//Pace
							echo "<td style='width:150px'>" .  "<input name='Pace' id='elapsed".  $PRrace['Distance'] ."' readonly value='".  $GOALpace ."'></td>"; //NEED TO CHANGE!!!
							//REST of results
							echo "<td style='width:150px'>" .  "SOON!"     	  									. "</td>";
							echo "<td style='width:250px'>" .  "???"        			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($GoalPace, $printArray),1)        . "</td>"; // CONVERT? need Javascript function! (not PHP)
							echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>"; // CONVERT/ calculate?
							echo "</tr>";
												
							
							//Difference ROW ****************************************************************************** 
							//$TimeDifference="00:00:00";
							$PaceDifference="00:00:01";
							$PointDifference="0";
							
							echo "<tr>";
							echo "<th>Difference:</th>";
							echo "<td style='width:100px'>" .  $PRrace['Distance']  						    . "</td>";
							
							
							//problem: javascript only does calculations if an event is changed, if not i need to make an initial value... precalculate it??? 
							//solution: make php difference function and pace function for this?
							
							//PHP FUNCTION TO GET TIME DIFF AND PACE DIFF
							//Time:
							$TimeDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Time']) - TimeToSecondsNEW($GOALtime));
							//Pace
							$PaceDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Pace']) - TimeToSecondsNEW($GOALpace));
							?>
							
							<td style='width:150px'><h4>Need to run this much faster: <h4><input name='Time' id='<?php echo 'time'.$PRrace['Distance']; ?>' readonly value="<?php echo $TimeDiffSTART; ?>" ></td> <!--<?php echo $GOALtime; ?>-->
							<td style='width:150px'><h4>Need to run this much faster per mile:</h4><input name='Pace' id='<?php echo 'pace'.$PRrace['Distance']; ?>' readonly value="<?php echo $PaceDiffSTART; ?>" ></td>
							
							<?php
							echo "<td style='width:150px'>" .  "   "     	  									. "</td>";
							echo "<td style='width:250px'>" .  "   "        			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($PaceDifference, $printArray),1)  . "</td>";
							echo "<td style='width:150px'>" . $PointDifference                                  . "</td>";
							echo "</tr>";
							
							//BLANK ROW
							echo "<tr>";
							echo "<td colspan='8' style='font-size:24px;background-color:#696969;'></td>";
							echo "</tr>";
							
							//END TABLE
							echo "</table>"; 


				
				}
			}		
		}
	}
	
	//4.  Distance was SELECTED ****************************************************************************** 
	else if ($Year==NULL or $Year=="%")
	{
		//distance not found in this year specified.
		$queryraceX = "select * from $myusername where (Distance=$Distance)"; // order by index? 
		//$Year=substr($Year, 0, 4);
		$distanceCheck = queryRaces($queryraceX, $Distance, $Year);
		
		$countDistance=0;
		foreach($distanceCheck as $distanceCheck)
		{
			$countDistance++;
		}
		//var_dump($distanceCheck);
		//echo "MY COUNT: $countDistance";
		
		
		$queryrace = "select * FROM $myusername where ((Time=(select MIN(Time) from $myusername where Distance=$Distance)) AND Distance=$Distance) LIMIT 1";  
		$PRrace = queryRaces($queryrace, $Distance, $Year."%");
		$Goalrace = $PRrace;
		
		// NOW GOING THROUGH EACH RACE AND STRIPPING DATA
		foreach ($PRrace as $PRrace)
		{
					/*
					$Time=$PRrace['Time'];
					$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
					$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
					$Timem= substr($Time, (strlen($Time)-2)); 
					$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
					$Timeh= $Time; */
					//echo "$Timeh:$Timem:$Times<br>";
					echo "<br>";
					
					//PRE SETTING TIME FOR DROPDOWN
					$Hours   = array();
					$Minutes = array();
					$Seconds = array();
					$selected ="selected";
					
					for($i=0; $i<60; $i++)
					{
						array_push($Hours   , $i);
						array_push($Minutes , $i);
						array_push($Seconds , $i);
					}
					//print_r($Hours);
					//echo "".print_r($Hours)."";
					
							//Start of table and Distance
							echo "<table id='races' class='scroll sortable' id='Prs' style='border: 4px solid orange;'>"; 
							echo "<tr>";
							echo "<td colspan='8' style='font-size:24px;background-color:#696969;'>" .  $PRDistances['distName']  	."</td>";
							echo "</tr>";
							
							//Table Headers
							echo "<th style='width:100px'> </th>";
							echo "<th style='width:100px'>Distance </th>";
							echo "<th style='width:150px'>Time </th>";
							echo "<th style='width:150px'>Pace </th>"; 
							echo "<th style='width:150px'>Date <br></th>";
							echo "<th style='width:250px'>Race Name </th>";
							echo "<th style='width:150px'>MPH (mi/hr) </th>";
							echo "<th style='width:150px'>Points (0-1400)</th>";
							echo "</tr>";
							
							//MY PRS
							echo "<tr>";
							echo "<th>Current PR:</th>";					
							echo "<td style='width:100px'>" .  $PRDistances['distName']  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Time']  		  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Pace']      	  						. "</td>";
							echo "<td style='width:150px'>" .  $PRrace['Date']      	  						. "</td>";
							echo "<td style='width:250px'>" .  $PRrace['Race'] 			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($PRrace['Pace'], $printArray),1)  . "</td>";
							echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>";
							echo "</tr>";
							
							//NEED TO UPDATE
							$GoalPace="00:00:01";
							
							//MY GOALS ROW:
							echo "<tr>";
							echo "<th>Goal Time/Pace:</th>";
						  //echo "<td style='width:100px' id='". $PRrace['Distance'] ."' name='Distance'  onchange=RecalculateElapsedTime ('". $PRrace['Distance'] ."') class='selectboxkl'>" .  $PRrace['Distance']  . "</td>";
							?>
							<!-- DISTANCE -->
							<td><input style='width:100px' id="<?php echo $PRrace['Distance']; ?>" name='Distance'  onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?> ','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class='selectboxkl' value='<?php echo $PRrace['Distance']; ?>'></td>
							
							
							
							<td><pre><b>H : M : S</b></pre>
							
							<?php
							//Now instead of sending it PR's, need to send it GOAL PR!
							$GOALtime="0";
							
							if($PRrace['Distance'] == "0.25")
							{
								$GOALtime="00:00:48";
							}
							if($PRrace['Distance'] == "0.50")
							{
								$GOALtime="00:01:52";
							}
							if($PRrace['Distance'] == "0.93")
							{
								$GOALtime="00:03:57";
							}
							if($PRrace['Distance'] == "1.00")
							{
								$GOALtime="00:04:18";
							}
							if($PRrace['Distance'] == "1.86")
							{
								$GOALtime="00:08:59";
							}
							if($PRrace['Distance'] == "2.00")
							{
								$GOALtime="00:09:40";
							}
							if($PRrace['Distance'] == "3.10")
							{
								$GOALtime="00:15:48";
							}
							if($PRrace['Distance'] == "6.00")
							{
								$GOALtime="00:32:05";
							}
							if($PRrace['Distance'] == "6.20")
							{
								$GOALtime="00:32:59";
							}
							if($PRrace['Distance'] == "10.00")
							{
								$GOALtime="00:53:48";
							}
							if($PRrace['Distance'] == "13.10")
							{
								$GOALtime="01:09:55";
							}
							if($PRrace['Distance'] == "26.20")
							{
								$GOALtime="02:29:48";
							}
							//PARSE H M S from desired time above time given
							$Time=$GOALtime;//$PRrace['Time'];
							$Times= substr($Time, (strlen($Time)-2)); // makes seconds the last 2 chars
							$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $s), "", $inputTime);	//gets rid of seconds and :
							$Timem= substr($Time, (strlen($Time)-2)); 
							$Time=substr($Time,0,-3);//$inputTime=str_replace((":" . $m), "", $inputTime);	//gets rid of minutes and :
							$Timeh= $Time; 
							
							$GOALpace=mypaceNEW($GOALtime, $PRrace['Distance']);
							
							?>
																									  
							<select id="starttimehour<?php echo $PRrace['Distance']; ?>" name="Hours" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>','<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>');" class="selectboxkl">
								<?php foreach ($Hours as $Hours) : ?>
									<option value='<?php echo $Hours; ?>'<?=$Hours == $Timeh ? ' selected=selected' : '';?>><?php echo "$Hours"; ?></option> 
								<?php endforeach; ?>
							</select>
							:
							<select id="starttimemin<?php echo $PRrace['Distance']; ?>" name="Minutes" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
								<?php foreach ($Minutes as $Minutes) : ?>
									<option value="<?php echo $Minutes; ?>"<?=$Minutes== "$Timem" ? ' selected=\"selected\"' : '';?>><?php echo "$Minutes"; ?></option> <!--WORKS!!!! :) -->
								<?php endforeach; ?>
							</select>
							:
							<select id="starttimesec<?php echo $PRrace['Distance']; ?>" name="Seconds" onchange="RecalculateElapsedTime ('<?php echo $PRrace['Distance']; ?>', '<?php echo $GOALtime; ?>'); TimeDiff ('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Time']; ?>'); PaceDifference('<?php echo $PRrace['Distance']; ?>','<?php echo $PRrace['Pace']; ?>'); " class="selectboxkl">
								<?php foreach ($Seconds as $Seconds) : ?>
									<option value='<?php echo $Seconds; ?>'<?=$Seconds == "$Times" ? " selected=selected" : '';?>><?php echo "$Seconds"; ?></option> <!--WORKS!!!! :) -->
								<?php endforeach; ?>
							</select></td>
							
							<?php
							
							//<select id='starttimehour". $PRrace['Distace'] ."' name='Hours'  onchange='RecalculateElapsedTime ("."test".")' class='selectboxkl'>";
							/*
							foreach ( $Hours as $Hours) : 
								echo "<option value='". $Hours."'"; 
								echo $Hours == $Timeh ? ' selected=selected': '';
								echo ">". $Hours;
								echo "</option>";
							endforeach;
							echo"</select>:";
							
							//minutes:
							echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Minutes'  class='selectboxkl'>";
							foreach ( $Minutes as $Minutes) : 
								echo "<option value='".$Minutes."'"; 
								echo $Minutes == $Timem ? ' selected=selected': '';
								echo ">". $Minutes;
								echo "</option>";
							endforeach;
							echo"</select>:";
							
							//Seconds:
							echo "<select id='starttimehour". $PRrace['Distace'] ."' name='Seconds'  class='selectboxkl'>";
							foreach ( $Seconds as $Seconds) : 
								echo "<option value='".$Seconds."'"; 
								echo $Seconds == $Times ? ' selected=selected': '';
								echo ">". $Seconds;
								echo "</option>";
							endforeach;
							echo"</select></td>";
							*/
						   
							//REST OF GOAL ROW
							//Pace
							echo "<td style='width:150px'>" .  "<input name='Pace' id='elapsed".  $PRrace['Distance'] ."' readonly value='".  $GOALpace ."'></td>"; //NEED TO CHANGE!!!
							//REST of results
							echo "<td style='width:150px'>" .  "SOON!"     	  									. "</td>";
							echo "<td style='width:250px'>" .  "???"        			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($GoalPace, $printArray),1)        . "</td>"; // CONVERT? need Javascript function! (not PHP)
							echo "<td style='width:150px'>" . $PRrace['Points']                                 . "</td>"; // CONVERT/ calculate?
							echo "</tr>";
												
							
							//Difference ROW ****************************************************************************** 
							//$TimeDifference="00:00:00";
							$PaceDifference="00:00:01";
							$PointDifference="0";
							
							echo "<tr>";
							echo "<th>Difference:</th>";
							echo "<td style='width:100px'>" .  $PRrace['Distance']  						    . "</td>";
							
							
							//problem: javascript only does calculations if an event is changed, if not i need to make an initial value... precalculate it??? 
							//solution: make php difference function and pace function for this?
							
							//PHP FUNCTION TO GET TIME DIFF AND PACE DIFF
							//Time:
							$TimeDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Time']) - TimeToSecondsNEW($GOALtime));
							//Pace
							$PaceDiffSTART= SecondsToTimeNEW(TimeToSecondsNEW($PRrace['Pace']) - TimeToSecondsNEW($GOALpace));
							?>
							
							<td style='width:150px'><h4>Need to run this much faster: <h4><input name='Time' id='<?php echo 'time'.$PRrace['Distance']; ?>' readonly value="<?php echo $TimeDiffSTART; ?>" ></td> <!--<?php echo $GOALtime; ?>-->
							<td style='width:150px'><h4>Need to run this much faster per mile:</h4><input name='Pace' id='<?php echo 'pace'.$PRrace['Distance']; ?>' readonly value="<?php echo $PaceDiffSTART; ?>" ></td>
							
							<?php
							echo "<td style='width:150px'>" .  "   "     	  									. "</td>";
							echo "<td style='width:250px'>" .  "   "        			  						. "</td>";
							echo "<td style='width:150px'>" . round(PaceToMPH($PaceDifference, $printArray),1)  . "</td>";
							echo "<td style='width:150px'>" . $PointDifference                                  . "</td>";
							echo "</tr>";
							
							//BLANK ROW
							echo "<tr>";
							echo "<td colspan='8' style='font-size:24px;background-color:#696969;'></td>";
							echo "</tr>";
							
							//END TABLE
							echo "</table>"; 
			}

	}
	else
	{
			
	}
    echo "</table>";

?>

</div>	
<hr  >
<br>






<!--TOTALS---------------------------------------------------------------------------------------->		
<?php 
$title = 'Totals: ';
echo "<br> <h2> $title </h2> <br>";

?>
<p>Below are the totals, means, medians, modes, ranges, bests, and worsts of the races you have selected. </p>
		<table>
			<tr>
				<th>DATA </th>
				<th>Races Run</th> 
				<th>Time</th>  
				<th>Distance</th> 
				<th>Place</th> 
				<th>Pace</th> 
				<th >Description</th> 
			</tr>
			
			<?php
			
			// PRINT ARRAYS	
			PrintArray($TOTALS);
			//PrintArray($AVERAGE);
			PrintArray($MEAN);
			PrintArray($MEDIAN);
			PrintArray($MODE);
			PrintArray($RANGE);
			PrintArray($BEST);
			PrintArray($WORST);			
					
					
			function PrintArray($myarray)
			{
				echo "<tr>";
				$arr_length = count($myarray); 
				for($i=0; $i < $arr_length ; $i++)
				{	
					if($i==0)
					echo "<td style='background-color:red; color:white'>" .  array_shift($myarray)  . "</td>";	
					else
					echo "<td >" .  array_shift($myarray)  . "</td>";
				}
				echo "</tr>";
			}
 
			?>

        </table>

		<!--<h1>All of my Races</h1>-->
		<br>
	     <hr  >
		<br>

		
		
		
		
<?php
// PRS PER YEAR: ****************************************************************************** 




array_multisort($event,$year,$mark);


//PRINT BY EVENT:
echo "<h2>Yearly PRs and Progress</h2><br>";
echo "<p>Tables below will show you per Event, your best mark per year in that event. <br>Its easy to track your progress in these events as well as know when you hit your PR and what it was!</p>";

$bestMark=100;
$index=1000;
$blahCount=0;


foreach($PRdist as $PRdist) // GO THROUGH EVENTS
{
	echo "<center><br><br><tr><th><h2> * ".$PRdist['distName']." * </th></tr></h2> <table><tr><th> Year </th><th> Event </th><th> Mark </th></tr> ";
	//echo "event Name : "          . $PRdist['Distance'] . "<br>";
	//echo "event Distance: "       . $PRdist['distName'] . "<br>";
	//echo "$StartYear - $CurrentYear<br>";
	
	for($y=2005; $y<=$CurrentYear; $y++) // GO THROUGH YEARS AND SPIT OUT PRs
	{
		//echo $y;
		//echo "<h3>".$y."</h3><br>";
		
		for($x=0; $x< count($year); $x++) // go through Array and match
		{
			//$blah++;
			//echo "<h3>".$year[$x] ."</h3><br>";
			//echo "Y is $y and year is " . $year[$x] . "<br>";
			
			if($y==$year[$x] && $PRdist['Distance']==$event[$x] && $mark[$x]<$bestMark) // if its the lowest mark print it
			{
				$bestMark=$mark[$x];
				$index=$x;
				
				
				//echo "hit<br>";
			}
		}
		//echo "index: ". $x . "<br>";
		
		if($index!=1000)
		{
			
			echo "<tr>";
			echo "<td>".$year[$index] ."</td>";
			echo "<td>".$event[$index]."</td>";
			echo "<td>".$mark[$index] ."</td>";
			echo "</tr>";
			
			
			$bestMark=100;
			$index=1000;
			
			
			
		}
	}
	echo "</table></center>";

}

	
//************************************************************************************************************************************************************ 



//PRINT BY EVENT:
echo "<h2>Yearly PRs Table</h2><br>";
echo "<p>This table. shows you the same info above in a more concise view, Horizonally you can see the yearly progress, and Vertically you can see the change in events/distances. <br> Red will show a decrease in performance from the previous year, and green will show inprovement! GOLD will be your PR!</p>";

$bestMark=100;
$index=1000;
$blahCount=0;
$lastYearIndex=0;

echo "<center><table>";
echo "<tr>";
echo "<td>Events / Year</td>";
for($y=2005; $y<=$CurrentYear; $y++) // GO THROUGH YEARS AND SPIT OUT PRs
{
	echo"<th>". $y ."</th>";
}
echo "</tr>";


//START BIG FORLOOPS:
foreach($PRdist2 as $PRdist2) // GO THROUGH EVENTS
{
	echo"<tr>";
	echo"<th>".$PRdist2['distName']."</th>";
		
	for($y=2005; $y<=$CurrentYear; $y++) // GO THROUGH YEARS AND SPIT OUT PRs
	{
		for($x=0; $x<= count($year); $x++) // go through Array and match
		{
			if($y==$year[$x] && $PRdist2['Distance']==$event[$x] && $mark[$x]<$bestMark) // if its the lowest mark print it
			{
				$bestMark=$mark[$x];
				$index=$x;
			}
		}
		//IF INFO IS FOUND DISPLAY IT HERE
		if($index!=1000)
		{
			//if performance is NOT better than last year mark red and display.
			if($mark[$index]>=$mark[$lastYearIndex])
			{
				echo "<td style='background-color:#ff6666;'>" . $mark[$index] . "</td>"; //. $mark[$lastYearIndex] . " TO "
			}
			
			
			//Mark green and display
			else
			{
				$PR="false";
				
				for($t=0;$t<count($myPRs);$t++)
				{	
					//echo "mark: $mark[$index] , PR: $myPRs[$t]<br>";
					if($mark[$index] == $myPRs[$t])
					{
						$PR="true";
					}
				}
				
				if($PR=="true")
					echo "<td style='background-color:#85e085; border: 4px solid gold;'>" . $mark[$index] . "</td>"; //. $mark[$lastYearIndex] . " TO "
				
				else
					echo "<td style='background-color:#85e085;'>" . $mark[$index] . "</td>";
			}
			$lastYearIndex=$index;
			$bestMark=100;
			$index=1000;
		}
		//ELSE DISPLAY -
		else
		{
			echo "<td>" . "-" . "</td>";
		}
	}
	
	echo "</tr>";
}
echo "</table></center>";

//echo "<br>$blah";
?>	
<hr>
<br>
<br>
		
		
		
		



		
<!-- NEW----------------------------------------------------------------->
<?php

/*
		
		//SET INITIAL DATA
		$dsn = 'mysql:host=vojta-data.db.sonic.net; dbname=vojta_data';
		$username = 'vojta_data-all';
		$password = '590d05cd';
		
		$dbconnect = mysql_connect($dsn, $username, $password); //uses my password to get in database
        if(!dbconnect)
                echo "Could not open database"; //if log-in fails then say ...

        //select database
		$db = mysql_select_db("vojta_data", $dbconnect); //connect to database and select vojta_data as the database in phpMyAdmin
        if(!$db)
        {
                echo "Could not open student info"; //if it cant be opened say so. 
                exit;
        }
		
		//query i want
		$result = mysql_query('SELECT * FROM $myusername'); //"1.00"
		//echo "My distance is: $Distance";
		
		// all tables headings
		echo 
		"<table border='1' > 
		<tr>
		<th> Index</th>
		<th> Date</th>
		<th> Race</th>
		<th> Time</th>
		<th> Distance</th>
		<th> Place</th>
		<th> Pace</th>
		</tr>";
		
		//get the actual data from DB
		while($row = mysql_fetch_array($result)) 
		{
		  //ODD
		  if($x==1)
		  {
			  echo "<tr>";
			  echo "<td>" . $row['Index'] . "</td>";
			  echo "<td>" . $row['Date'] . "</td>";
			  echo "<td>" . $row['Race'] . "</td>";
			  echo "<td>" . $row['Time'] . "</td>";
			  echo "<td>" . $row['Distance'] . "</td>";
			  echo "<td>" . $row['Place'] . "</td>";
			  echo "<td>" . $row['Pace'] . "</td>";
			  echo "</tr>";
			  $x=$x-1;
		  }
		  //EVEN
		  else  
		  {
			  echo "<tr>";
			  echo "<td>" . $row['Index'] . "</td>";
			  echo "<td>" . $row['Date'] . "</td>";
			  echo "<td>" . $row['Race'] . "</td>";
			  echo "<td>" . $row['Time'] . "</td>";
			  echo "<td>" . $row['Distance'] . "</td>";
			  echo "<td>" . $row['Place'] . "</td>";
			  echo "<td>" . $row['Pace'] . "</td>";
			  echo "</tr>";
			  $x=$x+1;
		  }
		  
		}
		echo "</table>";

		mysql_close($dbconnect); //closes connection
		
		*/

		
//GRAPHING STUFF**********************************
			
			// Using the php wrapper for google charts
			function draw_bar_graph($width, $height, $data, $max_value)
			{
				require_once('../map/graphs/gChart.php');
				require_once('../map/graphs/Header.php');

				// Need to separate the y values from the x labels
				// The labels are the keys, the values are the y values
				$myArray = array_values($data);
				$xLabels = array_keys($data);

				// This sets up the chart of google charts
				$barChart = new gBarChart();
				$barChart->addDataSet($myArray);            // add the y values
				$barChart->setAutoBarWidth();
				$barChart->setColors(array("ff3344", "11ff11", "22aacc"));
				$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
				$barChart->setDimensions($width, $height);
				$barChart->setVisibleAxes(array('x','y'));
				$barChart->setDataRange(0, $max_value);
				$barChart->addAxisRange(1, 0, $max_value);
				$barChart->addAxisLabel(0, $xLabels);       // Add the labels

				// Interesting, google charts creates an image from their site
				echo "<img src=" . $barChart->getUrl() . " /> <br>";

			} // End of draw_bar_graph() function

			
// Places finished: 1st, 2nd, 3rd **********************************************************************************************************************	
			//PUTTING TITLE ON GRAPH
			$title = 'My Race Finish Places: ';
			echo "<center><h1>GRAPHS:</h1></center><br>";
			echo "<p>Below are graphs of race results based on totals of a specific category.<br> 1st graph is: Count of Total Races I Have Run Each Year. <br> 2nd graph is: Count of Race Types: Road Race, XC Race, Track Race, Tri. <br> 3rd Graph is: Count of Each Distance I Have Run (ex. how many times I've run 400m).  </p><br><br>";
			echo "<br> <h2> $title </h2> <br>";
			echo "<p>Below is the count of top 3 places and how many of each I finished. <br> 1st, 2nd, 3rd, Other.</p>";
			
			//GETTING DATA READY AND ADDING THEM TO THE GRAPH:
			$graphData = array();
			$graphData2 = array(array());
			//echo $name;
			
			//GETTING QUERY OF RACES
			if($Distance=='All' or $Year=='All')
			{
				$queryrace = "SELECT * FROM $myusername order by Place ASC";
				$raceGraphYear = queryRaces($queryrace1, $Distance, $Year);
			}
			else if($Distance==NULL && $Year==NULL)
			{
				$queryrace = "SELECT * FROM $myusername order by Place ASC LIMIT 10";
				$raceGraphYear = queryRaces($queryrace1, $Distance, $Year);
			}		

			else if($Distance==NULL)
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Date LIKE :Year) order by Place ASC";
				$raceGraphYear = queryRaces($queryrace, $Distance, $Year."%"); 				
			}
			// Get races for selected distance. (if index is given)
			else
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Distance = :Distance AND Date LIKE :Year) order by Place ASC"; 
				$raceGraphYear = queryRaces($queryrace, $Distance, $Year."%");
			}
					
			
			// NOW GOING THROUGH EACH RACE AND STRIPPING DATA
			foreach ($raceGraphYear as $raceGraphYear)
			{
				 $name=$raceGraphYear['Race']; 
				 $place=$raceGraphYear['Place']; // x-axis
				 
				 //GOT 1st 2nd 3rd and OTHER
				 if($place=='1' or $place=='2' or $place=='3' )
				 {
					 //do nothing and count it later
					 
					 //MAKE and add it to table
				 }
				 else
				 {
					 //Other
					 $place='OTHER';
				 }
				
				// COUNT IT AND GRAPH IT
				if(array_key_exists($place, $graphData))
					$graphData[$place]++;       // Yes, increment it
				else
					$graphData[$place] = 1;     // No, set it to one*/ 1
					
			} 

			//function draw_bar_graph($width, $height, $data, $max_value)
			draw_bar_graph(960, 240, $graphData, ($totalCount/1.5)); //prints graph

			// Dump the data just so we can see how it is organized
			//var_dump($graphData);
			//echo "<br><br> 1st: $graphData[1] <br>2nd:  $graphData[2] <br>3rds: $graphData[3]<br>";
			
			// TABLE
			$title2= "My Race Finishes: ";
			echo "<br> <h2> $title2 </h2> <br>";
			echo "<table id='Prs' style='border: 4px solid orange;'><tr>";
			echo "<th style='width:100px'> Place Finished </th>";		
			echo "<th style='width:120px'> Count </th>"; 
			echo "</tr>";
			echo "<tr>";
			echo "<td>1st</td>";
			echo "<td>$graphData[1]</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>2nd</td>";
			echo "<td>$graphData[2]</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>3rd</td>";
			echo "<td>$graphData[3]</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Other</td>";
			echo "<td>". $graphData["OTHER"] . "</td>";
			echo "</tr>";
			echo "</table><br>";
			
			
			
// Number of Races / Year: **********************************************************************************************************************	
			//PUTTING TITLE ON GRAPH
			$title = 'Count of Races I Have Run Each Year: ';
			echo "<br> <h2> $title </h2> <br>";
			
			//GETTING DATA READY AND ADDING THEM TO THE GRAPH:
			$graphData = array();
			$graphData2 = array(array());
			//echo $name;
			
			//GETTING QUERY OF RACES
			if($Distance=='All' or  $Year=='All')
			{
				$queryrace = "SELECT * FROM $myusername order by Date ASC";
				$raceGraphYear = queryRaces($queryrace1, $Distance, $Year);
			}
			
			else if($Distance==NULL && $Year==NULL)
			{
				$queryrace = "SELECT * FROM $myusername order by Date ASC LIMIT 10";
				$raceGraphYear = queryRaces($queryrace1, $Distance, $Year);
			}

			else if($Distance==NULL)
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Date LIKE :Year) order by Date ASC";
				$raceGraphYear = queryRaces($queryrace, $Distance, $Year."%"); 				
			}
			// Get races for selected distance. (if index is given)
			else
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Distance = :Distance AND Date LIKE :Year) order by Date ASC"; 
				$raceGraphYear = queryRaces($queryrace, $Distance, $Year."%");
			}
					
			
			// NOW GOING THROUGH EACH RACE AND STRIPPING DATA
			foreach ($raceGraphYear as $raceGraphYear)
			{
				 $name=$raceGraphYear['Race'];
				 $year=substr($raceGraphYear['Date'], 0, 4); // race count by distance;
				 
				if(array_key_exists($year, $graphData))
					$graphData[$year]++;       // Yes, increment it
				else
					$graphData[$year] = 1;     // No, set it to one*/ 1
					
			} 

			//function draw_bar_graph($width, $height, $data, $max_value)
			draw_bar_graph(960, 240, $graphData, ($totalCount/3)); //prints graph

			// Dump the data just so we can see how it is organized
			//var_dump($graphData);


// Breakdown of race types: **********************************************************************************************************************		

			//PUTTING TITLE ON GRAPH
			$title = 'Count of Race Types: ';
			echo "<br> <h2> $title </h2> <br>";
			
			//GETTING DATA READY AND ADDING THEM TO THE GRAPH:
			$graphData = array();
			$graphData2 = array(array());
			//echo $name;
			
			//GETTING QUERY OF RACES
			if($Distance==NULL && $Year==NULL)
			{
				$queryrace = "SELECT * FROM $myusername order by Distance DESC LIMIT 10";
				$raceGraphType = queryRaces($queryrace1, $Distance, $Year);
			}
			
			else if($Distance=='All' or $Year=='All')
			{
				$queryrace = "SELECT * FROM $myusername order by Distance DESC";
				$raceGraphType = queryRaces($queryrace1, $Distance, $Year);
			}

			else if($Distance==NULL)
			{
				$raceGraphType = queryRaces($queryrace1, $Distance, $Year."%"); 				
			}
			// Get races for selected distance. (if index is given)
			else
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Distance = :Distance AND Date LIKE :Year) order by Distance DESC"; 
				$raceGraphType = queryRaces($queryrace1, $Distance, $Year."%");
			}
			
			// NOW GOING THROUGH EACH RACE AND STRIPPING DATA
			foreach ($raceGraphType as $raceGraphType)
			{
				 $name=$raceGraphType['Race'];
				 $Type=$raceGraphType['Type']; // race count by distance;
				 //$raceGraph['Race']; // Race count for years;
				 
				if(array_key_exists($Type, $graphData))
					$graphData[$Type]++;       // Yes, increment it
				else
					$graphData[$Type] = 1;     // No, set it to one*/ 1
					
			} 

			//function draw_bar_graph($width, $height, $data, $max_value)
			draw_bar_graph(960, 240, $graphData, ($totalCount/2)); //prints graph

			// Dump the data just so we can see how it is organized
			//var_dump($graphData);		
			
// DISTANCE: **********************************************************************************************************************			
			
			//PUTTING TITLE ON GRAPH
			$title = 'Count of Each Distance I Have Run: ';
			echo "<br> <h2> $title </h2> <br>";
			
			//GETTING DATA READY AND ADDING THEM TO THE GRAPH:
			$graphData = array();
			$graphData2 = array(array());
			//echo $name;
			
			//GETTING QUERY OF RACES
			if($Distance==NULL && $Year==NULL)
			{
				$queryrace = "SELECT * FROM $myusername order by Distance ASC LIMIT 10";
				$raceGraph = queryRaces($queryrace, $Distance, $Year);
			}
			
			else if($Distance=='All' or $Year=='All')
			{
				$queryrace = "SELECT * FROM $myusername order by Distance ASC";
				$raceGraph = queryRaces($queryrace, $Distance, $Year);
			}
			
			else if($Distance==NULL)
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Date LIKE :Year) order by Distance ASC";  
				$raceGraph = queryRaces($queryrace, $Distance, $Year."%"); 				
			}
			// Get races for selected distance. (if index is given)
			else
			{
				$queryrace = "SELECT * FROM $myusername WHERE (Distance = :Distance AND Date LIKE :Year) order by Distance ASC"; 
				$raceGraph = queryRaces($queryrace, $Distance, $Year."%");
			}
			
			// NOW GOING THROUGH EACH RACE AND STRIPPING DATA
			foreach ($raceGraph as $raceGraph)
			{
				 $name=$raceGraph['Race'];
				 $distance=$raceGraph['Distance']; // race count by distance;
				 $raceGraph['Race']; // Race count for years;
				 
				if(array_key_exists($distance, $graphData))
					$graphData[$distance]++;       // Yes, increment it
				else
					$graphData[$distance] = 1;     // No, set it to one*/ 1
					
			} 

			//function draw_bar_graph($width, $height, $data, $max_value)
			draw_bar_graph(960, 240, $graphData, ($totalCount/4)); //prints graph

			// Dump the data just so we can see how it is organized
			//var_dump($graphData);

?>		
<hr  >
<br>
<br>

<!-- ****************************************************************************** ******************************************************************************           -->
<!-- ****************************************************************************** ******************************************************************************           -->
<!-- MAP  will have to get a API key later-->


<!--
OTHER M A P:

<div id="map" style="width:400px;height:400px;background:red"></div>

<script>
function myMap() {
  var mapCanvas = document.getElementById("map");
  var mapOptions = {
    center: new google.maps.LatLng(51.5, -0.2), zoom: 10
  };
  var map = new google.maps.Map(mapCanvas, mapOptions);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>


To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->
<!-- MY MAP _______________________________________________________________________________________________________________________                -->
<?php 
		/*function geocode($address)
		{
		  //define('GOOGLE_GEOCODE', 'http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&address=');
		  
		  $urlAddress = urlencode( $address );
		  
		  $geocodeUrl = GOOGLE_GEOCODE . $address;
		  $xmlResponse = simplexml_load_file(GOOGLE_GEOCODE . $urlAddress);
		  
		  $lat = $xmlResponse->result->geometry->location->lat;
		  $lng = $xmlResponse->result->geometry->location->lng;
		  
		  $ret['lat'] = $lat;
		  $ret['lng'] = $lng;
		  return $ret;
		}*/

		include_once("../map/GoogleMap.php");
		include_once("../map/JSMin.php");

		$MAP_OBJECT = new GoogleMapAPI(); 
		$MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE; ?>
	
 <!-- TABLE FOR MAP RACES 
  <table width='800px' border='1' cellspacing='0' cellpadding='0'><tr><th width='50px'>Race Name</th><th width='50px'>Location</th></tr> -->	
	
	
<?php		//Getting races and plotting on map
			foreach ($raceMap as $raceMap):
 			
				if($raceMap['Location']==NULL)	
				{
					//echo "NONE";
				}
				else
				{ 				
					$RaceName=$raceMap['Race'];     				
					$RaceLocation=$raceMap['Location'];    
					//echo "Have a location! $RaceLocation";
					
					//MAP
					$MAP_OBJECT->addMarkerByAddress($RaceLocation,"$RaceName", nl2br("Race: $RaceName\n\n") . "Location: $RaceLocation"); // THERE ARE 3 Fields: 1. plots it on graph, 2. put a button at bottom of graph, 3. adds description!
					
					//Table
					//echo "<tr><td>$RaceName</td>";
					//echo "<td>$RaceLocation</td></tr>";
				}     	
		    endforeach;
?>

<head>
		<div align="center">
		<?=$MAP_OBJECT->getHeaderJS();?>
		<?=$MAP_OBJECT->getMapJS();?>
</head>
		<body>
		<H1>My Races on the MAP</H1>
		<p>Using Google Maps, I have mapped each race on a map based on its geographical location. </p>
		<?=$MAP_OBJECT->printOnLoad();?>
		<?=$MAP_OBJECT->printMap();?>
		<?=$MAP_OBJECT->printSidebar();?>
	
		 
		<br><br> 
<!-- END MAPS ----------------------------------------------------------------------------------------------------------------------------------------------------->


		
<br>	

		
</section>
<ul class="myButtons">
	<span class="myButtons" style="display: inline;">
		<a class="myButtons" onclick="topFunction()" id="myBtn" title="Go to top">Top</a>
	</span>
</ul>
	

<br>
<br>
<!-- begin wwww.htmlcommentbox.com -->
 <h1>Comments: </h1>
 <div style="color:white;" id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">Comment Form</a> is loading comments...</div>
 <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
 <script type="text/javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=hcb_user.PAGE || (""+window.location).replace(/'/g,"%27"), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&mod=%241%24wq1rdBcg%24DnRxkqNQmUnhoputqLMl10"+"&opts=16862&num=10&ts=1499300164544");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
<!-- end www.htmlcommentbox.com -->
	
</main>
<footer>
<center>
    <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, Inc. 	
	
			<div id="sfcxppf9yed89xa3ybnbdp1jrgxgycgaqfb"></div>
		<script type="text/javascript" src="https://counter6.freecounter.ovh/private/counter.js?c=xppf9yed89xa3ybnbdp1jrgxgycgaqfb&down=async" async></script>
		<br><a href="https://www.freecounterstat.com">free counter for websites</a><noscript><a href="https://www.freecounterstat.com" title="free counter for websites"><img src="https://counter6.freecounter.ovh/private/freecounterstat.php?c=xppf9yed89xa3ybnbdp1jrgxgycgaqfb" border="0" title="free counter for websites" alt="free counter for websites"></a></noscript>
	</p>
</center>
</footer>
</body>
</html>
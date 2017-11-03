<?php
// ***index.php use to be called USERS.php
require_once('pages/database.php');



/*   VARIABLES **************************************************************

*****************************************************************************/
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




//SPITS OUT "ALL" users and info
//****************************************************************************** 

	$queryusers = 'SELECT * FROM users';
	$statement1 = $db->prepare($queryusers);
	$statement1->execute();
	//$users = $statement1->fetch();
	$statement1->closeCursor();
	
	//ALL USERS STORED IN HERE:
	$users=queryRaces($queryusers);
?>







<!-- HTML --------------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
	<!-- FOR SORTING TABLES!!! -->
	<script src="pages/sorttable.js"></script> 
	<!-- INCLUDING FOR ALL JAVASCRIPT! -->
	<script src="pages/javascript_RaceResults.js"></script> 
	
    <title>Finishline Users</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style> 
		h2   {text-shadow: 1px 5px 5px #FF0000; color: white}  
	</style>

</head>

<!-- the body section -->
<body onload="Init ()">


<main>




<!-- TOP BUTTONS -->  
   <center>
   <span class="myButtons" style="display: inline;">
   
   <h2> Links: </h2>
   
   <a class="button" href="pages/login.php" >Admin</a> <!--indexAdmin.php -->
   <a class="button" href="index.php" style="background-color:red;" >View All Users</a>
   <a class="button" href="pages/functions.php">Other Functions / Conversions</a>
   <a class="button" href="pages/distance_list.php">List distances</a>     
   <a class="button" href="pages/signup.php" >Sign up for updates</a>
   
   <a class="button" href="http://vojta.users.sonic.net/blog/"> Vojta's Main Page </a>
   <a class="button" href="pages/about.html">Vojta's Bio</a>
   
   </span>
   
    <br>
   <hr  >
   <br>
   <!--<h1 style="font-size:100px;">Finishline </h1>-->
	<img src='image/finishline2.jpg' alt='finish' align='center'  height="400"> 
   </center>

<center>
	<div style="border: 4px solid red;">
		<span><h2> Create Account: </h2><p style="display: inline;"><a class="button" href="pages/create_account.php" >Sign-up</a></p></span><br>
		<span><h2> Existing User: </h2><p style="display: inline;"><a class="button" href="pages/login.php" >Login</a></p><br><br></span>
	</div>
	
	<br><br>
	<iframe width="560" height="315" src="https://www.youtube.com/embed/0ZYh7jzcIMY" frameborder="0" gesture="media" allowfullscreen></iframe>
	<br><br>
</center>



<br><br>
<h1 style="font-size:50px;"> Display All Users </h1>	
<p>Below are all users that store their race results on Finishline. Please click on one to see their results, or Create an Account to start tracking your own race results. If you already have an account, please loggin.</p>

<br>
<br>


<!-- STARTING TABLE OF DATA -->
<center>
	<!--<div style="height:400px; overflow:auto; display:block;">  -->
	   <table id="races" class="scroll sortable" >
		  	
			<!-- MAIN TABLE HEADINGS-->
			<thead >
				<tr class="header" >
					
					<th style="width:80px">Click              					    </th> <!-- DOES NOT EVEN MOVE -->
					<th style="width:120px">Picture                					</th> <!-- DOES NOT EVEN MOVE -->
					<th style="width:120px">Count                					</th> <!-- DOES NOT EVEN MOVE -->
					<th style="width:100px">First Name            &DownArrowUpArrow;</th> <!-- DOES NOT EVEN MOVE -->
					<th style="width:150px">Last  Name            &DownArrowUpArrow;</th> <!--SORTING TABLE BASED ON INPUT --> <!-- WORKS onclick="sortTable(0)" -->
					<th style="width:250px">Gender                &DownArrowUpArrow;</th> <!-- WORKS-->
					<th style="width:250px">Total Wins                &DownArrowUpArrow;</th> <!-- WORKS-->
					<th style="width:250px">Best Points Earned        &DownArrowUpArrow;</th> <!-- WORKS-->
					<th style="width:250px">Last Race Date            &DownArrowUpArrow;</th> <!-- WORKS-->
					<th style="width:250px">Age               &DownArrowUpArrow;</th> <!-- WORKS-->
					
					<th style="width:150px">Total Results         &DownArrowUpArrow;</th> <!-- TIME IS NOT SORTED RIGHT... -->
					
				</tr>
			</thead>
        
		
		<!--table body -->
		 <tbody>                      
            <!-- GETS EACH RACE and Race details-->                     
				
				
				<?php
				$totalCount=0;
				foreach($users as $users):
					
					//PICTURE:	
					
					//username:
					$username=$users['username'];
									
					//if picture exists, use picture
					//echo "Picture: " . $users['Picture'];
					if($users['Picture']!=Null)
					{
						$picture= "image/racePics/". $username. "/" . $users['Picture'];
					} 
					//else use default
					else
					{
						$picture="image/default.jpg";
					}
					
					
					//TOTAL RACES:
					$queryusers = 'SELECT Count(Race) FROM '.$username;
					$totalRacesArray=queryRaces($queryusers);
					$totalRaces=$totalRacesArray[0][0];//gets the number of races!				
					
					//# of wins:
					$number_of_wins_Query = 'SELECT Count(*) FROM ' .$username. ' WHERE Place=1';
					$ResultQuery=queryRaces($number_of_wins_Query);
					$number_of_wins = $ResultQuery[0][0];
										
					//Best event point / rank:
					$Max_Points_Query = 'SELECT MAX(Points) FROM ' .$username;
					$ResultQuery=queryRaces($Max_Points_Query);
					$Max_Points = $ResultQuery[0][0];
										
					//Last Race Date:
					$Last_Race_Date_Query = 'SELECT MAX(Date) FROM ' .$username;
					$ResultQuery=queryRaces($Last_Race_Date_Query);
					$Last_Race_Date = $ResultQuery[0][0];
										
					//AGE: (get from user)
					
				?>	
				
			<tr  class='clickable-row'  onclick="window.document.location='<?php 
			//echo "index.php?user=". $username;
			echo "pages/RaceResults.php?choice=search&user=".urlencode($username)."&Year=".urlencode('All')."&Distance=".urlencode('All'); 
			?>';"> 
			
							
				<td ><a class="button" style="background:red; color:white;">Click Row to View User</a></td>
				<td > <img height="70px" src="<?php echo $picture; ?>" alt="<?php echo $picture; ?>" ></td>
				<td style="width:100px">  <?php $totalCount++; echo "$totalCount";  			 ?> </td>
				<td style="width:150px">  <?php echo $users['first_name'];                 		 ?> </td>
				<td style="width:250px">  <?php echo $users['last_name'];                        ?> </td>
				<td style="width:150px" > <?php echo $users['sex'];                              ?> </td>
				<td style="width:150px" > <?php echo $number_of_wins;                              ?> </td>
				<td style="width:150px" > <?php echo $Max_Points;                              ?> </td>
				<td style="width:150px" > <?php echo $Last_Race_Date;                              ?> </td>
				<td style="width:150px" > <?php echo $users['age'];                              		 ?> </td>
				
				<td style="width:100px">  <?php echo $totalRaces;                            	 ?></td>	
						
           </tr>	

            <?php endforeach; ?>
			
			
		
			
		 </tbody> 	
	</table>

	<hr>
	<br>
	<br>
	
	
<!--TO TOP OF PAGE-->	
	<ul class="myButtons">
	<span class="myButtons" style="display: inline;">
		<a class="myButtons" onclick="topFunction()" id="myBtn" title="Go to top">TO Top</a>
	</span>
	</ul>


	<br>
	<br>
<!--DONATE-->
<a class="button" href="https://paypal.me/VojtaR" ><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQm_YX3h8Gtk6xGAHV_Jw2eIFLlto_nDU_kBNGFfB0ukQux31Ak8w" ></a>


<!-- begin wwww.htmlcommentbox.com -->
 <h1>Comments: </h1>
 <div style="color:white;" id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">Comment Form</a> is loading comments...</div>
 <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
 <script type="text/javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=hcb_user.PAGE || (""+window.location).replace(/'/g,"%27"), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&mod=%241%24wq1rdBcg%24DnRxkqNQmUnhoputqLMl10"+"&opts=16862&num=10&ts=1499300164544");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
<!-- end www.htmlcommentbox.com -->
	
	</center>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, Inc.</p>
</footer>
</body>

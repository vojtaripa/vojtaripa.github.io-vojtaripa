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
	$statement1 = $db->prepare($queryusers);<?php
   //SOURCE:
   //https://dcrazed.com/free-responsive-html5-css3-templates/
   
   ?>
<!--HTML-->
<!DOCTYPE HTML>
<!--
   Spectral by HTML5 UP
   html5up.net | @ajlkn
   Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
   -->
<html>
   <head>
      <title>Vojta Ripa</title>
      <meta charset="utf-8" />
	  <meta name="description" content="Vojta Ripa's Landing Page and Projects">
	  <meta name="keywords" content="vojta, ripa, landing, page, projects, about, resume, main, profile, directory, php, html5, css, developer, javascript, full, stack, junior, best, mySQL, databases,website, builder">
	  <meta name="author" content="Vojta Ripa">
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
      <link rel="stylesheet" href="assets/css/main.css" />
      <!--[if lte IE 8]>
      <link rel="stylesheet" href="assets/css/ie8.css" />
      <![endif]-->
      <!--[if lte IE 9]>
      <link rel="stylesheet" href="assets/css/ie9.css" />
      <![endif]-->
      <!--MINE-->
      <link rel="Finishline Icon" href="image/finishline.ico">
      <!-- FOR SORTING TABLES!!! -->
      <script src="pages/sorttable.js"></script> 
   </head>
   <body class="landing" onload="Init ()">
      <!-- Page Wrapper -->
      <div id="page-wrapper">
         <!-- Header/ Menu -->
         <header id="header" class="alt">
		    <!--<img src="assets/css/images/VojtaRipa.png" alt="Vojta Ripa"  style="width:3%; float:right;"> --> 
            <h1><a href="index.php"><i class="icon fa-user-circle-o" ></i><b> Vojta</b> Ripa</a></h1>
            <nav id="nav" class="alt" >
               <ul>
                  <li class="special">
                     <a href="#menu" class="menuToggle"><span>Menu</span></a>
                     <div id="menu">
                        <ul>
                           <li><a style="color:#E6584B" href="index.php">Home</a></li>
                           <li><a href="#about">About Vojta</a></li>
                           <li><a href="#projects">Projects</a></li>
                           <li><a href="#useful">Useful Sites</a></li>
                           <li><a href="Vojta Ripa Resume 2018 simple.htm">Resume</a></li>
                           <li><a href="http://vojta.users.sonic.net/finishline/">Best Project (FINISHLINE)</a></li>
                           <li><a href="http://vojta.users.sonic.net/blog/">Vojta's Running Blog</a></li>
                           <br>
                        </ul>
                     </div>
                  </li>
               </ul>
            </nav>
         </header>
         <!-- Intro -->
         <section id="banner">
            <div class="inner">
			   <center><img src="assets/css/images/VojtaRipa.png " style="width:13%" alt="Vojta Ripa" ></center><br>
               <h2><i class="icon fa-user"></i><b> Vojta</b> Ripa</h2>
               <p>My Website and Project Directory<br />
                  Enjoy!<br /><br />
                  created by <a href="http://vojtaripa.com/blog"><b>Vojta Ripa</b></a>.
               </p>
               <ul class="actions">
                  <li><a href="#projects" class="button special">See Projects</a></li>
                  <li><a href="blog" class="button special">See Running Blog</a></li>
               </ul>
            </div>
            <a href="#about" class="more scrolly" style="text-decoration:none">Learn More</a>
         </section>
         
		 
		 <!-- About -->
         <section id="about" class="wrapper style1 special">
            <div class="inner">
               <header class="major">
                  <h2 style="float:left">Welcome to my website!</h2>
                  <p style="float:left">Hi everyone,<br /><br>
                     My name is Vojta Ripa, and I'm a web-developer / programmer. <br>
					 I'm currently seeking the position of a Web Developer to further enhance organizational worth owing to my knowledge in mySQL, CSS, PHP,  JavaScript, Ajax,  HTML and JQuery.<br>
                     Below you will see a list of some of my work, and projects<br>
                     I was born in Czech Republic and moved to the US at the age of 10. <br>
                     I have graduated from CSU Stanislaus with my BS in Computer Science, and since been working for a few tech<br>
                     companies, learning range of skills. 
                  </p>
                  <br>
				  <br>
				  <h4><u>Skills</u></h4>
				  <div class="row">
				  <div class="12u 12u$(medium)">
                        <ul >
                           <li>Web developement</li>
						   <li>Working with Databases</li>
						   <li>Programming</li>
						   <li>Networking</li>
                           <li>Hardware and software troubleshooting</li>
                           <li>VOIP communications</li>
						   <li>Troubleshooting and debugging</li>
                           <li>Virus removal and system maintenance.</li>
                           <li>and much more!</li>
                        </ul>
                     
                  </div>
				  </div>
				  
				  <center>
				  <br><br>
                  <p><b>Please see my resume here:</b></p>
                  <a href="Vojta Ripa Resume 2018 simple.htm" class="button big special">My Resume</a>
               </header>
               <ul class="icons major">
                  <li><span class="icon fa-code major style3"><span class="label">Code</span></span></li>
                  <li><span class="icon fa-laptop major style1"><span class="label">Laptop</span></span></li>
                  <li><span class="icon fa-database major style2"><span class="label">Database</span></span></li>
                  <li><span class="icon fa-user major style1"><span class="label">User</span></span></li>
                  <li><span class="icon fa-html5 major style3"><span class="label">Database</span></span></li>
               </ul>
			   </center>
            </div>
         </section>
         <!-- Projects -->
         <section class="wrapper style5" id="projects">
         <div class="inner" >
            <header>
               <h2>Projects</h2>
               <p>Below are projects I have worked on. Please take a look! </p>
            </header>
            <!--table-->
            <section class="wrapper style4">
               <table width="100%"  border="0">
                  <tr>
                     <th>Name / Link</th>
                     <th>Description</th>
                  </tr>
                  <tr>
                     <td width="20%" scope="row">
                        <a href="finishline/index.php">FINISHLINE</a>              <br>
                     </td>
                     <td>Finishline allows you to add, store, and analyze your race results. <br>You can filter your results bases on: year, distance, race type ect., you can sort your races by any field. 
                        <br>See all of your PRs, compare your results with other users, add a race picture with each race, races will be diplayed on a map so you can see where you ran, see all totals and averages.<br>
                        You can also set race goals, and see diffrent race data on graphs.<br>
                        Please let me know what else you would like to see, I can change, modify, add anything; Open to suggestions!<br>
                        Please create your account and start adding races, the more people we have the better!<br>
                     </td>
                  </tr>
				  <tr>
                     <td width="20%" scope="row">
                        <a href="https://vojtaripa.github.io/">GitHub - Vojta Ripa</a>              <br>
                     </td>
                     <td>Finishline on GitHub (Still need changes made)<br>
                     </td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="http://vojta.users.sonic.net/blog/index2.html">Sodoku Solver</a>              <br>
                     </td>
                     <td>Sudoku Solver I made my last year in college, solves a lot of sudokus, needs some advanced algorithms to solve harder sodokus.</td>
                  </tr>
                  <tr>
                     <td width="20%" scope="row">
                        <a href="http://vojta.users.sonic.net/blog/runner-ranker">Athlete Ranker</a>              <br>
                     </td>
                     <td>This program ranks track athletes based on their performance </td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="http://vojta.users.sonic.net/mywordpress/">Kanzler Vineyards</a>              <br>
                     </td>
                     <td>This is a site I made for Kanzler Vineyards</td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="phpclass/index.html">PHP Class</a>              <br>
                     </td>
                     <td>How to use PHP with a MySQL database</td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="http://vojta.users.sonic.net/picturedatabase/JustPictureIt.html">Picture Database</a>              <br>
                     </td>
                     <td>Project we made in College: Picture Database</td>
                  </tr>
                  <tr>
                     <td width="20%" scope="row">
                        <a href="http://vojta.users.sonic.net/blog/">Vojtas Running Webpage</a>              <br>
                     </td>
                     <td>This is my running webpage, it is still being worked on.</td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="RaceResults/index.php">My Race Results</a>              <br>
                     </td>
                     <td>These are all of my race results</td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="http://vojta.users.sonic.net/Sonic/ConferenceBridge.php">Conference Bridge</a>              <br>
                     </td>
                     <td>Connects multiple phone calls to one group call.</td>
                  </tr>
                  <tr>
                     <td scope="row">
                        <a href="https://hopper.csustan.edu/~vripa/vojtaripa/vojtaripa.html">Old Webpage</a>              <br>
                     </td>
                     <td>Old Website I made in College</td>
                  </tr>
                  <tr>
                     <td width="20%" scope="row">
                        <a href="verigate/index.html">Verigate</a>              <br>
                     </td>
                     <td>This tool helps determine how many pairs of copper a customer will need to get the desired internet speed based on their distance away from the CO</td>
                  </tr>
                  <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>
         </div>
         </table>
		 <!--****************************************************************************** -->
		 <br>
		 <br>
		 <header>
         <h2 id="useful">Useful Sites and Projects</h2>
		 <p>Below are userful links to sites </p>
		 </header>
		 
         <table>
         <tr>
         <th>Website</th>
         <th>Purpose</th>
         </tr>
         <tr>
         <td><a href="https://jsfiddle.net/user/vojtaripa/fiddles/">JsFiddle</a></td>
         <td>Link to my projects on JS Fiddle which is for testing html, CSS, javascript and jQuery. </td>
         </tr>
         <tr>
         <td><a href="https://github.com/vojtaripa">GitHub</a></td>
         <td>Link to my projects on GitHub which is a code hosting platform for version control and collaboration. </td>
         </tr>
         <tr>
         <td><a href="https://tampermonkey.net/?ext=dhdg&browser=chrome">Tampermonkey</a></td>
         <td>Link to Tampermonkey used to run custom JavaScript code on webpages. </td>
         </tr>
         <tr>
         <td><a href="https://stackoverflow.com/users/8292172/vojta-ripa">StackOverflow</a></td>
         <td>Link to StackOverflow, a Form used to Ask and Answer Programming Questions. </td>
         </tr>
         <tr>
         <td><a href="https://autohotkey.com/">AutoHotkey</a></td>
         <td>AutoHotkey is a free, open-source scripting language for Windows that allows users to easily create small to complex scripts for all kinds of tasks such as: form fillers, auto-clicking, macros, etc.. </td>
         </tr>
         <tr>
         <td><a href="https://daneden.github.io/animate.css/">Cool JS Effects</a></td>
         <td>Experiencing different CSS styles ect. and Javascript Animation. </td>
         </tr>
		 <tr>
         <td><a href="http://phpfiddle.org/">PHP Fiddle</a></td>
         <td>A test area that can be used to make simple PHP related projects on a public server. </td>
         </tr>
		 <tr>
         <td><a href="https://www.codingforentrepreneurs.com/projects/">Coding Tutorials</a></td>
         <td>Step-by-step to learn and launch your web project. </td>
         </tr>
		 <tr>
         <td><a href="https://pages.github.com/">GitHub Pages</a></td>
         <td>Hosted directly from your GitHub repository. Just edit, push, and your changes are live. </td>
         </tr>
         </table>
      </div>
      </section>	
      <!--Comments -->
      <section id="cta" class="wrapper style4">
         <div class="inner">
            <!--<h2>Comments:</h2>
               <p>Please let me know what else you would like to see, I can change, modify, add anything; Open to suggestions!<br></p>-->
            <div style="color:white;" id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">Comment Form</a> is loading comments...</div>
            <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
            <script type="text/javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=hcb_user.PAGE || (""+window.location).replace(/'/g,"%27"), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&mod=%241%24wq1rdBcg%24DnRxkqNQmUnhoputqLMl10"+"&opts=16862&num=10&ts=1499300164544");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
            <!-- end www.htmlcommentbox.com -->
         </div>
      </section>
      <!-- Footer -->
      <footer id="footer" class="nav">
         <style>
            .nav li a {
            font-family: FontAwesome;
            color:#eee;
            font-size:22pt;
            text-decoration: none;
            display: block;
            padding:15px;
            }
            .nav li i {
            color:#fff;
            padding:0 15px;
            }
            .nav li b {
            padding:0 15px;
            display: none;
            }
            .nav a:hover {
            color: #fff;
            }
            .nav a:hover i {
            display: none;
            }
            .nav a:hover b {
            display: block;
            }
         </style>
         <!--DONATE-->
         <a  href="https://paypal.me/VojtaR" ><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk9WBW530XSss5VaG3JiJdj6pz2upM8o3XA-ntd_cuEoM1j7NW" ></a>
         <!--EMOJIS https://www.emojicopy.com/ -->
         <!--ICONS: http://fontawesome.io/icons/-->
         <ul class="icons">
            <li><a href="https://www.strava.com/athletes/7494937"> <i class="icon fa-road"></i><b><span class="label"> Strava</span></b></a></li>
            <li><a href="https://www.facebook.com/vojta.ripa"> <i class="icon fa-facebook"></i><b><span class="label">Facebook</span></b></a></li>
            <li><a href="https://www.instagram.com/vojtaripa/" > <i class="icon fa-instagram"></i><b><span class="label">Instagram</span></b></a></li>
            <li><a href="https://www.youtube.com/user/vojtaripa?feature=guide" > <i class="icon fa-youtube"></i><b><span class="label">YouTube</span></b></a></li>
            <li><a href="https://www.youtube.com/user/vojtaripa?feature=guide" > <i class="icon fa-linkedin-square"></i><b><span class="label">Linked In</span></b></a></li>
            <li><a href="pages/signup.php" > <i class="icon fa-envelope-o"></i><b><span class="label">Email</span></b></a></li>
         </ul>
         <ul class="copyright">
            <li>&copy; <?php echo date("Y"); ?> <a href="http://vojta.users.sonic.net/blog/">Vojta Ripa</a>, Inc. </li>
         </ul>
      </footer>
      </div>
      <!-- Scripts -->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/jquery.scrollex.min.js"></script>
      <script src="assets/js/jquery.scrolly.min.js"></script>
      <script src="assets/js/skel.min.js"></script>
      <script src="assets/js/util.js"></script>
      <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
      <script src="assets/js/main.js"></script>
   </body>
</html>
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


<link type = "text/css" rel = "stylesheet" href = "../main.css" />


<h1>Result Query</h1>
<div id="layout1">
<a href = "http://sonic.net/~vojta/finishline/">Home</a>
<h2>Your Request is: </h2>


<?php
		//require_once('../database.php');
		echo ' ';
		echo "<h2>".($_GET["user"]) ."</h2>" ; //outputs what user put in
		
        //session_start();
        //include ('info.php');

        $dsn = 'mysql:host=vojta-data.db.sonic.net;dbname=vojta_data';
		$username = 'vojta_data-all';
		$password = '590d05cd';
		
		$dbconnect = mysql_connect($dsn, $username, $password); //uses my password to get in database
        if(!dbconnect)
                echo "Could not open database"; //if log-in fails then say ...

        //select database
		$db = mysql_select_db("vojta_data", $dbconnect); //connect to database and select vojta_data as the database in phpMyAdmin
        if(!$db)
        {
                echo "Could not open info"; //if it cant be opened say so. 
                exit;
        }

		//gets query from address
		$myQuery = $_GET["user"];
		$myQuery = "$myQuery";
		
		//need to replace \ char with nothing.
		$myQuery= str_replace("\\","",$myQuery);
		echo "executing query: $myQuery";
		
		$res = mysql_query($myQuery); //$_GET["user"]
		
				
		$regex = "/^[select]|[Select]|[SELECT]/";
		
		//$regex = "/[a-zA-Z]+ \d+/";
		if (preg_match($regex, $myQuery)==FALSE)
		{
			  echo "Query must start with 'select'"; //if it cant be opened say so. 
              exit;
		}
		if ($myQuery==null || $res==null)
		{
			echo "<br><br>Sorry no results found.";
		}

		else
		{
			echo "<table border='1'>";
			// HEADERS
			echo "<tr>";
			for($i = 0; $i < mysql_num_fields($res); $i++) //$res
			{
				echo '<th>' . mysql_field_name($res, $i) . '</th>'; //$res
			}
			echo "</tr>";
			
			
			//TUPLES/ ROWS
			
			while($row = mysql_fetch_row($res)) 
			{
				echo "<tr>";
				foreach($row as $_column) 
				{
					echo "<td> $_column </td>";
				}
				echo "</tr>";
			}
			
			echo "</table>";
		}

		mysql_close($dbconnect); //closes connection

?>
</div>
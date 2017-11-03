<?php

require_once('database.php');

/*
DistanceID
Name
DistanceMascot
*/

// Get all Distance

$query = 'SELECT * FROM MyDistances ORDER BY Distance';

$statement = $db->prepare($query);

$statement->execute();

$Distance = $statement->fetchAll();

$statement->closeCursor();

?>

<!DOCTYPE html>

<html>



<!-- the head section -->

<head>

    <title>Race Distance Translations</title>

    <link rel="stylesheet" type="text/css" href="../main.css" />

</head>



<!-- the body section -->

<body>


<main>

<center>
   <span class="myButtons" style="display: inline;">
   
   <h2> Links: </h2>
   
   <a class="button" href="login.php" >Admin</a> <!--indexAdmin.php -->
   <a class="button" href="../index.php" >View All Users</a>
   <a class="button" href="functions.php">Other Functions / Conversions</a>
   <a class="button" href="distance_list.php" style="background-color:red;" >List distances</a>     
   <a class="button" href="signup.php" >Sign up for updates</a>
   
   <a class="button" href="http://vojta.users.sonic.net/blog/"> Vojta's Main Page </a>
   <a class="button" href="about.html">Vojta's Bio</a>
   
   </span>
   
    <br>
   <hr  >
   <br>
<header><h1>Race Distance Translations</h1></header>



    <h1>Here are the different distance I chose to translate to the common name</h1>

    <table>

        <tr>
            <th>Distance</th>
            <th>Distance Name</th>

        </tr>
  <?php foreach ($Distance as $Distance) : ?>
        <tr>
            <td><?php echo $Distance['Distance']; ?></td>
			<td><?php echo $Distance['distName']; ?></td>
        </tr>
        <?php endforeach; ?>    
   
    </table>
</center>

    <br>

    <p><a href="../index.php">Home</a></p>

    </main>



    <footer>

        <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, Inc.</p>

    </footer>

</body>

</html>
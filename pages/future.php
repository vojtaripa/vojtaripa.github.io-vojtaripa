<?php
require_once ('database.php');

//NEED TO GET ALL FUTURE RACE DATA:
	
	$queryraces = 'SELECT * FROM futureRaces';
	$statement1 = $db->prepare($queryraces);
	$statement1->execute();
	$Races = $statement1->fetchAll(); //ARRAY of races. 
	$statement1->closeCursor();

?>


<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
	<script src="sorttable.js"></script> <!-- FOR SORTING TABLES!!! -->
    <title>Here Are All My Race Results</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style> 
		h2   {text-shadow: 1px 5px 5px #FF0000; color: white}  
	</style>
</head>

<!-- the body section -->
<body>


<main>

<!-- FUTURE RACES --------------------------------------------------------------------------------------------------------------------->
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
</center>


  
  <div id="myDIV" class="header  AddRace">
  <h2>Here are my future races I would like to run</h2>
  <input type="text" id="AddRace" class="AddRace" value="<?php echo "Date: YYYY-MM-DD Race Name: <race name>" ?>">
  <span onclick="newElement()" class="addBtn AddRace">Add</span>
  
	</div>
	
<br>	
<button class="button" onclick="sortList()">Sort</button>
<br>
<form action="ProcessFuture.php" method="post" id="process_future" enctype="multipart/form-data">


  <center>
  <h1><u> TO DO Races: </u></h1>
  <!-- Pointing to new page that will communicate with DB and inputs this data in...  ----------------------------------->
  <!--<span onclick="window.location.assign('ProcessFuture.php')" class="addBtn AddRace">Save All</span> -->
  <!-- Reloads Page ----------------------------------->
  </center>
  
  <ol class="AddRace" id="myUL" >
  <?php
  //NOW SPIT OUT RACES:
  	 foreach ($Races as $Race) : 
		if($Race['done']=="0")
			$checked = "checked";
		else
			$checked = "";
	 
		echo"<li class='AddRace ". $checked ."' name='". $Race['Index'] ."'>";
			 echo "<b> Date: </b>". $Race['date'] . "<b>   Race Name: </b>". $Race['race'] . ""; 
		echo"</li>";
     endforeach; 
  
  ?>
  </ol>
	
	<input id="amount" value="0" type=hidden name="amount"></input>
	<br><br>
	   <span onclick="location.reload()" class="button">Clear</span> <input class="button"  value="Submit" type="submit"  id="submit"> <!--value="Submit" type="submit"-->
</form>
<br>
<!--<button class="button" id="inputs">Get Inputs</button> intermediate button, how im having submit handle this function -->

	<br>
	<br>
	<p style="display: inline;"><a class="button" href="../index.php" >Back Home to Races</a></p>
	


	
<!-- JAVASCRIPT --------------------------------------------------------------------------------------->
<script>
function sortList() {
  var list, i, switching, b, shouldSwitch;
  list = document.getElementById("myUL");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    b = list.getElementsByTagName("LI");
    //Loop through all list-items:
    for (i = 0; i < (b.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*check if the next item should
      switch place with the current item:*/
      if (b[i].innerHTML.toLowerCase() > b[i + 1].innerHTML.toLowerCase()) {
        /*if next item is alphabetically
        lower than current item, mark as a switch
        and break the loop:*/
        shouldSwitch= true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark the switch as done:*/
      b[i].parentNode.insertBefore(b[i + 1], b[i]);
      switching = true;
    }
  }
}
</script>
	
	
	<script>	
	// Create a "close" button and append it to each list item (WORKS)
	var myNodelist = document.getElementsByTagName("LI");
	var i;
	for (i = 0; i < myNodelist.length; i++) {
	  var span = document.createElement("SPAN");
	  var txt = document.createTextNode("\u00D7");
	  span.className = "close";
	  span.appendChild(txt);
	  myNodelist[i].appendChild(span);
	}

	// Click on a close button to hide the current list item (WORKS)
	var close = document.getElementsByClassName("close");
	var i;
	for (i = 0; i < close.length; i++) {
	  close[i].onclick = function() {
		var div = this.parentElement;
		//div.style.display = "none";
		div.remove();
	  }
	}

	// Add a "checked" symbol when clicking on a list item (WORKS)
	var list = document.querySelector('ol');
	list.addEventListener('click', function(ev) 
	{
	  if (ev.target.tagName === 'LI') 
	  {
		ev.target.classList.toggle('checked');
	  }
	}, false);

	// Create a new list item when clicking on the "Add" button (WORKS)
	function newElement()
	{
	  var li = document.createElement("li");
	  li.className ="AddRace";
	  var inputValue = document.getElementById("AddRace").value;
	  var t = document.createTextNode(inputValue);
	  li.appendChild(t);
	  if (inputValue === '') 
	  {
		  alert("You must write something!"); //shows alert on screen.
	  } 
	  else if (!(/^Date:/.test(inputValue ))) 
	  {
		  alert("Please see proper format!"); //shows alert on screen.
	  }
	  else 
	  {
		document.getElementById("myUL").appendChild(li);
	  }
	  document.getElementById("AddRace").value = "";

	  var span = document.createElement("SPAN");
	  var txt = document.createTextNode("\u00D7");
	  span.className = "close";
	  span.appendChild(txt);
	  li.appendChild(span);

	  for (i = 0; i < close.length; i++) 
	  {
		close[i].onclick = function() 
		{
		  var div = this.parentElement;
		  div.style.display = "none";
		}
	  }
	}
	
	</script>
	


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js">
</script>
<script>
$(document).ready(function()
{
    var $amount=0;
	
	$("#submit").click(function()
	{
        //$("li").toggle();
		$("li").each(function()
		{		
				//gets all table data 
				var $InputVal = $(this).text();
				var $checked  = $(this).attr('class'); //CSS PROPERTY
				
				
				var	$newli = $("<br><input  id='"+ $amount +"' name='race"+ $amount +"' type=hidden></input>"); //type=hidden
                var $newCHECKEDinput = $("<br><input  id='checked"+ $amount +"' name='checked"+ $amount +"' type=hidden></input>"); //type=hidden
				
								
				//adding it to header
				$newli.val($InputVal).text($InputVal).appendTo(this);
			    $newCHECKEDinput.val($checked).text($checked).appendTo(this); // NEED TO CHANGE
				
				
				$amount++;
		});
		
		$("#amount").val($amount);
		
    });
});
</script>



		

<?php
$username="vojtaripa";
// TO GET IN AS ADMIN AGAIN ***********************************************************************************  
$queryuser = 'SELECT * FROM users  WHERE username = :username ORDER BY idusers DESC limit 1'; 
$statement5 = $db->prepare($queryuser);
$statement5->bindValue(':username', $username);
$statement5->execute();
$theuser = $statement5->fetchAll();
$statement5->closeCursor();

$username = $theuser['0']['username'];
$password =	$theuser['0']['password'];
?>

</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, Inc.</p>
</footer>
</body>
</html>
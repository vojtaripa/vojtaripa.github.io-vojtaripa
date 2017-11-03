//JAVASCRIPT FOR RACE RESULTS:
        
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
		
		function TimeH(inputTime) 
		{	
			//echo nl2br("Seconds are now: $Seconds \n"); 00:00:00
			var Hours=0;
			
			Hours = inputTime.substring(2, 0);

			return Hours;
		}
		function TimeM(inputTime) 
		{	
			//echo nl2br("Seconds are now: $Seconds \n");
			var  Minutes=0;
			
			Minutes= inputTime.substring(5, 3);

			return Minutes;
		}
		function TimeS(inputTime) 
		{	
			//echo nl2br("Seconds are now: $Seconds \n");
			var Seconds=0;
			
			Seconds = inputTime.substring(8, 6);
						
			return Seconds;
		}
		
		// MY LIVE PACE CALCULATOR:
		//LINK: https://www.daniweb.com/programming/web-development/threads/305789/javascript-calculate-time-between-times
		function RecalculateElapsedTime (SpecificDist, desiredPR) 
		{
            //Gets distance
			var distance = document.getElementById (SpecificDist);
			var distVal= distance.value;
			
            //Initializes name if 4 changing fields		
			var hour   = "starttimehour";
			var minute = "starttimemin";
			var second = "starttimesec";
			var mypace = "elapsed";
			
			//Just adding distance to make ID name unique
			var hour   = hour.concat(SpecificDist);
			var minute = minute.concat(SpecificDist);
			var second = second.concat(SpecificDist);
			var mypace = mypace.concat(SpecificDist);
			
			//finds that element in this page
			var startHSelect = document.getElementById (hour);
            var startMSelect = document.getElementById (minute);
			var startSSelect = document.getElementById (second);					
			
			// convert string values to integers
			var startH = parseInt (startHSelect.value);
			var startM = parseInt (startMSelect.value);
			var startS = parseInt (startSSelect.value);	
			
			// create Date objects from start and end
			var start = new Date ();	// the current date and time, in local time.
			  var end = new Date ();

			//setting stand and end date (formatting) so we can use getTime() function
			start.setHours (startH, startM, startS);
			  end.setHours (00,     00,         00);
			
			//Now setting result AKA elapsed time
			var elapsedInS = start.getTime () - end.getTime ();
			
			//Gets total amount of sec.
			var totalSec = (elapsedInS / (1000*distVal));
			
			//uses function to convert sec to time again.
			var pace = SecondsToTime (totalSec);
			
			//Gets value of result field
			var elapsedSpan = document.getElementById (mypace);
							  
			
			//changes the value of the result field
			elapsedSpan.value = "" + (pace); //seconds //(elapsedInS / (1000*distVal) )   //.innerHTML
			//Feel ();
			//SelectTime($Times,$Timem,$Timeh); // this is PHP.. bleh..
			/*var testing = "time";
			var test = document.getElementById (testing.concat(SpecificDist));
			test.value = "" + (x);*/
						
        }
		
		//FIND THE DIFFERENCE BETWEEN TIMES / PACES
		function TimeDiff (SpecificDist, InputTime)
		{
			//Time I will get from the function at INPUTTIME, USERTIME will vary and ill have to get it from the input BOX.
			//Then I need to convert them to seconds, do subtraction, then convert them back? OR I can use use the PHP built in function?
			//Then copy the same for pace. 
            //document.write(InputTime, SpecificDist);
			//input are getting here!
			
			var testing = "time";		
			
			//Initializes name if 4 changing fields		
			var hour   = "starttimehour";
			var minute = "starttimemin";
			var second = "starttimesec";		
			
			//Just adding distance to make ID name unique
			var hour   =   hour.concat(SpecificDist);
			var minute = minute.concat(SpecificDist);
			var second = second.concat(SpecificDist);
			
			
			//finds that element in this page
			var startHSelect = document.getElementById (hour);
            var startMSelect = document.getElementById (minute);
			var startSSelect = document.getElementById (second);					
			
			// convert string values to integers
			var startH = parseInt (startHSelect.value);
			var startM = parseInt (startMSelect.value);
			var startS = parseInt (startSSelect.value);	
			
			//Getting array of 3 values, H, M, S
			//InputTime=TimeParse("00:01:01"); //TimeParse(InputTime)
					
			var H = InputTime.substring(2, 0);
			var M = InputTime.substring(5, 3);
			var S = InputTime.substring(8, 6);
			
			// create Date objects from start and end
			var start = new Date ();	// the current date and time, in local time.
			var   end = new Date ();

			//setting stand and end date (formatting) so we can use getTime() function
			start.setHours (startH, startM, startS); //00,00,49
			  end.setHours (H, M, S); //InputTime
			
			//Now setting result AKA elapsed time
			var elapsedInS =  end.getTime () - start.getTime ();
			elapsedInS = Math.abs(elapsedInS)
			
			//uses function to convert sec to time again.
			var totalSec = (elapsedInS / (1000));
			var time = SecondsToTime (totalSec); //totalSec
			
			
			//Gets value of result field
			var test = document.getElementById (testing.concat(SpecificDist));
	        //changes the value of the result field
			test.value = time;//"TIME: " + time + "INPUTTIME: " + H+":"+M+":"+S +"Start: " + startH+":"+ startM+":"+startS;	
			return time;
		}
				
		//FIND THE DIFFERENCE BETWEEN TIMES / PACES
		function PaceDifference (SpecificDist, InputTime)
		{
			//Time I will get from the function at INPUTTIME, USERTIME will vary and ill have to get it from the input BOX.
			//Then I need to convert them to seconds, do subtraction, then convert them back? OR I can use use the PHP built in function?
			//Then copy the same for pace. 
            //document.write(InputTime, SpecificDist);
			//input are getting here!
			
			//InputTime is not PACE
			
			var distance = document.getElementById (SpecificDist);
			var distVal= distance.value;
			
			var testing = "pace";		
			
			//Initializes name if 4 changing fields		
			var hour   = "starttimehour";
			var minute = "starttimemin";
			var second = "starttimesec";		
			
			//Just adding distance to make ID name unique
			var hour   =   hour.concat(SpecificDist);
			var minute = minute.concat(SpecificDist);
			var second = second.concat(SpecificDist);
			
			
			//finds that element in this page
			var startHSelect = document.getElementById (hour);
            var startMSelect = document.getElementById (minute);
			var startSSelect = document.getElementById (second);					
			
			// convert string values to integers
			var startH = parseInt (startHSelect.value);
			var startM = parseInt (startMSelect.value);
			var startS = parseInt (startSSelect.value);	
			
						
			//NOW I NEED TO GET PACE (first)
						// create Date objects from start and end
			var start = new Date ();	// the current date and time, in local time.
			  var end = new Date ();

			//setting stand and end date (formatting) so we can use getTime() function
			start.setHours (startH, startM, startS);
			  end.setHours (00,     00,         00);
			
			//Now setting result AKA elapsed time
			var elapsedInS = start.getTime () - end.getTime ();
			
			//Gets total amount of sec.
			var totalSec = (elapsedInS / (distVal*1000)); //*1000
			//NOW I HAVE total seconds of pace
			
			//uses function to convert sec to time again.
			
			//NOT RELAVENT ONLY FOR TESTING
			var paceTEST = SecondsToTime (totalSec);
			
			var paceH = paceTEST.substring(2, 0);
			var paceM = paceTEST.substring(5, 3);
			var paceS = paceTEST.substring(8, 6);
						
			
			// NOW I CAN SUBTRACT PACE calculated and pace given.
			// create Date objects from start and end
			var startPACE = new Date ();	// the current date and time, in local time.
			var   endPACE = new Date ();

	
			//Getting array of 3 values, H, M, S of PACE coming in as InputTime
			//InputTime=TimeParse("00:01:01"); //TimeParse(InputTime)
					
			var H = InputTime.substring(2, 0);
			var M = InputTime.substring(5, 3);
			var S = InputTime.substring(8, 6);
			
			//setting stand and end date (formatting) so we can use getTime() function
			startPACE.setHours (paceH, paceM, paceS); //00,00,49
			  endPACE.setHours (H, M, S); //InputTime
			
			//Now setting result AKA elapsed time
			var elapsedInSPACE =  endPACE.getTime () - startPACE.getTime();  // REPLACED!!!!! startPACE.getTime ()
			elapsedInSPACE = Math.abs(elapsedInSPACE)
			
			//uses function to convert sec to time again.
			var totalSecPACE = (elapsedInSPACE/1000 ); // /1000
			var paceX = SecondsToTime (totalSecPACE); //totalSec			
			
			//Gets value of result field
			var test = document.getElementById (testing.concat(SpecificDist));
	        //changes the value of the result field
			test.value =  paceX;//endPACE.getTime () +"-"+ startPACE.getTime (); //paceX; //H+":"+M+":"+S;//paceX; //WORKS:paceTEST; ////	
			return paceX;
		}
		
		//RUN IT WHEN VALUES CHANGE
        function Init () 
		{
			//Run pace calculator
			RecalculateElapsedTime ();
			//Run time difference function
			TimeDiff ();
			//Run pace difference function
			PaceDifference ();
        }
	
	
		//CHANGED HERE DOWN. ****************************************************************************** 
		function accordion ()
		{
			//THIS IS FOR HIDDEN DROPDOWN (ABOUT )
			var acc = document.getElementsByClassName("accordion");
			var i;

			for (i = 0; i < acc.length; i++) 
			{
				acc[i].onclick = function()
				{
					/* Toggle between adding and removing the "active" class,
					to highlight the button that controls the panel */
					this.classList.toggle("active");

					/* Toggle between hiding and showing the active panel */
					var panel = this.nextElementSibling;
					if (panel.style.display === "block") 
					{
						panel.style.display = "none";
					} 
					else 
					{
						panel.style.display = "block";
					}
				}
			}
		}
    
	//TABLE SEARCH
	function myFunction() 
	{
	  // Declare variables 
	  var input, filter, table, tr, td, i, year, th; //variables
	 
	 input = document.getElementById("myInput"); //gets value
	  filter = input.value.toUpperCase(); // what im searching for in uppercase
	 
	 table = document.getElementById("races"); //which table? races table
	  tr = table.getElementsByTagName("tr"); //gets each row.
	  
	  //year = document.getElementById("year"); 
	  //th = year.getElementsByTagName("th");
	  
	  //year2 = document.getElementById("year2"); 
	  //th2 = year.getElementsByTagName("th");
	  //th[0].innerHTML="";
	  //th[0].style.display ="";
	  
	  //year = tr.getElementById("year");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) 
	  {
		td = tr[i].getElementsByTagName("td")[3]; //NEEDS TO BE THE COLUMN NUMBER OF WHAT YOU WANT TO SEARCH!!!
			
		if (td) 
		{
		  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) 
		  {
			tr[i].style.display = "";
		  } 
		  else 
		  {
			tr[i].style.display = "none";
		  }
		} 
	  }
	  
	  //for headers
	  /*for (i = 0; i < 10; i++) 
	  {
			th[i].innerHTML="";    // gets rid of text
			th2[i].innerHTML="";    // gets rid of text
			//th[i].style.display =""; // gets rid of actual object
	  }*/
	}
	
	//Hide Rows
	function toggle() 
	{
	var input, filter, table, tr, td, i, year, th; //variables
	 
	 table = document.getElementById("races"); //which table? races table
	  tr = table.getElementsByTagName("tr"); //gets each row.

	 for (i = 0; i < tr.length; i++) 
	  {
		 if( document.getElementById("hidethis").style.display=='none' )
		 {
		   document.getElementById("hidethis").style.display = '';
		 }
		 else
		 {
		   document.getElementById("hidethis").style.display = 'none';
		 }
	  }
	}
	
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("myBtn").style.display = "block";
		} else {
			document.getElementById("myBtn").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
	
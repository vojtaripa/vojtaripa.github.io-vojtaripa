<?php
   //require_once('util/secure_conn.php');  // require a secure connection
	require_once('../captcha/appvars.php');
	require_once('../captcha/connectvars.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create an account / Sign-up</title>
        <link rel="stylesheet" type="text/css" href="../main.css"/>
    </head>
    
	
<body>		
        <main>
		
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
				
					<header>
						
						<h1>Sign-up Page</h1>
					</header>
					</center>
            <h1>Please Create a Login Account</h1>
			
			<center>



<!--IMAGE--------------------------------------------------------------------------------------->
		<h2>Image to be upload</h2>
        <form action="addLogin.php" method="post" id="login_form" enctype="multipart/form-data">
			
	
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
			<br>
			<h1 style='background-color:red; color:white'><u><b>STEP 1:</b></u><br> Please fill in the following,  follow format shown.</h1>	
			<!--<h3> Fill in the following, please follow format shown. </h3> 	-->
				
				<table>
								
                <tr>
				<td width="20%" scope="row"> <label><b style="color:red;font-size:25px;">*</b>Username        :</label></td>
                <td><input type="text" class="text" name="myusername" placeholder="username" required></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
                <label><b style="color:red;font-size:25px;">*</b>Password        :</label></td>
                <td><input type="password" pattern=".{6,}" class="text" name="password1" placeholder="password" required></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label><b style="color:red;font-size:25px;">*</b>Re-type password:</label></td>
                <td><input type="password" pattern=".{6,}" class="text" name="password2" placeholder="password" required></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label for="verify"><b style="color:red;font-size:25px;">*</b>Verification:</label></td>
				<td>
					<img src="captcha.php" alt="Verification pass-phrase" />
					<input type="text" id="verify" name="verify" value="" required placeholder="Enter whats above."/> 
				</td>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label><b style="color:red;font-size:25px;">*</b>First Name:</label></td>
                <td><input type="text" class="text" name="first_name" placeholder="Usain" required></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label><b style="color:red;font-size:25px;">*</b>Last Name:</label></td>
                <td><input type="text" class="text" name="last_name" placeholder="Bolt" required></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label>Email:</label></td>
                <td><input type="email" class="text" name="email" placeholder="devnull@sonic.com"></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label><b style="color:red;font-size:25px;">*</b>Gender:</label></td>
                <td>
					<input type="radio" name="gender" value="m"> Male<br>
					<input type="radio" name="gender" value="f"> Female<br>
				</td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label><b style="color:red;font-size:25px;">*</b>Age:</label></td>
                <td><input type="number"  min="1" max="99" class="text" name="age" placeholder="0" required></td>
                <br>
				</tr>
				
				<tr>
				<td width="20%" scope="row">
				<label>Link to your Strava / webpage:
				</td>
                <td><input type="url" name="webpage" placeholder="https://www.strava.com"></label></td>
                <br>
				</tr>
				
				 <tr>
				<td> <label>About you / Bio:</label></td>
			   <td> <textarea rows="8" cols="75" name="About" placeholder="About you..."> </textarea></td><br>
			   </tr>
				
				
				</table>
				<br><br>
                <label>&nbsp;</label>
				
				<input type="hidden" name="action" value="login">
				
                <input class="button" type="submit" value="Sign-up">
				<input class="button" type="reset">
            </form>
			
			
			<br><br>
			
			
			<h1>Already have an Account?</h1>
			<br>
			<a class="button" href="login.php" >Sign-in</a>
			<a class="button" href="../index.php" >View All Users</a>

            <p><?php echo $login_message;?></p>
			</center>
			
        </main>
		
		
	<footer>
        <p>&copy; <?php echo date("Y"); ?> Vojta Ripa, 2017, Inc.</p>
    </footer>
	
    </body>
</html>

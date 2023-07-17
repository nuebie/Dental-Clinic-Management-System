<?php
include "../../included/session.php";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/signup.css">
  </head>
  <body>
        <div class="signuptxt"><h1>Sign up here</h1></div><br>
		<div class="main">
			<a id="back" href="index.php"><b> &#8249; Go back </b></a>
			<div class="container2">
				<div class="pdeets">
					<form class="" action="../../process/addnewaccount.php" method="post">
						<h3>Personal Details</h3>
						<input type="text" class="fname" name="fname" value="" placeholder="First name"><br>
						<input type="text" class="lname" name="lname" value="" placeholder="Last name"><br>

						<input type="radio" id="male" name="gender" value="male">
            			<label for="male">Male</label>
            			<input type="radio" id="female" name="gender" value="female">
            			<label for="female">Female</label><br>
	
						<input type="date" class="birthdate" name="birthdate" value=""><br>
						<input type="text" class="contact_num" name="contact_num" value="" placeholder="Phone number"><br>
						<input type="email" class="email" name="email" value="" placeholder="Email"><br>
				</div>
				<div class="adeets">
						<h3>Account Details</h3>
						<input type="text" class="uname" name="username" value="" placeholder="username"><br>
						<input type="password" class="pword" name="password" value="" placeholder="password"><br>

						<div class="signupbtn"><input type="submit" class="signup" name="signup" value="Sign up"></div>

					</form>
					<p class="signupvalidation">
					<?php
						if(isset($_SESSION["error"])){
						$error = $_SESSION["error"];
						echo $error;
						unset( $_SESSION["error"]);
						}
					?>
					</p>
				</div>
			</div>
		</div>
  </body>
</html>

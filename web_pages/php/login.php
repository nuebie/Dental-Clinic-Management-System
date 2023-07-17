<?php
include "../../included/session.php";
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="../css/login.css">
   </head>
   <body>
     <h1>Log In</h1>
	 <a id="back" href="index.php"><b> &#8249; Go back </b></a>
	 <div id="box-overlay2"></div>
     <div class="input_form">
       <form class="loginfrm" id="loginfrm" action="../../included/session.php" method="post">
         <input type="text" class="uname" name="uname" id="username" value="" placeholder="username"><br>
         <input type="password" class="pword" id="password" name="pword" value="" placeholder="password"><br>
         <input type="submit" class="login" id="loginbtn" name="login" value="Login">
       </form>

       <p class="loginvalidation" id="loginvalidation">
         <?php
         if(isset($_SESSION["error"])){
           $error = $_SESSION["error"];
           echo $error;
           unset( $_SESSION["error"]);
         }
          ?>
       </p>

       No account?<br>
       <a href="signup.php">Sign up here</a>
     </div>
   </body>
 </html>

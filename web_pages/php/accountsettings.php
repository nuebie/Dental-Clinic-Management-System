<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];

if (is_null($userid)) {
  header("Location: login.php");
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        //UPDATE USER DETAIL
        $(document).on("click",'#updateuserdetail',function(){
          event.preventDefault();
          var form = $('#userdetailfrm')[0];
          var fd = new FormData(form);

          $.ajax({
            type: "POST",
            url: "../../process/edituserdetail.php",
            data: fd,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (data) {
              if (data == "SUCCESS") {
                location.reload();
              }

              else{
                 $("#uservalidation").empty().append(""+data+"");
              }
            }
          });
        });

        //UPDATE PASSWORD
          $(document).on("click",'#passwordbtn',function(){
            event.preventDefault();
            var current_pword = $("#current_pword").val();
            var new_pword = $("#new_pword").val();
            var userid = $("#userid").val();


            $.ajax({
              url:"../../process/editpassword.php",
              method:"POST",
              data:{current_pword: current_pword, new_pword: new_pword, userid: userid},
              success:function(data)
              {
                if (data == "FILL IN THE MISSING FIELDS" || data == "PASSWORD DOES NOT MATCH. TRY AGAIN.") {
                $("#passwordvalidation").empty().append(""+data+"");
                }

              else{
                location.reload();
                }
              }
            });
          });

      });
  </script>
  </head>
  <body>
    <h1>Account Settings</h1>
	<div class="main">


    <?php
    //FETCH
    $sql = "SELECT * FROM user where userid = '$userid'";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
      while ($user = mysqli_fetch_assoc($res)){
          $originalusername = $user['username'];
          $username = $user['username'];
          $contactnum = $user['contactnum'];
      }
    }
     ?>
		<br>
      <h3>User Details</h3>
      <form id="userdetailfrm" method="post">
        <input type="hidden" name="userid" id="userid" value="<?=$userid?>">
        <input type="hidden" name="originalusername" id="originalusername" value="<?=$originalusername?>">
        Username: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" name="username" value="<?=$username?>"><br>
        Contact Number: &nbsp; <input type="text" name="contactnum" value="<?=$contactnum?>"><br>

       <input type="button" class ="btn1" id="updateuserdetail" name="" value="Save">

      </form>
      <p class="uservalidation" id="uservalidation"></p>


		<br>
      <h3>Password</h3>
        <form class="passwordfrm" method="post">
          Password: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="password" class="current_pword" id="current_pword" name="" value=""><br>
          New Password: &nbsp; <input type="password" class="new_pword" id="new_pword" name="" value=""><br>

          <input type="button" class="btn1" id="passwordbtn" name="passwordbtn" value="Save">

        </form>
        <p class="passwordvalidation" id="passwordvalidation"></p>


	</div>
  </body>
</html>

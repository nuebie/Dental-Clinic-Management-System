<?php
include_once "../../included/db_connection.php";
include_once "../../included/session.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];

if (is_null($userid)) {
  header("Location: login.php");
}

$sql = "SELECT * FROM user WHERE userid = '$userid' ";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0){
  while($user = mysqli_fetch_assoc($res)){
    $role = $user['role'];
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/dashboard.css">
    <title></title>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        //SEARCH FOR USER USING USERNAME
          $("#search").on("input", function(){
            var username = $(this).val();
            var strlength = $(this).val().length;

            $("#reloadsection").load("../../process/usersearch.php", {
              username: username,
              strlength : strlength
              });
            });

        //CHANGE A USER'S ROLE
          $(document).on("change",'select',function(){
            var role = $(this).val();
            var userid = $(this).attr("id");

            $.ajax({
              url:"../../process/changeuserrole.php",
              method:"POST",
              data:{newrole:role, userid:userid},
              success:function(data)
              {
                if (data == 1) {
                location.reload();
                }
                else {
                alert("CANNOT CHANGE USER ROLE");
                }
              }
            });
          });

          //REMOVE USER
          $(document).on("submit",'form',function(){
            event.preventDefault();
            var userid = $("input[name='userid']",this).val();

            $.ajax({
              url:"../../process/deleteuser.php",
              method:"POST",
              data:{user:userid},
              success:function(data)
              {
                if (data == 1) {
                location.reload();
                }
                else {
                alert("CANNOT REMOVE USER");
                }
              }
            });
          });
        });
    </script>
  </head>
  <body>
	<h1>Clinic Dashboard</h1>
	<div class="sidebar">
    <?php
      if ($role == "dentist") { ?>
        <a href="manageuser.php" class="active"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
    <?php  }
     ?>

     <?php
       if ($role == "staff") { ?>
         <a href="manageuser_staff.php" class="active"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
     <?php  }
      ?>

		<a href="manageappointment.php"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Appointments</a>
		<a href="manageservice.php"><i class="fas fa-tooth"></i>&nbsp;&nbsp; Services</a>
		<a href="managetreatment.php"><i class="fas fa-hand-holding-medical"></i>&nbsp; Treatments</a>

    <?php
      if ($role == "dentist") { ?>
        <a href="manageprescription.php"><i class="fas fa-clipboard"></i>&nbsp;&nbsp; Prescriptions</a>
    <?php  }
     ?>

		<a href="appointmentschedule.php"><i class="far fa-clock"></i>&nbsp;&nbsp;Appointment Time</a>
	</div>
	<div class="section">
    <form class="usersearchfrm" action="index.html" method="post">
      <input type="text" name="" value="" id="search" placeholder="Search User by Username">
    </form>

    <div class="" id="reloadsection">
      <table>
        <tr>
          <th>Username</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Gender</th>
          <th>Birth date</th>
          <th>Email</th>
          <th>Contact</th>
        </tr>

        <?php
        //GET USER INFORMATION
        $sql = "SELECT * FROM user";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) > 0){

          while($user = mysqli_fetch_assoc($res)){
            $userid2 = $user['userid'];
            $username = $user['username'];
            $birthdate = $user['birthdate'];
            $fname = $user['fname'];
            $lname = $user['lname'];
            $role = $user['role'];
            $gender = $user['gender'];
            $email = $user['email'];
            $contactnum = $user['contactnum'];

            echo '<tr>';
            echo '<td>'.$username.'</td>';
            echo '<td>'.$fname.'</td>';
            echo '<td>'.$lname.'</td>';
            echo '<td>'.$gender.'</td>';
            echo '<td>'.$birthdate.'</td>';
            echo '<td>'.$email.'</td>';
            echo '<td>'.$contactnum.'</td>';

            //IF CURRENT ROLE OF USER IS REGULAR USER
            if ($role == "regular_user") {
              $opprole1 = "staff";
              $opprole2 = "dentist";
              echo '<td>
              <select id="'.$userid2.'">
                <option>'.$role.'</option>
                <option>'.$opprole1.'</option>
                <option>'.$opprole2.'</option>
              </select>
             </td>';
              }

            //IF THE CURRENT ROLE OF USER IS STAFF
            if ($role == "staff") {
              $opprole1 = "regular_user";
              $opprole2 = "dentist";
              echo '<td>
              <select id="'.$userid2.'">
                <option>'.$role.'</option>
                <option>'.$opprole1.'</option>
                <option>'.$opprole2.'</option>
              </select>
              </td>';
              }

              //IF THE CURRENT ROLE OF USER IS DENTIST
              if ($role == "dentist") {
                $opprole1 = "regular_user";
                $opprole2 = "staff";
                echo '<td>
                <select id="'.$userid2.'">
                  <option>'.$role.'</option>
                  <option>'.$opprole1.'</option>
                  <option>'.$opprole2.'</option>
                </select>
                </td>';
                }


            echo '<td class="td_btn">
              <form class="removefrm" action="index.html" method="post">
                <input type="hidden" name="userid" value="'.$userid2.'">
                <input type="submit" class="btnx" name="" value="Remove">
              </form>
              </td>';
            echo '</tr>';

          }
        }
         ?>
      </table>
    </div>
	</div>
  </body>
</html>

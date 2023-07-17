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
           var appointschedid;

           $("#addnewtimediv").hide();
           $("#updatetimediv").hide();

           //ADD NEW TIME BUTTON IS CLICKED
           $(document).on("click",'#add',function(){
             $("#addnewtimediv").show();
          });

          //DELETE EXISTING TIME
          $(document).on("click","[id^=delete]",function(){
            event.preventDefault();
            var appointschedid = $(this).val();

              $.ajax({
                url:"../../process/deleteappointmenttime.php",
                method:"POST",
                data:{appointschedid:appointschedid},
                success:function(data)
                {
                  if (data == 1) {
                  location.reload();
                  }
                  else {
                  alert("CANNOT DELETE THIS APPOINTMENT TIME");
                  }
                }
              });
            });

            //EDIT EXISTING TIME
            $(document).on("click","[id^=edit]",function(){
              appointschedid = $(this).val();
              $("#updatetimehidden").val(appointschedid);
              $("#updatetimediv").show();


            });



         });
     </script>
   </head>
   <body>
	<h1>Clinic Dashboard</h1>
	<div class="sidebar">
    <?php
      if ($role == "dentist") { ?>
        <a href="manageuser.php"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
    <?php  }
     ?>

     <?php
       if ($role == "staff") { ?>
         <a href="manageuser_staff.php"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
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

		<a href="appointmentschedule.php" class="active"><i class="far fa-clock"></i>&nbsp;&nbsp;Appointment Time</a>
	</div>
	<div class="section">
     <div class="addnewtimediv" id="addnewtimediv">
	 <h2>Add Time</h2>
       <form class="" action="../../process/manageappointmentschedule.php" method="post">
        Start time: <input class="time" type="time" name="starttime" value=""> <br>
        End time: &nbsp;&nbsp;<input class="time" type="time" name="endtime" value=""> <br><br>
        <input class="submit" type="submit" name="submit" value="Submit">
       </form><br>
		<a class="cancel" href="appointmentschedule.php">Cancel</a>
     </div>

     <div class="updatetimediv" id="updatetimediv">
		<h2>Edit Time</h2>
       <form class="" action="../../process/editappointmenttime.php" id="" method="post">
        Start time: <input class="time" type="time" name="starttime" value=""> <br>
        End time: &nbsp;&nbsp;<input class="time" type="time" name="endtime" value=""> <br>
        <input class="submit" type="hidden" name="appointschedid" id="updatetimehidden" value="">
        <input class="submit" type="submit" name="submit" value="Save">
       </form><br>
		<a class="cancel" href="appointmentschedule.php">Cancel</a>
     </div>

     <div class="">
       <table>
         <tr>
           <th>START TIME</th>
           <th>END TIME</th>
         </tr>

         <?php
         //RETRIEVE THE APPOINTMENT TIME
         $format = "%h:%i %p";
         $sql = "SELECT appointschedid, TIME_FORMAT(starttime, '$format') as starttime, TIME_FORMAT(endtime, '$format') as endtime FROM `appointment_schedule`";
         $retappointtime = mysqli_query($conn,$sql);

         if(mysqli_num_rows($retappointtime) > 0){

         while($appointment_schedule = mysqli_fetch_assoc($retappointtime)){
           $appointschedid = $appointment_schedule['appointschedid'];
           $starttime = $appointment_schedule['starttime'];
           $endtime = $appointment_schedule['endtime'];
           $concatenatesched = $starttime." - ".$endtime; //CONCATENATE START TIME AND END TIME ?>

           <tr>
             <td><?= $starttime?></td>
             <td><?= $endtime?></td>
             <td><button class="btn1" id="edit<?= $appointschedid?>" value="<?= $appointschedid?>">Edit</button>
				<button class="btnx" id="delete<?= $appointschedid?>" value="<?= $appointschedid?>">Delete</button></td>
           </tr>
      <?php   }
       }
          ?>
     </div>



     <div class="">
        <button id="add" value="add"><i class="fas fa-plus"></i>&nbsp;&nbsp; Add Time</button>
     </div>

	</div>
   </body>
 </html>

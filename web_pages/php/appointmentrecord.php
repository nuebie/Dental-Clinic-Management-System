<?php
include_once "../../included/db_connection.php";
include_once "../../included/session.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

          //IF A "CANCEL" BUTTON HAS BEEN CLICKED FOR PENDING APPOINTMENTS
          $(document).on("click", 'button', function () {
            var appointid = $(this).attr('id');

            $.ajax({
              url:"../../process/usercancelpendingappointment.php",
              method:"POST",
              data:{appointid:appointid},
              success:function(data)
              {
                if (data == 1) {
                location.reload();
                }
                else {
                alert("CANNOT CANCEL THIS APPOINTMENT");
                }
              }
            });
          });
        });
    </script>
    <title></title>
  </head>
  <body>
  <h1>Account</h1><br>
  <div class="main">
	<h2>Appointment Records</h2>
    <?php

    $sql = "SELECT * FROM appointment WHERE patientid = '$userid' ORDER BY appointid DESC";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
      while($appointment = mysqli_fetch_assoc($res)){
        $appointid = $appointment['appointid'];
        $appointdate = $appointment['appointdate'];
        $appointtimeid = $appointment['appointtime'];
        $status = $appointment['status'];
        $servid = $appointment['servid'];

        //FETCH THE CONCATENATED TIME
        $format = "%h:%i %p";
        $sql = "SELECT TIME_FORMAT(starttime, '$format') as starttime, TIME_FORMAT(endtime, '$format') as endtime FROM `appointment_schedule` WHERE appointschedid = '$appointtimeid' ";
        $time = mysqli_query($conn, $sql);

        if(mysqli_num_rows($time) > 0){
          while($schedule = mysqli_fetch_assoc($time)){
            $starttime = $schedule['starttime'];
            $endtime = $schedule['endtime'];
            $concatenatesched = $starttime." - ".$endtime;
          }
        }

        //FETCH SERVICE
        $sql_service = "SELECT * FROM service WHERE servid = '$servid'";
        $service_data = mysqli_query($conn,$sql_service);

        if(mysqli_num_rows($service_data) > 0){
          while($service = mysqli_fetch_assoc($service_data) ){
            $servname = $service['servname'];
          }
        }

        ?>

        <div class="box-overlay2">
          Appointment Date: <?=$appointdate?><br>
          Time: <?=$concatenatesched?><br>
          Service: <?=$servname?><br>
          Status: <?=$status?><br><br>

          <?php
            if ($status == "pending") {
              echo '<button class="btncncl" id='.$appointid.'>Cancel</button>';
            }
           ?>
		</div>

      <?php }
    }
     ?>
	 </div>
  </body>
</html>

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

          //SEARCH FOR PATIENT USING NAME
            $("#search").on("input", function(){
              //$("#filterstatus").val("Select").change();
              var name = $(this).val();
              var strlength = $(this).val().length;

              $("#reloadsection").load("../../process/appointmentsearch.php", {
                name: name,
                strlength : strlength
                });
              });

          //FILTER APPOINTMENT BY STATUS
            $("#filterstatus").change(function(){
              var appointmentstatus = $(this).val();
              $("#reloadsection").load("../../process/appointmentfilter.php", {
              appointmentstatus: appointmentstatus
              });
            });

          //IF A "STATUS" BUTTON HAS BEEN CLICKED
          $(document).on("click", 'button', function () {
            var appointid = $(this).attr('id');
            var newstatus = $(this).val();

            /*$.ajax({
              url:"../../process/reloadmanageappointment.php",
              method:"POST",
              data:{appointid:appointid, newstatus:newstatus},
              success:function(data)
              {
                if (data == 1) {
                location.reload();
                }
                else {
                alert("CANNOT DELETE THIS SERVICE");
                }
              }
            });*/

            $("#reloadsection").load("../../process/reloadmanageappointment.php", {
               appointid: appointid,
               newstatus: newstatus
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
        <a href="manageuser.php"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
    <?php  }
     ?>

     <?php
       if ($role == "staff") { ?>
         <a href="manageuser_staff.php"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
     <?php  }
      ?>

		<a href="manageappointment.php" class="active"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Appointments</a>
		<a href="manageservice.php"><i class="fas fa-tooth"></i>&nbsp;&nbsp; Services</a>
		<a href="managetreatment.php"><i class="fas fa-hand-holding-medical"></i>&nbsp; Treatments</a>

    <?php
      if ($role == "dentist") { ?>
        <a href="manageprescription.php"><i class="fas fa-clipboard"></i>&nbsp;&nbsp; Prescriptions</a>
    <?php  }
     ?>

		<a href="appointmentschedule.php"><i class="far fa-clock"></i>&nbsp;&nbsp;Appointment Time</a>
	</div>
    <div class="section" id="divappointmentsection">
      <input type="text" name="" value="" id="search" placeholder="Search">

      <select class="" name="" id="filterstatus">
        <option value="Select">Select</option>
        <option>pending</option>
        <option>treated</option>
        <option>cancelled</option>
      </select>

      <div id="reloadsection">
        <table>
          <tr>
            <th>PATIENT</th>
            <th>SERVICE</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>STATUS</th>
          </tr>
          <?php

            //RETRIEVE THE APPOINTMENT RECORDS
            $sql = "SELECT * FROM appointment ORDER BY appointid DESC";
            $res = mysqli_query($conn,$sql);

            if(mysqli_num_rows($res) > 0){

            while($appointment = mysqli_fetch_assoc($res)){
              $appointid = $appointment['appointid'];
              $patientid = $appointment['patientid'];
              $servid = $appointment['servid'];
              $appointdate = $appointment['appointdate'];
              $appointschedid = $appointment['appointtime'];
              $status = $appointment['status'];

              //RETRIEVE THE PATIENT NAME
              $sql = "SELECT * FROM user WHERE userid = '$patientid'";
              $retuser = mysqli_query($conn,$sql);

              if(mysqli_num_rows($retuser) > 0){

              while($user = mysqli_fetch_assoc($retuser)){
                $fname = $user['fname'];
                $lname = $user['lname'];
                $fullname = $fname." ".$lname; //CONCATENATE FIRST NAME AND LAST NAME
              }
            }

              //RETRIEVE THE SERVICE NAME
              $sql = "SELECT * FROM service WHERE servid = '$servid'";
              $retserv = mysqli_query($conn,$sql);

              if(mysqli_num_rows($retserv) > 0){

              while($service = mysqli_fetch_assoc($retserv)){
                $servname = $service['servname'];
              }
            }

              //RETRIEVE THE APPOINTMENT TIME
              $format = "%h:%i %p";
              $sql = "SELECT TIME_FORMAT(starttime, '$format') as starttime, TIME_FORMAT(endtime, '$format') as endtime FROM `appointment_schedule` WHERE appointschedid = '$appointschedid' ";
              $retappointtime = mysqli_query($conn,$sql);

              if(mysqli_num_rows($retappointtime) > 0){

              while($appointment_schedule = mysqli_fetch_assoc($retappointtime)){
                $starttime = $appointment_schedule['starttime'];
                $endtime = $appointment_schedule['endtime'];
                $concatenatesched = $starttime." - ".$endtime; //CONCATENATE START TIME AND END TIME
              }
            }

              echo "<tr>";
                echo "<td>".$fullname."</td>";
                echo "<td>".$servname."</td>";
                echo "<td>".$appointdate."</td>";
                echo "<td>".$concatenatesched."</td>";
                echo "<td>".$status."</td>";

                //"STATUS" BUTTONS

                  // IF STATUS == "PENDING"
                  if ($status == "pending") {
                    echo '<td>
                    <button class="btn1" id="'.$appointid.'" value="confirmed">Confirm</button>
                    <button class="btnx" id="'.$appointid.'" value="cancelled">Cancel</button>
                    </td>';
                  }

                  // IF STATUS == "CONFIRMED"
                  if ($status == "confirmed") {
                    echo '<td>
                    <button class="btn1" id="'.$appointid.'" value="treated">Treated</button>
                    </td>';
                  }

              echo "</tr>";
            }
          }
           ?>
        </table>
      </div>
    </div>
  </body>
</html>

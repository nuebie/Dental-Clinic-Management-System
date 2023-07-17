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

           $("#newpresdiv").hide();

           //ADD NEW PRESCRIPTION BUTTON IS CLICKED
           $(document).on("click",'#add',function(){
             $("#newpresdiv").show();
          });

           //LOAD UPDATE FORM FOR PRESCRIPTION
           $(document).on("click","#edit",function(){
			 document.getElementById("updatepresdiv").style.display = "block";
             var presinfo = $(this).val();
             var split = presinfo.split("_");

             var presid = split[0];
             var patientfullname = split[1];
             var dentistfullname = split[2];
             var date = split[3];

             $("#updatepresdiv").load("../../process/loadprescriptiondetail.php", {
                presid: presid,
                patientfullname: patientfullname,
                dentistfullname: dentistfullname,
                date: date
             });

           });

           //ADD NEW PRESCRIPTION RECORD
           $(document).on("click",'#newpresbtn',function(){
             event.preventDefault();
             var form = $('#newpresfrm')[0];
             var fd = new FormData(form);

             $.ajax({
               type: "POST",
               url: "../../process/addnewprescription.php",
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
                    alert(data);
                 }
               }
             });
           });

           //UPDATE PRESCRIPTION RECORD
           $(document).on("click",'#updatepresbtn',function(){
             event.preventDefault();
             var form = $('#updatepresfrm')[0];
             var fd = new FormData(form);

             $.ajax({
               type: "POST",
               url: "../../process/editprescription.php",
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
                    alert(data);
                 }
               }
             });
           });

           //DELETE EXISTING PRESCRIPTION RECORD
           $(document).on("click","#delete",function(){
             event.preventDefault();
             var presid = $(this).val();

               $.ajax({
                 url:"../../process/deleteprescription.php",
                 method:"POST",
                 data:{presid:presid},
                 success:function(data)
                 {
                   if (data == 1) {
                   location.reload();
                   }
                   else {
                   alert("CANNOT DELETE THIS PRESCRIPTION");
                   }
                 }
               });
             });

             //SEARCH FOR PATIENT USING NAME
             $("#search").on("input", function(){
               var name = $(this).val();
               var strlength = $(this).val().length;

               $("#reloadsection").load("../../process/prescriptionsearch.php", {
                 name: name,
                 strlength : strlength
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

		<a href="manageappointment.php"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Appointments</a>
		<a href="manageservice.php"><i class="fas fa-tooth"></i>&nbsp;&nbsp; Services</a>
		<a href="managetreatment.php"><i class="fas fa-hand-holding-medical"></i>&nbsp; Treatments</a>

    <?php
      if ($role == "dentist") { ?>
        <a href="manageprescription.php" class="active"><i class="fas fa-clipboard"></i>&nbsp;&nbsp; Prescriptions</a>
    <?php  }
     ?>

		<a href="appointmentschedule.php"><i class="far fa-clock"></i>&nbsp;&nbsp;Appointment Time</a>
	</div>
	<div class="section">
    <div class="addsection" id="newpresdiv">
	<h2>Add Prescription</h2>
      <form class="" action="../../process/addnewprescription.php" id="newpresfrm" method="post">
        Date: <input class="date" type="date" name="date" id="date" value="">

        <select class="patient" name="patient" id="patient">
          <option value="0">- Select -</option>

          <?php
          //FETCH THE PATIENT NAMES
          $sql = " SELECT * from user";
          $retpatient = mysqli_query($conn,$sql);

          if(mysqli_num_rows($retpatient) > 0){
            while($user = mysqli_fetch_assoc($retpatient) ){
              $patientid = $user['userid'];
              $fname = $user['fname'];
              $lname = $user['lname'];
              $fullname = $fname." ".$lname;

              // OPTION
              echo '<option id="'.$patientid.'" value = "'.$patientid.'">'.$fullname.'</option>';
            }
          }
            ?>

        </select><br>

        Medicine Description: <br>
        <textarea name="med" rows="8" cols="80"></textarea> <br><br>

        <input class="submit" type="submit" id="newpresbtn" name="" value="Submit">


      </form><br>
		<a class="cancel" href="manageprescription.php">Cancel</a>
    </div>


    <div class="updatesection" id="updatepresdiv">

    </div>

    <button id="add" value="add"><i class="fas fa-plus"></i>&nbsp;&nbsp; Add Prescription</button>
    <input type="text" name="" value="" id="search" placeholder="Search">

    <div class="" id="reloadsection">
      <table>
        <tr>
          <th>PATIENT NAME</th>
          <th>DENTIST</th>
          <th>DATE</th>
        </tr>

        <?php
        //RETRIEVE PRESCRIPTIONS
        $sql = "SELECT * FROM prescription ORDER BY presid DESC";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) > 0){

        while($prescription = mysqli_fetch_assoc($res)){
          $presid = $prescription['presid'];
          $patientid = $prescription['patientid'];
          $dentistid = $prescription['dentistid'];
          $date = $prescription['date'];

          //FETCH PATIENT'S FULL NAME
          $sql = "SELECT * FROM user where userid = '$patientid' ";
          $userres = mysqli_query($conn,$sql);

          if(mysqli_num_rows($userres) > 0){

          while($user = mysqli_fetch_assoc($userres)){
            $fname = $user['fname'];
            $lname = $user['lname'];
            $patientfullname = $fname." ".$lname;
          }
        }

        //FETCH DENTIST FULL NAME
        $sql = "SELECT * FROM user where userid = '$dentistid' ";
        $userres = mysqli_query($conn,$sql);

        if(mysqli_num_rows($userres) > 0){

        while($user = mysqli_fetch_assoc($userres)){
          $fname = $user['fname'];
          $lname = $user['lname'];
          $dentistfullname = $fname." ".$lname;
        }
      }
          ?>

          <tr>
            <td><?= $patientfullname?></td>
            <td><?= $dentistfullname?></td>
            <td><?= $date?></td>

            <td><button class="btn1" id="edit" value="<?= $presid."_".$patientfullname."_".$dentistfullname."_".$date?>">Edit</button>
				<button class="btnx" id="delete" value="<?= $presid?>">Delete</button></td>
          </tr>
     <?php   }
      }
         ?>
    </div>
	</div>
  </body>
</html>

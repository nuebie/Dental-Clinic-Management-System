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

          $("#newtreatdiv").hide();

          //ADD NEW TREATMENT BUTTON IS CLICKED
          $(document).on("click",'#add',function(){
            $("#newtreatdiv").show();
         });

         //ADD NEW TREATMENT RECORD
         $(document).on("click",'#addnewtreat',function(){
           event.preventDefault();
           var form = $('#addnewtreatfrm')[0];
           var fd = new FormData(form);

           $.ajax({
             type: "POST",
             url: "../../process/addnewtreatment.php",
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
                  //$("#treatupdatevalidation").empty().append(""+data+"");
                  alert("CANNOT ADD NEW TREATMENT RECORD.");
               }
             }
           });
         });

          //IF A PATIENT HAS BEEN CHOSEN, LOAD THE APPOINTMENT DETAILS (DATE & SERVICE)
          $('#patient').change(function () {
            var patientid = $(this).val();
            //alert(patientid);
            $('#appointdetails').load("../../process/reloadappointmentdetails.php", {
               patientid: patientid
            });
          });

          //LOAD UPDATE FORM FOR TREATMENT
          $(document).on("click","#edit",function(){
			 document.getElementById("updatetreatdiv").style.display = "block";
            var treatinfo = $(this).val();
            var split = treatinfo.split("_");

            var treatid = split[0];
            var fullname = split[1];
            var servname = split[2];
            var appointdate = split[3];

            $("#updatetreatdiv").load("../../process/loadtreatmentdetail.php", {
               treatid: treatid,
               fullname: fullname,
               servname: servname,
               appointdate: appointdate
            });

          });

          //UPDATE TREATMENT RECORD
          $(document).on("click",'#updatetreatbtn',function(){
            event.preventDefault();
            var form = $('#updatetreatfrm')[0];
            var fd = new FormData(form);

            $.ajax({
              type: "POST",
              url: "../../process/edittreatment.php",
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
                   $("#treatupdatevalidation").empty().append(""+data+"");
                }
              }
            });
          });

          //DELETE EXISTING TREATMENT RECORD
          $(document).on("click","#delete",function(){
            event.preventDefault();
            var treatid = $(this).val();

              $.ajax({
                url:"../../process/deletetreatment.php",
                method:"POST",
                data:{treatid:treatid},
                success:function(data)
                {
                  if (data == 1) {
                  location.reload();
                  }
                  else {
                  alert("CANNOT DELETE THIS TREATMENT");
                  }
                }
              });
            });

            //SEARCH FOR PATIENT USING NAME
            $("#search").on("input", function(){
              var name = $(this).val();
              var strlength = $(this).val().length;

              $("#reloadsection").load("../../process/treatmentsearch.php", {
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
		<a href="managetreatment.php" class="active"><i class="fas fa-hand-holding-medical"></i>&nbsp; Treatments</a>

    <?php
      if ($role == "dentist") { ?>
        <a href="manageprescription.php"><i class="fas fa-clipboard"></i>&nbsp;&nbsp; Prescriptions</a>
    <?php  }
     ?>

		<a href="appointmentschedule.php"><i class="far fa-clock"></i>&nbsp;&nbsp;Appointment Time</a>
	</div>
	<div class="section">
    <div class="addsection" id="newtreatdiv">
      <form class="" action="" id="addnewtreatfrm" method="post">
		<h2>Add Treatment</h2>
        <select class="patient" name="patient" id="patient">
          <option value="0">- Select -</option>

          <?php
          //FETCH TREATED APPOINTMENTS
          $sql = " SELECT * from appointment where status = 'treated' AND hastreatment = 'no' ";
          $res = mysqli_query($conn,$sql);

          if(mysqli_num_rows($res) > 0){
            while($appointment = mysqli_fetch_assoc($res) ){
              $patientid = $appointment['patientid'];

              //FETCH THE PATIENT NAME WITH TREATED APPOINTMENT
              $sql = " SELECT * from user where userid = '$patientid' ";
              $retpatient = mysqli_query($conn,$sql);

              if(mysqli_num_rows($retpatient) > 0){
                while($user = mysqli_fetch_assoc($retpatient) ){
                  $fname = $user['fname'];
                  $lname = $user['lname'];
                  $fullname = $fname." ".$lname;

                  // OPTION
                  echo '<option id="'.$patientid.'" value = "'.$patientid.'">'.$fullname.'</option>';
                }
              }

          }
        }
        else {
          echo "NO ROWS";
        }
           ?>

        </select>

        <div class="appointdetails" id="appointdetails">
          Date:&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input class="text" type="text" name="appointdate" value=""><br>
          Treatment:&nbsp; <input class="text" type="text" name="service" value="">
          <input type="hidden" name="appointid" value="">
        </div>

        Teeth No/s:&nbsp; <input class="text" type="text" name="teethno" value=""><br>
        Treatment description:<br>
        <textarea name="treatdesc" rows="8" cols="80"></textarea> <br>
        Fee:&nbsp; <input class="text" type="number" name="fee" value=""><br><br>
        <input class="submit" type="submit" id="addnewtreat" name="submit" value="Submit">
      </form><br>
	  <a class="cancel" href="managetreatment.php">Cancel</a>
    </div><br>


    <div class="updatesection" id="updatetreatdiv">

    </div>

    <button id="add" value="add"><i class="fas fa-plus"></i>&nbsp;&nbsp; Add Treatment</button>
    <input type="text" name="" value="" id="search" placeholder="Search">

    <div class="" id="reloadsection">
      <table>
        <tr>
          <th>PATIENT NAME</th>
          <th>SERVICE</th>
          <th>DATE</th>
        </tr>

        <?php
        //RETRIEVE TREATMENT RECORDS
        $sql = "SELECT * FROM treatment ORDER BY treatid DESC";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) > 0){

        while($treatment = mysqli_fetch_assoc($res)){
          $treatid = $treatment['treatid'];
          $userid = $treatment['userid'];
          $appointid = $treatment['appointid'];

          //FETCH PATIENT'S FULL NAME
          $sql = "SELECT * FROM user where userid = '$userid' ";
          $userres = mysqli_query($conn,$sql);

          if(mysqli_num_rows($userres) > 0){

          while($user = mysqli_fetch_assoc($userres)){
            $fname = $user['fname'];
            $lname = $user['lname'];
            $fullname = $fname." ".$lname;
          }
        }

        //FETCH APPOINTMENT DATE
        $sql = "SELECT * FROM appointment where appointid = '$appointid' ";
        $appointres = mysqli_query($conn,$sql);

        if(mysqli_num_rows($appointres) > 0){

        while($appointment = mysqli_fetch_assoc($appointres)){
          $appointdate = $appointment['appointdate'];
          $servid = $appointment['servid'];

          //FETCH APPOINTMENT SERVICE
          $sql = "SELECT * FROM service where servid = '$servid' ";
          $servres = mysqli_query($conn,$sql);

          if(mysqli_num_rows($servres) > 0){

          while($service = mysqli_fetch_assoc($servres)){
            $servname = $service['servname'];
          }
        }
        }
      }
          ?>

          <tr>
            <td><?= $fullname?></td>
            <td><?= $servname?></td>
            <td><?= $appointdate?></td>

            <td><button class="btn1" id="edit" value="<?= $treatid."_".$fullname."_".$servname."_".$appointdate?>">Edit</button>
				<button class="btnx" id="delete" value="<?= $treatid?>">Delete</button></td>
          </tr>
     <?php   }
      }
         ?>
    </div>
	</div>
  </body>
</html>

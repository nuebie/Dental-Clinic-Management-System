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

          $("#newservdiv").hide();

          //ADD NEW SERVICE BUTTON IS CLICKED
          $(document).on("click",'#add',function(){
            $("#newservdiv").show();
         });

         //LOAD UPDATE FORM FOR SERVICE
         $(document).on("click","#edit",function(){
			document.getElementById("updateservdiv").style.display = "block";
           var servid = $(this).val();

           $("#updateservdiv").load("../../process/loadservicedetail.php", {
              servid: servid
           });
         });

         //ADD NEW SERVICE RECORD
         $(document).on("click",'#addservbtn',function(){
           event.preventDefault();
           var form = $('#newprodfrm')[0];
           var fd = new FormData(form);

           $.ajax({
             type: "POST",
             enctype: 'multipart/form-data',
             url: "../../process/addnewservice.php",
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

         //UPDATE SERVICE RECORD
         $(document).on("click",'#updateservbtn',function(){
           event.preventDefault();
           var form = $('#updateservfrm')[0];
           var fd = new FormData(form);

           $.ajax({
             type: "POST",
             enctype: 'multipart/form-data',
             url: "../../process/editservice.php",
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

         //DELETE EXISTING SERVICE
         $(document).on("click","#delete",function(){
           event.preventDefault();
           var servid = $(this).val();

             $.ajax({
               url:"../../process/deleteservice.php",
               method:"POST",
               data:{servid:servid},
               success:function(data)
               {
                 if (data == 1) {
                 location.reload();
                 }
                 else {
                 alert("CANNOT DELETE THIS SERVICE");
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
        <a href="manageuser.php"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
    <?php  }
     ?>

     <?php
       if ($role == "staff") { ?>
         <a href="manageuser_staff.php"><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Users</a>
     <?php  }
      ?>

		<a href="manageappointment.php"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Appointments</a>
		<a href="manageservice.php" class="active"><i class="fas fa-tooth"></i>&nbsp;&nbsp; Services</a>
		<a href="managetreatment.php"><i class="fas fa-hand-holding-medical"></i>&nbsp; Treatments</a>

    <?php
      if ($role == "dentist") { ?>
        <a href="manageprescription.php"><i class="fas fa-clipboard"></i>&nbsp;&nbsp; Prescriptions</a>
    <?php  }
     ?>

		<a href="appointmentschedule.php"><i class="far fa-clock"></i>&nbsp;&nbsp;Appointment Time</a>
	</div>
	<div class="section">
    <div class="addsection" id="newservdiv">
      <form class="newservform" action="../../process/addnewservice.php" id="newprodfrm" method="post" enctype="multipart/form-data">
			<h2>Add Service</h2>
            Service Name: <input class="text" type="text" name="serv_name" id="serv_name" value=""> <br>

            Service Image: <input type="file" id="file" name="serv_image" value=""> <br>

            Price: <input class="text" type="number" step="0.01" min=0 name="price" id="price" value="">  Per Tooth:<input type="checkbox" name="pertooth" value=""> <br>

            Service Description: <br>

            <textarea name="serv_description"  id="serv_description" rows="8" cols="80"></textarea> <br><br>

            <input class ="submit" type="submit" id="addservbtn" name="addservbtn" class="addserv" value="ADD NEW SERVICE">
            <input class="submit" type="reset" name="" value="CLEAR">

              <p class="servicevalidation" id="servicevalidation"></p>
          </form>
		  <a class="cancel" href="manageservice.php">Cancel</a>
    </div>

    <div class="updatesection" id="updateservdiv">

    </div>

    <button id="add" value="add"><i class="fas fa-plus"></i>&nbsp;&nbsp; Add Service</button>

    <div class="">
      <table>
        <tr>
          <th>SERVICE NAME</th>
          <th>SERVICE DESCRIPTION</th>
          <th>PRICE</th>
        </tr>

        <?php
        //RETRIEVE SERVICES
        $sql = "SELECT * FROM service";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) > 0){

        while($service = mysqli_fetch_assoc($res)){
          $servid = $service['servid'];
          $servname = $service['servname'];
          $servimage = $service['servimage'];
          $servdesc = $service['servdesc'];
          $price = $service['price'];
          $pertooth = $service['pertooth'];

          //SHORTENED SERVICE DESCRIPTION
          $substring = substr($servdesc,0,15);
          $shortdescription = $substring."...";?>

          <tr>
            <td><?= $servname?></td>
            <td><?= $shortdescription?></td>
            <td><?php
            echo $price;
            if ($pertooth == "yes") {
              echo " /tooth";
            }
             ?></td>

            <td><button class="btn1" id="edit" value="<?= $servid?>">Edit</button>
				<button class="btnx" id="delete" value="<?= $servid?>">Delete</button>
			</td>
          </tr>
     <?php   }
      }
         ?>
    </div>
	</div>
  </body>
</html>

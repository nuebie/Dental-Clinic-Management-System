<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
	<h2>Edit Prescription</h2>
     <?php
     if (isset($_POST['presid'])) {
       $presid = $_POST['presid'];
       $patientfullname = $_POST['patientfullname'];
       $dentistfullname = $_POST['dentistfullname'];
       $date = $_POST['date'];

       $sql = "SELECT * FROM prescription WHERE presid = '$presid'";
       $res = mysqli_query($conn,$sql);

       if(mysqli_num_rows($res) > 0){

       while($prescription = mysqli_fetch_assoc($res)){
         $med = $prescription['med'];
         ?>

         Patient:&nbsp; <b><?= $patientfullname?></b><br>
         Dentist:&nbsp; <b><?= $dentistfullname?></b><br>
         Date:&nbsp; <b><?= $date?></b>
         <form class="" action="../../process/edittreatment.php" id="updatepresfrm" method="post">
                <input type="hidden" name="presid" value="<?= $presid?>">
                Medicine Description: <br>
                <textarea name="med" rows="8" cols="80"><?= $med?></textarea> <br>

               <input class="submit" type="button" id="updatepresbtn" name="updatepresbtn" value="SAVE">
               <input class="submit" type="reset" name="" value="CLEAR">

                 <p class="presupdatevalidation" id="presupdatevalidation"></p>
         </form>
		<a class="cancel" href="manageprescription.php">Cancel</a>
     <?php }
         }
     }
      ?>
   </body>
 </html>

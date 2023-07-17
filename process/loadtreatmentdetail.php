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
	<h2>Edit Treatment</h2>
     <?php
     if (isset($_POST['treatid'])) {
       $treatid = $_POST['treatid'];
       $fullname = $_POST['fullname'];
       $servname = $_POST['servname'];
       $appointdate = $_POST['appointdate'];

       $sql = "SELECT * FROM treatment WHERE treatid = '$treatid'";
       $res = mysqli_query($conn,$sql);

       if(mysqli_num_rows($res) > 0){

       while($treatment = mysqli_fetch_assoc($res)){
         $teethno = $treatment['teethno'];
         $treatdesc = $treatment['treatdesc'];
         $fee = $treatment['fee'];
         ?>

         Patient:&nbsp; <b><?= $fullname?></b><br>
         Service:&nbsp; <b><?= $servname?></b><br>
         Date:&nbsp; <b><?= $appointdate?></b>
         <form class="" action="../../process/edittreatment.php" id="updatetreatfrm" method="post">
                <input type="hidden" name="treatid" value="<?= $treatid?>">
                Teeth no/s:&nbsp; <input class="text" type="text" name="teethno" value="<?= $teethno?>"><br>
                Treatment Description: <br>
                <textarea name="treatdesc" rows="8" cols="80"><?= $treatdesc?></textarea> <br>
                Fee:&nbsp; <input class="text" type="number" name="fee" value="<?= $fee?>"><br><br>


               <input class="submit" type="button" id="updatetreatbtn" name="updatetreatbtn" value="SAVE">
               <input class="submit" type="reset" name="" value="CLEAR">

                 <p class="treatupdatevalidation" id="treatupdatevalidation"></p>
         </form>
		<a class="cancel" href="managetreatment.php">Cancel</a>

     <?php }
         }
     }
      ?>
   </body>
 </html>

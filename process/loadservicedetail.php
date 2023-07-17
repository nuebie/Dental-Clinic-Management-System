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
	<h2>Edit Service</h2>
    <?php
    if (isset($_POST['servid'])) {
      $servid = $_POST['servid'];

      $sql = "SELECT * FROM service WHERE servid = '$servid'";
      $res = mysqli_query($conn,$sql);

      if(mysqli_num_rows($res) > 0){

      while($service = mysqli_fetch_assoc($res)){
        $servid = $service['servid'];
        $servname = $service['servname'];
        $servimage = $service['servimage'];
        $servdesc = $service['servdesc'];
        $price = $service['price'];
        $pertooth = $service['pertooth'];?>

        <form class="newservform" action="../../process/editservice.php" id="updateservfrm" method="post" enctype="multipart/form-data">
              <input type="hidden" name="servid" value="<?= $servid?>">
              <input type="hidden" name="filename" value="<?= $servimage?>">
              Service Name:&nbsp; <input class="text" type="text" name="serv_name" id="serv_name" value="<?= $servname?>"> <br>

              Service Image:&nbsp; <input type="file" id="file" name="serv_image" value=""> <br>

              Price:&nbsp; <input class="text" type="number" step="0.01" min=0 name="price" id="price" value="<?= $price?>">&nbsp;

              Per Tooth:&nbsp; <input type="checkbox" name="pertooth" value="" <?php
              if ($pertooth == "yes") {
                echo "checked";
              }?>
              > <br>

              Service Description: <br>

              <textarea name="serv_description"  id="serv_description" rows="8" cols="80"><?= $servdesc?></textarea> <br>

              <input class="submit" type="submit" id="updateservbtn" name="updateservbtn" class="addserv" value="SAVE">
              <input class="submit" type="reset" name="" value="CLEAR">

                <p class="servicevalidation" id="servicevalidation"></p>
        </form>
		<a class="cancel" href="manageservice.php">Cancel</a>
    <?php }
        }
    }
     ?>
  </body>
</html>

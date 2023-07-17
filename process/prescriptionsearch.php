<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

$name = $_POST['name'];
$strlength = $_POST['strlength'];
$name = explode(" ",$name);

echo
'
<table>
  <tr>
    <th>PATIENT NAME</th>
    <th>DENTIST</th>
    <th>DATE</th>
  </tr>
';

if ($strlength > 0) {
  //RETRIVE ID & PATIENT NAME
  $sql = "SELECT * FROM user WHERE fname LIKE '$name[0]%' OR lname LIKE '$name[0]%'";
  $userres = mysqli_query($conn,$sql);

  if(mysqli_num_rows($userres) > 0){
    while($user = mysqli_fetch_assoc($userres)){
      $patientid = $user['userid'];
      $fname = $user['fname'];
      $lname = $user['lname'];
      $patientfullname = $fname." ".$lname; //CONCATENATE FIRST NAME AND LAST NAME

      //RETRIEVE PRESCRIPTIONS OF SEARCHED PATIENT
      $sql = "SELECT * FROM prescription WHERE patientid = '$patientid' ORDER BY presid DESC";
      $presres = mysqli_query($conn,$sql);

      if(mysqli_num_rows($presres) > 0){

      while($prescription = mysqli_fetch_assoc($presres)){
        $presid = $prescription['presid'];
        $patientid = $prescription['patientid'];
        $dentistid = $prescription['dentistid'];
        $date = $prescription['date'];

        //FETCH DENTIST FULL NAME
        $sql = "SELECT * FROM user where userid = '$dentistid' ";
        $dentres = mysqli_query($conn,$sql);

        if(mysqli_num_rows($dentres) > 0){

        while($dent = mysqli_fetch_assoc($dentres)){
          $dentfname = $dent['fname'];
          $dentlname = $dent['lname'];
          $dentistfullname = $dentfname." ".$dentlname;
        }
      } ?>

      <tr>
        <td><?= $patientfullname?></td>
        <td><?= $dentistfullname?></td>
        <td><?= $date?></td>

        <td><button class="btn1" id="edit" value="<?= $presid."_".$patientfullname."_".$dentistfullname."_".$date?>">Edit</button>
    <button class="btnx" id="delete" value="<?= $presid?>">Delete</button></td>
      </tr>
      <?php }
    }
  }
}

echo '</table>';
}

else {
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
}?>

<tr>
  <td><?= $patientfullname?></td>
  <td><?= $dentistfullname?></td>
  <td><?= $date?></td>

  <td><button class="btn1" id="edit" value="<?= $presid."_".$patientfullname."_".$dentistfullname."_".$date?>">Edit</button>
<button class="btnx" id="delete" value="<?= $presid?>">Delete</button></td>
</tr>

<?php }
 }
echo '</table>';
}
 ?>

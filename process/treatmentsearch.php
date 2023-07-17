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
    <th>SERVICE</th>
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
      $fullname = $fname." ".$lname; //CONCATENATE FIRST NAME AND LAST NAME

      //RETRIEVE THE TREATMENT RECORDS OF SEARCHED PATIENT
      $sql = "SELECT * FROM treatment WHERE userid = '$patientid' ORDER BY treatid DESC";
      $treatres = mysqli_query($conn,$sql);

      if(mysqli_num_rows($treatres) > 0){

        while($treatment = mysqli_fetch_assoc($treatres)){
          $treatid = $treatment['treatid'];
          $appointid = $treatment['appointid'];

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
        }?>

        <tr>
          <td><?= $fullname?></td>
          <td><?= $servname?></td>
          <td><?= $appointdate?></td>

          <td><button class="btn1" id="edit" value="<?= $treatid."_".$fullname."_".$servname."_".$appointdate?>">Edit</button>
      <button class="btnx" id="delete" value="<?= $treatid?>">Delete</button></td>
        </tr>

        <?php }
      }
    }
  }

  echo '</table>';
}

else {
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
}?>

<tr>
  <td><?= $fullname?></td>
  <td><?= $servname?></td>
  <td><?= $appointdate?></td>

  <td><button class="btn1" id="edit" value="<?= $treatid."_".$fullname."_".$servname."_".$appointdate?>">Edit</button>
<button class="btnx" id="delete" value="<?= $treatid?>">Delete</button></td>
</tr>
<?php }
 }

 echo '</table>';
}
 ?>

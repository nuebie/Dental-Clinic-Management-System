<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

$appointmentstatus = $_POST['appointmentstatus'];

/*
if($status == "Fulfilled Orders")
  $status = "fulfilled";

if($status == "Unfulfilled Orders")
  $status = "unfulfilled";

if($status == "Cancelled Orders")
  $status = "cancelled";
*/

echo
'<table>
  <tr>
    <th>PATIENT</th>
    <th>SERVICE</th>
    <th>DATE</th>
    <th>TIME</th>
    <th>STATUS</th>
  </tr>';

  //RETRIEVE THE APPOINTMENT RECORDS
  $sql = "SELECT * FROM appointment WHERE status = '$appointmentstatus' ORDER BY appointid DESC";
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
          <button id="'.$appointid.'" value="treated">TREATED</button>
          </td>';
        }

    echo "</tr>";
  }
}

echo '</table>';
 ?>

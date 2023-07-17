<?php
include "../included/db_connection.php";
include_once "../included/session.php";

$username = $_POST['username'];
$strlength = $_POST['strlength'];

echo '
<table>
  <tr>
    <th>Username</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Gender</th>
    <th>Birth date</th>
    <th>Email</th>
    <th>Contact</th>
  </tr>
';

if ($strlength > 0) {
  $sql = "SELECT * FROM user WHERE username LIKE '$username%'";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){
    while($user = mysqli_fetch_assoc($res)){
      $userid = $user['userid'];
      $username = $user['username'];
      $birthdate = $user['birthdate'];
      $fname = $user['fname'];
      $lname = $user['lname'];
      $role = $user['role'];
      $gender = $user['gender'];
      $email = $user['email'];
      $contactnum = $user['contactnum'];

      echo '<tr>';
      echo '<td>'.$username.'</td>';
      echo '<td>'.$fname.'</td>';
      echo '<td>'.$lname.'</td>';
      echo '<td>'.$gender.'</td>';
      echo '<td>'.$birthdate.'</td>';
      echo '<td>'.$email.'</td>';
      echo '<td>'.$contactnum.'</td>';

      //IF CURRENT ROLE OF USER IS REGULAR USER
      if ($role == "regular_user") {
        $opprole1 = "staff";
        $opprole2 = "dentist";
        echo '<td>
        <select id="'.$userid.'">
          <option>'.$role.'</option>
          <option>'.$opprole1.'</option>
          <option>'.$opprole2.'</option>
        </select>
       </td>';
        }

      //IF THE CURRENT ROLE OF USER IS STAFF
      if ($role == "staff") {
        $opprole1 = "regular_user";
        $opprole2 = "dentist";
        echo '<td>
        <select id="'.$userid.'">
          <option>'.$role.'</option>
          <option>'.$opprole1.'</option>
          <option>'.$opprole2.'</option>
        </select>
        </td>';
        }

        //IF THE CURRENT ROLE OF USER IS DENTIST
        if ($role == "dentist") {
          $opprole1 = "regular_user";
          $opprole2 = "staff";
          echo '<td>
          <select id="'.$userid.'">
            <option>'.$role.'</option>
            <option>'.$opprole1.'</option>
            <option>'.$opprole2.'</option>
          </select>
          </td>';
          }


      echo '<td class="td_btn">
        <form class="removefrm" action="index.html" method="post">
          <input type="hidden" name="userid" value="'.$userid.'">
          <input type="submit" class="btnx" name="" value="Remove">
        </form>
        </td>';
      echo '</tr>';
    }
  }
  echo '</table>';
}

else {
  $sql = "SELECT * FROM user";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){

    while($user = mysqli_fetch_assoc($res)){
      $userid = $user['userid'];
      $username = $user['username'];
      $birthdate = $user['birthdate'];
      $fname = $user['fname'];
      $lname = $user['lname'];
      $role = $user['role'];
      $gender = $user['gender'];
      $email = $user['email'];
      $contactnum = $user['contactnum'];

      echo '<tr>';
      echo '<td>'.$username.'</td>';
      echo '<td>'.$fname.'</td>';
      echo '<td>'.$lname.'</td>';
      echo '<td>'.$gender.'</td>';
      echo '<td>'.$birthdate.'</td>';
      echo '<td>'.$email.'</td>';
      echo '<td>'.$contactnum.'</td>';

      //IF CURRENT ROLE OF USER IS REGULAR USER
      if ($role == "regular_user") {
        $opprole1 = "staff";
        $opprole2 = "dentist";
        echo '<td>
        <select id="'.$userid.'">
          <option>'.$role.'</option>
          <option>'.$opprole1.'</option>
          <option>'.$opprole2.'</option>
        </select>
       </td>';
        }

      //IF THE CURRENT ROLE OF USER IS STAFF
      if ($role == "staff") {
        $opprole1 = "regular_user";
        $opprole2 = "dentist";
        echo '<td>
        <select id="'.$userid.'">
          <option>'.$role.'</option>
          <option>'.$opprole1.'</option>
          <option>'.$opprole2.'</option>
        </select>
        </td>';
        }

        //IF THE CURRENT ROLE OF USER IS DENTIST
        if ($role == "dentist") {
          $opprole1 = "regular_user";
          $opprole2 = "staff";
          echo '<td>
          <select id="'.$userid.'">
            <option>'.$role.'</option>
            <option>'.$opprole1.'</option>
            <option>'.$opprole2.'</option>
          </select>
          </td>';
          }


      echo '<td class="td_btn">
        <form class="removefrm" action="index.html" method="post">
          <input type="hidden" name="userid" value="'.$userid.'">
          <input type="submit" class="btnx" name="" value="Remove">
        </form>
        </td>';
      echo '</tr>';

    }
  }
}
 ?>

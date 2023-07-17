<?php
include "../included/db_connection.php";

$newrole = $_POST['newrole'];
$userid = $_POST['userid'];

$sql = "UPDATE `user` SET `role`='$newrole' where userid = '$userid'";
$res = mysqli_query($conn,$sql);

//CHECK IF USER ROLE HAS BEEN UPDATED
echo mysqli_affected_rows($conn);
 ?>

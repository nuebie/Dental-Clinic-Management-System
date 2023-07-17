<?php
include "../included/db_connection.php";

$userid = $_POST['user'];

//DELETE USER USING USERID
$sql = "DELETE FROM `user` WHERE userid='$userid'";
$res = mysqli_query($conn,$sql);

//CHECK IF USER RECORD HAS BEEN DELETED
echo mysqli_affected_rows($conn);

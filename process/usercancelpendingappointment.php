<?php
include "../included/db_connection.php";

if(isset($_POST['appointid']))
{
    $appointid = $_POST['appointid'];

    $sql = "UPDATE `appointment` SET `status`='cancelled' WHERE appointid = '$appointid'";
    $res = mysqli_query($conn,$sql);

    //CHECK IF APPOINTMENT RECORD HAS BEEN UPDATED
    echo mysqli_affected_rows($conn);
}


 ?>

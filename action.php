<?php
include "includes/db.php";
if (isset($_POST['status'])) {
    $query = "update tbl_213_device set device_status = " . $_POST['status'] . " " .(isset($_POST["usage"])?", device_usage=device_usage+1 ":""). " where device_id = " . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
} else if (isset($_POST['fav'])) {
    $query = "update tbl_213_device set device_fav = " . $_POST['fav'] . " where device_id=" . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
} else if (isset($_POST['delete'])) {
    $query = "delete from tbl_213_device where device_id=" . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
} else if (isset($_POST['permission'])) {
    $query = "update tbl_213_device set device_permission='" . $_POST['permission'] . "' where device_id=" . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
}
// $query = "select * from tbl_213_device where device_id = " . $_POST['deviceID'];
// $result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
if (isset($result))
    mysqli_free_result($result);
    include "includes/disconnect.php";
?>
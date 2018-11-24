<?php
include "connectDB.php";

$conn = connectDB::connect();

if(isset($_GET["id"])){
    $id = $conn->real_escape_string($_GET["id"]);
}

$sql = "SELECT `picture` FROM `user_profiles` WHERE `id` = $id";
$result = connectDB::select($sql);

header("Content-type: image/jpeg");
echo $result[0]['picture'];
?>
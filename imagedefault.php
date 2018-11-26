<?php
include "connectDB.php";

$conn = connectDB::connect();

$sql = "SELECT `image` FROM `default_images` WHERE `default_images`.`id`=\"1\"";
$result = connectDB::select($sql);

header("Content-type: image/jpeg");
echo $result[0]['image'];
?>
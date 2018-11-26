<?php
include "connectDB.php";

session_start();

if(!isset($_SESSION['id'])){
    header('Location: https://devweb2018.cis.strath.ac.uk/cs312groupq/index.php');
}

function test_input($test_data) {
    $test_data = trim($test_data);
    $test_data = stripslashes($test_data);
    $test_data = strip_tags($test_data);
    $test_data = htmlspecialchars($test_data);
    return $test_data;
}

$sql = "UPDATE * FROM `genders`";
$genderOptions = connectDB::select($sql);

$id = $_SESSION['id'];

if(!isset($_POST["name"])){
    $sql = "SELECT * FROM `user_profiles` WHERE `id`=\"$id\"";
    $result = connectDB::select($sql);

    if($result != false){
        $name = $result[0]["name"];
        $age = $result[0]["age"];
        $gender = $result[0]["gender"];
        $location = $result[0]["location"];
    }
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <link rel="stylesheet" type="text/css" href="Design.css"/>
    <title>Love At First Site</title>
</head>
<body>
<div class="content_wrapper">
    <div class="header">
        <span class="left"><a href="index.php">Love at first site</a></span>
    </div>

    <h1>Edit profile</h1>
    <div class="main_form">
        <form action="editProfile.php" method="post">
                <label><input type="text" name="first" value="false" hidden/></label>

            <div class="buttons">
                <button formaction="UserProfile.php">Back</button>
                <button type="submit" name="edit" value="aaa">Submit</button>
            </div>
        </form>
        <form action="editPreferences.php" method="post">
            <button formaction="editPreferences.php">Edit Preferences</button>
        </form>
    </div>
</div>
</body>
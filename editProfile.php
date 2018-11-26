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

$genderOptions;
$countryOptions;

$sql = "SELECT * FROM `genders`";
$genderOptions = connectDB::select($sql);

$sql = "SELECT * FROM `countries`";
$countryOptions = connectDB::select($sql);

$id = $_SESSION['id'];

$name = $age = $gender = $location = "";
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
else{
    $name =          test_input(isset ($_POST["name"])         ?$_POST["name"]:"");
    $age =           test_input(isset ($_POST["age"])          ?$_POST["age"]:"");
    $gender =        test_input(isset ($_POST["gender"])       ?$_POST["gender"]:"");
    $location =      test_input(isset ($_POST["location"])     ?$_POST["location"]:"");
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
        <?php

            ?>
            <h1>Edit profile</h1>
            <div class="main_form">
                <form action="editProfile.php" method="post">
                    <table>
                        <label><input type="text" name="first" value="false" hidden/></label>
                        <tr><td><label>Name:</label></td> <td><input type="text" name="name" value="<?php echo $name; ?>"/> </td></tr>
                        <tr><td><label>Age:</label></td> <td><input type="text" name="age" value="<?php echo $age; ?>" required pattern="((18|19|[2-9][0-9]))"/> </td></tr>
                        <tr><td><label>Gender:</label></td> <td> <select name="gender">
                                    <option value="" selected disabled value>select gender<br>
                                        <?php
                                        foreach ($genderOptions as $g){
                                            echo "<option value=\"".$g['id']."\"";
                                            if($g['id']===$gender) echo " selected=\"selected\"";
                                            echo ">".$g['name']."</option><br>";
                                        }
                                        echo "</select><br>";
                                        ?>
                            </td></tr>
                        <tr><td><label>Location:</label></td> <td> <select name="location">
                                    <option value="" selected disabled value>select country<br>
                                        <?php
                                        foreach ($countryOptions as $c){
                                            echo "<option value=\"".$c['id']."\"";
                                            if($c['id']===$location) echo " selected=\"selected\"";
                                            echo ">".$c['name']."</option><br>";
                                        }
                                        echo "</select><br>";
                                        ?>
                            </td></tr>
                    </table>
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
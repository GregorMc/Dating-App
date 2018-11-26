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

$oldPass = $newPass = $newPassConfirm = "";

$name = $age = $gender = $location = $bio = $picture = "";

if(!isset($_POST["name"])){
    $sql = "SELECT * FROM `user_profiles` WHERE `id`=\"$id\"";
    $result = connectDB::select($sql);

    if($result != false){
        $name = $result[0]["name"];
        $age = $result[0]["age"];
        $gender = $result[0]["gender"];
        $location = $result[0]["location"];
        $bio = $result[0]["bio"];
        $picture = $result[0]["picture"];
    }
}
else{
    $name =          test_input(isset ($_POST["name"])         ?$_POST["name"]:"");
    $age =           test_input(isset ($_POST["age"])          ?$_POST["age"]:"");
    $gender =        test_input(isset ($_POST["gender"])       ?$_POST["gender"]:"");
    $location =      test_input(isset ($_POST["location"])     ?$_POST["location"]:"");
}

if(isset($_POST["oldpass"])){
    $oldPass =           test_input(isset ($_POST["oldpass"])          ?$_POST["oldpass"]:"");
    $newPass =        test_input(isset ($_POST["newpass"])       ?$_POST["newpass"]:"");
    $newPassConfirm =      test_input(isset ($_POST["newpassc"])     ?$_POST["newpassc"]:"");
}

if(isset($_POST["bio"])){
    $bio =           test_input(isset ($_POST["bio"])          ?$_POST["bio"]:"");
}

if(isset($_POST["image"])){
    $picture =           test_input(isset ($_POST["image"])          ?$_POST["image"]:"");
}

$pass = false;
if($newPass != "" && $newPass == $newPassConfirm)
    $pass = true;

if($pass == true){
    $sql = "UPDATE `user_profiles` SET  `password`=\"$newPass\" WHERE `id`=\"$id\";";
    $result = connectDB::query($sql);
}

if(!empty($_POST["edit"])){
    $sql = "UPDATE `user_profiles` SET  `name`=\"$name\", `age`=\"$age\", `gender`=\"$gender\", `location`=\"$location\" WHERE `id`=\"$id\";";
    $result = connectDB::query($sql);
}

if(!empty($_POST["editBio"])){
    $sql = "UPDATE `user_profiles` SET  `bio`=\"$bio\" WHERE `id`=\"$id\";";
    connectDB::query($sql);
}

if(!empty($_POST["editImage"])){
    $sql = "UPDATE `user_profiles` SET  `picture`=\"$picture\" WHERE `id`=\"$id\";";
    connectDB::query($sql);
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
                        <tr><td><label>Name:</label></td> <td><input type="text" name="name" value="<?php echo $name; ?>" required/></td></tr>
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
                        <button type="submit" name="edit" value="aaa">Submit</button>
                    </div>
                </form>
                <form action="editPreferences.php" method="post">
                    <button formaction="editPreferences.php">Edit Preferences</button>
                </form>
            </div>
        <div class="main_form">
            <form action="editProfile.php" method="post">
                <p>Change password</p>
                <?php echo  ($pass==false)? ((!empty($oldPass))?  "<span class='error_span'>New password confirmation doesn't match the new password!</span>" : "") : "<p>Password changed</p>";?>
                <table><tr>
                        <td>Old Password:</td>
                        <td><input type="password" name="oldpass" value="<?php echo $oldPass; ?>" required/></td></tr>
                    <tr><td>New Password:</td>
                        <td><input type="password" name="newpass" value="<?php echo $newPass; ?>" required/></td></tr>
                    <tr><td>Confirm New Password:</td>
                        <td><input type="password" name="newpassc" value="<?php echo $newPassConfirm; ?>" required/></td>
                    </tr></table>
                <div class="buttons">
                    <button type="submit" name="editPass" value="aaa">Submit</button>
                </div>
            </form>

        </div>
        <div class="main_form">
            <form action="editProfile.php" method="post">
                <p>Change bio</p>
                <textarea name="bio" rows="5" cols="50" value="<?php echo $bio; ?>" required maxlength=255><?php echo $bio; ?></textarea>
                <div class="buttons">
                    <button type="submit" name="editBio" value="aaa">Submit</button>
                </div>
            </form>
        </div>
        <div class="main_form">
            <form action="editProfile.php" method="post">
                <p>Current image</p>
                <div style="margin: 0 auto; text-align: center;">
                <?php
                    if (!is_null($picture))
                        echo "<img src=\"image.php?id=".$id."\" width=33%/>";
                    else
                        echo "<img src=\"imagedefault.php\" width=33%/>";?>

                </div>
                <p>Upload image</p>
                <p>
                    <input type="file" name="image" id="image" required/>
                </p>
                <div class="buttons">
                    <button type="submit" name="editImage" value="aaa">Submit</button>
                </div>
            </form>
        </div>
        <div class="buttons">
            <button formaction="UserProfile.php">Back</button>
            <form action="editPreferences.php" method="post">
                <button formaction="editPreferences.php">Edit Preferences</button>
            </form>
        </div>
    </div>
    </body>
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

$id = $_SESSION['id'];

if(!empty($_POST["editGenders"])){
    $sql = "DELETE FROM `user_profiles_genders` WHERE `user_profiles_genders`.`user`=\"$id\"";
    $result = connectDB::query($sql);

    if(isset ($_POST["male"]) && $_POST["male"] == true){
        $sql = "INSERT INTO `user_profiles_genders` (`user`, `gender_of_interest`) VALUES (\"$id\", '1')";
        connectDB::query($sql);
    }
    if(isset ($_POST["female"]) && $_POST["female"] == true){
        $sql = "INSERT INTO `user_profiles_genders` (`user`, `gender_of_interest`) VALUES (\"$id\", '2')";
        connectDB::query($sql);
    }
    if(isset ($_POST["other"]) && $_POST["other"] == true){
        $sql = "INSERT INTO `user_profiles_genders` (`user`, `gender_of_interest`) VALUES (\"$id\", '3')";
        connectDB::query($sql);
    }
}

if(!empty($_POST["editAge"]) && isset ($_POST["to"]) && isset ($_POST["from"])){
    $minage = $_POST["from"];
    $maxage = $_POST["to"];

    $sql = "UPDATE `user_profiles` SET `min_age_of_interest` = \"$minage\" WHERE `user_profiles`.`id` = \"$id\";";
    connectDB::query($sql);

    $sql = "UPDATE `user_profiles` SET `max_age_of_interest` = \"$maxage\" WHERE `user_profiles`.`id` = \"$id\";";
    connectDB::query($sql);
}

if(!empty($_POST["interest_id"])){
    $sql = "DELETE FROM `user_profiles_interests` WHERE `user_profiles_interests`.`user`=\"$id\" AND `user_profiles_interests`.`interest`=\"".$_POST["interest_id"]."\"";
    connectDB::query($sql);
}
if(!empty($_POST["addNew"])){
    $sql = "SELECT `interests`.`id` FROM `interests` WHERE `interests`.`name`=\"".$_POST["newInterest"]."\"";
    $result1 = connectDB::select($sql);
    $inter;

    if(empty($result1)){
        $sql = "INSERT INTO `interests` (`name`) VALUES (\"".strtolower($_POST["newInterest"])."\")";
        connectDB::query($sql);
        $sql = "SELECT `interests`.`id` FROM `interests` WHERE `interests`.`name`=\"".strtolower($_POST["newInterest"])."\"";
        $result1 = connectDB::select($sql);
    }
    $inter = $result1[0]["id"];

    $sql = "INSERT INTO `user_profiles_interests` (`user`, `interest`) VALUES (\"$id\",\"$inter\")";
    connectDB::query($sql);
}

$sql = "SELECT `gender_of_interest` FROM `user_profiles` INNER JOIN (SELECT `user_profiles_genders`.`user` 
as `user_id`, `genders`.`id` as `gender_of_interest` FROM `user_profiles_genders` INNER JOIN `genders` 
ON `genders`.`id`=`user_profiles_genders`.`gender_of_interest`) as `gen` ON `user_profiles`.`id`= `gen`.`user_id` 
WHERE `user_profiles`.`id`=\"$id\"";

$genders = connectDB::select($sql);
if(empty($genders))
    $genders = array();

$minage = $maxage = "";

$sql = "SELECT `user_profiles`.`min_age_of_interest` FROM `user_profiles` WHERE `id`=\"$id\"";
$result = connectDB::select($sql);
if(!empty($result))
    $minage = $result[0]["min_age_of_interest"];

$sql = "SELECT `user_profiles`.`max_age_of_interest` FROM `user_profiles` WHERE `id`=\"$id\"";
$result = connectDB::select($sql);
if(!empty($result))
    $maxage = $result[0]["max_age_of_interest"];



$sql = "SELECT `interest`, `interest_n` FROM `user_profiles` INNER JOIN (SELECT `user_profiles_interests`.`user` 
            as `user_id`, `interests`.`id` as `interest`, `interests`.`name` as `interest_n` FROM `user_profiles_interests` INNER JOIN `interests` 
            ON `interests`.`id`=`user_profiles_interests`.`interest`) as `inter` ON `user_profiles`.`id`= `inter`.`user_id` 
            WHERE `user_profiles`.`id`=\"$id\"";

$result2 = connectDB::select($sql);

connectDB::disconnect();
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
    <h1>Edit preferences</h1>
    <div class="main_form">
        <?php echo empty($_POST["editGenders"])? "" : "<p>saved changes</p>";?>
        <form action="editPreferences.php" method="post">
            <p>Genders I'm interested in...</p>
            <table><tr>
                    <td><input type="checkbox" name="male" <?php echo (in_array(array('gender_of_interest'=>"1"), $genders)) ? ' checked="checked"' : ''; ?>/></td>
                    <td>Male</td>
                    <td><input type="checkbox" name="female" <?php echo (in_array(array('gender_of_interest'=>"2"), $genders)) ? ' checked="checked"' : ''; ?>/></td>
                    <td>Female</td>
                    <td><input type="checkbox" name="other" <?php echo (in_array(array('gender_of_interest'=>"3"), $genders)) ? ' checked="checked"' : ''; ?>/></td>
                    <td>Other</td>
                </tr></table>

            <div class="buttons">
                <button formaction="editPreferences.php" type="submit" name="editGenders" value="aaa">Save</button>
            </div>
        </form>
    </div>
    <div class="main_form">
        <?php echo empty($_POST["editAge"])? "" : "<p>saved changes</p>";?>
        <form action="editPreferences.php" method="post">
            <p>Age I'm interested in...</p>
            <table><tr>
                    <td><input type="text" name="from" value="<?php echo $minage; ?>" required pattern="((18|19|[2-9][0-9]))"/></td>
                    <td> to </td>
                    <td><input type="text" name="to" value="<?php echo $maxage; ?>" required pattern="((18|19|[2-9][0-9]))"/></td>
                </tr></table>

            <div class="buttons">
                <button formaction="editPreferences.php" type="submit" name="editAge" value="aaa">Save</button>
            </div>
        </form>
    </div>
    <div class="main_form" id="prefs">
        <?php echo empty($_POST["addNew"])? (empty($_POST["interest_id"])? "" : "<p>saved changes</p>") : "<p>saved changes</p>";?>
        <form action="editPreferences.php" method="post">

            <?php

            if(empty($result))
                echo "<p>You currently have no interests added to your profile...</p>\n";
            else{
                echo "<p>Your interests: </p>\n";
                echo "<table>";
                foreach ($result2 as $r){
                    echo "<tr>";
                    echo "<td>".$r["interest_n"]."</td>\n";
                    echo "<td><button type=\"submit\" name=\"interest_id\" value=".$r["interest"].">remove</button></td>\n";
                    echo "</tr>";
                }
                echo "</table>";
            }

            ?>
        </form>
    </div>
    <div class="main_form" id="prefs">
        <form action="editPreferences.php" method="post">
            <label for="newInterest"><b>Interest</b></label>
            <input type="text" placeholder="Name Your Interest..." name="newInterest" required pattern='([A-Za-z0-9\-]+)'/>
            <button type="submit" name="addNew" value="aaa">add</button><br>

        </form>
        <form action="UserProfile.php" method="post">
            <button type="submit" formaction="UserProfile.php">Back</button>
        </form>

    </div>
</div>
</body>
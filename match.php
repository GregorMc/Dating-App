<?php
    include "connectDB.php";
    session_start();

    if(!isset($_SESSION['id'])) {
        header('Location: https://devweb2018.cis.strath.ac.uk/cs312groupq/index.php');
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <link rel="stylesheet" type="text/css" href="Design.css"/>
    <title>Love At First Site</title>
</head>
<?php

$id = 2;
//$id = $_SESSION["id"];

$sql = "SELECT DISTINCT `user_profiles`.`id` FROM `user_profiles`, `user_profiles_genders`, `user_profiles_interests`, 
(SELECT `user_profiles`.`min_age_of_interest` AS `min`, `user_profiles`.`max_age_of_interest` AS `max`, 
`user_profiles`.`age` AS `user_age`, `user_profiles`.`location` AS `location` FROM `user_profiles` 
WHERE `user_profiles`.`id`=\"$id\") AS `age_and_location` WHERE `user_profiles`.`id`!=\"$id\" 
AND `user_profiles_genders`.`user`=`user_profiles`.`id` AND `user_profiles`.`gender` IN 
(SELECT `user_profiles_genders`.`gender_of_interest` FROM `user_profiles`, `user_profiles_genders` 
WHERE `user_profiles`.`id`=\"$id\" AND `user_profiles_genders`.`user`=`user_profiles`.`id`) 
AND `user_profiles_genders`.`gender_of_interest` IN (SELECT `user_profiles`.`gender` FROM `user_profiles` 
WHERE `user_profiles`.`id`=\"$id\") AND `user_profiles_interests`.`user`=`user_profiles`.`id` 
AND `user_profiles_interests`.`interest` IN (SELECT `user_profiles_interests`.`interest` 
FROM `user_profiles`, `user_profiles_interests` WHERE `user_profiles`.`id`=\"$id\" 
AND `user_profiles_interests`.`user`=`user_profiles`.`id`) AND `user_profiles`.`age` >= `age_and_location`.`min` 
AND `user_profiles`.`age` <= `age_and_location`.`max` 
AND `age_and_location`.`user_age` >= `user_profiles`.`min_age_of_interest` 
AND `age_and_location`.`user_age` <= `user_profiles`.`max_age_of_interest` 
AND `user_profiles`.`location`=`age_and_location`.`location`";

$message = "";
$matches = connectDB::select($sql);

if (!empty($matches)){
    $message = "MATCH!";
}
else {
    $message = "No matches have been found.";
}

$sql = "SELECT * FROM `genders`";
$genderOptions = connectDB::select($sql);

$sql = "SELECT * FROM `countries`";
$countryOptions = connectDB::select($sql);

connectDB::disconnect();
?>

<body>
<div class="content_wrapper">
    <div class="header">
        <span class="left"><a href="index.php">Love at first site</a></span>
        <span class="right">
        <button onclick="window.location.href='logout.php'">Log Out</button>
    </span>
    </div>

    <h1 style="text-align:center;" > Love at First Site </h1>
    <?php echo "<span class='confirm'>".$message."</span><br>"; ?>

    <div class="match_list">
        <table>
            <th colspan='2'>Image</th>
            <th colspan='2'>Name</th>
            <th colspan='1'>Age</th>
            <th colspan='2'>Gender</th>
            <th colspan='1'>Location</th>
        <?php
        foreach ($matches as $m){
            $curr = $m['id'];
            $sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`id`= \"$curr\"";
            $person = connectDB::select($sql);
            foreach ($person as $p){
                echo "<tr>";
                if (!is_null($p['picture']))
                    echo "<td colspan='2'><img src=\"image.php?id=".$p["id"]."\" width=50/></td>";
                else
                    echo "<td colspan='2'><img src=\"imagedefault.php\" width=50/></td>";
                echo "<td colspan='2'>".$p['name']."</td>";
                echo "<td colspan='2'>".$p['age']."</td>";
                foreach ($genderOptions as $g){
                    if($g['id']===$p['gender'])
                        echo "<td>".$g['name']."</td>";
                }
                foreach ($countryOptions as $c){
                    if($c['id']===$p['location'])
                        echo "<td>".$c['name']."</td>";
                }
                echo "<td colspan='2'><button onclick=\"window.location.href='PublicUserProfile.php?id=".$p['id']."'\" name='see_profile' value=".$p['username'].">See Profile</button></td>";
                echo "</tr>";
            }
        }
        ?>
        </table>
    </div>
</div>
</body>

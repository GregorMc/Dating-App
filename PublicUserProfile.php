<?php
    include "connectDB.php";
    session_start();

    $conn = connectDB::connect();

    if(isset($_GET["id"])){
        $passed_id = $conn->real_escape_string($_GET["id"]);
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
function test_input($test_data) {
    $test_data = trim($test_data);
    $test_data = stripslashes($test_data);
    $test_data = strip_tags($test_data);
    $test_data = htmlspecialchars($test_data);
    return $test_data;
}

connectDB::connect();

$id = $passed_id;

$sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`id`=\"$id\"";
$user_details = connectDB::select($sql);

$sql = "SELECT * FROM `genders`";
$genderOptions = connectDB::select($sql);

$sql = "SELECT * FROM `countries`";
$countryOptions = connectDB::select($sql);

$sql = "SELECT `interest`, `interest_n` FROM `user_profiles` INNER JOIN (SELECT `user_profiles_interests`.`user` 
            as `user_id`, `interests`.`id` as `interest`, `interests`.`name` as `interest_n` FROM `user_profiles_interests` INNER JOIN `interests` 
            ON `interests`.`id`=`user_profiles_interests`.`interest`) as `inter` ON `user_profiles`.`id`= `inter`.`user_id` 
            WHERE `user_profiles`.`id`=\"$id\"";

$interests = connectDB::select($sql);

$username = $user_details[0]["username"];

connectDB::disconnect();
?>

<body>
<div class="content_wrapper">
    <div class="header">
        <span class="left"><a href="index.php">Love at first site</a></span>
        <span class="right">
            <?php
                if(!isset($_SESSION['id']))
                    echo "<button onclick=\"window.location.href='index.php'\">Log In</button>";
                else
                    echo "<button onclick=\"window.location.href='logout.php'\">Log Out</button>";
            ?>
    </span>
    </div>
    <div class="main_form">
        <h1><?php echo "$username"?></h1>
        <div class="user_profile" id="wrapper">
            <div class="user_profile" id="desc">
                <?php
                    if (!is_null($user_details[0]['picture']))
                        echo "<img src=\"image.php?id=".$user_details[0]["id"]."\" width=33%/>";
                    else
                        echo "<img src=\"imagedefault.php\" width=33%/>";
                echo "<span> <label>Bio: </label>".$user_details[0]['bio']."</span>";
                echo "<table>";
                echo "<tr><td><label>Name:</label></td>";
                echo "<td>".$user_details[0]['name']."</td></tr>";
                echo "<tr><td><label>Age:</label></td>";
                echo "<td>".$user_details[0]['age']."</td></tr>";
                echo "<tr><td><label>Gender: </label></td>";
                foreach ($genderOptions as $g){
                    if($g['id']===$user_details[0]['gender'])
                        echo "<td>".$g['name']."</td></tr>";
                }
                echo "<tr><td><label>Location: </label></td>";
                foreach ($countryOptions as $c){
                    if($c['id']===$user_details[0]['location'])
                        echo "<td>".$c['name']."</td></tr>";
                }
                    if (isset($user_details[0]['min_age_of_interest']) && isset($user_details[0]['max_age_of_interest'])){
                    echo "<tr><td><label>Age of Interest: </label></td>";
                    echo "<td>".$user_details[0]['min_age_of_interest']."-".$user_details[0]['max_age_of_interest']."</td></tr>";
                }
                $index = 0;
                foreach ($interests as $in){
                    if ($index == 0){
                        echo "<tr><td><label>Interests: </label></td><td>".$in['interest_n']."</td></tr>";
                    }
                    else {
                        echo "<tr><td></td><td>".$in['interest_n']."</td></tr>";
                    }
                    $index++;
                }
                echo "</table>";
                ?>
                <div class="buttons">
                    <form method="post">
                        <button formaction="match.php">Back to Matches</button>
                        <button formaction="mailto:<?php echo $user_details[0]['email'];?>"><?php echo $user_details[0]['email']; ?></button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
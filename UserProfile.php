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
function test_input($test_data) {
    $test_data = trim($test_data);
    $test_data = stripslashes($test_data);
    $test_data = strip_tags($test_data);
    $test_data = htmlspecialchars($test_data);
    return $test_data;
}

connectDB::connect();

$id = $_SESSION["id"];

$sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`id`=\"$id\"";
$user_details = connectDB::select($sql);

$username = $user_details[0]["username"];
$password = $user_details[0]["password"];

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
    <div class="main_form">
        <h1><?php echo "Hi, ".$username."!"?></h1>
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
//                TODO GENDER 2 LOCATION 13
                echo "<td>".$user_details[0]['gender']."</td></tr>";
                echo "<tr><td><label>Location: </label></td>";
                echo "<td>".$user_details[0]['location']."</td></tr>";
                echo "</table>";
                ?>
                <div class="buttons">
                    <form method="post">
                        <button formaction="editProfile.php">Edit Profile</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
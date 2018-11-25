<?php
    include "connectDB.php";
    /*
    session_start();
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    } else{
        header("Location: index.php");
    }*/
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

$username = test_input(isset ($_POST["username"]) ? $_POST["username"] : "");
$password = test_input(isset ($_POST["password"]) ? $_POST["password"] : "");

$sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`username`=\"$username\" AND `user_profiles`.`password`=\"$password\"";

$user_details = connectDB::select($sql);
connectDB::disconnect();

?>

<body>
<div class="content_wrapper">
    <div class="header">
        <span class="left"><a href="index.php">Love at first site</a></span>
        <span class="right">
        <label>Search: </label><input type="text"/>
        <button onclick="window.location.href='index.php'">Log In</button>
    </span>
    </div>
    <div class="main_form">
        <h1><?php echo "Hi, ".$username."!"?></h1>
        <div class="user_profile" id="wrapper">
            <div class="user_profile" id="desc">
                <?php echo "<img src=\"image.php?id=".$user_details[0]["id"]."\" width=33%/>";
                echo "<span> <label>Bio: \t</label>".$user_details[0]['bio']."</span>";
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
                        <button formaction="index.php">Back</button>
                        <button formaction="editProfile.php">Edit Profile</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
<?php
include "connectDB.php";
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
        <div class="image"><?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $user_details[0]["picture"] ).'" width=33%/>';?></div>
    </div>
</div>
</body>
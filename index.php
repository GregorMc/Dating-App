<?php
    include "connectDB.php";

    // Check if the user is already logged in, if yes then redirect him to welcome page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Love at First Site</title>
    <link rel="stylesheet" type="text/css" href="Design.css"/>
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

    $sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`username`=$username AND `user_profiles`.`password`=$password";
    $result = connectDB::select($sql);
    //var_dump(connectDB::select($sql));

    //session_start();
    //var_dump($result);
    //$_SESSION["id"] = $result["id"];

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

<h1 style="text-align:center;" > Love at First Site </h1>
<div class="main_form">
    <form action="UserProfile.php" method="post">
    <label>Username :</label> <input type="text" name="username" value="<?php echo $username; ?>"/> <br>
    <label>Password :</label> <input type="password" name="password" value="<?php echo $password; ?>"/> <br>
    <div class="buttons">
        <button formaction="UserProfile.php" formmethod="post" type="submit" name="logIn"> Log in </button>
    </div>
        <hr>
        <p>Don't have an account?</p>
    <div class="buttons">
        <button formaction="SignupPage.php" formmethod="post" type="submit" name="signUp"> Sign up </button>
    </div>
    </form>
</div>
</div>
</body>

<?php






?>
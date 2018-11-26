<?php
    include "connectDB.php";

    session_start();

    if(isset($_SESSION['id'])) {
        header('Location: https://devweb2018.cis.strath.ac.uk/cs312groupq/UserProfile.php');
    }

    function test_input($test_data) {
        $test_data = trim($test_data);
        $test_data = stripslashes($test_data);
        $test_data = strip_tags($test_data);
        $test_data = htmlspecialchars($test_data);
        return $test_data;
    }

    $form_error = "";
    $username = test_input(isset ($_POST["username"]) ? $_POST["username"] : "");
    $password = test_input(isset ($_POST["password"]) ? $_POST["password"] : "");

    $sql = "SELECT * FROM `user_profiles`";
    $result = connectDB::select($sql);

    $sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`username`=\"$username\" AND `user_profiles`.`password`=\"$password\"";
    $result = connectDB::select($sql);

    if(!empty($username) && !empty($password)){
        if(empty($result)){
            $form_error = "Wrong username or password.";
        }
        else{
            $_SESSION["id"] = $result[0]["id"];
            header('Location: https://devweb2018.cis.strath.ac.uk/cs312groupq/UserProfile.php');
        }
    }

    if(!empty($_POST['username']) && empty($result)){
        $form_error = "Wrong username or password";
    }
    connectDB::disconnect();
    ?>
    <!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Love at First Site</title>
    <link rel="stylesheet" type="text/css" href="Design.css"/>
</head>
<body>
<div class="content_wrapper">
    <div class="header">
        <span class="left"><a href="index.php">Love at first site</a></span>
        <span class="right">
        <button onclick="window.location.href='index.php'">Log In</button>
    </span>
    </div>

<h1 style="text-align:center;" > Love at First Site </h1>
<div class="main_form">
    <span class="error_span"><?php echo $form_error;?></span>

    <form action="index.php" method="post">

        <label>Username :</label> <input type="text" name="username" required pattern="([A-Za-z0-9_\-,.]+)"  value="<?php echo $username; ?>"/> <br>
        <label>Password :</label> <input type="password" name="password" required value="<?php echo $password; ?>"/> <br>
        <div class="buttons">
            <button type="submit" name="logIn"> Log in </button>
        </div>
    </form>
    <hr>
    <p>Don't have an account?</p>
    <div class="buttons">
        <button onclick="window.location.href='SignupPage.php'" name="signUp"> Sign up </button>
    </div>
</div>
</div>
</body>
<?php
include "connectDB.php";

session_start();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Please create your user profile</title>
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
    <?php

    function test_input($test_data) {
        $test_data = trim($test_data);
        $test_data = stripslashes($test_data);
        $test_data = strip_tags($test_data);
        $test_data = htmlspecialchars($test_data);
        return $test_data;
    }

    $genderOptions;
    $countryOptions;
    $prompt = "";
    $message = "";
    $succ = false;

    $name =          test_input(isset ($_POST["name"])         ?$_POST["name"]:"");
    $username =      test_input(isset ($_POST["username"])     ?$_POST["username"]:"");
    $email =         test_input(isset ($_POST["email"])        ?$_POST["email"]:"");
    $confirmEmail =  test_input(isset ($_POST["confirmEmail"]) ?$_POST["confirmEmail"]:"");
    $password =      test_input(isset ($_POST["password"])     ?$_POST["password"]:"");
    $confirmPassword = test_input(isset ($_POST["confirmPassword"])  ?$_POST["confirmPassword"]:"");
    $age =           test_input(isset ($_POST["age"])          ?$_POST["age"]:"");
    $gender =        test_input(isset ($_POST["gender"])       ?$_POST["gender"]:"");
    $location =      test_input(isset ($_POST["location"])     ?$_POST["location"]:"");

    $sql = "SELECT * FROM `genders`";
    $genderOptions = connectDB::select($sql);

    $sql = "SELECT * FROM `countries`";
    $countryOptions = connectDB::select($sql);

    $sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`username`=\"$username\" AND `user_profiles`.`password`=\"$password\"";
    $accountExistsCheck = connectDB::select($sql);

     if (!empty($_POST['password']) && !empty($_POST['confirmPassword']) && $_POST['password'] !== $_POST['confirmPassword']){
                $prompt = "Passwords don't match!";
            }
            else if (!empty($email) && !empty($confirmEmail) && $email !== $confirmEmail) {
                $prompt = "Emails don't match!";
            }
            else if (empty($accountExistsCheck)) {
                $sql = "INSERT INTO `user_profiles`(`name`, `username`, `email`, `password`, `age`, `gender`, `location`) VALUES (\"$name\",\"$username\", \"$email\", \"$password\", \"$age\", \"$gender\", \"$location\")";

                if (connectDB::query($sql) === TRUE) {
                    $succ = true;
                    $msg = "Thank you for signing up to Love At First Site! Please click the link to access your account.. https://devweb2018.cis.strath.ac.uk/~jwb16142/312/groupq/UserProfile.php ";
                    mail($email, "Love at First Site", $msg);

                    $message = "Hello, " . $name . ", and Welcome to Love at First Site!\n Are you ready to find your soul mate?\n Click on the link sent to your email address " . $email . "\n";
                    $sql = "SELECT * FROM `user_profiles` WHERE `user_profiles`.`username`=\"$username\"";
                    $result = connectDB::select($sql);

                    $_SESSION["id"] = $result[0]["id"];
                }
            } else {

               echo "<span class='error_span'>Account with username: ".$username." already exists!</span>";
            }
            connectDB::disconnect();
            ?>
        <h1>Please create your user profile</h1>
        <?php echo "<span class='error_span'>".$prompt."</span>";
              echo "<span class='confirm'>".$message."</span>";?>

    <div class="main_form">
            <form action="SignupPage.php" method="post">
                <table>
                    <tr><td><label>Name:</label></td> <td><input type="text" name="name" required value="<?php echo $name; ?>"/> </td></tr>
                    <tr><td><label>Username:</label></td> <td><input type="text" name="username" required pattern="([A-Za-z0-9_\-,.]+)" value="<?php echo $username; ?>"/></td></tr>
                    <tr><td><label>Email:</label></td> <td><input type="email" name="email" required value="<?php echo $email; ?>"/></td></tr>
                    <tr><td><label>Confirm Email:</label></td> <td><input type="email" name="confirmEmail" required value="<?php echo $confirmEmail; ?>"/> </td></tr>
                    <tr><td><label>Password:</label></td> <td><input type="password" name="password" required value="<?php echo $password; ?>"/> </td></tr>
                    <tr><td><label>Confirm Password:</label></td> <td><input type="password" name="confirmPassword" required value="<?php echo $confirmPassword; ?>"/> </td></tr>
                    <tr><td><label>Age:</label></td> <td><input type="text" name="age" required pattern="((18|19|[2-9][0-9]))" value="<?php echo $age; ?>"/> </td></tr>
                    <tr><td><label>Gender:</label></td> <td> <select name="gender" required>
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
                    <tr><td><label>Location:</label></td> <td> <select name="location" required>
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
                    <?php if ($succ == true){
                        echo "<div class='buttons'><button formaction='index.php'>Continue</button></div>";
                    } else {
                        echo "<div class=\"buttons\">";
                        echo "<button onclick=\"window.location.href='index.php'\" type=\"button\" formaction=\"\">Back</button>";
                        echo "<button type=\"submit\">Submit</button>";
                        echo "</div>";
                    }?>
                </div>
            </form>
        </div>
        </div>
    </body>
</html>
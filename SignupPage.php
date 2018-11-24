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
        <label>Search: </label><input type="text"/>
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

    // Connect to database.
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs312groupq";
    $pass = "EizooSi1ool3";
    $dbname = "cs312groupq";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if($conn->connect_error){
        die("connection failed : ".$conn->connect_error);
    }

    //set up variables from $_GET
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
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $genderOptions[$i] = $row;
            $i++;
        }
    }

    $sql = "SELECT * FROM `countries`";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $i = 0;
        while($row = $result->fetch_assoc()){
            $countryOptions[$i] = $row;
            $i++;
        }
    }

    if (($name==="") || ($username==="") || (!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($password==="") || ($age==="") || ($location==="") || ($email != $confirmEmail)
    || ($password != $confirmPassword) || ($gender==="")) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $prompt = "Please complete all fields.";
    }

    ?>
        <h1>Please create your user profile</h1>
        <div class="main_form">
            <?php echo "<span class='error_span'>$prompt</span>";?>
            <form action="SignupPage.php" method="post">
                <table>
                    <tr><td><label>Name:</label></td> <td><input type="text" name="name" value="<?php echo $name; ?>"/> </td></tr>
                    <tr><td><label>Username:</label></td> <td><input type="text" name="username"value="<?php echo $username; ?>"/></td></tr>
                    <tr><td><label>Email:</label></td> <td><input type="text" name="email" value="<?php echo $email; ?>"/></td></tr>
                    <tr><td><label>Confirm Email:</label></td> <td><input type="text" name="confirmEmail" value="<?php echo $confirmEmail; ?>"/> </td></tr>
                    <tr><td><label>Password:</label></td> <td><input type="password" name="password" value="<?php echo $password; ?>"/> </td></tr>
                    <tr><td><label>Confirm Password:</label></td> <td><input type="password" name="confirmPassword" value="<?php echo $confirmPassword; ?>"/> </td></tr>
                    <tr><td><label>Age:</label></td> <td><input type="text" name="age" value="<?php echo $age; ?>"/> </td></tr>
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
                    <button formaction="index.php">Back</button>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
                <?php
            }

            $sql = "INSERT INTO `user_profiles`(`name`, `username`, `email`, `password`, `age`, `gender`, `location`) VALUES (\"$name\",\"$username\", \"$email\", \"$password\", \"$age\", \"$gender\", \"$location\")";

            if($conn->query($sql) === TRUE){
                $msg = "Thank you for signing up to Love At First Site! Please click the link to access your account.. https://devweb2018.cis.strath.ac.uk/~jwb16142/312/groupq/UserProfile.php " ;
                mail($email, "Love at First Site", $msg);

                echo  "Hello, ".$name.", and Welcome to Love at First Site!\n";
                echo  "Are you ready to find your soul mate?\n" ;
                echo  "Click on the link sent to your email address ".$email."\n";
            }

            $conn->close();
            ?>
        </div>
</div>
    </body>
</html>
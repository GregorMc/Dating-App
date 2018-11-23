<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Please create your user profile</title>
    <link rel="stylesheet" type="text/css" href="Design.css"/>
</head>
<body>
<div class="content_wrapper">
    <?php

    $genderOptions;
    $countryOptions;

    // Connect to database.
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs312groupq";
    $pass = "EizooSi1ool3";
    $dbname = "cs312groupq";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if($conn->connect_error){
        die("connection failed : ".$conn->connect_error); //FIXME remove once working
    }

    //set up variables from $_GET
    $name =          strip_tags(isset ($_POST["name"])         ?$_POST["name"]:"");
    $username =      strip_tags(isset ($_POST["username"])     ?$_POST["username"]:"");
    $email =         strip_tags(isset ($_POST["email"])        ?$_POST["email"]:"");
    $confirmEmail =  strip_tags(isset ($_POST["confirmEmail"]) ?$_POST["confirmEmail"]:"");
    $password =      strip_tags(isset ($_POST["password"])     ?$_POST["password"]:"");
    $confirmPassword = strip_tags(isset ($_POST["confirmPassword"])  ?$_POST["confirmPassword"]:"");
    $age =           strip_tags(isset ($_POST["age"])          ?$_POST["age"]:"");
    $gender =        strip_tags(isset ($_POST["gender"])       ?$_POST["gender"]:"");
    $location =      strip_tags(isset ($_POST["location"])     ?$_POST["location"]:"");

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
        echo "<p> Please complete all fields.</p>";
    }

    ?>
        <h1>Please create your user profile</h1>

        <div class="main_form">
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
                <div class="buttons"><button type="submit">Submit</button></div>
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
            ?>
        </div>
</div>
    </body>
</html>
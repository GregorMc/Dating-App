<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Please create your user profile</title>

</head>
<body>
<div>
    <link rel="stylesheet" type="text/css" href="Design.css"/>

    <?php


    //set up variables from $_GET

    $name =          strip_tags(isset ($_POST["name"])         ?$_POST["name"]:"");
    $username =      strip_tags(isset ($_POST["username"])     ?$_POST["username"]:"");
    $email =         strip_tags(isset ($_POST["email"])        ?$_POST["email"]:"");
    $password =      strip_tags(isset ($_POST["password"])     ?$_POST["password"]:"");
    $age =           strip_tags(isset ($_POST["age"])          ?$_POST["age"]:"");
    $location =      strip_tags(isset ($_POST["location"])     ?$_POST["location"]:"");

    if (($name==="") || ($username==="") || (!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($password==="") || ($age<18) || ($location==="")) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        echo "<p> Please complete all fields.</p>";
    }

    ?>
        <div>
            <h1>Please create your user profile</h1>
            <link rel="stylesheet" type="text/css" href="Design.css"/>
        </div>

        <form action="SignupPage.php" method="post">
            <p>
                Name:               <input type="text" name="name" value="<?php echo $name; ?>"/> <br/>
                Username:           <input type="text" name="username"value="<?php echo $username; ?>"/> <br/>
                Email:              <input type="text" name="email" value="<?php echo $email; ?>"/> <br/>
                Password:           <input type="text" name="password" value="<?php echo $password; ?>"/> <br/>
                Age:                <input type="number" name="age" value="<?php echo $age; ?>"/> <br/>
                Location:           <input type="text" name="location" value="<?php echo $location; ?>"/> <br/>

            <p><input type="submit"/></p>

            </p>
        </form>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign up page</title>
    </head>
    <body>


    </body>

        <?php

    }



    $msg = "Thank you for signing up to Love At First Site! Please click the link to access your account.. https://devweb2018.cis.strath.ac.uk/~jwb16142/312/groupq/UserProfile.php " ;
    mail($email, "Love at First Site", $msg);

    echo  "Hello ".$name." and Welcome to Love at First Site!";
    echo  " Are you ready to find your soul mate? " ;
    echo  "Click on the link sent to your email address ".$email;

    //connect to MySQL database
    // *** TO BE CREATED ***

    $host = "devweb2018.cis.strath.ac.uk";
    $user = "";
    $pass = "";
    $dbname = "";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if($conn->connect_error){
        die("connection failed : ".$conn->connect_error); //FIXME remove once working
    }

    //create SQL query and run it
    $sql = "INSERT INTO `UserProfiles` (`id`, `name`, `username`, `email`, `password`, `age`, `location`) VALUES "
        ."(NULL, '$name', '$username', '$email', '$password', '$age', '$location');";


    if($conn->query($sql)===TRUE){
        echo"<p> Insert successful</p>";
    } else{
        die("Error on insert ".$conn-> error);//FIXME remove once working
    }




    ?>
</div>
</body>
</html>
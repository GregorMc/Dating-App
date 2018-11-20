

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Sign up </title>


</head>
<body>
<div>
    <h1>Sign up Confirmation</h1>
    <link rel="stylesheet" type="text/css" href="Design.css"/>

    <?php


    //set up variables from $_GET

    $name =     isset ($_POST["name"])         ?$_POST["name"]:"";
    $username =      isset ($_POST["username"])          ?$_POST["username"]:"";
    $email =         isset ($_POST["email"])            ?$_POST["email"]:"";
    $password =      isset ($_POST["password"])             ?$_POST["password"]:"";
    $age =           isset ($_POST["age"])       ?$_POST["age"]:"";
    $location =      isset ($_POST["location"])       ?$_POST["Location"]:"";


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
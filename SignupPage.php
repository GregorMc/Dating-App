<!DOCTYPE html>
<div>
    <h1>Please create your user profile</h1>
    <?php
    $name = (isset($_POST["name"]))?$_POST["name"]:"";
    $username = (isset($_POST["username"]))?$_POST["username"]:"";
    $email = (isset($_POST["email"]))?$_POST["email"]:"";
    $password = (isset($_POST["password"]))?$_POST["password"]:"";
    $age = (isset($_POST["age"]))?$_POST["age"]:"";
    $location = (isset($_POST["location"]))?$_POST["location"]:"";

    ?>
</div>

<form action="InsertUserProfile.php"method="post">
    <p>
        Name: <input type="text" name="name"/> <br/>
        Username: <input type="text" name="username"/> <br/>
        Email: <input type="text" name="email"/> <br/>
        Confirm Email: <input type="text" name="confirmemail"/> <br/>
        Password: <input type="text" name="password"/> <br/>
        Confirm Password: <input type="text" name="confirmpassword"/> <br/>
        Age: <input type="text" name="age"/> <br/>
        Location: <input type="text" name="location"/> <br/>

        <input type="submit"/>
    </p>
</form>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up page</title>
</head>
<body>


</body>
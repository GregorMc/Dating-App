<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Love at First Site</title>
    <link rel="stylesheet" type="text/css" href="Design.css"/>
</head>

<body>

<div class="content_wrapper">
    <div class="header">
        <span class="left">Love at first site</span>
        <span class="right">
        <label>Search: </label><input type="text"/>
        <button formaction="">Sign In</button>
    </span>
    </div>

<h1 style="text-align:center;" > Love at First Site </h1>
<div class="main_form">
    <form>
    <label>Username :</label> <input type="text" name="userName"/> <br>
    <label>Password :</label> <input type="text" name="password"/> <br>
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
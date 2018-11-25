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

$genderOptions;
$countryOptions;
$prompt = "";

$sql = "SELECT * FROM `genders`";
$genderOptions = connectDB::select($sql);

$sql = "SELECT * FROM `countries`";
$countryOptions = connectDB::select($sql);

$id;

$name = $age = $gender = $location = "";
//reikia hidden id fieldo
if(!isset($_POST["id"])){
    $id = "3";

    $sql = "SELECT * FROM `user_profiles` WHERE `id`=\"$id\"";
    $result = connectDB::select($sql);

    if($result != false){
        $name = $result[0]["name"];
        $age = $result[0]["age"];
        $gender = $result[0]["gender"];
        $location = $result[0]["location"];
    }
}
else{
    $id = isset($_POST["id"])?$_POST["id"]:"";

    $name =          test_input(isset ($_POST["name"])         ?$_POST["name"]:"");
    $age =           test_input(isset ($_POST["age"])          ?$_POST["age"]:"");
    $gender =        test_input(isset ($_POST["gender"])       ?$_POST["gender"]:"");
    $location =      test_input(isset ($_POST["location"])     ?$_POST["location"]:"");
}
?>

    <body>
    <div class="content_wrapper">
        <div class="header">
            <span class="left"><a href="index.php">Love at first site</a></span>
        </div>
        <?php

        if (($name==="") || ($age==="") || ($location==="")|| ($gender==="") || !isset($_POST["first"])) {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $prompt = "Please complete all fields.";
            }

            ?>
            <h1>Edit profile</h1>
            <div class="main_form">
                <?php echo "<span class='error_span'>$prompt</span>";?>
                <form action="editPage.php" method="post">
                    <table>
                        <label><input type="text" name="id" value="<?php echo $id; ?>" hidden/></label>
                        <label><input type="text" name="first" value="false" hidden/></label>
                        <tr><td><label>Name:</label></td> <td><input type="text" name="name" value="<?php echo $name; ?>"/> </td></tr>
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
                        <button formaction="UserProfile.php">Back</button>
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <?php
        }
        else{
            $sql = "UPDATE `user_profiles` SET  `name`=\"$name\", `age`=\"$age\", `gender`=\"$gender\", `location`=\"$location\" WHERE `id`=\"$id\"";

            if(connectDB::query($sql) === TRUE){
                echo  "updated";
            }

            connectDB::disconnect();
        }
        ?>
    </div>
    </div>
    </body>
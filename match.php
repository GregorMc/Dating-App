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

$id = "3";

$sql = "SELECT DISTINCT `user_profiles`.`id` FROM `user_profiles`, `user_profiles_genders`, `user_profiles_interests`, 
(SELECT `user_profiles`.`min_age_of_interest` AS `min`, `user_profiles`.`max_age_of_interest` AS `max`, 
`user_profiles`.`age` AS `user_age`, `user_profiles`.`location` AS `location` FROM `user_profiles` 
WHERE `user_profiles`.`id`=\"$id\") AS `age_and_location` WHERE `user_profiles`.`id`!=\"$id\" 
AND `user_profiles_genders`.`user`=`user_profiles`.`id` AND `user_profiles`.`gender` IN 
(SELECT `user_profiles_genders`.`gender_of_interest` FROM `user_profiles`, `user_profiles_genders` 
WHERE `user_profiles`.`id`=\"$id\" AND `user_profiles_genders`.`user`=`user_profiles`.`id`) 
AND `user_profiles_genders`.`gender_of_interest` IN (SELECT `user_profiles`.`gender` FROM `user_profiles` 
WHERE `user_profiles`.`id`=\"$id\") AND `user_profiles_interests`.`user`=`user_profiles`.`id` 
AND `user_profiles_interests`.`interest` IN (SELECT `user_profiles_interests`.`interest` 
FROM `user_profiles`, `user_profiles_interests` WHERE `user_profiles`.`id`=\"$id\" 
AND `user_profiles_interests`.`user`=`user_profiles`.`id`) AND `user_profiles`.`age` >= `age_and_location`.`min` 
AND `user_profiles`.`age` <= `age_and_location`.`max` 
AND `age_and_location`.`user_age` >= `user_profiles`.`min_age_of_interest` 
AND `age_and_location`.`user_age` <= `user_profiles`.`max_age_of_interest` 
AND `user_profiles`.`location`=`age_and_location`.`location`";

$result = connectDB::select($sql);

connectDB::disconnect();

?>

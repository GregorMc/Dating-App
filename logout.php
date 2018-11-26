<?php
session_start();
session_destroy();
if(session_status() == PHP_SESSION_NONE){
    header('Location: https://devweb2018.cis.strath.ac.uk/cs312groupq/index.php');
}
<?php
class connectDB
{
    protected static $conn;

    protected static $host = "devweb2018.cis.strath.ac.uk";
    protected static $user = "cs312groupq";
    protected static $pass = "EizooSi1ool3";
    protected static $dbname = "cs312groupq";

    public static function connect(){
        if(!isset(self::$connection)){
            self::$conn = new mysqli(self::$host, self::$user, self::$pass, self::$dbname);
        }

        return self::$conn;
    }

    public static function disconnect(){
        self::$conn->close();
    }

    //for queries other than select (returns true or false depending whether query worked or not)
    public static function query($q){
        self::$conn = self::connect();

        $result = self::$conn->query($q);

        return $result;
    }
    //for queries which are of select type (returns results)
    public static function select($query) {
        $rows = array();
        $result = self::query($query);
        if($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
}
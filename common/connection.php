<?php
//connect the database
class connection
{
    function con()
    {
        $host = "localhost"; //host name
        $un = 'root'; //username
        $pw = ""; //password
        $db = "petlovers"; //db name

        //connect using PDO
        $con = new PDO("mysql:host=$host;dbname=$db", "$un", "$pw");

        if (!$con) {
            die("Connetion Faild :" . mysqli_connect_error());
        }
        return $con;
    }
}
$ob = new connection();
$con = $ob->con();

$config_email = "devrackcom@gmail.com";
$config_password = "";
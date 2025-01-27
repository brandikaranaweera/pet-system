<?php
date_default_timezone_set("Asia/Colombo");
//To make sure authentication
session_start(); //Start a session
error_reporting(E_WARNING || E_ALL);
$userinfo=$_SESSION['admin']; //assign the session for a variable
if(count($userinfo)!=0){ //to check login or not

}  else { 
    $msgi = base64_encode("Please login!!!");
    header("Location:../petlovers/admin");
    exit();
    
}    
?>
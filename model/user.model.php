<?php
class user
{

    //Check Email is exists or not
    public function checkEmail($email)
    {
        global $con;
        $r = $con->prepare("SELECT * FROM user WHERE email=?");
        $r->execute(array($email));
        return $r->rowCount();
    }

    //Add new user
    public function addNewUser($arr)
    {
        $forAdd = "0";
        $forSer = "0";
        if (isset($arr["for_service"])) {
            $forSer =  $arr["for_service"] == "1" ? "1" : "0";
        }
        if (isset($arr["for_advertise"])) {
            $forAdd = $arr["for_advertise"] == "1" ? "1" : "0";
        }
        global $con;
        $r = $con->prepare("INSERT INTO user (first_name,last_name,email,password,status,mobile,address,postal_code,for_advertise,for_services) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $r->execute(array($arr["first_name"], $arr["last_name"], $arr["email"], sha1($arr["password"]), 1, $arr["mobile"], $arr["address"], $arr["postal_code"], $forAdd, $forSer));
        $user_id = $con->lastinsertId();
        return $user_id;

        if ($r->errorCode() != 0) {
            $errors = $r->errorinfo();
            echo $errors[2];
        }
    }

    //Add new user
    public function updateUser($arr)
    {
        $forAdd = "0";
        $forSer = "0";
        if (isset($arr["for_service"])) {
            $forSer =  $arr["for_service"] == "1" ? "1" : "0";
        }
        if (isset($arr["for_advertise"])) {
            $forAdd = $arr["for_advertise"] == "1" ? "1" : "0";
        }
        global $con;
        $r = $con->prepare("UPDATE user set first_name=?,last_name=?,email=?,password=?,status=?,mobile=?,address=?,postal_code=?,for_advertise=?,for_services=? where user_id=?");
        $r->execute(array($arr["first_name"], $arr["last_name"], $arr["email"], sha1($arr["password"]), 1, $arr["mobile"], $arr["address"], $arr["postal_code"], $forAdd, $forSer, $arr['user_id']));
        //$user_id = $con->lastinsertId();


        if ($r->errorCode() != 0) {
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return  $arr['user_id'];
    }

    //To get user login details 
    function getUser($user_id)
    {
        global $con;
        $r = $con->prepare("SELECT user_id,first_name,last_name,email,status,mobile,address,postal_code,for_advertise,for_services FROM user WHERE user_id=?"); // we use ? to prevent from sql injection attacks

        $r->execute(array($user_id)); // pass values using arrays

        if ($r->errorCode() != 0) {
            $errors = $r->errorInfo();
            echo $errors[2];
        }

        return $r;
    }


    //To get user login details 
    function userlogin($email, $password)
    {
        global $con;
        $r = $con->prepare("SELECT user_id,first_name,last_name,email,status,mobile,address,postal_code,for_advertise,for_services FROM user WHERE email=? AND password=?"); // we use ? to prevent from sql injection attacks

        $r->execute(array($email, $password)); // pass values using arrays

        if ($r->errorCode() != 0) {
            $errors = $r->errorInfo();
            echo $errors[2];
        }

        return $r;
    }


    //To get user login details 
    function checkUser($email)
    {
        global $con;
        $r = $con->prepare("SELECT user_id,first_name,last_name,email,status,mobile,address,postal_code,for_advertise,for_services FROM user WHERE email=? "); // we use ? to prevent from sql injection attacks

        $r->execute(array($email)); // pass values using arrays

        if ($r->errorCode() != 0) {
            $errors = $r->errorInfo();
            echo $errors[2];
        }

        return $r;
    }

    function updateToken($user_id,$token)
    {
        global $con;
        $r = $con->prepare("UPDATE user set reset_token=?  where user_id=?");
        $r->execute(array($token, $user_id));


        if ($r->errorCode() != 0) {
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return $user_id;
    }

    function checkToken($user_id,$token)
    {
        global $con;
        $r = $con->prepare("SELECT user_id,first_name,last_name,email,status,mobile,address,postal_code,for_advertise,for_services FROM user WHERE user_id=? and reset_token=?"); // we use ? to prevent from sql injection attacks

        $r->execute(array($user_id,$token)); // pass values using arrays

        if ($r->errorCode() != 0) {
            $errors = $r->errorInfo();
            echo $errors[2];
        }

        return $r;
    }

    //Add new user
    public function updatePassword($password,$user_id)
    {
       
        global $con;
        $r = $con->prepare("UPDATE user set password=?,reset_token='' where user_id=?");
        $r->execute(array(sha1($password), $user_id));
        //$user_id = $con->lastinsertId();


        if ($r->errorCode() != 0) {
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return  $user_id;
    }
}

<?php
session_start();
include '../common/connection.php'; //DB Connection
include '../model/user.model.php'; //user model
require '../PHPMailer/PHPMailerAutoload.php'; //php mailer

$action = $_REQUEST['action'];

switch ($action) {
    case "register": // Registration
        $arr = $_POST;
        unset($_SESSION['old_data']);
        unset($_SESSION["err_email"]);
        $_SESSION['old_data'] = $arr;
        $obu = new user(); // Initialize the user class

        //Server validation
        if ($obu->checkEmail($arr['email']) > 0) {
            $_SESSION["err_email"] = "Already exists";
            header("Location:../register");
            break;
        }
        $user_id = $obu->addNewUser($arr);
        if ($user_id) {
            unset($_SESSION['old_data']);
            unset($_SESSION["err_email"]);
            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the password

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($arr['email']); //email of the reception
            $mail->Subject = 'Welcome to Petlovers'; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $arr['first_name'] . "<br></b>" //body of the mail
                . "Thank you for joining with PETLOVERS";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $r = $obu->userlogin($arr['email'], sha1($arr['password'])); //check user credential
            $nor = $r->rowCount();
            if ($nor) {
                $user = $r->fetch(PDO::FETCH_BOTH);
                $userarr = $user;
                $_SESSION['user'] = $userarr;
                header("Location:../home");
            }
            // $arrid = array('user_id'=> $user_id);
            // $userarray = $arr + $arrid;
            // var_dump($userarray);
            // $_SESSION['user'] = $userarray;

        } else {
            header("Location:../home");
        }
        break;

    case 'login': //Login
        $user_name = $_POST['email'];
        $password = sha1($_POST['password']);
        unset($_SESSION['login_err']);

        $obu = new user();
        $r = $obu->userlogin($user_name, $password); //check user credential
        $nor = $r->rowCount();
        // echo $nor;

        if ($nor) {
            $user = $r->fetch(PDO::FETCH_BOTH);
            $userarr = $user;
            $_SESSION['user'] = $userarr;
            //var_dump($userarr);
            header("Location:../home");
        } else { //if  wrong credentials
            $_SESSION['login_err'] = "Please provide correct information";
            header("Location:../login");
        }
        break;

    case "update": // Registration
        $arr = $_POST;
        $obu = new user(); // Initialize the user class


        $user_id = $obu->updateUser($arr);
        header("Location:../login");
        break;

    case 'forgot': //Login
        $user_name = $_POST['email'];
        unset($_SESSION['forgot_err']);

        $obu = new user();
        $r = $obu->checkUser($user_name); //check user credential
        $nor = $r->rowCount();
        // echo $nor;

        if ($nor) {
            $user = $r->fetch(PDO::FETCH_BOTH);
            $userarr = $user;
            $token = sha1(rand());

            $obu->updateToken($userarr["user_id"], $token);

            $restLink = "http://localhost/petlovers/reset-password?user=" . $userarr['user_id'] . "&token=".$token;

            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the password

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($user_name); //email of the reception
            $mail->Subject = 'Reset Password'; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $userarr['first_name'] . "<br></b>" //body of the mail
                . "Please <a href='" . $restLink . "'>Click Here</a> to reset the password"
                . "Thank you;";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $msg = base64_encode("Reset Link sent to your email!");
            header("Location:../login?msg=" . $msg);
        } else { //if  wrong credentials
            $_SESSION['forgot_err'] = "User Does Not Exists";
            header("Location:../forgotpassword");
        }
        break;



    case "reset": // Registration
        $arr = $_POST;
        $obu = new user(); // Initialize the user class
        
        //Server validation
        $r = $obu->checkToken($arr['user_id'],$arr['token']); //check user credential
        $nor = $r->rowCount();
        if ($nor == 0) {
            $msg = base64_encode("Token Expired!");
            header("Location:../reset-password?msg=".$msg);
            break;
        }
        $user_id = $obu->updatePassword($arr["password"],$arr["user_id"]);
        if ($user_id) {
            
            $msg = base64_encode("Password Reset Successful!");
            header("Location:../login?msg=" . $msg);


        } else {
            header("Location:../login?");
        }
        break;
}

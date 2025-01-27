<?php
session_start();
include '../common/connection.php'; //DB Connection
include '../model/post.model.php'; //user model
require '../PHPMailer/PHPMailerAutoload.php'; //php mailer

$action = $_REQUEST['action'];

switch ($action) {
    case "register": // Registration
        $arr = $_POST;
        unset($_SESSION['old_post']);
        $_SESSION['old_post'] = $arr;
        $obp = new post(); // Initialize the user class


        $post_id = $obp->addNewPost($arr['category'], $arr['district'], $arr['title'], $arr['age'], $arr['owner_name'], $arr['owner_contact'], $arr['owner_address'], $arr['price'], $arr['description'], 1, 0, $_SESSION['user']['user_id']);

        if ($post_id) {
            unset($_SESSION['old_post']);

            $images = count($_FILES['images']['name']); //no of imagses

            if ($_FILES['images']['name'][0] != "") { //upload images
                for ($i = 0; $i < $images; $i++) {
                    $image = $_FILES['images']['name'][$i]; //image name
                    $image_tmp = $_FILES['images']['tmp_name'][$i]; //serve temp location

                    $imgarr = explode(".", $image);
                    $image_new = time() . "_" . $post_id . "." . $imgarr[count($imgarr) - 1]; //new name to store
                    $r = $obp->addPostImage($post_id, $image_new, $image_tmp);
                }
            }
            $user_id = $_SESSION['user']['user_id'];
            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the password

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($_SESSION['user']['email']); //email of the reception
            $mail->Subject = $arr['title']; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $_SESSION['user']['first_name'] . "<br></b>" //body of the mail
                . "Your add " . $arr['title'] . " is posted. Please choose your plan and pay to publish<br>"
                . "Please <a href='http://localhost/petlovers/pay-post?user_id=$user_id&post_id=$post_id'>click here</a> to pay <br>"
                . "Thank You";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $msg1 = base64_encode("Post has been added successfully");

            header("Location:../pay-post?user_id=$user_id&post_id=$post_id&msg=$msg1"); //redirection

        } else {
            header("Location:../sell-pet");
        }
        break;

    case "update": // Registration
        $arr = $_POST;
        $post_id = $arr['post_id'];
        $obp = new post(); // Initialize the user class


        $post_id = $obp->editPost($arr['post_id'], $arr['category'], $arr['district'], $arr['title'], $arr['age'], $arr['owner_name'], $arr['owner_contact'], $arr['owner_address'], $arr['price'], $arr['description'], 1, 0, $_SESSION['user']['user_id']);

        if ($post_id) {
            $images = count($_FILES['images']['name']); //no of imagses
            if ($_FILES['images']['name'][0] != "") { //upload images
                for ($i = 0; $i < $images; $i++) {
                    $image = $_FILES['images']['name'][$i]; //image name
                    $image_tmp = $_FILES['images']['tmp_name'][$i]; //serve temp location

                    $imgarr = explode(".", $image);
                    $image_new = time() . "_" . $post_id . "." . $imgarr[count($imgarr) - 1]; //new name to store
                    $r = $obp->addPostImage($post_id, $image_new, $image_tmp);
                }
            }

            $msg1 = base64_encode("Post has been Updated successfully");

            header("Location:../edit-post?post_id=$post_id&msg=$msg1"); //redirection
        } else {
            header("Location:../edit-post?post_id=$post_id&msg=$msg1"); //redirection
        }
        break;

    case 'pay':
        $arr = $_POST;
        unset($_SESSION['old_pay']);
        $_SESSION['old_pay'] = $arr;

        $user_id = $_SESSION['user']['user_id'];
        $post_id = $arr['post_id'];
        $obp = new post(); // Initialize the user class


        $post_id = $obp->payForPost($arr);

        if ($post_id) {

            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the pssword

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($_SESSION['user']['email']); //email of the reception
            $mail->Subject = "Payment Success"; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $_SESSION['user']['first_name'] . "<br></b>" //body of the mail
                . "Your payment successful and post is live<br>"
                . "Thank You";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $msg1 = base64_encode("Payment completed successfully");

            header("Location:../my-posts?donate=1&msg=$msg1"); //redirection

        } else {
            header("Location:../pay-post?user_id=$user_id&post_id=$post_id"); //redirection
        }
        break;

    case 'donate':
        $arr = $_POST;
        unset($_SESSION['old_pay']);
        $_SESSION['old_pay'] = $arr;
        $obp = new post(); // Initialize the user class


        $post_id = $obp->donate($arr['amount'], $_SESSION['user']['user_id']);

        if ($post_id) {
            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the password

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($_SESSION['user']['email']); //email of the reception
            $mail->Subject = "Thank you for Donation"; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $_SESSION['user']['first_name'] . "<br></b>" //body of the mail
                . "Thank you for your donation"
                . "Thank You";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $msg1 = base64_encode("Thank you for your donation");

            header("Location:../my-posts?msg=$msg1"); //redirection

        } else {
            header("Location:../my-posts?donate=1");
        }


        break;

    case 'delete':
        $obp = new post();
        $post_id = $_GET['post_id'];
        $post = $obp->getPost($post_id);
        $r = $post->fetch(PDO::FETCH_BOTH);
        $imagecount = $r['image_count'];


        //if there are images delete those
        if ($imagecount > 0) {
            $postImages = $obp->getImages($post_id);
            while ($im = $postImages->fetch(PDO::FETCH_BOTH)) {
                $oldPath = "../images/posts/" . $im['image'];
                unlink($oldPath); //delete from the file
            }
        }
        $obp->deleteImages($post_id);
        $obp->deletePost($post_id);
        header("Location:../my-posts");

        break;

    case 'delImage':
        $obp = new post();
        $img_id = $_GET['img_id'];
        $image = $_GET['image'];
        $post_id = $_GET['post'];
        $oldPath = "../images/posts/" . $image;
        unlink($oldPath);
        $obp->deleteImage($img_id);
        header("Location:../edit-post?post_id=" . $post_id);
        break;

    case 'addService':
        $arr = $_POST;
        unset($_SESSION['old_service']);
        $_SESSION['old_service'] = $arr;
        $obp = new post(); // Initialize the user class


        $service_id = $obp->addService($arr['service_type'], $arr['district'], $arr['service_title'], $arr['contact'], $arr['service_address'], $arr['description'], $arr['lat'], $arr['lng'], $_SESSION['user']['user_id']);

        if ($service_id) {
            unset($_SESSION['old_service']);

            $user_id = $_SESSION['user']['user_id'];
            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the password

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($_SESSION['user']['email']); //email of the reception
            $mail->Subject = $arr['service_title']; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $_SESSION['user']['first_name'] . "<br></b>" //body of the mail
                . "Your Service " . $arr['service_title'] . " is now live on PETLOVERS<br>"
                . "Thank You";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $msg1 = base64_encode("Service has been added successfully");

            header("Location:../my-services?msg=$msg1"); //redirection

        } else {
            header("Location:../add-service");
        }
        break;

    case 'bookNow':
        $arr = $_POST;
        $obp = new post(); // Initialize the user class


        $post_id = $obp->bookService($arr);

        if ($post_id) {

            $mail = new PHPMailer(); //php mailer class

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465; //or 587
            $mail->SMTPAuth = true;
            $mail->Username = $config_email; //Sender email //change the email and password
            $mail->Password = $config_password; //Sender password enter the pssword

            $mail->setFrom($config_email, 'PETLOVERS'); //change the email
            $mail->addAddress($arr['email']); //email of the reception
            $mail->Subject = "Service Booking"; //Subject of the Email
            $mail->IsHTML(true);  //for enable html in the body
            $mail->Body = "<b>Hi," . $arr['name'] . "<br></b>" //body of the mail
                . "We got you booking on " . $arr['service_name'] . " service for " . $arr['service_title'] . "<br>"
                . "We will get back to you soon.<br><br>"
                . "<b>Service Title</b> : ".$arr['service_title']."<br>"
                . "<b>Service Type</b> : ".$arr['service_name']."<br>"
                . "<b>Contact</b> : ".$arr['contact']."<br>"
                . "<b>Service Address </b>: ".$arr['service_address']."<br>"
                . "<b>District</b> : ".$arr['district_name']."<br>"
                . "<br>"
                . "Thank You";

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
            }
            $msg1 = base64_encode("Service Booked successfully");

            header("Location:../services?msg=$msg1"); //redirection

        } else {
            header("Location:../services"); //redirection
        }
        break;



    case 'deleteService':
        $obp = new post();
        $service_id = $_GET['service_id'];
        $obp->deleteService($service_id);
        header("Location:../my-services");

        break;

    case 'updateService':
        $arr = $_POST;
        $post_id = $arr['service_id'];
        $obp = new post(); // Initialize the user class


        $post_id = $obp->editService($arr);

        $msg1 = base64_encode("Service has been Updated successfully");
        header("Location:../edit-service?service_id=$post_id&msg=$msg1"); 
        break;
}

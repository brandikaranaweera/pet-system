<?php
session_start();
include '../common/connection.php'; //DB Connection
include '../model/admin.model.php'; //user model
include '../model/post.model.php'; //user model

$action = $_REQUEST['action'];

switch ($action) {
    case 'login': //Login
        $user_name = $_POST['username'];
        $password = sha1($_POST['password']);
        unset($_SESSION['login_err']);

        $oba = new admin();
        $r = $oba->adminlogin($user_name, $password); //check user credential
        $nor = $r->rowCount();
        if ($nor) {
            $user = $r->fetch(PDO::FETCH_BOTH);
            $userarr = $user;
            $_SESSION['admin'] = $userarr;
            //var_dump($userarr);
            header("Location:../admin/dashboard");
        } else { //if  wrong credentials
            $_SESSION['login_err'] = "Please provide correct information";
            header("Location:../admin/login");
        }
        break;

    case "update": // Registration
        $arr = $_POST;
        $post_id = $arr['post_id'];
        $obp = new admin(); // Initialize the user class
        $obpp = new post();


        $post_id = $obp->editPost($arr['post_id'], $arr['category'], $arr['district'], $arr['title'], $arr['age'], $arr['owner_name'], $arr['owner_contact'], $arr['owner_address'], $arr['price'], $arr['description'], 1, 0);

        if ($post_id) {
            $images = count($_FILES['images']['name']); //no of imagses
            if ($_FILES['images']['name'][0] != "") { //upload images
                for ($i = 0; $i < $images; $i++) {
                    $image = $_FILES['images']['name'][$i]; //image name
                    $image_tmp = $_FILES['images']['tmp_name'][$i]; //serve temp location

                    $imgarr = explode(".", $image);
                    $image_new = time() . "_" . $post_id . "." . $imgarr[count($imgarr) - 1]; //new name to store
                    $r = $obpp->addPostImage($post_id, $image_new, $image_tmp);
                }
            }

            $msg1 = base64_encode("Post has been Updated successfully");

            header("Location:../admin/edit-post?post_id=$post_id&msg=$msg1"); //redirection
        } else {
            header("Location:../admin/edit-post?post_id=$post_id&msg=$msg1"); //redirection
        }
        break;

    case 'delImage':
        $obp = new post();
        $img_id = $_GET['img_id'];
        $image = $_GET['image'];
        $post_id = $_GET['post'];
        $oldPath = "../images/posts/" . $image;
        unlink($oldPath);
        $obp->deleteImage($img_id);
        header("Location:../admin/edit-post?post_id=" . $post_id);
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
        header("Location:../admin/admin-adds");

        break;


    case 'deleteService':
        $obp = new post();
        $service_id = $_GET['service_id'];
        $obp->deleteService($service_id);
        header("Location:../admin/admin-services");

        break;

    case 'updateService':
        $arr = $_POST;
        $post_id = $arr['service_id'];
        $obp = new post(); // Initialize the user class


        $post_id = $obp->editService($arr);

        $msg1 = base64_encode("Service has been Updated successfully");
        header("Location:../admin/edit-service?service_id=$post_id&msg=$msg1");
        break;
}

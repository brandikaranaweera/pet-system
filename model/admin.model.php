<?php
class admin
{

    //To get user login details 
    function adminLogin($username, $password)
    {
        global $con;
        $r = $con->prepare("SELECT admin_id,name,username FROM admin WHERE username=? AND password=?"); // we use ? to prevent from sql injection attacks

        $r->execute(array($username, $password)); // pass values using arrays

        if ($r->errorCode() != 0) {
            $errors = $r->errorInfo();
            echo $errors[2];
        }

        return $r;
    }

    public function getUsers(){
        global $con;
        $r=$con->prepare("SELECT * from user");
        $r->execute();
        return $r;
    }

    public function getServices(){
        global $con;
        $r=$con->prepare("SELECT a.service_id,a.stype_id,c.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type c on a.stype_id=c.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id "
        ."GROUP by a.service_id");
        $r->execute();
        return $r;
    }

    //get all posts
    public function getPosts(){
        global $con;
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id  "
        ."GROUP by a.add_id");
        $r->execute();
        return $r;
    }

    public function getBookings(){
        global $con;
        $r=$con->prepare("SELECT a.*,s.*,t.* from service_book a left join service s on a.service_id=s.service_id left outer join service_type t on s.stype_id=t.stype_id");
        $r->execute();
        return $r;
    }

    public function getDonations(){
        global $con;
        $r=$con->prepare("SELECT a.*,b.* from donation a left join user b on a.user_id=b.user_id ");
        $r->execute();
        return $r;
    }

    //update post
    public function editPost($post_id,$pet_cat,$district,$post_title,$pet_age,$owner_name,$owner_contact,$owner_address,$price,$description,$status,$pay_status){
        global $con;
        $r=$con->prepare("UPDATE advertisement set pet_cat=?,district_id=?,post_title=?,pet_age=?,owner_name=?,owner_contact=?,owner_address=?, price=?, description=?, status=? where add_id=?");
        $r->execute(array($pet_cat,$district,$post_title,$pet_age,$owner_name,$owner_contact,$owner_address,$price,$description,$status,$post_id));
        //$post_id=$con->lastinsertId();
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $post_id;
    }
}

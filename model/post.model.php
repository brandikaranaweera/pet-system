<?php 
class post{

    //Add new post
    public function addNewPost($pet_cat,$district,$post_title,$pet_age,$owner_name,$owner_contact,$owner_address,$price,$description,$status,$pay_status,$user_id){
        global $con;
        $r=$con->prepare("INSERT INTO advertisement (posted_date,pet_cat,district_id,post_title,pet_age,owner_name,owner_contact,owner_address, price, description, status, pay_status,user_id) VALUES (now(), ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $r->execute(array($pet_cat,$district,$post_title,$pet_age,$owner_name,$owner_contact,$owner_address,$price,$description,$status,$pay_status,$user_id));
        $post_id=$con->lastinsertId();
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $post_id;
        
        
    }

    //update post
    public function editPost($post_id,$pet_cat,$district,$post_title,$pet_age,$owner_name,$owner_contact,$owner_address,$price,$description,$status,$pay_status,$user_id){
        global $con;
        $r=$con->prepare("UPDATE advertisement set pet_cat=?,district_id=?,post_title=?,pet_age=?,owner_name=?,owner_contact=?,owner_address=?, price=?, description=?, status=?,user_id=? where add_id=?");
        $r->execute(array($pet_cat,$district,$post_title,$pet_age,$owner_name,$owner_contact,$owner_address,$price,$description,$status,$user_id,$post_id));
        //$post_id=$con->lastinsertId();
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $post_id;
    }

    //Add Image
    public function addPostImage($post_id, $image_new, $image_tmp){
        global $con;
        $r=$con->prepare("INSERT INTO post_image (post_id,image) VALUES (?,?)");
        $r->execute(array($post_id,$image_new));
        if($r){
            $path="../images/posts/".$image_new; //image store path
            move_uploaded_file($image_tmp,$path); //move image to the path
        }
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        return $r;
    }

    //Get Categories
    public function getCategories(){
        global $con;
        
        $r=$con->prepare("select * from categories");
        
        $r->execute(); 
        
        if($r->errorCode()!=0){
            $errors = $r -> errorInfo();
            echo $errors[2];
            
        }
        
        return $r;
    }

    //Get Disticts
    public function getDistricts(){
        global $con;
        
        $r=$con->prepare("select * from district");
        
        $r->execute(); 
        
        if($r->errorCode()!=0){
            $errors = $r -> errorInfo();
            echo $errors[2];
            
        }
        
        return $r;
    }

    //Get Packages
    public function getPackages(){
        global $con;
        
        $r=$con->prepare("select * from package");
        
        $r->execute(); 
        
        if($r->errorCode()!=0){
            $errors = $r -> errorInfo();
            echo $errors[2];
            
        }
        
        return $r;
    }

    //pay for post
    public function payForPost($arr){
        global $con;
        $r=$con->prepare("UPDATE advertisement SET published_date=now(),end_date=NOW() + INTERVAL (select package_validity from package where package_id=?) DAY,pay_status=?,package_id=? WHERE add_id=?");
        $r->execute(array($arr['package'],1,$arr['package'],$arr['post_id'],));
        
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return $arr['post_id'];
    }

    //Donate
    public function donate($amount,$user_id){
        global $con;
        $r=$con->prepare("INSERT INTO donation (amount,user_id) values (?,?)");
        $r->execute(array($amount,$user_id));
        $post_id=$con->lastinsertId();
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $post_id;
        
        
    }


    //get all posts
    public function getPosts(){
        global $con;
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and pay_status=1 and end_date>=now() GROUP by a.add_id");
        $r->execute();
        return $r;
    }

    //get post with pagination
    public function getPostsPaginate($start,$limit){
        global $con;
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and pay_status=1 and end_date>=now() GROUP by a.add_id LIMIt $start,$limit");
        $r->execute();
        return $r;
    }

    //get images
    public function getBannerImage($post_id){
        global $con;
        $r=$con->prepare("SELECT * FROM post_image where post_id=? LIMIT 1");
        $r->execute(array($post_id));
        return $r;
    }

    //get images
    public function getPostImages($post_id){
        global $con;
        $r=$con->prepare("SELECT * FROM post_image where post_id=?");
        $r->execute(array($post_id));
        return $r;
    }


    //get all posts
    public function getPostsFilter($arr){

        global $con;
        $subsql = "";
        $f_districts = [];
        $f_categories = [];
        $location = "";
        if($arr['keyword'] != "" && $arr['keyword'] != null){
            $subsql .= " and ( upper(post_title) LIKE '%".strtoupper($arr['keyword'])."%')";
        }
        if($arr['location'] != "" && $arr['location'] != null){
            $subsql .= " and ( upper(owner_address) LIKE '%".strtoupper($arr['location'])."%')";
        }
        if(isset($arr['f_districts'])){
            $f_districts = $arr['f_districts'];
        }
        if(count($f_districts) > 0){
            $subsql .= " and ( a.DISTRICT_ID IN (";
            foreach ($f_districts as $key=>$did) {
                if($key != 0){
                    $subsql .= ",".$did."";
                }else{
                    $subsql .= $did;
                }
                
            }
            $subsql .= "))";
        }

        if(isset($arr['f_categories'])){
            $f_categories = $arr['f_categories'];
        }
        
        if(count($f_categories) > 0){
            $subsql .= " and ( a.PET_CAT IN (";
            foreach ($f_categories as $keyc=>$cid) {
                if($keyc != 0){
                    $subsql .= ",".$cid."";
                }else{
                    $subsql .= $cid;
                }
                
            }
            $subsql .= "))";
        }

        if($arr['maxprice'] != "" && $arr['maxprice'] != null){
            $subsql .= " and ( PRICE <= ".$arr['maxprice'].")";
        }

        if($arr['minprice'] != "" && $arr['minprice'] != null){
            $subsql .= " and ( PRICE >= ".$arr['minprice'].")";
        }

        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and pay_status=1 and end_date>=now() ".$subsql." GROUP by a.add_id");
        
        $r->execute();

        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return $r;
    }

    //get post with pagination
    public function getPostsPaginateFilter($arr,$start,$limit){
        global $con;
        $subsql = "";
        $f_districts = [];
        $f_categories = [];
        $location = "";
        if($arr['keyword'] != "" && $arr['keyword'] != null){
            $subsql .= " and ( upper(post_title) LIKE '%".strtoupper($arr['keyword'])."%')";
        }
        if($arr['location'] != "" && $arr['location'] != null){
            $subsql .= " and ( upper(owner_address) LIKE '%".strtoupper($arr['location'])."%')";
        }
        if(isset($arr['f_districts'])){
            $f_districts = $arr['f_districts'];
        }
        if(count($f_districts) > 0){
            $subsql .= " and ( a.DISTRICT_ID IN (";
            foreach ($f_districts as $key=>$did) {
                if($key != 0){
                    $subsql .= ",".$did."";
                }else{
                    $subsql .= $did;
                }
                
            }
            $subsql .= "))";
        }

        if(isset($arr['f_categories'])){
            $f_categories = $arr['f_categories'];
        }
        
        if(count($f_categories) > 0){
            $subsql .= " and ( a.PET_CAT IN (";
            foreach ($f_categories as $keyc=>$cid) {
                if($keyc != 0){
                    $subsql .= ",".$cid."";
                }else{
                    $subsql .= $cid;
                }
                
            }
            $subsql .= "))";
        }

        if($arr['maxprice'] != "" && $arr['maxprice'] != null){
            $subsql .= " and ( PRICE <= ".$arr['maxprice'].")";
        }

        if($arr['minprice'] != "" && $arr['minprice'] != null){
            $subsql .= " and ( PRICE >= ".$arr['minprice'].")";
        }
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and pay_status=1 and end_date>=now() ".$subsql." GROUP by a.add_id LIMIt $start,$limit");
        $r->execute();

        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return $r;
    }


    //get user posts
    public function getUserPosts($user_id){
        global $con;
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date,a.posted_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and user_id=".$user_id." GROUP by a.add_id");
        $r->execute();
        return $r;
    }

    public function getPost($post_id){
        global $con;
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date,a.posted_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and add_id=".$post_id." GROUP by a.add_id");
        $r->execute();
        return $r;
    }

    //get user posts
    public function getUserSinglePosts($user_id,$post_id){
        global $con;
        $r=$con->prepare("SELECT a.add_id,a.pet_cat,c.cat_name,a.district_id,d.district_name,a.post_title,a.pet_age, "
        ."a.owner_name,a.owner_contact,a.owner_address,a.price,a.description,a.status,a.pay_status,a.published_date,a.posted_date, "
        ."a.user_id,COUNT(i.img_id) as image_count from advertisement a left JOIN categories c on a.pet_cat=c.cat_id "
        ."LEFT JOIN district d on a.district_id=d.district_id left join post_image i on a.add_id=i.post_id WHERE "
        ."status=1 and user_id=".$user_id." and add_id=".$post_id." GROUP by a.add_id");
        $r->execute();
        return $r;
    }

    public function getImages($post_id){
        global $con;
        $r=$con->prepare("SELECT * FROM post_image where post_id=?");
        $r->execute(array($post_id));
        return $r;
    }

    //delete Images 
    public function deleteImages($post_id){
        global $con;
        $r=$con->prepare("DELETE FROM post_image where post_id=?");
        $r->execute(array($post_id));
        return $r;
    }

    //delete Image
    public function deleteImage($img_id){
        global $con;
        $r=$con->prepare("DELETE FROM post_image where img_id=?");
        $r->execute(array($img_id));
        return $r;
    }

    //delete post
    public function deletePost($post_id){
        global $con;
        $r=$con->prepare("DELETE FROM advertisement where add_id=?");
        $r->execute(array($post_id));
        return $r;
    }

    //Get Service Type
    public function getServiceType(){
        global $con;
        
        $r=$con->prepare("select * from service_type");
        
        $r->execute(); 
        
        if($r->errorCode()!=0){
            $errors = $r -> errorInfo();
            echo $errors[2];
            
        }
        
        return $r;
    }


    //add new Service
    public function addService($service_type,$district,$service_title,$contact,$service_address,$description,$lat,$lng,$user_id){
        global $con;
        $r=$con->prepare("INSERT INTO service (service_title,stype_id,district,description,lat,lng,service_address,contact,user_id) VALUES (?, ?, ?,?, ?, ?, ?, ?,?)");
        $r->execute(array($service_title,$service_type,$district,$description,$lat,$lng,$service_address,$contact,$user_id));
        $service_id=$con->lastinsertId();
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $service_id;
        
        
    }



    //get all Services
    public function getServices(){
        global $con;
        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id "
        ."GROUP by a.service_id");
        $r->execute();
        
        return $r;
    }

    //get post with pagination
    public function getServicesPaginate($start,$limit){
        global $con;
        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id "
        ."GROUP by a.service_id LIMIt $start,$limit");
        $r->execute();
        return $r;
    }

    //get all posts
    public function getServicesFilter($arr){
        
        global $con;
        $subsql = "";
        $f_districts = [];
        $f_servicetype = [];
        $location = "";
        if($arr['keyword'] != "" && $arr['keyword'] != null){
            $subsql .= " and ( upper(service_title) LIKE '%".strtoupper($arr['keyword'])."%')";
        }
        if($arr['location'] != "" && $arr['location'] != null){
            $subsql .= " and ( upper(service_address) LIKE '%".strtoupper($arr['location'])."%')";
        }
        if(isset($arr['f_districts'])){
            $f_districts = $arr['f_districts'];
        }
        if(count($f_districts) > 0){
            $subsql .= " and ( a.DISTRICT IN (";
            foreach ($f_districts as $key=>$did) {
                if($key != 0){
                    $subsql .= ",".$did."";
                }else{
                    $subsql .= $did;
                }
                
            }
            $subsql .= "))";
        }

        if(isset($arr['f_servicetype'])){
            $f_servicetype = $arr['f_servicetype'];
        }
        if(count($f_servicetype) > 0){
            $subsql .= " and ( a.stype_id IN (";
            foreach ($f_servicetype as $keyc=>$sid) {
                if($keyc != 0){
                    $subsql .= ",".$sid."";
                }else{
                    $subsql .= $sid;
                }
                
            }
            $subsql .= "))";
        }
        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id WHERE 1=1 "
        ." ".$subsql."GROUP by a.service_id ");
        
        $r->execute();

        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return $r;
    }

    //get post with pagination
    public function getServicesPaginateFilter($arr,$start,$limit){
        global $con;
        $subsql = "";
        $f_districts = [];
        $f_servicetype = [];
        $location = "";
        if($arr['keyword'] != "" && $arr['keyword'] != null){
            $subsql .= " and ( upper(service_title) LIKE '%".strtoupper($arr['keyword'])."%')";
        }
        if($arr['location'] != "" && $arr['location'] != null){
            $subsql .= " and ( upper(service_address) LIKE '%".strtoupper($arr['location'])."%')";
        }
        if(isset($arr['f_districts'])){
            $f_districts = $arr['f_districts'];
        }
        if(count($f_districts) > 0){
            $subsql .= " and ( a.DISTRICT IN (";
            foreach ($f_districts as $key=>$did) {
                if($key != 0){
                    $subsql .= ",".$did."";
                }else{
                    $subsql .= $did;
                }
                
            }
            $subsql .= "))";
        }

        if(isset($arr['f_servicetype'])){
            $f_servicetype = $arr['f_servicetype'];
        }
        
        if(count($f_servicetype) > 0){
            $subsql .= " and ( a.stype_id IN (";
            foreach ($f_servicetype as $keyc=>$cid) {
                if($keyc != 0){
                    $subsql .= ",".$cid."";
                }else{
                    $subsql .= $cid;
                }
                
            }
            $subsql .= "))";
        }

        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id WHERE 1=1"
        ."".$subsql." GROUP by a.service_id  LIMIt $start,$limit");
        $r->execute();

        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }

        return $r;
    }


    //get user posts
    public function getUserServices($user_id){
        global $con;
        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id WHERE user_id=".$user_id." "
        ."GROUP by a.service_id");
        $r->execute();
        return $r;
    }

    public function getService($service_id){
        global $con;
        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id WHERE service_id=".$service_id." "
        ."GROUP by a.service_id");
        $r->execute();
        return $r;
    }

    //get user posts
    public function getUserSingleService($user_id,$service_id){
        global $con;
        $r=$con->prepare("SELECT a.service_id,a.stype_id,s.service_name,d.district_id,d.district_name,a.service_title,a.description, "
        ."a.lat,a.lng,a.service_address,a.contact,a.user_id from service a left JOIN service_type s on a.stype_id=s.stype_id "
        ."LEFT JOIN district d on a.district=d.district_id WHERE service_id=".$service_id." and  user_id=".$user_id." "
        ."GROUP by a.service_id");
        $r->execute();
        return $r;
    }


    public function bookService($arr){
        global $con;
        $r=$con->prepare("INSERT INTO service_book (booked_date,service_id,name,contact,address,email) VALUES (now(), ?, ?, ?,?, ?)");
        $r->execute(array($arr['service_id'],$arr['name'],$arr['contact'],$arr['address'],$arr['email']));
        $post_id=$con->lastinsertId();
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $post_id;
        
        
    }

            
    public function deleteService($service_id){
        global $con;
        $r=$con->prepare("DELETE FROM service where service_id=?");
        $r->execute(array($service_id));
        return $r;
    }

    public function editService($arr){
        global $con;
        $r=$con->prepare("update service set service_title=?,stype_id=?,district=?,description=?,lat=?,lng=?,service_address=?,contact=? where service_id=?");
        $r->execute(array($arr['service_title'],$arr['service_type'],$arr['district'],$arr['description'],$arr['lat'],$arr['lng'],$arr['service_address'],$arr['contact'],$arr['service_id']));
        
        
        if($r->errorCode() != 0){
            $errors = $r->errorinfo();
            echo $errors[2];
        }
        
        return $arr['service_id'];
    }


}
?>
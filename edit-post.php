<?php
include './common/sessionhandeling.php';
include './common/connection.php';
include './model/post.model.php';


$obpp = new post();
$categories = $obpp->getCategories();
$districts= $obpp->getDistricts();
$data = $obpp->getUserSinglePosts($_SESSION['user']['user_id'],$_GET['post_id']);
$count = $data->rowCount();
if ($count == 0) {
    header("Location:./my-posts");
} else {
    $post = $data->fetch(PDO::FETCH_BOTH);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pet Lovers</title>
    <?php include './common/styles.php' ?>
</head>

<body>
    <?php include './common/header.php' ?>
    <div class="container page-body d-flex justify-content-center align-items-center">
        <div class="col-md-12 py-3 pb-3 form-signup my-5 mb-5">
            <h4 class="text-center">Edit Advertisement</h4>
            <?php if (isset($_GET['msg'])) {  ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo base64_decode($_GET['msg']); ?>
                    </div>
                <?php } ?>
            <form method="post" action="./controller/post.controller?action=update" class="row g-3 needs-validation" id="advertisementForm" novalidate enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $post['add_id']; ?>">
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Pet Category</label>
                    <select class="form-select" name="category" required>
                        <option value="">Select the Category</option>
                        <?php 
                            while($rc=$categories->fetch((PDO::FETCH_BOTH))){?>
                            <option value="<?php echo $rc['cat_id']?>" <?php if($rc['cat_id']==$post['pet_cat']){echo 'selected';} ?>><?php echo $rc['cat_name'] ?></option>
                        <?php }?>
                    </select>
                    <div class="invalid-feedback">
                        Please Select the Category
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">District</label>
                    <select class="form-select" name="district" required>
                        <option value="">Select the District</option>
                        <?php 
                            while($rc=$districts->fetch((PDO::FETCH_BOTH))){?>
                            <option value="<?php echo $rc['district_id']?>" <?php if($rc['district_id']==$post['district_id']){echo 'selected';} ?>><?php echo $rc['district_name'] ?></option>
                        <?php }?>
                    </select>
                    <div class="invalid-feedback">
                        Please Select the District
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Post Title</label>
                    <input type="text" class="form-control" name="title" id="validationCustom01" value="<?php echo $post['post_title'] ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Title
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Pet Age</label>
                    <input type="text" class="form-control" name="age" id="validationCustom01" value="<?php echo $post['pet_age']?>" required>
                    <div class="invalid-feedback">
                        Please fill the Pet Age
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Owner Name</label>
                    <input type="text" class="form-control" name="owner_name" id="validationCustom01" value="<?php echo $post['owner_name'] ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Owner Name
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Owner Contact Number</label>
                    <input type="text" maxlength="10" minlength="10" class="form-control" name="owner_contact" id="validationCustom01" value="<?php echo $post['owner_contact']?>" onkeypress="return isNumber(event)" required>
                    <div class="invalid-feedback">
                        Please fill the Owner Contact Number
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Owner Address</label>
                    <input type="text" class="form-control" name="owner_address" id="validationCustom01" value="<?php echo $post['owner_address'] ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Owner Address
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Price</label>
                    <input type="text" name="price" class="form-control" id="validationCustom01" onkeypress="return isNumber(event)" value="<?php echo $post['price'] ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Price
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Description</label>
                    <textarea name="description" maxlength="500" class="form-control" id="validationCustom01" required><?php echo $post['description'] ?></textarea>
                    <div class="invalid-feedback">
                        Please fill Description
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Image</label>
                    <input type="file" class="form-control" id="validationCustom01"  name="images[]" multiple accept="image/*" >
                    <!-- <div class="invalid-feedback">
                        Please fill the Price
                    </div> -->
                </div>

                <?php if ($post['image_count'] != 0) { ?>
                    <div class="old-gallery d-flex mb-3 flex-wrap">
                        <?php
                        $postImages = $obpp->getImages($post['add_id']);
                        if ($post['image_count'] > 0) {
                            while ($im = $postImages->fetch(PDO::FETCH_BOTH)) {
                        ?>
                                <div class="card m-2" style="width: 200px;">
                                    <img class="card-img-top" src="./images/posts/<?php echo $im['image'] ?>" alt="Card image cap">
                                    <div class="card-footer">
                                        <?php if ($post['image_count'] > 1 ) {?>
                                        <a href="./controller/post.controller.php?action=delImage&img_id=<?php echo $im['img_id'] ?>&image=<?php echo $im['image'] ?>&post=<?php echo $post['post_id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                                        <?php }?>
                                    </div>
                                </div>
                        <?php
                            }
                        } ?>
                    </div>
                <?php } ?>

                
                <div class="col-12">
                    <button class="btn btn-warning w-100" type="submit">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
    <?php include './common/footer.php' ?>
</body>
<?php include './common/script.php' ?>
<script>
$(function() {
    // $('#registerForm').submit(function (){ 
    //     alert("submit");
    //     if($("#registerForm").checkValidity()) {
    //         alert("valid");
    //     }else{
    //         alert("invalid")
    //     }
        
    // });
});
</script>

</html>
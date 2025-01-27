<?php
include './common/sessionhandeling.php';
include './common/connection.php';
include './model/post.model.php';
if(isset($_SESSION["old_post"])){
    $category = $_SESSION['old_post']['category'];
    $district = $_SESSION['old_post']['district'];
    $title = $_SESSION['old_post']['title'];
    $age = $_SESSION['old_post']['age'];
    $owner_name = $_SESSION['old_post']['owner_name'];
    $owner_contact = $_SESSION['old_post']['owner_contact'];
    $owner_address = $_SESSION['old_post']['owner_address'];
    $price = $_SESSION['old_post']['price'];
    $description = $_SESSION['old_post']['description'];
}else{
    $category = "";
    $district = "";
    $title = "";
    $age = "";
    $owner_name = "";
    $owner_contact = "";
    $owner_address = "";
    $price = "";
    $description = "";
}

$obpp = new post();
$categories = $obpp->getCategories();
$districts= $obpp->getDistricts();
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
            <h4 class="text-center">Create Advertisement</h4>
            <form method="post" action="./controller/post.controller?action=register" class="row g-3 needs-validation" id="advertisementForm" novalidate enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Pet Category</label>
                    <select class="form-select" name="category" required>
                        <option value="">Select the Category</option>
                        <?php 
                            while($rc=$categories->fetch((PDO::FETCH_BOTH))){?>
                            <option value="<?php echo $rc['cat_id']?>" <?php if($rc['cat_id']==$category){echo 'selected';} ?>><?php echo $rc['cat_name'] ?></option>
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
                            <option value="<?php echo $rc['district_id']?>" <?php if($rc['district_id']==$district){echo 'selected';} ?>><?php echo $rc['district_name'] ?></option>
                        <?php }?>
                    </select>
                    <div class="invalid-feedback">
                        Please Select the District
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Post Title</label>
                    <input type="text" class="form-control" name="title" id="validationCustom01" value="<?php echo $title ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Title
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Pet Age</label>
                    <input type="text" class="form-control" name="age" id="validationCustom01" value="<?php echo $age?>" required>
                    <div class="invalid-feedback">
                        Please fill the Pet Age
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Owner Name</label>
                    <input type="text" class="form-control" name="owner_name" id="validationCustom01" value="<?php echo $owner_name ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Owner Name
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Owner Contact Number</label>
                    <input type="text" maxlength="10" minlength="10" class="form-control" name="owner_contact" id="validationCustom01" value="<?php echo $owner_contact?>" onkeypress="return isNumber(event)" required>
                    <div class="invalid-feedback">
                        Please fill the Owner Contact Number
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Owner Address</label>
                    <input type="text" class="form-control" name="owner_address" id="validationCustom01" value="<?php echo $owner_address ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Owner Address
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Price</label>
                    <input type="text" name="price" class="form-control" id="validationCustom01" onkeypress="return isNumber(event)" value="<?php echo $price ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Price
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Description</label>
                    <textarea name="description" maxlength="500" class="form-control" id="validationCustom01" required><?php echo $description ?></textarea>
                    <div class="invalid-feedback">
                        Please fill Description
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Image</label>
                    <input type="file" class="form-control" id="validationCustom01"  name="images[]" multiple accept="image/*" required>
                    <!-- <div class="invalid-feedback">
                        Please fill the Price
                    </div> -->
                </div>

                
                <div class="col-12">
                    <button class="btn btn-warning w-100" type="submit">POST</button>
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
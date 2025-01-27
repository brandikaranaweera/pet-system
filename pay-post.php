<?php
include './common/sessionhandeling.php';
include './common/connection.php';
include './model/post.model.php';

$post_user = $_GET['user_id'];
$post_id = $_GET['post_id'];

if($post_user != $_SESSION['user']['user_id']){
    header("Location:./profile"); //redirection
}

if(isset($_SESSION["old_pay"])){
    $package = $_SESSION['old_pay']['package'];
    $cardno = $_SESSION['old_pay']['cardno'];
    $cardtype = $_SESSION['old_pay']['cardtype'];
}else{
    $package = "1";
    $cardno = "";
    $cardtype = "";
}

$obpp = new post();
$packages = $obpp->getPackages();
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
            <h4 class="text-center">Pay For Post</h4>
            <?php if(isset($_GET['msg'])){  ?>
                <div class="alert alert-success text-center" role="alert">
                <?php echo base64_decode($_GET['msg']); ?>
                </div>
            <?php } ?>
            <form method="post" action="./controller/post.controller?action=pay" class="row g-3 needs-validation" id="advertisementForm" novalidate enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <div class="col-12">
                    <label class="form-lable">Package</label>
                    <?php 
                    $i=0;
                        while($rp=$packages->fetch((PDO::FETCH_BOTH))){?>
                        <div class="form-check ms-5 ps-5">
                            <input class="form-check-input " type="radio" name="package" id="flexRadioDefault1" value="<?php echo $rp['package_id'] ?>"  <?php if($rp['package_id']==$package){echo 'checked';} ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                <b><?php echo $rp['package_name'] ?> - Rs. <?php echo $rp['package_price']; ?>.00</b>&nbsp;<small>(<?php echo $rp['package_description'] ?>)</small>
                            </label>
                        </div>
                    <?php }?>
                </div>
                <!-- <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Package Price</label>
                    <input type="text" name="price" class="form-control" id="validationCustom01" onkeypress="return isNumber(event)" value="<?php echo "" ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Price
                    </div>
                </div> -->
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Card No</label>
                    <input type="text" name="card_no" class="form-control" id="validationCustom01" onkeypress="return isNumber(event)" value="<?php echo $cardno; ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Card No
                    </div>
                </div>
                <div class="form-check-inline my-3">
                    <input class="form-check-input " name="cardtype" type="radio" <?php ?> value="visa" id="forpackage1" checked>
                    <label class="form-check-label" for="forpackage1">
                        VISA
                    </label>
                    
                    <input class="form-check-input ml-4" name="cardtype" type="radio"  value="master" id="forservice" >
                    <label class="form-check-label" for="forservice">
                        Master
                    </label>
                    <div class="invalid-feedback" id="adInvalidFeedback">
                        Please use atlease one option.
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-warning w-100" type="submit">PAY NOW</button>
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
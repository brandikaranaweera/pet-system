<?php
include './common/sessionhandeling.php';
include './common/connection.php';
include './model/post.model.php';
$userid = $_SESSION['user']['user_id'];
$obp = new post();
$posts = $obp->getUserPosts($userid);

if (isset($_SESSION["old_pay"])) {
    $price = $_SESSION['old_pay']['price'];
    $cardno = $_SESSION['old_pay']['cardno'];
    $cardtype = $_SESSION['old_pay']['cardtype'];
} else {
    $price = "";
    $cardno = "";
    $cardtype = "";
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
    <div class="container page-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">My Advertisements</h4>
                <?php if (isset($_GET['msg'])) {  ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo base64_decode($_GET['msg']); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php if (isset($_GET['donate'])) {  ?>
            <div class="row">
                <div class="col-12 form-signup ">
                    <form method="post" action="./controller/post.controller?action=donate" class="row g-3 needs-validation" id="advertisementForm" novalidate enctype="multipart/form-data">
                        <h5 class="text-center">Donate For PetLovers</h5>
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label ">Donation Amount</label>
                            <input type="text" name="amount" class="form-control" id="validationCustom01" onkeypress="return isNumber(event)" value="<?php echo $price; ?>" required>
                            <div class="invalid-feedback">
                                Please fill the Card No
                            </div>
                        </div>
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

                            <input class="form-check-input ml-4" name="cardtype" type="radio" value="master" id="forservice">
                            <label class="form-check-label" for="forservice">
                                Master
                            </label>
                            <div class="invalid-feedback" id="adInvalidFeedback">
                                Please use atlease one option.
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-warning w-100" type="submit">Donate NOW</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php }?>
            <hr>
            <div class="row my-2">
                <div class="col-md-12">
                    <?php if ($posts->rowCount() == 0) { ?>
                        <div class="alert alert-info w-100 text-center" role="alert">
                            No posts available
                        </div>
                    <?php } ?>
                    <?php while ($row = $posts->fetch(PDO::FETCH_BOTH)) {
                        if ($row['add_id'] != null) { ?>
                            <div class="card ms-1 me-2 py-2 my-2 mb-2 w-100 card-shadow">
                                <div class="card-body row">
                                    <div class="col-md-3 d-flex justify-content-center">
                                            <?php
                                            ${'post_img' . $row['add_id']} = $obp->getBannerImage($row['add_id']);
                                            if ($row['image_count'] > 0) {
                                                while ($im = ${'post_img' . $row['add_id']}->fetch(PDO::FETCH_BOTH)) { ?>
                                                    <img src="./images/posts/<?php echo $im['image']; ?>" width="100%">
                                                <?php
                                                }
                                            } else { ?>
                                                <img src="https://i.stack.imgur.com/y9DpT.jpg" width="100%">
                                            <?php }
                                            ?>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted my-3" style="font-size: 13px;"><?php echo $row['cat_name'] ?></small>
                                        <h4 class="mb-0"><?php echo $row['post_title'] ?></h4>
                                        <small class="text-muted" style="font-size: 12px;"><i>by <?php echo $row['owner_name'] ?></i></small>
                                        <p class="my-2">
                                            <?php echo $row['description']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center align-items-center" style="border-left:1px solid #c6c6c6;">
                                        <div class="text-center">
                                            <h6>Rs <?php echo $row['price'] ?>/=</h6>
                                            <p class="mb-0 pb-0"><?php echo $row['owner_contact'] ?></p>
                                            <small class="text-muted" style="font-size: 11px;"><i class="fas fa-map-marker-alt"></i> &nbsp;<?php echo $row['district_name'] ?></small><br>
                                            <small class="text-muted" style="font-size: 10px;">Posted : <?php echo $row['posted_date'] ?></small><br>
                                            <a href="./edit-post?post_id=<?php echo $row['add_id']; ?>" class="btn btn-sm btn-warning my-1">EDIT</a>
                                            <?php if($row['pay_status'] == 0){ ?>
                                                <a href="./pay-post?user_id=<?php echo $userid ?>&post_id=<?php echo $row['add_id'] ?>" class="btn btn-sm btn-primary my-1">PAY NOW</a>
                                            <?php } ?>
                                            
                                            <a href="./controller/post.controller?action=delete&post_id=<?php echo $row['add_id']; ?>" class="btn btn-sm btn-danger my-1">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        if ($posts->rowCount() == 1 && $row['add_id'] == null) { ?>
                            <div class="alert alert-info w-100 text-center" role="alert">
                                No posts available
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
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
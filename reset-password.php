<?php
session_start();
unset($_SESSION['user']);
//unset($_SESSION['login_err']);
$token = "";
$user_id = "";
if(isset($_GET['token'])){
    $token = $_GET['token'];
}
if(isset($_GET['user'])){
    $user_id = $_GET['user'];
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
        <div class="col-md-12 py-3 pb-3 ">
            <div class="form-signin">
                <form action="./controller/user.controller?action=reset" method="post" id="preset">
                    <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                    <h1 class="h3 mb-3 fw-normal text-center">Reset Password</h1>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <div class="form-floating">
                        <input type="password" name="password" id="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <br>
                    <div class="form-floating">
                        <input type="password" name="cpassword" id="cpassword" class="form-control" id="floatingPassword" placeholder="Confirm Password">
                        <label for="floatingPassword"> Confirm Password</label>
                    </div>
                    <br>

                    <button class="w-100 btn btn-lg btn-warning" type="submit">Reset</button>
                    <?php if (isset($_GET['msg'])) {  ?>
                        <div class="alert alert-danger    text-center" role="alert">
                            <?php echo base64_decode($_GET['msg']); ?>
                        </div>
                    <?php } ?>

                </form>
            </div>

        </div>
    </div>
    <?php include './common/footer.php' ?>
</body>
<?php include './common/script.php' ?>
<script>
    $('#preset').on('submit', function() {
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();
        if (password != cpassword) {
            isValid = false;
            alert("Password mismatched");
            return false;
        } 
    });
</script>

</html>
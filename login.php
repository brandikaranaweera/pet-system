<?php 
session_start();
unset($_SESSION['user']);
//unset($_SESSION['login_err']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Pet Lovers</title>
<?php include './common/styles.php'?>
</head>
<body>
    <?php include './common/header.php' ?>
    <div class="container page-body d-flex justify-content-center align-items-center" >
        <div class="col-md-12 py-3 pb-3 ">
            <div class="form-signin">
                <?php if (isset($_GET['msg'])) {  ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo base64_decode($_GET['msg']) ;?>
                    </div>
                <?php } ?>
                <form action="./controller/user.controller?action=login" method="post">
                    <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                    <h1 class="h3 mb-3 fw-normal text-center">Login</h1>

                    <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                    </div>
                    <br>
                    <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    </div>

                    <button class="w-100 btn btn-lg btn-warning" type="submit">Login</button>
                    <?php if (isset($_SESSION['login_err'])) { ?>
                        <div class="alert alert-danger text-center my-3" role="alert">
                            Please provide valid information.
                        </div>
                    <?php } ?>
                    <p class="text-center"><a href="./forgotpassword">Forgot Password?</a></p>
                    
                </form>
            </div>
            
        </div>
    </div>
    <?php include './common/footer.php' ?>
</body>
<?php include './common/script.php' ?>
</html>



<?php
session_start();
if(isset($_SESSION["old_data"])){
    $firstname = $_SESSION['old_data']['first_name'];
    $lastname = $_SESSION['old_data']['last_name'];
    $mobile = $_SESSION['old_data']['mobile'];
    $email = $_SESSION['old_data']['email'];
    $address = $_SESSION['old_data']['address'];
    $postal_code = $_SESSION['old_data']['postal_code'];
    if(isset($_SESSION['old_data']['for_advertise'])){
        $foradvertise = true;
    }else{
        $foradvertise = false;
    }
    if(isset($_SESSION['old_data']['forservice'])){
        $forservice = true;
    }else{
        $forservice = false;
    }
}else{
    $firstname = "";
    $lastname = "";
    $mobile = "";
    $email = "";
    $address = "";
    $postal_code = "";
    $foradvertise = false;
    $forservice = false;
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
            <h4 class="text-center">Register</h4>
            <p class="text-center">Please fill in the required information</p>
            <form method="post" action="./controller/user.controller?action=register" class="row g-3 needs-validation" id="registerForm" novalidate enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">First name</label>
                    <input type="text" class="form-control" name="first_name" id="validationCustom01" value="<?php echo $firstname ?>" required>
                    <div class="invalid-feedback">
                        Please fill the First Name
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">Last name</label>
                    <input type="text" class="form-control" name="last_name" id="validationCustom02" value="<?php echo $lastname ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Last Name
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label ">Mobile</label>
                    <input type="text" maxlength="10" minlength="10" name="mobile" class="form-control" id="validationCustom01" onkeypress="return isNumber(event)" value="<?php echo $mobile ?>" required>
                    <div class="invalid-feedback">
                        Please provide valid Mobile
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">Email</label>
                    <input type="email" class="form-control <?php if(isset($_SESSION['err_email'])){echo 'is-invalid';} ?>" name="email" id="validationCustom02" value="<?php echo $email ?>" required>
                    <div class="invalid-feedback">
                        <?php if(isset($_SESSION['err_email'])){echo 'This email already registered.';} 
                        else{
                            echo 'Please provide valid email';
                        }
                        ?>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" id="validationCustom02" value="<?php echo $address ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Address
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">Postal Code</label>
                    <input type="text" maxlength="5" name="postal_code" class="form-control" id="validationCustom02" onkeypress="return isNumber(event)" value="<?php echo $postal_code ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Postal COde
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check-inline">
                        <input class="form-check-input " name="for_advertise" type="checkbox" <?php if($foradvertise){ echo "checked";} ?> value="1" id="foradvertise" >
                        <label class="form-check-label" for="foradvertise">
                            For Advertise
                        </label>
                       
                        <input class="form-check-input ml-4" name="for_service" type="checkbox" <?php if($forservice){ echo "checked";} ?> value="1" id="forservice" >
                        <label class="form-check-label" for="forservice">
                            For Provide Services
                        </label>
                        <div class="invalid-feedback" id="adInvalidFeedback">
                            Please use atlease one option.
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustomUsername" class="form-label">Password <small class="text-muted">(Minimum 8 Characters)</small></label>
                    <div class="input-group has-validation">
                        <input type="password" class="form-control" name="password" minlength="8" id="txtPassword" aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback">
                            Please enter valid password
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustomUsername" class="form-label">Confrim Password</label>
                    <div class="input-group has-validation">
                        <input type="password" class="form-control" name="cpassword" id="txtConfirmPassword" aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback" id="cPasswordFeedback">
                            Please enter valid password
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-warning w-100" type="submit">Register</button>
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
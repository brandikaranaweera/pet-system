<?php
session_start();
include './common/connection.php';
include './model/post.model.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pet Lovers</title>
    <?php include './common/styles.php' ?>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
</head>

<body>
    <?php include './common/script.php' ?>

    </script>
    <?php include './common/header.php' ?>
    <main class="page-body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center my-3">About Us</h3>
                    <?php if (isset($_GET['msg'])) {  ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php echo base64_decode($_GET['msg']); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-12 my-3">
                    <p class="text-justify">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                        ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                        id est laborum
                    </p>
                    <p class="text-justify">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                        ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                        id est laborum
                    </p>
                    <p class="text-justify">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                        ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                        id est laborum
                    </p>
                </div>

                <div class="col-lg-12">
                    <h3 class="text-center">Our Team</h3>
                </div>
                <div class="col-lg-3">
                    <div class="card w-100" style="width: 18rem;">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Jhone Doe</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card w-100" style="width: 18rem;">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Jhone Doe</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card w-100" style="width: 18rem;">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Jhone Doe</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card w-100" style="width: 18rem;">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Jhone Doe</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </main>

    <?php include './common/footer.php' ?>
</body>



</html>
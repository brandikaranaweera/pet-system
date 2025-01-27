<?php
session_start();
include './common/connection.php';
include './model/post.model.php';
$obp = new post();
$categories = $obp->getCategories();
$districts = $obp->getDistricts();

//if page is set
if (!isset($_GET['page']) || $_GET['page'] == 1) {
    $start = 0;
    $page = 1;
} else {
    $page = $_GET['page'];
    $start = $page * 10 - 10;
}

$prev = $page - 1; //previous page
$next = $page + 1; //next age
$limit = 10; //items per page
$keyword = "";
$f_districts = [];
$f_categories = [];
$maxprice = "";
$minprice = "";
$location = "";
if (count($_POST) > 0) {
    $arr = $_POST;
    $_SESSION['filter'] = $arr;
}
if (isset($_GET['filter']) || count($_POST) > 0) {
    if (isset($_SESSION['filter'])) {
        $arr = $_SESSION['filter'];
        $keyword = $_SESSION['filter']['keyword'];
        if (isset($_SESSION['filter']['f_districts'])) {
            $f_districts = $_SESSION['filter']['f_districts'];
        }
        if (isset($_SESSION['filter']['f_categories'])) {
            $f_categories = $_SESSION['filter']['f_categories'];
        }

        $maxprice = $_SESSION['filter']['maxprice'];
        $minprice = $_SESSION['filter']['minprice'];
        $location = $_SESSION['filter']['location'];

        $rposts = $obp->getPostsFilter($arr);
        $nor = $rposts->rowCount();
        $nop = ceil($nor / 10);
        $posts = $obp->getPostsPaginateFilter($arr, $start, $limit);
    }
    //
} else {
    $rposts = $obp->getPosts();
    $nor = $rposts->rowCount();
    $nop = ceil($nor / 10);
    $posts = $obp->getPostsPaginate($start, $limit);
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
    <main class="page-body">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/rottweiler-cute-dog-puppy-pets-autumn.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/colorful-parrot-4k-image.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/image3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container">
            <div class="col-md-12 py-3 pb-3">
                <h3 class="text-center">PET LOVERS</h3>
                <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
                    ultricies nec, pellentesque eu,Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
                    ultricies nec, pellentesque eu,</p>
            </div>
            <hr>
            <div class="col-md-12 d-flex justify-content-center">
                <a href="./pets" class="text-decoration-none text-dark">
                    <div class="card ms-1 me-2 py-2" style="width: 18rem;">
                        <div class="w-100 d-flex justify-content-center">
                            <div style="width: 250px; height:250px; border:1px solid #c8c8c8; border-radius:50%; background-image: url('./images/pets.jpeg'); 
                            background-repeat: no-repeat;background-size: contain;background-position: center;" class="card-img-top">

                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center text-decoration-none">Pets</h5>
                        </div>
                    </div>
                </a>
                <a href="./services" class="text-decoration-none text-dark">
                    <div class="card ms-1 me-2 py-2" style="width: 18rem;">
                        <div class="w-100 d-flex justify-content-center">
                            <div style="width: 250px; height:250px; border:1px solid #c8c8c8; border-radius:50%; background-image: url('./images/services.jpeg');
                            background-repeat: no-repeat;background-size: contain;background-position: center;" class="card-img-top">

                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center text-decoration-none">Services</h5>
                        </div>
                    </div>
                </a>
            </div>
            <hr>
            <?php include './common/posts.php' ?>
            <div class="row my-2">
                <div class="col-md-3">
                    &nbsp;
                </div>
                <div class="col-md-9 ">
                    <?php if ($posts->rowCount() != 0) { ?>
                        <div class="col-md-12 d-flex justify-content-center">
                            <?php if (isset($_GET['filter'])) {
                                if ($page != 1) { ?>
                                    <a type="button" href="./home?page=<?php echo $prev; ?>&filter=1" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-backward"></i></a>
                                <?php }
                                for ($i = 1; $i <= $nop; $i++) { ?>
                                    <a type="button" href="./home?page=<?php echo $i; ?>&filter=1" class="btn btn-sm 
                                        <?php if ($page != $i) {
                                            echo 'btn-outline-warning';
                                        } else {
                                            echo 'btn-outline-secondary';
                                        } ?> m-1"><?php echo $i; ?></a>
                                <?php
                                }
                                ?>
                                <?php if ($nop != $page) { ?>
                                    <a type="button" href="./home?page=<?php echo $next; ?>&filter=1" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-forward"></i></a>
                                <?php } ?>
                                <?php
                            } else {
                                if ($page != 1) { ?>
                                    <a type="button" href="./home?page=<?php echo $prev; ?>" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-backward"></i></a>
                                <?php }
                                for ($i = 1; $i <= $nop; $i++) { ?>
                                    <a type="button" href="./home?page=<?php echo $i; ?>" class="btn btn-sm 
                                        <?php if ($page != $i) {
                                            echo 'btn-outline-warning';
                                        } else {
                                            echo 'btn-outline-secondary';
                                        } ?> m-1"><?php echo $i; ?></a>
                                <?php
                                } ?>
                                <?php if ($nop != $page) { ?>
                                    <a type="button" href="./home?page=<?php echo $next; ?>" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-forward"></i></a>
                            <?php }
                            } ?>
                        <?php } ?>
                        </div>
                </div>
            </div>
        </div>
    </main>

    <?php include './common/footer.php' ?>
</body>
<?php include './common/script.php' ?>

</html>
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
        
        <div class="container">
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
                                    <a type="button" href="./pets?page=<?php echo $prev; ?>&filter=1" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-backward"></i></a>
                                <?php }
                                for ($i = 1; $i <= $nop; $i++) { ?>
                                    <a type="button" href="./pets?page=<?php echo $i; ?>&filter=1" class="btn btn-sm 
                                        <?php if ($page != $i) {
                                            echo 'btn-outline-warning';
                                        } else {
                                            echo 'btn-outline-secondary';
                                        } ?> m-1"><?php echo $i; ?></a>
                                <?php
                                }
                                ?>
                                <?php if ($nop != $page) { ?>
                                    <a type="button" href="./pets?page=<?php echo $next; ?>&filter=1" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-forward"></i></a>
                                <?php } ?>
                                <?php
                            } else {
                                if ($page != 1) { ?>
                                    <a type="button" href="./pets?page=<?php echo $prev; ?>" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-backward"></i></a>
                                <?php }
                                for ($i = 1; $i <= $nop; $i++) { ?>
                                    <a type="button" href="./pets?page=<?php echo $i; ?>" class="btn btn-sm 
                                        <?php if ($page != $i) {
                                            echo 'btn-outline-warning';
                                        } else {
                                            echo 'btn-outline-secondary';
                                        } ?> m-1"><?php echo $i; ?></a>
                                <?php
                                } ?>
                                <?php if ($nop != $page) { ?>
                                    <a type="button" href="./pets?page=<?php echo $next; ?>" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-forward"></i></a>
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
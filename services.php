<?php
session_start();
include './common/connection.php';
include './model/post.model.php';
$obp = new post();
$servicesType = $obp->getServiceType();
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
$f_servicetype = [];
$location = "";
if (count($_POST) > 0) {
    $arr = $_POST;
    $_SESSION['filter_s'] = $arr;
}
if (isset($_GET['filter_s']) || count($_POST) > 0) {
    if (isset($_SESSION['filter_s'])) {
        $arr = $_SESSION['filter_s'];
        $keyword = $_SESSION['filter_s']['keyword'];
        if (isset($_SESSION['filter_s']['f_servicetype'])) {
            $f_servicetype = $_SESSION['filter_s']['f_servicetype'];
        }
        if (isset($_SESSION['filter_s']['f_districts'])) {
            $f_districts = $_SESSION['filter_s']['f_districts'];
        }
        $location = $_SESSION['filter_s']['location'];



        $rposts = $obp->getServicesFilter($arr);
        $nor = $rposts->rowCount();
        $nop = ceil($nor / 10);
        $posts = $obp->getServicesPaginateFilter($arr, $start, $limit);
    }
    //
} else {
    $rposts = $obp->getServices();
    $nor = $rposts->rowCount();
    $nop = ceil($nor / 10);
    $posts = $obp->getServicesPaginate($start, $limit);
}

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
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3Pl2PT1QarbbQfjkjsXnatUKupPB8YT0&callback=initMap&libraries=&v=weekly"
      async
    ></script>
<script>
    function initMap() {
//     var clat = 7.223886065647188;
//     var clng = 80.72895999776105;
//     if($("#lat").val() != ""){
//       var clat =  parseFloat($("#lat").val());
//       var clng =  parseFloat($("#lng").val());
//     }
//   const myLatlng = { lat: clat, lng: clng};
  
//   const map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 7,
//     center: myLatlng,
//   });
//   // Create the initial InfoWindow.
//   let infoWindow = new google.maps.Marker({
//     position: myLatlng,
//     map,
//     title : "click your location"
//   });

}
function setServiceMap(divid,lat,lng,ltitle) {
    var clat = lat;
    var clng = lng;
    
    const myLatlng = { lat: clat, lng: clng};
  
    const map = new google.maps.Map(document.getElementById(divid), {
        zoom: 7,
        center: myLatlng,
    });
    const contentString =
    '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h6 id="firstHeading" class="firstHeading">'+ltitle+'</h6>' +
    '<div id="bodyContent">' +
    "</div>" +
    "</div>";
  const infowindow = new google.maps.InfoWindow({
    content: contentString,
  });
  const marker = new google.maps.Marker({
    position: myLatlng,
    map,
    title: ltitle,
  });

  marker.addListener("click", () => {
    infowindow.open({
      anchor: marker,
      map,
      shouldFocus: false,
    });
  });

  
}
</script>
    <?php include './common/header.php' ?>
    <main class="page-body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Services</h3>
                    <?php if (isset($_GET['msg'])) {  ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php echo base64_decode($_GET['msg']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-md-3">
                    <h6><u>Filter</u></h6>
                    <form action="" method="post">
                        <div class="mb-3 card card-shadow w-100 p-3">
                            <label for="exampleFormControlInput1" class="form-label">Search</label>
                            <hr class="my-0 mb-2">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Keyword">
                        </div>
                        <div class="mb-3 card card-shadow w-100 p-3">
                            <label for="exampleFormControlInput1" class="form-label">Location</label>
                            <hr class="my-0 mb-2">
                            <input type="text" name="location" value="<?php echo $location; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Location">
                        </div>

                        <div class="mb-3 card card-shadow w-100 p-3">
                            <label for="exampleFormControlInput1" class="form-label">Service Types</label>
                            <hr class="my-0 mb-2">
                            <?php while ($rc = $servicesType->fetch((PDO::FETCH_BOTH))) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" name="f_servicetype[]" type="checkbox" <?php if (in_array($rc['stype_id'], $f_servicetype)) {
                                                                                                                echo 'checked';
                                                                                                            } ?> value="<?php echo $rc['stype_id']; ?>" id="flexCheckDefault<?php echo $rc['stype_id'] ?>">
                                    <label class="form-check-label text-muted" for="flexCheckDefault<?php echo $rc['stype_id'] ?>">
                                        <?php echo $rc['service_name'] ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="mb-3 card card-shadow w-100 p-3">
                            <label for="exampleFormControlInput1" class="form-label">District</label>
                            <hr class="my-0 mb-2">
                            <?php while ($rd = $districts->fetch((PDO::FETCH_BOTH))) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" name="f_districts[]" type="checkbox" <?php if (in_array($rd['district_id'], $f_districts)) {
                                                                                                                echo 'checked';
                                                                                                            } ?> value="<?php echo $rd['district_id']; ?>" id="flexCheckDefaultD<?php echo $rd['district_id'] ?>">
                                    <label class="form-check-label text-muted" for="flexCheckDefaultD<?php echo $rd['district_id'] ?>">
                                        <?php echo $rd['district_name'] ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="mb-3 w-100 p-3">
                            <button type="submit" class="btn btn-warning w-100">Filter</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 ">
                    <?php if ($posts->rowCount() == 0) { ?>
                        <div class="alert alert-info w-100 text-center" role="alert">
                            No Services available
                        </div>
                    <?php } ?>
                    <?php while ($row = $posts->fetch(PDO::FETCH_BOTH)) {
                        if ($row['service_id'] != null) { ?>
                            <div class="card ms-1 me-2 py-2 my-2 mb-2 w-100 card-shadow">
                                <div class="card-body row">
                                    <div class="col-md-5 d-flex justify-content-center">
                                        <div class="w-100" style="height: 100%;" id="sevicemap<?php echo $row['service_id'] ?>">
                                        <?php echo  "<script>setServiceMap('sevicemap".$row['service_id']."',".$row['lat'].",".$row['lng'].",'".$row['service_title']."');</script>" ?>
                                    </div>
                                    </div>
                                    <div class="col-md-7">
                                        <small class="text-muted my-3" style="font-size: 13px;"><?php echo $row['service_name'] ?></small>
                                        <h4 class="mb-0"><?php echo $row['service_title'] ?></h4>
                                        <!-- <small class="text-muted" style="font-size: 12px;"><i>by <?php echo $row['owner_name'] ?></i></small> -->
                                        <p class="my-2">
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <small class="text-muted" style="font-size: 11px;"><i class="fas fa-phone"></i> &nbsp;<?php echo $row['contact'] ?></small><br>
                                        <small class="text-muted" style="font-size: 11px;"><i class="fas fa-map-marker-alt"></i> &nbsp;<?php echo $row['service_address'] ?></small><br>
                                        <small class="text-muted" style="font-size: 11px;"><i class="fas fa-map-marker-alt"></i> &nbsp;<?php echo $row['district_name'] ?></small><br>
                                        <br>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#booknow<?php echo $row['service_id'] ?>">Book Now</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="booknow<?php echo $row['service_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['service_title'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <form method="post" action="./controller/post.controller?action=bookNow" class="row g-3 needs-validation" id="" novalidate enctype="multipart/form-data">
                                                    <input type="hidden" name="service_id" value="<?php echo $row['service_id']; ?>">
                                                    <input type="hidden" name="service_name" value="<?php echo $row['service_name']; ?>">
                                                    <input type="hidden" name="service_title" value="<?php echo $row['service_title']; ?>">
                                                    <input type="hidden" name="district_name" value="<?php echo $row['district_name']; ?>">
                                                    <input type="hidden" name="service_address" value="<?php echo $row['service_address']; ?>">
                                                    <input type="hidden" name="contact" value="<?php echo $row['contact']; ?>">
                                                    <div class="col-md-6">
                                                        <label for="validationCustom01" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" id="validationCustom01" value=""  required>
                                                        <div class="invalid-feedback">
                                                            Please fill the Name
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="validationCustom01" class="form-label">Contact Number</label>
                                                        <input type="text" maxlength="10" minlength="10" class="form-control" name="contact" id="validationCustom01" value="" onkeypress="return isNumber(event)" required>
                                                        <div class="invalid-feedback">
                                                            Please fill the Service Contact Number
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="validationCustom01" class="form-label"> Address</label>
                                                        <input type="text" class="form-control" name="address" id="validationCustom01" value="" required>
                                                        <div class="invalid-feedback">
                                                            Please fill the Service Address
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="validationCustom02" class="form-label">Email</label>
                                                        <input type="email" class="form-control " name="email" id="validationCustom02" required>
                                                        <div class="invalid-feedback">
                                                            Please fill a valid email

                                                        </div>
                                                    </div>


                                                    <div class="col-12">
                                                        <button class="btn btn-warning w-100" type="submit">Book Now</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }
                        if ($posts->rowCount() == 1 && $row['service_id'] == null) { ?>
                            <div class="alert alert-info w-100 text-center" role="alert">
                                No posts available
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($posts->rowCount() != 0) { ?>
                        <div class="col-md-12 d-flex justify-content-center">
                            <?php if (isset($_GET['filter'])) {
                                if ($page != 1) { ?>
                                    <a type="button" href="./services?page=<?php echo $prev; ?>&filter=1" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-backward"></i></a>
                                <?php }
                                for ($i = 1; $i <= $nop; $i++) { ?>
                                    <a type="button" href="./services?page=<?php echo $i; ?>&filter=1" class="btn btn-sm 
                                        <?php if ($page != $i) {
                                            echo 'btn-outline-warning';
                                        } else {
                                            echo 'btn-outline-secondary';
                                        } ?> m-1"><?php echo $i; ?></a>
                                <?php
                                }
                                ?>
                                <?php if ($nop != $page) { ?>
                                    <a type="button" href="./services?page=<?php echo $next; ?>&filter=1" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-forward"></i></a>
                                <?php } ?>
                                <?php
                            } else {
                                if ($page != 1) { ?>
                                    <a type="button" href="./services?page=<?php echo $prev; ?>" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-backward"></i></a>
                                <?php }
                                for ($i = 1; $i <= $nop; $i++) { ?>
                                    <a type="button" href="./services?page=<?php echo $i; ?>" class="btn btn-sm 
                                        <?php if ($page != $i) {
                                            echo 'btn-outline-warning';
                                        } else {
                                            echo 'btn-outline-secondary';
                                        } ?> m-1"><?php echo $i; ?></a>
                                <?php
                                } ?>
                                <?php if ($nop != $page) { ?>
                                    <a type="button" href="./services?page=<?php echo $next; ?>" class="btn btn-sm btn-outline-warning m-1"><i class="fas fa-forward"></i></a>
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



</html>
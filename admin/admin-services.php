<?php
include '../common/adminsessionhandeling.php';
include '../common/connection.php';
include '../model/admin.model.php';
include '../model/post.model.php';
$oba = new admin();
$obp = new post();
$posts = $oba->getServices();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Petlovers</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>

<body>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3Pl2PT1QarbbQfjkjsXnatUKupPB8YT0&callback=initMap&libraries=&v=weekly" async></script>
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

        function setServiceMap(divid, lat, lng, ltitle) {
            var clat = lat;
            var clng = lng;

            const myLatlng = {
                lat: clat,
                lng: clng
            };

            const map = new google.maps.Map(document.getElementById(divid), {
                zoom: 7,
                center: myLatlng,
            });
            const contentString =
                '<div id="content">' +
                '<div id="siteNotice">' +
                "</div>" +
                '<h6 id="firstHeading" class="firstHeading">' + ltitle + '</h6>' +
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
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">PETLOVERS</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="./login">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="#">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./admin-adds">
                                <span data-feather="file"></span>
                                Advertisements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./admin-services">
                                <span data-feather="shopping-cart"></span>
                                Services
                            </a>
                        </li>
                        <hr>
                        <li class="nav-item"><b><u>Reports</u></b></li>
                        <li class="nav-item">
                            <a class="nav-link " href="./users">
                                <span data-feather="file"></span>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./advertisements">
                                <span data-feather="file"></span>
                                Advertisements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./services">
                                <span data-feather="shopping-cart"></span>
                                Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./service-booking">
                                <span data-feather="users"></span>
                                Service Booking
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./donation">
                                <span data-feather="bar-chart-2"></span>
                                Donations
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                </div>
                <h2>Services</h2>
                <?php if (isset($_GET['msg'])) {  ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo base64_decode($_GET['msg']); ?>
                    </div>
                <?php } ?>
                <div class="row my-2">
                    <div class="col-md-12 ">
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
                                                <?php
                                                echo  "<script>setServiceMap('sevicemap" . $row['service_id'] . "'," . $row['lat'] . "," . $row['lng'] . ",'" . $row['service_title'] . "');</script>"
                                                ?>
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
                                            <a href="./edit-service?service_id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-warning my-1">EDIT</a>
                                            <a href="../controller/admin.controller?action=deleteService&service_id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-danger my-1">Delete</a>
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
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="dashboard.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reporttable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>
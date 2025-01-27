<?php
include '../common/adminsessionhandeling.php';
include '../common/connection.php';
include '../model/admin.model.php';
include '../model/post.model.php';
$obpp = new post();
$servicesType = $obpp->getServiceType();
$districts= $obpp->getDistricts();
$data = $obpp->getService($_GET['service_id']);
$count = $data->rowCount();
if ($count == 0) {
    header("Location:./admin-services");
} else {
    $post = $data->fetch(PDO::FETCH_BOTH);
}
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
                <h2>Edit Services</h2>
                <?php if (isset($_GET['msg'])) {  ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo base64_decode($_GET['msg']); ?>
                    </div>
                <?php } ?>
                <form method="post" action="../controller/admin.controller?action=updateService" class="row g-3 needs-validation" id="addServiceForm" novalidate enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $post['service_id'] ?>" name="service_id">
                    <div class="col-12">
                        <label class="form-lable">Service Type</label>
                        <?php
                        $i = 0;
                        while ($rp = $servicesType->fetch((PDO::FETCH_BOTH))) { ?>
                            <div class="form-check ms-5 ps-5">
                                <input class="form-check-input " type="radio" name="service_type" id="flexRadioDefault1" value="<?php echo $rp['stype_id'] ?>" <?php if ($rp['stype_id'] == $post['stype_id']) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    <b><?php echo $rp['service_name'] ?></b>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">District</label>
                        <select class="form-select" name="district" required>
                            <option value="">Select the District</option>
                            <?php
                            while ($rc = $districts->fetch((PDO::FETCH_BOTH))) { ?>
                                <option value="<?php echo $rc['district_id'] ?>" <?php if ($rc['district_id'] == $post['district_id']) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $rc['district_name'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Please Select the District
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">Service Title</label>
                        <input type="text" class="form-control" name="service_title" id="validationCustom01" value="<?php echo $post['service_title'] ?>" required>
                        <div class="invalid-feedback">
                            Please fill the Title
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom01" class="form-label">Service Contact Number</label>
                        <input type="text" maxlength="10" minlength="10" class="form-control" name="contact" id="validationCustom01" value="<?php echo $post['contact'] ?>" onkeypress="return isNumber(event)" required>
                        <div class="invalid-feedback">
                            Please fill the Service Contact Number
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom01" class="form-label">Service Address</label>
                        <input type="text" class="form-control" name="service_address" id="validationCustom01" value="<?php echo $post['service_address'] ?>" required>
                        <div class="invalid-feedback">
                            Please fill the Service Address
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label ">Description</label>
                        <textarea name="description" maxlength="500" class="form-control" id="validationCustom01" required><?php echo $post['description'] ?></textarea>
                        <div class="invalid-feedback">
                            Please fill Description
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label ">Location</label>
                        <input type="hidden" name="lat" id="lat" value="<?php echo $post['lat'] ?>">
                        <input type="hidden" name="lng" id="lng" value="<?php echo $post['lng'] ?>">
                        <div id="map" style="height: 500px;"></div>
                    </div>


                    <div class="col-12 mb-3">
                        <button class="btn btn-warning w-100" type="submit">UPDATE SERVICE</button>
                    </div>
                </form>
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3Pl2PT1QarbbQfjkjsXnatUKupPB8YT0&callback=initMap&libraries=&v=weekly" async></script>
    <script>
        function initMap() {
            var clat = 7.223886065647188;
            var clng = 80.72895999776105;
            if ($("#lat").val() != "") {
                var clat = parseFloat($("#lat").val());
                var clng = parseFloat($("#lng").val());
            }
            const myLatlng = {
                lat: clat,
                lng: clng
            };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 7,
                center: myLatlng,
            });
            // Create the initial InfoWindow.
            let infoWindow = new google.maps.Marker({
                position: myLatlng,
                map,
                title: "click your location"
            });

            //infoWindow.open(map);
            // Configure the click listener.
            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                //infoWindow.close();
                // Create a new InfoWindow.
                infoWindow.setMap(null);
                $("#lat").val(mapsMouseEvent.latLng.toJSON().lat);
                $("#lng").val(mapsMouseEvent.latLng.toJSON().lng);
                infoWindow = new google.maps.Marker({
                    position: mapsMouseEvent.latLng,
                    map,
                    title: ""
                });
                // infoWindow.setContent(
                //   JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                // );
                // infoWindow.open(map);
            });
        }
    </script>

</body>

</html>
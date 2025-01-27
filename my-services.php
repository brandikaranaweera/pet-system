<?php
session_start();
include './common/connection.php';
include './model/post.model.php';
$obp = new post();
$posts = $obp->getUserServices($_SESSION['user']['user_id']);
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
                    <h3 class="text-center">My Services</h3>
                    <?php if (isset($_GET['msg'])) {  ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php echo base64_decode($_GET['msg']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
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
                                        echo  "<script>setServiceMap('sevicemap".$row['service_id']."',".$row['lat'].",".$row['lng'].",'".$row['service_title']."');</script>" 
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
                                        <a href="./controller/post.controller?action=deleteService&service_id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-danger my-1">Delete</a>
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
        </div>
    </main>

    <?php include './common/footer.php' ?>
</body>



</html>
<?php
include './common/sessionhandeling.php';
include './common/connection.php';
include './model/post.model.php';
if(isset($_SESSION["old_service"])){
    $service_title = $_SESSION['old_service']['service_title'];
    $district = $_SESSION['old_service']['district'];
    $stype = $_SESSION['old_service']['service_type'];
    $description = $_SESSION['old_service']['description'];
    $lat = $_SESSION['old_service']['lat'];
    $lng = $_SESSION['old_service']['lng'];
    $address = $_SESSION['old_service']['service_address'];
    $contact = $_SESSION['old_service']['contact'];
}else{
    $service_title = "";
    $district = "";
    $stype = "1";
    $description = "";
    $lat = "";
    $lng = "";
    $address = "";
    $contact = "";
}

$obpp = new post();
$servicesType = $obpp->getServiceType();
$districts= $obpp->getDistricts();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pet Lovers</title>
    <?php include './common/styles.php' ?>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
</head>

<body>
    <?php include './common/header.php' ?>
    <div class="container page-body d-flex justify-content-center align-items-center">
        <div class="col-md-12 py-3 pb-3 form-signup my-5 mb-5">
            <h4 class="text-center">Add Service</h4>
            <form method="post" action="./controller/post.controller?action=addService" class="row g-3 needs-validation" id="addServiceForm" novalidate enctype="multipart/form-data">
                <div class="col-12">
                    <label class="form-lable">Service Type</label>
                    <?php 
                    $i=0;
                        while($rp=$servicesType->fetch((PDO::FETCH_BOTH))){?>
                        <div class="form-check ms-5 ps-5">
                            <input class="form-check-input " type="radio" name="service_type" id="flexRadioDefault1" value="<?php echo $rp['stype_id'] ?>"  <?php if($rp['stype_id']==$stype){echo 'checked';} ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                <b><?php echo $rp['service_name'] ?></b>
                            </label>
                        </div>
                    <?php }?>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">District</label>
                    <select class="form-select" name="district" required>
                        <option value="">Select the District</option>
                        <?php 
                            while($rc=$districts->fetch((PDO::FETCH_BOTH))){?>
                            <option value="<?php echo $rc['district_id']?>" <?php if($rc['district_id']==$district){echo 'selected';} ?>><?php echo $rc['district_name'] ?></option>
                        <?php }?>
                    </select>
                    <div class="invalid-feedback">
                        Please Select the District
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Service Title</label>
                    <input type="text" class="form-control" name="service_title" id="validationCustom01" value="<?php echo $service_title ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Title
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Service Contact Number</label>
                    <input type="text" maxlength="10" minlength="10" class="form-control" name="contact" id="validationCustom01" value="<?php echo $contact?>" onkeypress="return isNumber(event)" required>
                    <div class="invalid-feedback">
                        Please fill the Service Contact Number
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Service Address</label>
                    <input type="text" class="form-control" name="service_address" id="validationCustom01" value="<?php echo $address ?>" required>
                    <div class="invalid-feedback">
                        Please fill the Service Address
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Description</label>
                    <textarea name="description" maxlength="500" class="form-control" id="validationCustom01" required><?php echo $description ?></textarea>
                    <div class="invalid-feedback">
                        Please fill Description
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label ">Location</label>
                    <input type="hidden" name="lat" id="lat" value="<?php echo $lat ?>">
                    <input type="hidden" name="lng" id="lng" value="<?php echo $lng ?>">
                    <div id="map" style="height: 500px;"></div>
                </div>

                
                <div class="col-12">
                    <button class="btn btn-warning w-100" type="submit">ADD SERVICE</button>
                </div>
            </form>
        </div>
    </div>
    <?php include './common/footer.php' ?>
</body>
<?php include './common/script.php' ?>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3Pl2PT1QarbbQfjkjsXnatUKupPB8YT0&callback=initMap&libraries=&v=weekly"
      async
    ></script>
<script>
function initMap() {
    var clat = 7.223886065647188;
    var clng = 80.72895999776105;
    if($("#lat").val() != ""){
      var clat =  parseFloat($("#lat").val());
      var clng =  parseFloat($("#lng").val());
    }
  const myLatlng = { lat: clat, lng: clng};
  
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 7,
    center: myLatlng,
  });
  // Create the initial InfoWindow.
  let infoWindow = new google.maps.Marker({
    position: myLatlng,
    map,
    title : "click your location"
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
      title : ""
    });
    // infoWindow.setContent(
    //   JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
    // );
    // infoWindow.open(map);
  });
}
</script>

</html>
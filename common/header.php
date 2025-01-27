<nav class="d-flex justify-content-center bg-secondary" >
   <div class="container d-flex justify-content-between row p-0">
       <div class="col-lg-6 text-white p-0">
       <i class="fa fa-phone" aria-hidden="true"></i> 07712345678 &nbsp;
        <i class="fa fa-envelope h6" aria-hidden="true"></i> test@gmail.com 
       </div>
       <div class="col-lg-6 d-felx justify-content-between p-0">
            <ul class="nav justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-white" href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="ms-3"><a class="text-white" href="#"><i class="fab fa-instagram"></i></a></li>
                <li class="ms-3"><a class="text-white" href="#"><i class="fab fa-facebook"></i></a></li>
            </ul>
       </div>
   </div> 
</nav>
<header class="p-3 bg-dark text-white sticky-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <!-- <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-secondary text-decoration-none">
            LOGO
            </a> -->

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="./" class="nav-link px-2 text-white">Home</a></li>
            <li><a href="./pets" class="nav-link px-2 text-white">Pets</a></li>
            <li><a href="./services" class="nav-link px-2 text-white">Services</a></li>
            <li><a href="./about-us" class="nav-link px-2 text-white">About Us</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <!-- <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search"> -->
                <?php if(isset($_SESSION['user'])){ 
                if($_SESSION['user']['for_advertise'] == "1"){ ?>
                    <a  href="./sell-pet" type="button" class="btn btn-warning me-2">Sell Pet</a>
                <?php }
                if($_SESSION['user']['for_services'] == "1"){ ?>
                    <a href="./add-service" type="button" class="btn btn-outline-light ">Add Service</a>
                <?php }?>
                
                
                <?php } ?>
            </form>

            <div class="text-end">
            <?php if(isset($_SESSION['user'])){ ?>
                
                <a href="#" class="d-block link-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle"> -->
                    <span class="rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; background-color:#ffc107;">
                        <b><?php echo ucfirst(substr($_SESSION['user']['first_name'],0,1));?></b>
                    </span>
                </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a href="./profile" class="dropdown-item"><b ><?php echo $_SESSION['user']['first_name'].' '.$_SESSION['user']['last_name'];?></b></span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="./my-posts" class="dropdown-item" href="./profile.php">My Advertisements</a></li>
            <li><a href="./my-services" class="dropdown-item" href="./profile.php">My Services</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./logout">Sign out</a></li>
          </ul>
            <?php } else{ ?>
                <a  href="./login" type="button" class="btn btn-outline-light me-2">Login</a>
                <a href="./register" type="button" class="btn btn-warning">Register</a>
            <?php } ?>
            
            </div>
        </div>
    </div>
</header>
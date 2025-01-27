<div class="row">
    <div class="col-md-12">
        <h3 class="text-center">PETS</h3>
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
                <label for="exampleFormControlInput1" class="form-label">Categories</label>
                <hr class="my-0 mb-2">
                <?php while ($rc = $categories->fetch((PDO::FETCH_BOTH))) { ?>
                    <div class="form-check">
                        <input class="form-check-input" name="f_categories[]" type="checkbox" <?php if (in_array($rc['cat_id'], $f_categories)) {
                                                                                                    echo 'checked';
                                                                                                } ?> value="<?php echo $rc['cat_id']; ?>" id="flexCheckDefault<?php echo $rc['cat_id'] ?>">
                        <label class="form-check-label text-muted" for="flexCheckDefault<?php echo $rc['cat_id'] ?>">
                            <?php echo $rc['cat_name'] ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-3 card card-shadow w-100 p-3">
                <label for="exampleFormControlInput1" class="form-label">Price</label>
                <hr class="my-0 mb-2">
                <input type="text" name="minprice" value="<?php echo $minprice; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Min" onkeypress="return isNumber(event)">
                <br>
                <input type="text" name="maxprice" value="<?php echo $maxprice; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Max" onkeypress="return isNumber(event)">
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
                No posts available
            </div>
        <?php } ?>
        <?php while ($row = $posts->fetch(PDO::FETCH_BOTH)) {
            if ($row['add_id'] != null) { ?>
                <div class="card ms-1 me-2 py-2 my-2 mb-2 w-100 card-shadow">
                    <div class="card-body row">
                        <div class="col-md-3 d-flex justify-content-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#postmodal<?php echo $row['add_id'] ?>">
                                <?php
                                ${'post_img' . $row['add_id']} = $obp->getBannerImage($row['add_id']);
                                if ($row['image_count'] > 0) {
                                    while ($im = ${'post_img' . $row['add_id']}->fetch(PDO::FETCH_BOTH)) { ?>
                                        <img src="./images/posts/<?php echo $im['image']; ?>" width="100%">
                                    <?php
                                    }
                                } else { ?>
                                    <img src="https://i.stack.imgur.com/y9DpT.jpg" width="100%">
                                <?php }
                                ?>
                            </a>
                        </div>
                        <div class="col-md-7">
                            <small class="text-muted my-3" style="font-size: 13px;"><?php echo $row['cat_name'] ?></small>
                            <h4 class="mb-0"><?php echo $row['post_title'] ?></h4>
                            <small class="text-muted" style="font-size: 12px;"><i>by <?php echo $row['owner_name'] ?></i></small>
                            <p class="my-2">
                                <?php echo $row['description']; ?>
                            </p>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-center" style="border-left:1px solid #c6c6c6;">
                            <div class="text-center">
                                <h6>Rs <?php echo $row['price'] ?>/=</h6>
                                <p class="mb-0 pb-0"><?php echo $row['owner_contact'] ?></p>
                                <small class="text-muted" style="font-size: 11px;"><i class="fas fa-map-marker-alt"></i> &nbsp;<?php echo $row['district_name'] ?></small><br>
                                <small class="text-muted" style="font-size: 10px;">Posted : <?php echo $row['published_date'] ?></small>
                                <a href="tel:<?php echo $row['owner_contact'] ?>" class="btn btn-sm btn-outline-warning my-1">Call Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="postmodal<?php echo $row['add_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['post_title'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="carouselpostimages<?php echo $row['add_id'] ?>" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <?php ${'post_img' . $row['add_id']} = $obp->getPostImages($row['add_id']);
                                                if ($row['image_count'] > 0) {
                                                    $i = 0;
                                                    while ($im = ${'post_img' . $row['add_id']}->fetch(PDO::FETCH_BOTH)) { ?>
                                                        <button type="button" data-bs-target="#carouselpostimages<?php echo $row['add_id'] ?>" data-bs-slide-to="<?php echo $i; ?>" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <?php $i++;
                                                    }
                                                } ?>
                                            </div>
                                            <div class="carousel-inner">
                                                <?php ${'post_imgg' . $row['add_id']} = $obp->getPostImages($row['add_id']);
                                                if ($row['image_count'] > 0) {
                                                    $i = 0;
                                                    while ($imm = ${'post_imgg' . $row['add_id']}->fetch(PDO::FETCH_BOTH)) { ?>
                                                        <div class="carousel-item <?php if ($i == 0) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                                            <img src="./images/posts/<?php echo $imm['image']; ?>" class="d-block w-100" alt="...">
                                                        </div>
                                                <?php $i++;
                                                    }
                                                } ?>

                                            </div>

                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselpostimages<?php echo $row['add_id'] ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselpostimages<?php echo $row['add_id'] ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 my-3">
                                        <p><b>Category</b> &nbsp; <?php echo $row['cat_name'] ?></p>
                                        <p><b>Owner</b> &nbsp; <?php echo $row['owner_name'] ?></p>
                                        <p><b>Contact No</b> &nbsp; <?php echo $row['owner_contact'] ?></p>
                                        <p><b>Address</b> &nbsp; <?php echo $row['owner_address'] ?></p>
                                        <p><b>District</b> &nbsp; <?php echo $row['district_name'] ?></p>
                                        <p><b>Pet Age</b> &nbsp; <?php echo $row['pet_age'] ?></p>
                                        <p><b>Price</b> &nbsp; <?php echo $row['price'] ?></p>
                                        <p><b>Description</b> &nbsp; <?php echo $row['description'] ?></p>
                                        <p><b>Posted Date</b> &nbsp; <?php echo $row['published_date'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php }
            if ($posts->rowCount() == 1 && $row['add_id'] == null) { ?>
                <div class="alert alert-info w-100 text-center" role="alert">
                    No posts available
                </div>
            <?php } ?>
        <?php } ?>

        
    </div>
</div>
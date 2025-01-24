  <?php
  $dem = "col-md-6";
    if ($blog_result->num_rows > 0) {
        // Display featured packages from the database <?= htmlspecialchars($row['name']) 
        while ($row = $blog_result->fetch_assoc()) {
            $displayed_rows_blog++;
            if($displayed_rows_blog > 2){
                $dem = "col-md-4";
            }else{
                $dem = "col-md-6";
            }
    ?>
            <div class="col-md-6 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('<?= htmlspecialchars($row['name']) ?>');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span><a href="?b=<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['post_date']) ?></a></span></p>
<h3 class="heading mb-3"><a href="#"><?= htmlspecialchars($row['title']) ?></a></h3>
<p><?= htmlspecialchars($row['description']) ?></p>
</div>
</div>
</div>
    <?php
        }
    }

    // Fill remaining cards with default content
    while ($displayed_rows_blog < $total_cards_blog) {
        $displayed_rows_blog++;
        if($displayed_rows_blog > 2){
            $dem = "col-md-4";
        }else{
            $dem = "col-md-6";
        }
    ?>
     <div class="col-md-6 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('<?= htmlspecialchars($row['name']) ?>');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span><a href="#"><?= htmlspecialchars($default_blog['name']) ?></a></span></p>
<h3 class="heading mb-3"><a href="#"><?= htmlspecialchars($default_blog['title']) ?></a></h3>
<p><?= htmlspecialchars($default_blog['description']) ?></p>
</div>
</div>
</div>  
    <?php
    }
    ?>	

//=====================
<div class="col-md-6 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('images/k1.jpg');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span>Jan. 01, 2024</span><a href="#">0 Comments</a></p>
<h3 class="heading mb-3"><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor</p>
</div>
</div>
</div>
//===========================================

//=======================================
<?php
    if ($blog_result->num_rows > 0) {
        // Display featured packages from the database <?= htmlspecialchars($row['name']) 
        while ($row = $blog_result->fetch_assoc()) {
            $displayed_rows_blog++;
    ?>
            
    <?php
        }
    }

    // Fill remaining cards with default content
    while ($displayed_rows_blog < $total_cards_blog) {
        $displayed_rows_blog++;
    ?>
       
    <?php
    }
    ?>	

    //=================================Destination Code ===========================

    <?php
    if ($destination_result->num_rows > 0) {
        // Display featured packages from the database <?= htmlspecialchars($row['name']) 
        while ($row = $destination_result->fetch_assoc()) {
            $displayed_rows++;
    ?>
     <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="card product-card">
                <a href="<?= htmlspecialchars($row['name']) ?>" target="_blank">
                  <img src="<?= htmlspecialchars($image_paths) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="card-img-top">
                  <div class="card-body">
                    <!-- <div class="d-flex justify-content-between">
                      <div class="duration">6 days &amp; 5 nights</div>
                      <div class="rating-box">
                        <div class="star-rating">
                            <i class="fa fa-star checked" data-index="0"></i>
                            <i class="fa fa-star checked" data-index="1"></i>
                            <i class="fa fa-star checked" data-index="2"></i>
                            <i class="fa fa-star checked" data-index="3"></i>
                            <i class="fa fa-star unchecked" data-index="4"></i>
                        </div>
                        <div class="rating">4.5</div>
                        <div class="rating-count">(2.2K)</div>
                      </div>
                    </div> -->
                    <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                    <div class="d-flex justify-content-between">
                      <div class="duration"><?= htmlspecialchars($row['description']) ?></div>
                    </div>
                    <a href="<?= htmlspecialchars($row['link']) ?>"><button class="btn btn-primary btn-block">View Details</button></a>
                  </div>
                </a>
              </div>
        </div>       
    <?php
        }
    }

    // Fill remaining cards with default content
    while ($displayed_rows < $total_cards) {
        $displayed_rows++;
    ?>
       <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="card product-card">
                <a href="<?= htmlspecialchars($default_destinations['name']) ?>" target="_blank">
                  <img src="<?= htmlspecialchars($default_destinations['image_path']) ?>" alt="<?= htmlspecialchars($default_destinations['name']) ?>" class="card-img-top">
                  <div class="card-body">
                    <!-- <div class="d-flex justify-content-between">
                      <div class="duration">6 days &amp; 5 nights</div>
                      <div class="rating-box">
                        <div class="star-rating">
                            <i class="fa fa-star checked" data-index="0"></i>
                            <i class="fa fa-star checked" data-index="1"></i>
                            <i class="fa fa-star checked" data-index="2"></i>
                            <i class="fa fa-star checked" data-index="3"></i>
                            <i class="fa fa-star unchecked" data-index="4"></i>
                        </div>
                        <div class="rating">4.5</div>
                        <div class="rating-count">(2.2K)</div>
                      </div>
                    </div> -->
                    <h5 class="card-title"><?= htmlspecialchars($default_destinations['title']) ?></h5>
                    <div class="d-flex justify-content-between">
                      <div class="duration"><?= htmlspecialchars($default_destinations['description']) ?></div>
                    </div>
                    <a href="<?= htmlspecialchars($default_destinations['link']) ?>"><button class="btn btn-primary btn-block">View Details</button></a>
                  </div>
                </a>
              </div>
        </div>
    <?php
    }
    ?>	


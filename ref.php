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
//===============================================Packages======================

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
=================================================================================================

<?php
    if ($blog_result->num_rows > 0) {
        // Display featured packages from the database <?= htmlspecialchars($row['name']) 
        while ($row = $blog_result->fetch_assoc()) {
            $displayed_rows_blog++;
            $image_path = explode(",",$row["image_paths"]);
            $displayed_rows_blog++;
            if($displayed_rows_blog > 6){
                $dem = "col-md-4";
            }else{
                $dem = "col-md-6";
            }
    ?>
             <div class="<?php echo htmlspecialchars($dem); ?> mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($image_path[0]); ?>" class="card-img-top" alt="Blog Image 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="blog-details.php?bid=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary">Read More</a>
                            <span class="float-end text-muted"><?= htmlspecialchars($row['post_date']) ?></span>
                        </div>
                    </div>
                </div>
    <?php
        }
    }

    // Fill remaining cards with default content
    while ($displayed_rows_blog < $total_cards_blog) {
        $displayed_rows_blog++;
    ?>
        <div class="<?php echo htmlspecialchars($dem); ?> mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($image_path[0]); ?>" class="card-img-top" alt="Blog Image 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($default_blog['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($default_blog['description']) ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="blog-details.php?bid=<?= htmlspecialchars($default_blog['id']) ?>" class="btn btn-primary">Read More</a>
                            <span class="float-end text-muted"><?= htmlspecialchars($default_blog['post_date']) ?></span>
                        </div>
                    </div>
                </div>
    <?php
    }
    ?>	

<?php
//=============================================
Array
(
    [package_id] => 6
    [package_name] => gulmarg 3 star
    [package_description] => wssdsds
sddsd

    [duration] => 6 Night & 7 Days
    [price] => 22220.00
    [destination_id] => 10
    [main_image] => 
    [is_trending] => 0
    [is_featured] => 0
    [rating] => 5.0
    [is_honeymoon] => 0
    [is_adventure] => 0
    [is_premium] => 0
    [is_budget] => 0
    [reviews] => 12200
    [additional_image] => images/k1.jpg
    [itinerary] => Day 1: Arrival in Leh
Arrive in Leh, where our representative will greet you at the airport and transfer you to the hotel. Spend the day acclimatizing to the high altitude.*Day 2: Leh - Local Sightseeing
Visit the famous Shanti Stupa, Leh Palace, and the bustling Leh Market. Return to the hotel in the evening.*Day 3: Leh to Nubra Valley
Drive through the Khardung La Pass to reach Nubra Valley. Visit Diskit Monastery and enjoy a camel ride in the sand dunes.
    [inclusions] => Accommodation in 3-star hotels
Daily breakfast and dinner
Airport transfers
All sightseeing tours by private cab
Inner line permits
    [exclusions] => Airfare
Lunch 
Any personal expenses
Travel insurance
    [charges_for_exclusions] => 800.00
    [terms_and_conditions] => Please read the following terms and conditions carefully before booking the tour. By booking, you agree to all the terms mentioned below.
    [created_at] => 2025-02-03 15:46:59

    ?>


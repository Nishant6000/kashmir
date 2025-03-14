<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kashmir Meridian</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
    <link rel="stylesheet" href="css/css-animate.css">
    <link rel="stylesheet" href="css/css-flaticon.css">
    <link rel="stylesheet" href="css/css-tiny-slider.css">
    <link rel="stylesheet" href="css/css-glightbox.min.css">
    <link rel="stylesheet" href="css/css-aos.css">
    <link rel="stylesheet" href="css/css-style.css">
    </head>
<body>
<?php
    $conn = new mysqli("localhost", "root", "", "kashmir_tourism");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['loc'])) {
        $location = $_GET['loc'];
        $no_of_travellers = 2;
        $price_limit = 100000; // Convert ₹10,000 to 10000
    }else{
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $no_of_travellers = isset($_POST['no_of_travellers']) ? (int)$_POST['no_of_travellers'] : 0;
    $price_limit = isset($_POST['price_limit']) ? (int)str_replace(['₹', ','], '', $_POST['price_limit']) : 0; // Convert ₹10,000 to 10000
    }
    if (!empty($location) && $price_limit > 0) {
        // Get destination ID based on location
        $stmt = $conn->prepare("SELECT id FROM destinations WHERE name = ?");
        $stmt->bind_param("s", $location);
        $stmt->execute();
        $stmt->bind_result($destination_id);
        $stmt->fetch();
        $stmt->close();
    
        if ($destination_id) {
            // Get packages based on destination_id and price limit
            $sql = "SELECT 
                        *
                    FROM packages p
                    LEFT JOIN packages_images pi ON p.id = pi.package_id
                    WHERE p.destination_id = ? AND p.price <= ?
                    GROUP BY p.id";
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $destination_id, $price_limit);
            $stmt->execute();
            $featured_result = $stmt->get_result();
            //$featured_result = $result->fetch_all();
            
            $stmt->close();
            if ($featured_result->num_rows == 0) {
                echo "<script>
                        alert('No Results found for this location! Going back.');
                        window.history.back();
                      </script>";
                exit;
            }
           
            //die;
        } else {
            echo "<script>
            alert('No Results found for this location! Going back.');
            window.history.back();
          </script>";
    exit;
        }
    } else {
       
        echo "<script>
        alert('Please select valid inputs.! Going back.');
        window.history.back();
      </script>";
exit;
    }


//die;
$default_featured = array();
$default_featured['id'] = "1";
$default_featured['name'] = "Romantic Escape to Kashmir | FREE Excursion to Gulmarg";
$default_featured['description'] = "Romantic Escape to Kashmir | FREE Excursion to Gulmarg";
$default_featured['duration'] = "6 days & 5 Night";
$default_featured['price'] = "12000";
$default_featured['link'] = "";
$default_featured['image'] = "images/k1.jpg";
$default_featured['rating'] = "4.0";
$default_featured['reviews'] = "1200";
// Count how many rows have been displayed
$displayed_rows = 0;
$total_cards = 9; // Minimum cards to display
?>
<!-- <div class="py-4 top-wrap">
<div class="container-xl">
<div class="row d-flex align-items-start">
<div class="col-md topper d-flex mb-md-0 align-items-xl-center">
<div class="icon d-flex justify-content-center align-items-center"><span class="fa fa-map"></span>
</div>
<div class="text pl-3 pl-md-3">
<p class="con"><span>Free Call</span> <span>+1 234 456 78910</span></p>
<p class="con">Call Us Now 24/7 Customer Support</p>
</div>
</div>
<div class="col-md topper d-flex mb-md-0 align-items-xl-center">
<div class="icon d-flex justify-content-center align-items-center"><span class="fa fa-paper-plane"></span>
</div>
<div class="text pl-3 pl-md-3">
<p class="hr"><span>Our Location</span></p>
<p class="con">Suite 721 New York NY 10016</p>
</div>
</div>
<div class="col-md topper d-flex mb-md-0 align-items-xl-center">
<div class="icon d-flex justify-content-center align-items-center"><span class="fa fa-connectdevelop"></span>
</div>
<div class="text pl-3 pl-md-3">
<p class="con"><span>Connect </span> <span>with us</span></p>
<p class="con"><a href="#">Facebook</a> <a href="#">Twitter</a> <a href="#">Dribbble</a></p>
</div>
</div>
</div>
</div>
</div> -->
<!-- <nav class="navbar navbar-expand-lg  ftco-navbar-light">
    <div class="container-xl">
    <a class="navbar-brand align-items-center" href="index.html">
    <span class="tagline">Kashmir Meridian <small>Your Gateway to the Mystical Land</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="fa fa-bars"></span> Menu
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
    <li class="nav-item"><a class="nav-link" href="destinations.html">Destinations</a></li>
    <li class="nav-item"><a class="nav-link" href="tour-packages.html">Packages</a></li>
    <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
    </ul>
    <p class="mb-0"><a href="#" class="btn btn-primary rounded">Login/Signup</a></p>
    </div>
    </div>
    </nav> -->
    <?php
include_once("includes/navbar.php");
?>
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_4.jpg');">
<div class="overlay"></div>
<div class="container">
<div class="row no-gutters slider-text align-items-center justify-content-center">
<div class="col-md-9 pt-5 text-center">
<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Packages<i class="fa fa-chevron-right"></i></span></p>
<h1 class="mb-0 bread">All Pacakges</h1>
</div>
</div>
</div>
</section>
<section class="ftco-section ftco-no-pb ftco-no-pt">
    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <div class="ftco-search d-flex justify-content-center">
    <div class="row">
     <div class="col-md-12 nav-link-wrap d-flex "><!--justify-content-center -->
    <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Destination Search</a>
    <!-- <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Rent Properties</a> -->
    </div>
    </div>
    <div class="col-md-12 tab-wrap">
    <div class="tab-content" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
    <form action="search_packages.php" method="POST" class="search-property-1">
    <div class="row g-0">
        <div class="col-md d-flex">
            <div class="form-group p-4">
                <label for="location">Location</label>
                <div class="form-field">
                    <div class="select-wrap">
                        <div class="icon"><span class="fa fa-chevron-down"></span></div>
                        <select name="location" id="location" class="form-control" required>
                            <option value="">Select Location</option>
                            <option value="Gulmarg">Gulmarg</option>
                            <option value="Sonmarg">Sonmarg</option>
                            <option value="Leh">Leh</option>
                            <option value="Ladakh">Ladakh</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md d-flex">
            <div class="form-group p-4">
                <label for="no_of_travellers">No of Travellers</label>
                <div class="form-field">
                    <div class="icon"><span class="fa fa-users"></span></div>
                    <input type="number" name="no_of_travellers" id="no_of_travellers" class="form-control" placeholder="2" required>
                </div>
            </div>
        </div>

        <div class="col-md d-flex">
            <div class="form-group p-4">
                <label for="price_limit">Price Limit</label>
                <div class="form-field">
                    <div class="select-wrap">
                        <div class="icon"><span class="fa fa-chevron-down"></span></div>
                        <select name="price_limit" id="price_limit" class="form-control" required>
                            <option value="">Select Price</option>
                            <option value="5000">₹5,000</option>
                            <option value="10000">₹10,000</option>
                            <option value="20000">₹20,000</option>
                            <option value="40000">₹40,000</option>
                            <option value="100000">₹100,000</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md d-flex">
            <div class="form-group d-flex w-100 border-0">
                <div class="form-field w-100 align-items-center d-flex">
                    <input type="submit" value="Search" class="align-self-stretch form-control btn btn-primary">
                </div>
            </div>
        </div>
    </div>
</form>
    </div>
    <!-- <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-performance-tab">
    <form action="#" class="search-property-1">
    <div class="row g-0">
    <div class="col-md d-flex">
    <div class="form-group p-4 border-0">
    <label for="#">Enter Keyword</label>
    <div class="form-field">
    <div class="icon"><span class="fa fa-search"></span></div>
    <input type="text" class="form-control" placeholder="Enter Keyword">
    </div>
    </div>
    </div>
    <div class="col-md d-flex">
    <div class="form-group p-4">
    <label for="#">Property Type</label>
    <div class="form-field">
    <div class="select-wrap">
    <div class="icon"><span class="fa fa-chevron-down"></span></div>
    <select name id class="form-control">
    <option value>Residential</option>
    <option value>Commercial</option>
    <option value>Land</option>
    <option value>Industrial</option>
    </select>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md d-flex">
    <div class="form-group p-4">
    <label for="#">Location</label>
    <div class="form-field">
    <div class="icon"><span class="ion-ios-pin"></span></div>
    <input type="text" class="form-control" placeholder="Search Location">
    </div>
    </div>
    </div>
    <div class="col-md d-flex">
    <div class="form-group p-4">
    <label for="#">Price Limit</label>
    <div class="form-field">
    <div class="select-wrap">
    <div class="icon"><span class="fa fa-chevron-down"></span></div>
    <select name id class="form-control">
    <option value>$100</option>
    <option value>$10,000</option>
    <option value>$50,000</option>
    <option value>$100,000</option>
    <option value>$200,000</option>
    <option value>$300,000</option>
    <option value>$400,000</option>
    <option value>$500,000</option>
    <option value>$600,000</option>
    <option value>$700,000</option>
    <option value>$800,000</option>
    <option value>$900,000</option>
    <option value>$1,000,000</option>
    <option value>$2,000,000</option>
    </select>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md d-flex">
    <div class="form-group d-flex w-100 border-0">
    <div class="form-field w-100 align-items-center d-flex">
    <input type="submit" value="Search" class="align-self-stretch form-control btn btn-primary">
    </div>
    </div>
    </div>
    </div>
    </form>
    </div> -->
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </section>
    <section class="ftco-section bg-light" style="color: blue;">
        <div class="container-xl">
        <div class="row justify-content-center">
        <div class="col-md-8 heading-section text-center mb-2" data-aos="fade-up" data-aos-duration="1000">
        <span class="subheading">Explore Our Top-Rated Packages</span>
        <h2 class="mb-1">Searched Packages</h2>
        </div>
        </div>
        <div class="row">
           
        <?php
         //
    if ($featured_result->num_rows > 0) {
        // Display featured packages from the database
        while ($row = $featured_result->fetch_assoc()) {
            // echo "<pre>";
            // print_r($row);
            // echo "<pre>";
           $displayed_rows++; 
    ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                <div class="card product-card">
                    <a href="package-details.php?package_id=<?= htmlspecialchars($row['id']) ?>" target="_blank">
                        <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="card-img-top">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="duration"><?= htmlspecialchars($row['duration']) ?></div>
                                <div class="rating-box">
                                    <div class="star-rating">
                                        <i class="fa fa-star checked" data-index="0"></i>
                                        <i class="fa fa-star checked" data-index="1"></i>
                                        <i class="fa fa-star checked" data-index="2"></i>
                                        <i class="fa fa-star checked" data-index="3"></i>
                                        <i class="fa fa-star <?= ($row['rating'] >= 4.5 ? 'checked' : 'unchecked') ?>" data-index="4"></i>
                                    </div>
                                    <div class="rating"><?= htmlspecialchars($row['rating']) ?></div>
                                    <div class="rating-count">(<?= htmlspecialchars($row['reviews']) ?>)</div>
                                </div>
                            </div>
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <div class="d-flex justify-content-between">
                                <div class="price">INR <?= htmlspecialchars($row['price']) ?></div>
								<div class="strike-price">INR <?= number_format($row['price'] * 1.25, 2) ?></div>
                            </div>
                            <a href="package-details.php?package_details=<?= htmlspecialchars($row['package_id']) ?>"><button class="btn btn-primary btn-block">View Details</button></a>
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
                <a href="<?= htmlspecialchars($default_featured['link']) ?>" target="_blank">
                    <img src="<?= htmlspecialchars($default_featured['image']) ?>" alt="<?= htmlspecialchars($default_featured['name']) ?>" class="card-img-top">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="duration"><?= htmlspecialchars($default_featured['duration']) ?></div>
                            <div class="rating-box">
                                <div class="star-rating">
                                    <i class="fa fa-star checked" data-index="0"></i>
                                    <i class="fa fa-star checked" data-index="1"></i>
                                    <i class="fa fa-star checked" data-index="2"></i>
                                    <i class="fa fa-star checked" data-index="3"></i>
                                    <i class="fa fa-star <?= ($default_featured['rating'] >= 4.5 ? 'checked' : 'unchecked') ?>" data-index="4"></i>
                                </div>
                                <div class="rating"><?= htmlspecialchars($default_featured['rating']) ?></div>
                                <div class="rating-count">(<?= htmlspecialchars($default_featured['reviews']) ?>)</div>
                            </div>
                        </div>
                        <h5 class="card-title"><?= htmlspecialchars($default_featured['name']) ?></h5>
                        <div class="d-flex justify-content-between">
                            <div class="price">INR <?= htmlspecialchars($default_featured['price']) ?></div>
							<div class="strike-price">INR <?= number_format($default_featured['price'] * 1.25, 2) ?></div>
                        </div>
                        <a href="package-details.php?package_id=<?= htmlspecialchars($default_featured['id']) ?>"><button class="btn btn-primary btn-block">View Details</button></a>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    ?>	  
        <div class="row justify-content-right">
            <nav>
                <ul class="custom-pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </nav>
          </div>
        
        </div>
       
          
        </div>
        </section>
        <!-- <footer class="ftco-footer">
            <div class="container-xl">
            <div class="row mb-5 pb-5 justify-content-between">
            <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2 logo d-flex">
            <a class="navbar-brand align-items-center" href="index.html">
            <span class>Kashmir Meridian <small>Your Gateway to the Mystical Land</small></span>
            </a>
            </h2>
            <p>At Kashmir Meridian, we believe that travel is not just a journey; it’s an experience that stays with you forever. As a premier travel company specializing in Kashmir and its breathtaking surroundings, we take great pride in curating unforgettable adventures that leave you spellbound.</p>
            <ul class="ftco-footer-social list-unstyled mt-2">
            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
            <li><a href="#"><span class="fa fa-instagram"></span></a></li>
            </ul>
            </div>
            </div>
            <div class="col-md-6 col-lg-2">
            <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Quick Links</h2>
            <ul class="list-unstyled">
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>FAQ</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Popular Packages</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Trending Packages</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>My Profile</a></li>
            </ul>
            </div>
            </div>
            <div class="col-md-6 col-lg-2">
            <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Kashmir Meridian</h2>
            <ul class="list-unstyled">
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Home</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>About</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Blog</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Contact Us</a></li>
            <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Ticket Availability</a></li>
            
            </ul>
            </div>
            </div>
            <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Have a Questions?</h2>
            <div class="block-23 mb-3">
            <ul>
            <li><span class="icon fa fa-map marker"></span><span class="text">Address : Khidmat Complex, Branch office, Abi Guzar Rd, Srinagar, Jammu and Kashmir 190001</span></li>
            <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+91 9113539263</span></a></li>
            <li><a href="#"><span class="icon fa fa-paper-plane pr-4"></span><span class="text"><span class="__cf_email__" >info@kashmirmeridian.org</span></span></a></li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="container-fluid px-0 py-2 bg-darken">
            <div class="container-xl">
            <div class="row">
            <div class="col-md-12 text-center">
            <p class="mb-0 mt-2" style="color: rgba(255,255,255,.5); font-size: 13px;">Copyright &copy;2024 All rights reserved | Kashmir Meridian</p>
            </p></div>
            </div>
            </div>
            </div>
            </footer> -->
            <?php
include_once("includes/footer.php");
?>
<script src="js/6440-js-bootstrap.bundle.min.js"></script>
<script src="js/1306-js-tiny-slider.js"></script>
<script src="js/1453-js-glightbox.min.js"></script>
<script src="js/673-js-aos.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script>
<script src="js/8593-js-google-map.js"></script>
<script src="js/6806-js-main.js"></script>
</body>
</html>

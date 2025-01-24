<!DOCTYPE html>
<html lang="en">
<head>
<title>Kashmir Meridian</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
<link rel="stylesheet" href="css/css-animate.css">
<link rel="stylesheet" href="css/css-flaticon.css">
<link rel="stylesheet" href="css/css-tiny-slider.css">
<link rel="stylesheet" href="css/css-glightbox.min.css">
<link rel="stylesheet" href="css/css-aos.css">
<link rel="stylesheet" href="css/css-style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "kashmir_tourism");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count packages for each destination
$sql = "
    SELECT d.name AS destination_name, COUNT(p.id) AS package_count
    FROM destinations d
    LEFT JOIN packages p ON d.id = p.destination_id
    GROUP BY d.id, d.name
    ORDER BY d.name ASC"; // Sort by destination name

$result = $conn->query($sql);

// Prepare an array to hold the data
$destinations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
}
// Fetch Featured Packages
$featured_sql = "
    SELECT 
        packages.*, 
        packages_images.* 
    FROM 
        packages 
    INNER JOIN 
        packages_images 
    ON 
        packages.id = packages_images.package_id
    WHERE 
        packages.is_featured = 1 
    LIMIT 6
";
$featured_result = $conn->query($featured_sql);
$trending_sql = "
    SELECT 
        packages.*, 
        packages_images.* 
    FROM 
        packages 
    INNER JOIN 
        packages_images 
    ON 
        packages.id = packages_images.package_id
    WHERE 
        packages.is_trending = 1 
    LIMIT 6
";
$trending_result = $conn->query($trending_sql);
$honeymoon_sql = "
    SELECT 
        packages.*, 
        packages_images.* 
    FROM 
        packages 
    INNER JOIN 
        packages_images 
    ON 
        packages.id = packages_images.package_id
    WHERE 
        packages.is_honeymoon = 1 
    LIMIT 6
";
$honeymoon_result = $conn->query($honeymoon_sql);

$blog_sql = "
    SELECT 
        blogs.*, 
        GROUP_CONCAT(blog_images.image_path) AS image_paths
    FROM 
        blogs 
    INNER JOIN 
        blog_images 
    ON 
        blogs.id = blog_images.blog_id
    GROUP BY 
        blogs.id
    LIMIT 6
";
$blog_result = $conn->query($blog_sql);
// print_r($blog_result);die;
// if ($blog_result->num_rows > 0) {
//     // Display featured packages from the database
//     while ($row = $blog_result->fetch_assoc()) {
       
//     }
// }    
//die;

$default_featured = array();
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
$displayed_rows_tre = 0;
$displayed_rows_hon = 0;
$total_cards = 6; // Minimum cards to display
$displayed_rows_blog = 0;

$default_featured = array();
$default_featured['name'] = "Romantic Escape to Kashmir | FREE Excursion to Gulmarg";
$default_featured['description'] = "Romantic Escape to Kashmir | FREE Excursion to Gulmarg";
$default_featured['duration'] = "6 days & 5 Night";
$default_featured['price'] = "12000";
$default_featured['link'] = "";
$default_featured['image'] = "images/k1.jpg";
$default_featured['rating'] = "4.0";
$default_featured['reviews'] = "1200";

$default_blog = array();
$default_blog['title'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
$default_blog['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor";
$default_blog['post_date'] = "2025-01-23";
$default_blog['link'] = "";
$default_blog['image_path'] = "images/k1.jpg";
$total_cards_blog = 5;

// Fetch Trending Packages
// $trending_sql = "SELECT * FROM packages WHERE is_trending = 1 LIMIT 6"; // Add conditions as needed
// $trending_result = $conn->query($trending_sql);
// // Close connection
// print_r($featured_result);
// print_r($trending_result);
//die;

$conn->close();
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
<nav class="navbar navbar-expand-lg  ftco-navbar-light">
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
<p class="mb-0"><a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#authModal">Login/Signup</a></p>
</div>
</div>
</nav>
<section class="slider-hero">
<div class="overlay"></div>
<div class="hero-slider">
<div class="item">
<div class="work">
<div class="img d-flex align-items-center js-fullheight" style="background-image: url(images/bg_1.png);">
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-10 col-xl-6">
<div class="text text-center" data-aos="fade-up" data-aos-duration="1000">
<h2>A Cozy Winter Retreat in Kashmir</h2>
<p class="mb-5">Nestled amidst the snow-capped peaks of Kashmir, this charming house exudes a tranquil winter wonderland. Surrounded by pristine snow, it offers a perfect escape into nature’s serene embrace.</p>
<p><a href="#" class="btn btn-primary px-5 py-3">Learn More <span class="ion ion-ios-arrow-round-forward"></span></a></p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="item">
<div class="work">
<div class="img d-flex align-items-center justify-content-center js-fullheight" style="background-image: url(images/bg_2.png);">
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-10 col-xl-6">
<div class="text text-center" data-aos="fade-up" data-aos-duration="1000">
<h2>Lush Valley Oasis</h2>
<p class="mb-5">Experience the breathtaking beauty of this valley, where a winding river cuts through a landscape of verdant greenery and towering mountains. The serene waters and lush surroundings create a perfect harmony of nature’s splendor..</p>
<p><a href="#" class="btn btn-primary px-5 py-3">Learn More <span class="ion ion-ios-arrow-round-forward"></span></a></p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="item">
<div class="work">
<div class="img d-flex align-items-center justify-content-center js-fullheight" style="background-image: url(images/bg_3.png);">
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-10 col-xl-6">
<div class="text text-center" data-aos="fade-up" data-aos-duration="1000">
<h2>Kashmir’s Floral Symphony</h2>
<p class="mb-5">Amidst the stunning valley of Kashmir, a vibrant tapestry of flowers adds a burst of color to the lush landscape. The vivid blooms against the backdrop of serene mountains and flowing river create a breathtaking scene of nature’s artistry.</p>
<p><a href="#" class="btn btn-primary px-5 py-3">Learn More <span class="ion ion-ios-arrow-round-forward"></span></a></p>
</div>
</div>
</div>
</div>
</div>
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
<a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Tour Search</a>
<!-- <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Rent Properties</a> -->
</div>
</div>
<div class="col-md-12 tab-wrap">
<div class="tab-content" id="v-pills-tabContent">
<div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
<form action="#" class="search-property-1">
<div class="row g-0">
<!-- <div class="col-md d-flex">
<div class="form-group p-4 border-0">
<label for="#">Enter Keyword</label>
<div class="form-field">
<div class="icon"><span class="fa fa-search"></span></div>
<input type="text" class="form-control" placeholder="Enter Keyword">
</div>
</div>
</div> -->
<div class="col-md d-flex">
<div class="form-group p-4">
<label for="#">Location</label>
<div class="form-field">
<div class="select-wrap">
<div class="icon"><span class="fa fa-chevron-down"></span></div>
<select name id class="form-control">
<option value>Gulmarg</option>
<option value>Sonmarg</option>
<option value>Leh</option>
<option value>Ladakh</option>
</select>
</div>
</div>
</div>
</div>
<div class="col-md d-flex">
<div class="form-group p-4">
<label for="#">No of travellers</label>
<div class="form-field">
<div class="icon"><span class="fa fa-users"></span></div>
<input type="number" class="form-control" placeholder="2">
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
<option value>&#8377;5000</option>
<option value>&#8377;10,000</option>
<option value>&#8377;20,000</option>
<option value>&#8377;40,000</option>
<option value>&#8377;100,000</option>

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
<section class="ftco-section">
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-8 heading-section text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
<span class="subheading">Top Picks for Every Traveler</span>
<h2 class="mb-4">Explore Our Categories &amp; Places</h2>
</div>
</div>
<div class="row justify-content-center">
<div class="col-md-10">
<div class="row g-1 mb-1">
<div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
<a href="#" class="services">
<div class="icon"><span class="fa fa-map"></span></div>
<div class="text">
<h2>Jammu</h2>
</div>
</a>
</div>
<div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
<a href="#" class="services">
<div class="icon"><span class="fa fa-map-marker"></span></div>
<div class="text">
<h2>Kashmir</h2>
</div>
</a>
</div>
<div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
<a href="#" class="services">
<div class="icon"><span class="fa fa-map-o"></span></div>
<div class="text">
<h2>Manali</h2>
</div>
</a>
</div>
<div class="col-md-3 text-center d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
<a href="#" class="services">
<div class="icon"><span class="fa fa-map-signs"></span></div>
<div class="text">
<h2>Shimla</h2>
</div>
</a>
</div>
</div>
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-4" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
<ul class="places-list">
<li>
<a href="#">
Srinagar
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Srinagar"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Leh
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Leh"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Ladkah
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Ladkah"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Sonmag
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Sonmag"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
</ul>
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
<ul class="places-list">
<li>
<a href="#">
Katra
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Katra"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Gurez valley
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Gurez valley"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Gulmarg
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Gulmarg"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Pahalgam
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Pahalgam"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
</ul>
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="700" data-aos-duration="1000">
<ul class="places-list">
<li>
<a href="#">
Dachigam
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Dachigam"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Anantnag
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Anantnag"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Manali
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Manali"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
<li>
<a href="#">
Shimla
<span><?php 
foreach($destinations as $destination){
	if($destination["destination_name"] == "Shimla"){
		echo $destination["package_count"];
	}else{
		echo 0;
	}
}
?> Packages</span>
</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="ftco-section bg-light">
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-8 heading-section text-center mb-2" data-aos="fade-up" data-aos-duration="1000">
<span class="subheading">Explore Our Top-Rated Packages</span>
<h2 class="mb-1">Featured Packages</h2>
</div>
</div>
<div class="row">
	<div class="row justify-content-right">
		<nav>
			<ul class="custom-pagination">
				<li><a id="prev" href="#">&laquo;</a></li>
				<li><a id="next" href="#">&raquo;</a></li>
			</ul>
		</nav>
	  </div>
	  <div id="pac1" class="row">
	  <?php
    if ($featured_result->num_rows > 0) {
        // Display featured packages from the database
        while ($row = $featured_result->fetch_assoc()) {
            $displayed_rows++;
    ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                <div class="card product-card">
                    <a href="<?= htmlspecialchars($row['link'] ?? '#') ?>" target="_blank">
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
                            <button class="btn btn-primary btn-block">Request Callback</button>
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
                        <button class="btn btn-primary btn-block">Request Callback</button>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    ?>	  
<!-- <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
	<div class="card product-card">
        <a href="/tours/kashmir-honeymoon-tour-package" target="_blank">
          <img src="images/k1.jpg" alt="Romantic Escape to Kashmir | FREE Excursion to Gulmarg" class="card-img-top">
          <div class="card-body">
            <div class="d-flex justify-content-between">
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
            </div>
            <h5 class="card-title">Romantic Escape to Kashmir | FREE Excursion to Gulmarg</h5>
            <div class="d-flex justify-content-between">
              <div class="price">INR 21,000</div>
              <div class="strike-price">INR 38,182</div>
            </div>
            <div class="save-price">SAVE INR 17,182</div>
            <button class="btn btn-primary btn-block">Request Callback</button>
          </div>
        </a>
      </div>
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
	<div class="card product-card">
        <a href="/tours/kashmir-honeymoon-tour-package" target="_blank">
          <img src="images/k1.jpg" alt="Romantic Escape to Kashmir | FREE Excursion to Gulmarg" class="card-img-top">
          <div class="card-body">
            <div class="d-flex justify-content-between">
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
            </div>
            <h5 class="card-title">Romantic Escape to Kashmir | FREE Excursion to Gulmarg</h5>
            <div class="d-flex justify-content-between">
              <div class="price">INR 21,000</div>
              <div class="strike-price">INR 38,182</div>
            </div>
            <div class="save-price">SAVE INR 17,182</div>
            <button class="btn btn-primary btn-block">Request Callback</button>
          </div>
        </a>
      </div>
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
	
	<div class="card product-card">
        <a href="/tours/kashmir-honeymoon-tour-package" target="_blank">
          <img src="images/k1.jpg" alt="Romantic Escape to Kashmir | FREE Excursion to Gulmarg" class="card-img-top">
          <div class="card-body">
            <div class="d-flex justify-content-between">
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
            </div>
            <h5 class="card-title">Romantic Escape to Kashmir | FREE Excursion to Gulmarg</h5>
            <div class="d-flex justify-content-between">
              <div class="price">INR 21,000</div>
              <div class="strike-price">INR 38,182</div>
            </div>
            <div class="save-price">SAVE INR 17,182</div>
            <button class="btn btn-primary btn-block">Request Callback</button>
          </div>
        </a>
      </div>
	  
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
	
	<div class="card product-card">
        <a href="/tours/kashmir-honeymoon-tour-package" target="_blank">
          <img src="images/k1.jpg" alt="Romantic Escape to Kashmir | FREE Excursion to Gulmarg" class="card-img-top">
          <div class="card-body">
            <div class="d-flex justify-content-between">
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
            </div>
            <h5 class="card-title">Romantic Escape to Kashmir | FREE Excursion to Gulmarg</h5>
            <div class="d-flex justify-content-between">
              <div class="price">INR 21,000</div>
              <div class="strike-price">INR 38,182</div>
            </div>
            <div class="save-price">SAVE INR 17,182</div>
            <button class="btn btn-primary btn-block">Request Callback</button>
          </div>
        </a>
      </div>
	  
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
	
	<div class="card product-card">
        <a href="/tours/kashmir-honeymoon-tour-package" target="_blank">
          <img src="images/k1.jpg" alt="Romantic Escape to Kashmir | FREE Excursion to Gulmarg" class="card-img-top">
          <div class="card-body">
            <div class="d-flex justify-content-between">
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
            </div>
            <h5 class="card-title">Romantic Escape to Kashmir | FREE Excursion to Gulmarg</h5>
            <div class="d-flex justify-content-between">
              <div class="price">INR 21,000</div>
              <div class="strike-price">INR 38,182</div>
            </div>
            <div class="save-price">SAVE INR 17,182</div>
            <button class="btn btn-primary btn-block">Request Callback</button>
          </div>
        </a>
      </div>
	  
</div>
<div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
	
	<div class="card product-card">
        <a href="/tours/kashmir-honeymoon-tour-package" target="_blank">
          <img src="images/k1.jpg" alt="Romantic Escape to Kashmir | FREE Excursion to Gulmarg" class="card-img-top">
          <div class="card-body">
            <div class="d-flex justify-content-between">
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
            </div>
            <h5 class="card-title">Romantic Escape to Kashmir | FREE Excursion to Gulmarg</h5>
            <div class="d-flex justify-content-between">
              <div class="price">INR 21,000</div>
              <div class="strike-price">INR 38,182</div>
            </div>
            <div class="save-price">SAVE INR 17,182</div>
            <button class="btn btn-primary btn-block">Request Callback</button>
          </div>
        </a>
      </div>
	  
</div> -->
</div>
</div>
<div class="row justify-content-center">
	<div class="col-md-8 heading-section text-center mb-2" data-aos="fade-up" data-aos-duration="1000">
	<h2 class="mb-1">Trending Packages</h2>
	</div>
	</div>
	<div class="row">
		<div class="row justify-content-right">
			<nav>
				<ul class="custom-pagination">
					<li><a id="prev-2" href="#">&laquo;</a></li>
					<li><a id="next-2" href="#">&raquo;</a></li>
				</ul>
			</nav>
		  </div>
		  <div id="pac2" class="row">
			<?php			
		  if ($trending_result->num_rows > 0) {
        // Display featured packages from the database
        while ($row = $trending_result->fetch_assoc()) {
            $displayed_rows_tre++;
    ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                <div class="card product-card">
                    <a href="<?= htmlspecialchars($row['link'] ?? '#') ?>" target="_blank">
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
                            <button class="btn btn-primary btn-block">Request Callback</button>
                        </div>
                    </a>
                </div>
            </div>
    <?php
        }
    }

    // Fill remaining cards with default content
    while ($displayed_rows_tre < $total_cards) {
        $displayed_rows_tre++;
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
                        <button class="btn btn-primary btn-block">Request Callback</button>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    ?>
	</div>
	</div>
</div>
</section>

<section class="img vid-section" style="background-image: url(images/ropeway.png);">
<div class="overlay"></div>
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-8 vid-height d-flex align-items-center justify-content-center text-center">
<div class="video-wrap" data-aos="fade-up">
<h3>Soar Above the Scenic Splendor</h3>
<p>Experience the breathtaking beauty of Kashmir from a unique vantage point with a thrilling cable car ride. Soaring high above the majestic mountains and lush valleys, the cable car offers panoramic views of the region's stunning landscapes.</p>

</div>
</div>
</div>
</div>
</section>
<section class="ftco-section bg-light">
	<div class="container-xl">
	<div class="row justify-content-center">
	<div class="col-md-8 heading-section text-center mb-2" data-aos="fade-up" data-aos-duration="1000">
	<span class="subheading">Highlighting Our Premier Packages</span> 
	<h2 class="mb-1">Featured Honeymoon Packages</h2>
	</div>
	</div>
	<div class="row">
		<div class="row justify-content-right">
			<nav>
				<ul class="custom-pagination">
					<li><a id="prev-3" href="#">&laquo;</a></li>
					<li><a id="next-3" href="#">&raquo;</a></li>
				</ul>
			</nav>
		  </div>
<div id="pac3" class="row">	
	<?php	  
if ($honeymoon_result->num_rows > 0) {
        // Display featured packages from the database
        while ($row = $honeymoon_result->fetch_assoc()) {
            $displayed_rows_hon++;
    ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                <div class="card product-card">
                    <a href="<?= htmlspecialchars($row['link'] ?? '#') ?>" target="_blank">
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
                            <button class="btn btn-primary btn-block">Request Callback</button>
                        </div>
                    </a>
                </div>
            </div>
    <?php
        }
    }

    // Fill remaining cards with default content
    while ($displayed_rows_hon < $total_cards) {
        $displayed_rows_hon++;
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
                        <button class="btn btn-primary btn-block">Request Callback</button>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    ?>
	</div>
	</div>
	</div>
	</section>
<section class="ftco-section ftco-about-section">
<div class="container-xl">
<div class="row g-xl-5">
<div class="col-md-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
<div class="img w-100" style="background-image: url(images/boating.jpg);"></div>
</div>
<div class="col-md-8 heading-section" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
	<span class="subheading">Discover Fun and Excitement in the Great Outdoors</span>
<h2 class="mb-4">Outdoor Activities</h2>
<div>
<p class="d-flex justify-content-center text-left">Kashmir offers a diverse array of adventures, from trekking through lush meadows and alpine lakes to skiing on the powdery slopes of Gulmarg, one of Asia’s premier ski destinations. The region’s majestic landscapes provide a stunning backdrop for these activities, whether you’re hiking amidst the serene beauty of the Himalayas or enjoying the thrill of skiing down snow-capped mountains. For a more tranquil experience, boating on the pristine waters of Dal Lake and Nigeen Lake in a traditional Shikara offers a peaceful escape and a unique view of Kashmir’s natural and cultural splendor.</p>
<!-- <div class="row py-5">
	
<div class="col-md-6 col-lg-3">
<div class="counter-wrap" data-aos="fade-up" data-aos-duration="1000">
<div class="text">
<span class="d-block number gradient-text"><span id="count1" class="counter" data-count="50">0</span></span>
<p>Years of Experienced</p>
</div>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="counter-wrap" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
<div class="text">
<span class="d-block number gradient-text"><span id="count2" class="counter" data-count="210">0</span>K+</span>
<p>Total Properties</p>
</div>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="counter-wrap" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
<div class="text">
<span class="d-block number gradient-text"><span id="count2" class="counter" data-count="450">0</span></span>
<p>Qualified Realtors</p>
</div>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="counter-wrap" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
<div class="text">
<span class="d-block number gradient-text"><span id="count2" class="counter" data-count="100">0</span></span>
<p>Total Branches</p>
</div>
</div>
</div>
</div> -->
<div class="img img-2" style="background-image: url(images/skiing.jpg);" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
</div>
</div>
</div>
</div>
</section>
<section class="ftco-intro ftco-no-pt ftco-no-pb img" style="background-image: url(images/bg_4.png);">
<div class="overlay"></div>
<div class="container-xl py-5">
<div class="row justify-content-center">
<div class="col-lg-10 col-xl-8">
<div class="row">
<div class="col-md-8 d-flex align-items-center">
<div>
<h2 class="mb-0">We Craft Unforgettable Kashmir Experiences</h2>
</div>
</div>
<div class="col-md-4 d-flex align-items-center">
<!-- <p class="mb-0"><a href="#" class="btn btn-black py-3 px-4">Get in touch</a></p> -->
<p class="mb-0"></p><a href="#" class="btn btn-black py-3 px-4" data-toggle="modal" data-target="#contactModal">Get in touch</a></p>
</div>
</div>

</div>
</div>
</div>
</section>
<section class="ftco-section testimony-section bg-light">
<div class="container-xl">
<div class="row justify-content-center pb-4">
<div class="col-md-7 text-center heading-section" data-aos="fade-up" data-aos-duration="1000">
<span class="subheading">Testimonial</span>
<h2 class="mb-3">Experiences from Our Valued Travelers</h2>
</div>
</div>
<div class="row">
<div class="col-md-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
<div class="carousel-testimony">
<div class="item">
<div class="testimony-wrap">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
<div class="text">
<p class="mb-4 msg">Thanks Muzaffar for you support. We really had a good time. Everything was well organized. Our driver, Sajjad was very polite and helpful in nature, which made our trip more enjoyable.</p>
<div class="d-flex align-items-center">
<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
<div class="pl-3 tx">
<p class="name">SHIVA</p>
<div class="star-rating">
	<i class="fa fa-star checked" data-index="0"></i>
	<i class="fa fa-star checked" data-index="1"></i>
	<i class="fa fa-star checked" data-index="2"></i>
	<i class="fa fa-star checked" data-index="3"></i>
	<i class="fa fa-star checked" data-index="4"></i>
</div>
<span class="position">
	
</span>
</div>
</div>
</div>
</div>
</div>
<div class="item">
<div class="testimony-wrap">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
<div class="text">
<p class="mb-4 msg">The trip was very nice . Every one was very polite in Kashmir . We enjoyed the trip . The person who managed our trip was very helpful and kind . The places we visited according to the trip plan was very beautiful. the hotel where we stayed was very luxury and comfortable.</p>
<div class="d-flex align-items-center">
<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
<div class="pl-3 tx">
<p class="name">HARPREET SINGH</p>
<div class="star-rating">
	<i class="fa fa-star checked" data-index="0"></i>
	<i class="fa fa-star checked" data-index="1"></i>
	<i class="fa fa-star checked" data-index="2"></i>
	<i class="fa fa-star checked" data-index="3"></i>
	<i class="fa fa-star checked" data-index="4"></i>
</div>
<span class="position"></span>
</div>
</div>
</div>
</div>
</div>
<div class="item">
<div class="testimony-wrap">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
<div class="text">
<p class="mb-4 msg">Very Co-operative staff… they makes your trip more joyful and comfortable.. best part is there is good choice of hotels if you want to exchange one… so overall I am happy with there services throughout my Kashmir trip…</p>
<div class="d-flex align-items-center">
<div class="user-img" style="background-image: url(images/person_3.jpg)"></div>
<div class="pl-3 tx">
<p class="name">LUBNA FURQAN</p>
<div class="star-rating">
	<i class="fa fa-star checked" data-index="0"></i>
	<i class="fa fa-star checked" data-index="1"></i>
	<i class="fa fa-star checked" data-index="2"></i>
	<i class="fa fa-star checked" data-index="3"></i>
	<i class="fa fa-star checked" data-index="4"></i>
</div>
<span class="position"></span>
</div>
</div>
</div>
</div>
</div>
<div class="item">
<div class="testimony-wrap">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
<div class="text">
<p class="mb-4 msg">The trip was really fantastic.From the start to end the Kashmir tour planner and drivers were very helpful. Specially Muktar Bhai and Najma Ma’am has helped us explore new places and the hotels they have arranged are family friendly and really good.</p>
<div class="d-flex align-items-center">
<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
<div class="pl-3 tx">
<p class="name">GADDE MOHANRAO</p>
<div class="star-rating">
	<i class="fa fa-star checked" data-index="0"></i>
	<i class="fa fa-star checked" data-index="1"></i>
	<i class="fa fa-star checked" data-index="2"></i>
	<i class="fa fa-star checked" data-index="3"></i>
	<i class="fa fa-star checked" data-index="4"></i>
</div>
<span class="position"></span>
</div>
</div>
</div>
</div>
</div>
<div class="item">
<div class="testimony-wrap">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
<div class="text">
<p class="mb-4 msg">We planned our Kashmir trip in winters via Kashmir Meridian Tours & Travels. Mr. Muzaffar helped us plan the itinerary. He was our go to person on the trip. We had alot of choas in starting, he accommodated all our changes, requirements very patiently. After reaching Kashmir, everything was super smooth and according to plan.</p>
<div class="d-flex align-items-center">
<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
<div class="pl-3 tx">
<p class="name">PARIDHI PATODIA</p>
<div class="star-rating">
	<i class="fa fa-star checked" data-index="0"></i>
	<i class="fa fa-star checked" data-index="1"></i>
	<i class="fa fa-star checked" data-index="2"></i>
	<i class="fa fa-star checked" data-index="3"></i>
	<i class="fa fa-star checked" data-index="4"></i>
</div>
<span class="position"></span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="ftco-section ftco-agent ftco-no-pb">
  <div class="overlay"></div>
  <div class="container-xl">
    <div class="row justify-content-center pb-1">
      <div class="col-md-10 heading-section" data-aos="fade-up" data-aos-duration="1000">
        <span class="subheading">Gallery</span>
        <h2 class="mb-4">Explore the Moments</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-12 mb-0 mb-lg-0">
        <img
          src="images/img%20(73).webp"
          class="w-100 shadow-1-strong mb-4"
          alt="Boat on Calm Water"
          style="height: 25%;"
        />
        <img
          src="images/mountain1.webp"
          class="w-100 shadow-1-strong rounded"
          alt="Wintry Mountain Landscape"
          style="height: 50%;"
        />
      </div>
      <div class="col-lg-4 mb-1 mb-lg-0">
        <img
          src="images/mountain2.webp"
          class="w-100 shadow-1-strong rounded mb-4"
          alt="Mountains in the Clouds"
          style="height: 50%;"
        />
        <img
          src="images/img%20(73).webp"
          class="w-100 shadow-1-strong rounded"
          alt="Boat on Calm Water"
          style="height: 25%;"
        />
      </div>
      <div class="col-lg-4 mb-1 mb-lg-0">
        <img
          src="images/img%20(73).webp"
          class="w-100 shadow-1-strong rounded mb-4"
          alt="Waves at Sea"
          style="height: 25%;"
        />
        <img
          src="images/mountain3.webp"
          class="w-100 shadow-1-strong rounded"
          alt="Yosemite National Park"
          style="height: 50%;"
        />
      </div>
    </div>
  </div>
</section>

<section class="ftco-section bg-light">
<div class="container-xl">
<div class="row justify-content-center mb-5">
<div class="col-md-7 heading-section text-center" data-aos="fade-up" data-aos-duration="1000">
<span class="subheading">Our Blog</span>
<h2>Recent Stories</h2>
</div>
</div>
<div class="row">
<?php
  $dem = "col-md-6";
    if ($blog_result->num_rows > 0) {
        // Display featured packages from the database <?= htmlspecialchars($row['name']) 
        while ($row = $blog_result->fetch_assoc()) {
            $image_path = explode(",",$row["image_paths"]);
            $displayed_rows_blog++;
            if($displayed_rows_blog > 2){
                $dem = "col-md-4";
            }else{
                $dem = "col-md-6";
            }
    ?>
            <div class="<?php echo htmlspecialchars($dem); ?> d-flex">
  <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
    <a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('<?php echo htmlspecialchars($image_path[0]); ?>');">
    </a>
    <div class="text">
      <p class="meta">
        <span>Admin</span>
        <span><a href="?b=<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['post_date']) ?></a></span>
      </p>
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
     <div class="<?php echo htmlspecialchars($dem); ?> d-flex">
  <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
    <a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('<?php echo htmlspecialchars($default_blog["image_path"]); ?>');">
    </a>
    <div class="text">
      <p class="meta">
        <span>Admin</span> 
        <span><a href="#"><?= htmlspecialchars($default_blog['post_date']) ?></a></span>
      </p>
      <h3 class="heading mb-3"><a href="#"><?= htmlspecialchars($default_blog['title']) ?></a></h3>
      <p><?= htmlspecialchars($default_blog['description']) ?></p>
    </div>
  </div>
</div>
    <?php
    }
    ?>
<!-- <div class="col-md-6 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('images/k1.jpg');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span>Jan. 01, 2024</span><a href="#">0 Comments</a></p>
<h3 class="heading mb-3"><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor</p>
</div>
</div>
</div> -->
<!-- <div class="col-md-6 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('images/k1.jpg');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span>Jan. 01, 2024</span><a href="#">0 Comments</a></p>
<h3 class="heading mb-3"><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor</p>
</div>
</div>
</div> -->
<!-- <div class="col-md-4 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('images/k1.jpg');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span>Jan. 01, 2024</span><a href="#">0 Comments</a></p>
<h3 class="heading mb-3"><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor</p>
</div>
</div>
</div> -->
<!-- <div class="col-md-4 d-flex">
<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('images/k1.jpg');">
</a>
<div class="text">
<p class="meta"><span>Admin</span> <span>Jan. 01, 2024</span><a href="#">0 Comments</a></p>
<h3 class="heading mb-3"><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a></h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor</p>
</div>
</div>
</div> -->
<!-- <div class="col-md-4 d-flex">
	<div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
	<a href="blog-single.html" class="block-20 img d-flex align-items-end" style="background-image: url('images/k1.jpg');">
	</a>
	<div class="text">
	<p class="meta"><span>Admin</span> <span>Jan. 01, 2024</span><a href="#">0 Comments</a></p>
	<h3 class="heading mb-3"><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a></h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor</p>
	</div>
	</div>
	</div> -->

</div>
</div>
<!-- </section>
<section class="ftco-gallery">
<div class="container-xl-fluid">
<div class="row g-0">
<div class="col-md-2" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
<a href="images/gallery-1.jpg" class="gallery-wrap img d-flex align-items-center justify-content-center glightbox" style="background-image: url(images/gallery-1.jpg);">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-search"></span></div>
</a>
</div>
<div class="col-md-2" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
<a href="images/gallery-1.jpg" class="gallery-wrap img d-flex align-items-center justify-content-center glightbox" style="background-image: url(images/gallery-2.jpg);">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-search"></span></div>
</a>
</div>
<div class="col-md-2" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
<a href="images/gallery-3.jpg" class="gallery-wrap img d-flex align-items-center justify-content-center glightbox" style="background-image: url(images/gallery-3.jpg);">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-search"></span></div>
</a>
</div>
<div class="col-md-2" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
<a href="images/gallery-4.jpg" class="gallery-wrap img d-flex align-items-center justify-content-center glightbox" style="background-image: url(images/gallery-4.jpg);">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-search"></span></div>
</a>
</div>
<div class="col-md-2" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
<a href="images/gallery-5.jpg" class="gallery-wrap img d-flex align-items-center justify-content-center glightbox" style="background-image: url(images/gallery-5.jpg);">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-search"></span></div>
</a>
</div>
<div class="col-md-2" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
<a href="images/gallery-6.jpg" class="gallery-wrap img d-flex align-items-center justify-content-center glightbox" style="background-image: url(images/gallery-6.jpg);">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-search"></span></div>
</a>
</div>
</div>
</div>
</section> -->
<!-- get in touch modal -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title" id="contactModalLabel">Get in Touch</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="contactForm">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" placeholder="Enter your name" required>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required>
					</div>
				</form>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="contactForm">Submit</button>
			</div>
		</div>
	</div>
</div>
<!-- get in Login modal -->
<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title" id="authModalLabel">Login/Signup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="authTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Signup</a>
					</li>
				</ul>
				<!-- Tab content -->
				<div class="tab-content" id="authTabContent">
					<!-- Login Form -->
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
						<form id="loginForm">
							<div class="form-group">
								<label for="loginEmail">Email address</label>
								<input type="email" class="form-control" id="loginEmail" placeholder="Enter your email" required>
							</div>
							<div class="form-group">
								<label for="loginPassword">Password</label>
								<input type="password" class="form-control" id="loginPassword" placeholder="Password" required>
							</div>
							<button type="submit" class="btn btn-primary">Login</button>
						</form>
					</div>
					<!-- Signup Form -->
					<div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
						<form id="signupForm">
							<div class="form-group">
								<label for="signupName">Name</label>
								<input type="text" class="form-control" id="signupName" placeholder="Enter your name" required>
							</div>
							<div class="form-group">
								<label for="signupEmail">Email address</label>
								<input type="email" class="form-control" id="signupEmail" placeholder="Enter your email" required>
							</div>
							<div class="form-group">
								<label for="signupPassword">Password</label>
								<input type="password" class="form-control" id="signupPassword" placeholder="Password" required>
							</div>
							<button type="submit" class="btn btn-primary">Signup</button>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<footer class="ftco-footer">
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
	<li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Ticket Availability</a></li>
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
</footer>
<script src="js/6440-js-bootstrap.bundle.min.js"></script>
<script src="js/1306-js-tiny-slider.js"></script>
<script src="js/1453-js-glightbox.min.js"></script>
<script src="js/673-js-aos.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script>
<script src="js/8593-js-google-map.js"></script>
<script src="js/6806-js-main.js"></script>
<script>
	$(document).ready(function() {
            var currentPage = 0;
            var itemsPerPage = 3;
            var totalItems = $("#pac1 .col-md-4").length;
            var totalPages = Math.ceil(totalItems / itemsPerPage);
			var totalItems2 = $("#pac2 .col-md-4").length;
            var totalPages2 = Math.ceil(totalItems2 / itemsPerPage);
			var totalItems3 = $("#pac3 .col-md-4").length;
            var totalPages3 = Math.ceil(totalItems3 / itemsPerPage);

            function showPage(page, direction, divid) {
                var start = page * itemsPerPage;
                var end = start + itemsPerPage;
                
                // Add sliding out class to current visible items
                var currentItems = $("#"+divid+" .col-md-4:visible");
				//alert(divid);
                currentItems.addClass(direction === 'right' ? 'slide-out-left' : 'slide-out-right');

                // After sliding out, hide them
                setTimeout(function() {
                    currentItems.hide().removeClass('slide-out-left slide-out-right');

                    // Add sliding in class to new items
                    var newItems = $("#"+divid+" .col-md-4").slice(start, end);
                    newItems.addClass(direction === 'right' ? 'slide-in-right' : 'slide-in-left').show();

                    // Remove sliding in class after animation
                    setTimeout(function() {
                        newItems.removeClass('slide-in-right slide-in-left');
                    }, 500);
                }, 500);
            }

            $("#next").click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages - 1) {
                    currentPage++;
                    showPage(currentPage, 'right', 'pac1');
                }
            });

            $("#prev").click(function(e) {
                e.preventDefault();
                if (currentPage > 0) {
                    currentPage--;
                    showPage(currentPage, 'left', 'pac1');
                }
            });
			$("#next-2").click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages2 - 1) {
                    currentPage++;
                    showPage(currentPage, 'right', 'pac2');
                }
            });

            $("#prev-2").click(function(e) {
                e.preventDefault();
                if (currentPage > 0) {
                    currentPage--;
                    showPage(currentPage, 'left', 'pac2');
                }
            });
			$("#next-3").click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages3 - 1) {
                    currentPage++;
                    showPage(currentPage, 'right', 'pac3');
                }
            });

            $("#prev-3").click(function(e) {
                e.preventDefault();
                if (currentPage > 0) {
                    currentPage--;
                    showPage(currentPage, 'left', 'pac3');
                }
            });

            // Initialize the first page with sliding animation
            showPage(currentPage, 'right', 'pac1');
			showPage(currentPage, 'right', 'pac2');
			showPage(currentPage, 'right', 'pac3');
        });
</script>
</body>
</html>

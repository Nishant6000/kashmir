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
    //$conn = new mysqli("localhost", "root", "", "kashmir_tourism");
    include_once("db.php");

    // Check connection
    if (isset($_GET["hid"])) {
        $hid = $_GET["hid"];
        $sql = "
    SELECT hotels.*, 
           GROUP_CONCAT(hotel_images.image_path SEPARATOR ', ') AS image_paths
    FROM hotels 
    LEFT JOIN hotel_images ON hotels.id = hotel_images.hotel_id
    WHERE hotels.id = ?
    GROUP BY hotels.id
";
    
        $stmt = $conn->prepare($sql);
    
        // Check if the statement was prepared successfully
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    
        // Bind and execute if prepare was successful
        $stmt->bind_param("i", $hid);
        $stmt->execute();
        $hotel_result = $stmt->get_result();
        $stmt->close();
    }else{
        echo '<script>
        alert("Invalid request. Redirecting to Home Page");
        window.location.href = "index.php";
      </script>';
    exit;
    }
    if ($hotel_result->num_rows == 0) {
        echo "<script>
                alert('Hotel Details Not found! Going back.');
                window.history.back();
              </script>";
        exit;
    }
    
    
    $hotel_details =  $hotel_result->fetch_assoc();
   
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
    <p class="mb-0"><a href="#" class="btn btn-primary rounded">Login/Signup</a></p>
    </div>
    </div>
    </nav>
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_4.jpg');">
<div class="overlay"></div>
<div class="container">
<div class="row no-gutters slider-text align-items-center justify-content-center">
<div class="col-md-9 pt-5 text-center">
<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Packages<i class="fa fa-chevron-right"></i></span></p>
<h1 class="mb-0 bread">Destinations</h1>
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
    <section class="py-5">
    <div class="container">
        <div class="row">

            <!-- Left Column - Hotel Details -->
            <div class="col-md-8">
                <div class="card card-custom">
                    <h2 class="tripdeth">Hotel Details</h2>
                    <!-- <p> A luxurious stay with modern amenities and breathtaking views. Enjoy a relaxing atmosphere with top-notch services. </p> -->

                    <!-- Default Hotel Card -->
                    <div class="hotel-card" id="main-hotel-card">
                        <img src="<?php $images = explode(',', $hotel_details['image_paths']); echo !empty($images[0]) ? "./admin/".$images[0] : 'https://picsum.photos/600/400'; ?>" class="hotel-img" id="main-hotel-img" alt="Hotel Image">
                        <input type="hidden" id="current_hotel_price" value="<?php echo $hotel_details['price']; ?>">
                        <input type="hidden" id="hotel_ids" value="<?php echo $hotel_details['id']; ?>">
                        <div class="hotel-info">
                            <h5 id="main-hotel-name">
                                <?php echo $hotel_details['name']; ?>
                                <?php echo $hotel_details['rating']; ?>☆
                            </h5>
                            <p id="main-hotel-location"> <strong>Location:</strong> <?php echo $hotel_details['location']; ?> </p>
                            <p id="main-hotel-address"> <strong>Address:</strong> <?php echo $hotel_details['detailed_description']; ?> </p>
                            <p id="main-hotel-amenities"> <strong>Amenities:</strong> <?php echo $hotel_details['other_features']; ?> </p>
                          
                            <button class="btn btn-primary mt-3" onclick="history.back()">Go Back</button>
                        </div>
                    </div>
                    <h2 class="tripdeth">Hotel Description</h2>
                    <p> <?php echo $hotel_details['description']; ?></p>
                </div>
            </div>

            <!-- Right Column - Hotel Images -->
            <div class="col-md-4">
                <div class="card card-custom">
                    <h2 class="tripdeth">Hotel Images</h2>
                    <div class="hotel-gallery">
                        <?php
                        $images = explode(',', $hotel_details['image_paths']);
                        foreach ($images as $image) {
                            $image2 = explode("/",$image);
                            //echo $image;
                            echo '<img src="./admin/uploads/'.$image2[1]. '" class="hotel-img-thumbnail" alt="Hotel Image" onclick="openModal(\'./admin/uploads/'.$image2[1]. '\')">';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hotel Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Hotel Image">
            </div>
        </div>
    </div>
</div>



<!-- Image Modal -->


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
            </footer>
<script src="js/6440-js-bootstrap.bundle.min.js"></script>
<script src="js/1306-js-tiny-slider.js"></script>
<script src="js/1453-js-glightbox.min.js"></script>
<script src="js/673-js-aos.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script>
<script src="js/8593-js-google-map.js"></script>
<script src="js/6806-js-main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function openModal(imageSrc) {
        document.getElementById("modalImage").src = imageSrc;
        $("#imageModal").modal("show");
    }
</script>
</body>
</html>

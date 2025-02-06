<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kashmir Meridian</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
    $conn = new mysqli("localhost", "root", "", "kashmir_tourism");

    // Check connection
    if (isset($_GET["package_details"])) {
        $pid = $_GET["package_details"];
    
        $stmt = $conn->prepare("SELECT 
    p.id AS package_id,
    p.name AS package_name,
    p.description AS package_description,
    p.duration,
    p.price,
    p.destination_id,
    p.image AS main_image,
    p.is_trending,
    p.is_featured,
    p.rating,
    p.is_honeymoon,
    p.is_adventure,
    p.is_premium,
    p.is_budget,
    p.reviews,
    
    pi.image AS additional_image,  -- Additional images from Packages_images
    
    pd.itinerary,
    pd.hotel_id,
    pd.car_id,
    pd.inclusions,
    pd.exclusions,
    pd.charges_for_exclusions,
    pd.terms_and_conditions,
    pd.created_at

FROM 
    Packages p

LEFT JOIN 
    Packages_images pi ON p.id = pi.package_id

LEFT JOIN 
    Package_details pd ON p.id = pd.package_id

WHERE 
    p.id = ?;
");
    
        // Check if the statement was prepared successfully
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    
        // Bind and execute if prepare was successful
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $featured_result = $stmt->get_result();
        $stmt->close();
    }else{
        echo '<script>
        alert("Invalid request. Redirecting to Home Page");
        window.location.href = "index.php";
      </script>';
    exit;
    }
    $row = $featured_result->fetch_assoc();
    $hotel_id = 0;
    $hotel_id = $row["hotel_id"];
    $destination_id = $row["destination_id"];
    $text = $row["duration"];
    //die;
if (preg_match('/(\d+)\s*Days?/', $text, $matches)) {
    $days = $matches[1]; // Extract the number of days
} else {
   $days = 0;
}

    if ($hotel_id) {
        $stmt = $conn->prepare("
    SELECT hotels.*, 
           GROUP_CONCAT(hotel_images.image_path SEPARATOR ', ') AS image_paths
    FROM hotels 
    LEFT JOIN hotel_images ON hotels.id = hotel_images.hotel_id
    WHERE hotels.id = ?
    GROUP BY hotels.id
");
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $related_packages_result = $stmt->get_result();
        $stmt->close();
    
    }
   $hotel_details = $related_packages_result->fetch_assoc();
  $hotel_details_image = explode(',',$hotel_details["image_paths"]);
  
   if ($destination_id) {
    $stmt = $conn->prepare("
    SELECT hotels.*, 
           GROUP_CONCAT(hotel_images.image_path SEPARATOR ', ') AS image_paths
    FROM hotels 
    LEFT JOIN hotel_images ON hotels.id = hotel_images.hotel_id
    WHERE hotels.destination_id = ?
    GROUP BY hotels.id
");
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $related_packages_result_loc = $stmt->get_result();
    $stmt->close();

}
//$hotel_details_loc = $related_packages_result_loc->fetch_assoc();
$hotel_details_loc = []; // Initialize an empty array

    while ($row_n = $related_packages_result_loc->fetch_assoc()) {
        // Convert image_paths to an array
        //$row['image_paths'] = $row['image_paths'] ? explode(', ', $row['image_paths']) : [];
        $hotel_details_loc [] = $row_n; // Store each row in the array
    }
//echo count($hotel_details_loc);die;
// echo "<pre>";
//print_r($hotel_details_loc);
// echo "<pre>";
//die;
//e;
function generateStarRating($rating) {
    $max_stars = 5; // Total stars
    $output = '<div class="star-rating" id="main-hotel-rating">' . PHP_EOL;

    for ($i = 1; $i <= $max_stars; $i++) {
        if ($i <= $rating) {
            $output .= '<i class="fa fa-star checked"></i>' . PHP_EOL; // Filled star
        } else {
            $output .= '<i class="fa fa-star unchecked"></i>' . PHP_EOL; // Empty star
        }
    }

    $output .= '</div>';
    return $output;
}

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
<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Packages details<i class="fa fa-chevron-right"></i></span></p>
<h4 class="mb-0 bread"><?= htmlspecialchars($row['package_name']) ?></h4>
</div>
</div>
</div>
</section>
<section class="ftco-section ftco-no-pb ftco-no-pt">
    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <!-- <div class="ftco-search d-flex justify-content-center">
    <div class="row">
     <div class="col-md-12 nav-link-wrap d-flex ">
    <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Destination Search</a>
    <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Rent Properties</a>
    </div>
    </div>
    <div class="col-md-12 tab-wrap">
    <div class="tab-content" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
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
    <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-performance-tab">
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
    </div> 
    </div>
    </div>
    </div>
    </div> -->
    </div>
    </div>
    </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="row">

                <!-- Left Column - Package Details -->
                <div class="col-md-8">
                    <!-- Package Details -->
                    <div class="card card-custom">
                        <h2 class="tripdeth">Package Details</h2>
                        <p>
                        <?= htmlspecialchars($row['package_description']) ?>
                        </p>
                    </div>

                    <!-- Hotel Details -->
                    <div class="card card-custom">
    <h2 class="tripdeth">Hotel Details</h2>
    <p> <?= htmlspecialchars($hotel_details['description']) ?></p>

    <!-- Default Hotel Card -->
        <div class="hotel-card" id="main-hotel-card">
            <img src="<?= htmlspecialchars($hotel_details_image[0]) ?>" class="hotel-img" id="main-hotel-img" alt="Default Hotel">
            <?php 

            ?>
            <input type="hidden" id="current_hotel_price" value="7000">
            <input type="hidden" id="days" value="<?= htmlspecialchars($days) ?>">
            <div class="hotel-info">
                <h5 id="main-hotel-name">
                    <?= htmlspecialchars($hotel_details['name']) ?>
                    <!-- <div class="star-rating" id="main-hotel-rating">
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star unchecked"></i>
                    </div> -->
                    <?php 
                        echo generateStarRating($hotel_details['rating']);
                    ?>
                </h5>
                <p id="main-hotel-location"><?= htmlspecialchars($hotel_details['location']) ?></p>
                <a href="hotel_details.php?hid=<?php echo $destination_id; ?>" class="btn btn-link btn-sm">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> View Details
                </a>
                <!-- Button to Open Modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hotelSelectionModal">
                    Select Another Hotel
                </button>
            </div>
        </div>
    </div>

                    <!-- modal -->
                    <div class="modal fade" id="hotelSelectionModal" tabindex="-1" role="dialog" aria-labelledby="hotelSelectionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hotelSelectionModalLabel">Select Your Hotel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body bg-light">
                                    <!-- List of Hotels -->
                                    <div class="hotel-list ">
                                        <?php  
                                          foreach($hotel_details_loc as $ho_ind){ 
                                            $img_paths = explode(",", $ho_ind['image_paths']);

                                        ?>
                                        
                                    <div class="hotel-card modal-hotel-card" 
                                                    data-name="<?php echo $ho_ind['name']; ?>" 
                                                    data-location="<?php echo $ho_ind['location']; ?>"
                                                    data-img="<?php echo $img_paths[0]; ?>"
                                                    data-rating="<?php echo $ho_ind['rating']; ?>"
                                                    data-hotel-price="<?php echo $ho_ind['price']; ?>">
                                                    
                                                    <img src="<?php echo $img_paths[0]; ?>" class="hotel-img" alt="Hotel 2">
                                                    <div class="hotel-info">
                                                        <h5><?php echo $ho_ind['name']; ?>
                                                            <!-- <div class="star-rating">
                                                                <i class="fa fa-star checked"></i>
                                                                <i class="fa fa-star checked"></i>
                                                                <i class="fa fa-star checked"></i>
                                                                <i class="fa fa-star checked"></i>
                                                                <i class="fa fa-star unchecked"></i>
                                                            </div> -->
                                                            <?php 
                        echo generateStarRating($ho_ind['rating']);
                    ?>
                                                        </h5>
                                                        <p><?php echo $ho_ind['location']; ?></p>
                                                        <a href="hotel_details.php?hid=<?php echo $destination_id; ?>" class="btn btn-link btn-sm">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i> View Details
                                                        </a>
                                                        <button class="btn btn-primary btn-lg btn-block mb-1 select-hotel-btn">Select This Hotel</button>
                                                    </div>
                                    </div>

                                    <?php 
                                        }
                                    ?>
                                    
                                        
                                        <!-- Add more hotels as needed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <!-- Vehicle Details -->
                    <div class="card card-custom">
                        <h2 class="tripdeth">Vehicle Details</h2>
                        <p>Travel in comfort with our range of premium vehicles to suit your needs.</p>
                    
                        <!-- Default Vehicle Card -->
                        <div class="vehicle-card">
                            <img src="images/crysta.jpg" class="vehicle-img" alt="Default Vehicle">
                            <div class="vehicle-info">
                                <h5>Innova Crysta</h5>
                                <p>Color:Maroon</p>
                                
                                <!-- Button to Open Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vehicleSelectionModal">
                                    Select Another Vehicle
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal for Selecting Other Vehicles -->
                    <div class="modal fade" id="vehicleSelectionModal" tabindex="-1" role="dialog" aria-labelledby="vehicleSelectionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="vehicleSelectionModalLabel">Select Your Vehicle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body bg-light">
                                    <!-- List of Vehicles -->
                                    <div class="vehicle-list ">
                                        <div class="vehicle-card modal-vehicle-card">
                                            <img src="images/crysta.jpg" class="vehicle-img" alt="Vehicle 2">
                                            <div class="vehicle-info">
                                                <h5>Innova Crysta</h5>
                                                <p>Color: White</p>
                                                <a href="#" class="btn btn-primary btn-lg btn-block mb-1">Select This Vehicle</a>
                                            </div>
                                        </div>
                                        <div class="vehicle-card modal-vehicle-card">
                                            <img src="images/crysta.jpg" class="vehicle-img" alt="Vehicle 3">
                                            <div class="vehicle-info">
                                                <h5>Innova Crysta</h5>
                                                <p>Color: White</p>
                                                <a href="#" class="btn btn-primary btn-lg btn-block mb-1">Select This Vehicle</a>
                                            </div>
                                        </div>
                                        <!-- Add more vehicles as needed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Itinerary Section -->
                    <div class="card card-custom">
                        <h2 class="tripdeth">Day-wise Itinerary</h2>
                        <div class="timeline">
                            <?php 
                            
                            $itenaray = array();
                            $itenaray = explode("*", $row['itinerary']);
                           foreach ($itenaray as $itenaray_indu){
                            $data =  explode("\n",  $itenaray_indu);
                           
                           
                          
                          

?>
                            <!-- Day 1 -->
                            <div class="timeline-day">
                                <div class="timeline-content">
                                    <label class="timeline-day-label">
                                        <input type="checkbox" name="day" value="day1" checked>
                                        <span class="timeline-day-title"><?= htmlspecialchars($data[0]) ?></span>
                                    </label>
                                    <p><?= htmlspecialchars($data[1]) ?></p>
                                </div>
                            </div>
<?php
                           }
                           ?>
                            <!-- Day 2 -->
                            <!-- <div class="timeline-day">
                                <div class="timeline-content">
                                    <label class="timeline-day-label">
                                        <input type="checkbox" name="day" value="day1" checked>
                                        <span class="timeline-day-title">Day 2: Leh - Local Sightseeing</span>
                                    </label>
                                    <p>Visit the famous Shanti Stupa, Leh Palace, and the bustling Leh Market. Return to the hotel in the evening.</p>
                                </div>
                            </div> -->

                            <!-- Day 3 -->
                            <!-- <div class="timeline-day">
                                <div class="timeline-content">
                                    <label class="timeline-day-label">
                                        <input type="checkbox" name="day" value="day1" checked>
                                        <span class="timeline-day-title">Day 3: Leh to Nubra Valley</span>
                                    </label>
                                    <p>Drive through the Khardung La Pass to reach Nubra Valley. Visit Diskit Monastery and enjoy a camel ride in the sand dunes.</p>
                                </div>
                            </div> -->

                            <!-- Additional Days -->
                            <!-- Continue adding more days in a similar structure -->

                        </div>
                    </div>

                    <!-- Inclusions and Exclusions -->
                    <div class="card card-custom">
                        <h2 class="tripdeth">Inclusions & Exclusions</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Inclusions</h4>
                                <ul class="list-group list-group-flush">
                                    <?php
                                      $inclusions = array();
                                      $inclusions = explode("\n", $row['inclusions']);
                                    foreach($inclusions as $inclusions_ind){
                                    ?>
                                    <li class="list-group-item pl-1"><i class="fa fa-check-circle"></i><?= htmlspecialchars($inclusions_ind) ?></li>

                                    <?php
                                    }
                                    ?>
                                    <!-- <li class="list-group-item pl-1"><i class="fa fa-check-circle"></i> Daily breakfast and dinner</li>
                                    <li class="list-group-item pl-1"><i class="fa fa-check-circle"></i> Airport transfers</li>
                                    <li class="list-group-item pl-1"><i class="fa fa-check-circle"></i> All sightseeing tours by private cab</li>
                                    <li class="list-group-item pl-1"><i class="fa fa-check-circle"></i> Inner line permits</li> -->
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4>Exclusions</h4>
                                <ul class="list-group list-group-flush">
                                <?php
                                      $Exclusions = array();
                                      $Exclusions = explode("\n", $row['exclusions']);
                                    foreach($Exclusions as $Exclusions_ind){
                                    ?>
                                    <li class="list-group-item pl-1"><i class="fa fa-times-circle red"></i><?= htmlspecialchars($Exclusions_ind) ?></li>
                                    <?php
                                    }
                                    ?>

                                    <!-- <li class="list-group-item pl-1"><i class="fa fa-times-circle red"></i> Airfare</li>
                                    <li class="list-group-item pl-1">
                                        <i class="fa fa-times-circle red" id="ilunch"></i> Lunch&nbsp;
                                        <input type="checkbox" id="lunch" class="checkbox-inline">
                                    </li>
                                    <li class="list-group-item pl-1"><i class="fa fa-times-circle red"></i> Any personal expenses</li>
                                    <li class="list-group-item pl-1"><i class="fa fa-times-circle red"></i> Travel insurance</li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card card-custom">
                        <h3 class="tripdeth">Frequently Asked Questions (FAQs)</h3>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What is included in the tour package?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        The tour package includes accommodation in Hotel as Selected Above, daily breakfast and dinner, airport transfers, sightseeing tours by private cab, and inner line permits.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Are flights included in the package?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        No, airfare is not included in the tour package. You will need to book your flights separately.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Can I customize the itinerary?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        Yes, you can customize the itinerary according to your preferences. Please contact us for more details.
                                    </div>
                                </div>
                            </div>

                            <!-- Add more FAQs as needed -->

                        </div>
                    </div>
                    

                    <!-- Terms and Conditions -->
                    <div class="card card-custom">
                        <h3 class="tripdeth">Terms and Conditions</h3>
                        <p>
                        <?= htmlspecialchars($row['terms_and_conditions']) ?>
                        </p>
                    </div>
                </div>

                <!-- Right Column - Pricing & Booking -->
                <div class="col-md-4">
                    <!-- Pricing Section -->
                     <div class="sticky-sidebar">
                    <div class="card card-custom bg-light p-3 mb-4 ">
                        <h3 class="tripdeth"> <?= htmlspecialchars($row['duration']) ?></h3>
                        <p class="tripdetp">₹ <span id="tprice"><?= htmlspecialchars($row['price']) ?></span>/- per person</p>
                        <?php
                        $inclusions_with_commas = str_replace("\n", ", ", $row['inclusions']);
                        ?>
                        <p><?= htmlspecialchars($inclusions_with_commas) ?>.</p>
                    </div>

                    <!-- Booking Section -->
                    <div class="card card-custom bg-light p-3">
                        <h3 class="tripdeth">Book Your Tour</h3>
                        <p>Experience the beauty of Trip with our expertly curated tour package.</p>
                        
                        <a href="#" class="btn btn-primary btn-lg btn-block mb-1" data-toggle="modal" data-target="#bookingModal">Book Now</a>
                        <a href="#" class="btn btn-secondary btn-lg btn-block custom-primary">Enquire Now</a>
                        <a href="#" class="btn btn-primary btn-lg btn-block mb-1">Preview Itinerary(PDF)</a>
                    </div>
                    
                </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Tour Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input for number of adults -->
                <div class="form-group mb-3">
                    <label for="adults">Number of Adults:</label>
                    <input type="number" id="adults" class="form-control" placeholder="Enter number of adults" min="1">
                </div>
                
                <!-- Input for number of children below 8 -->
                <div class="form-group mb-3">
                    <label for="childrenBelow8">Number of Children below 8:</label>
                     <input type="number" id="childrenBelow8" class="form-control" placeholder="Enter number of children below 8" min="0">
                </div>
                
                <!-- Input for number of children above 8 -->
                <div class="form-group mb-3">
                    <label for="childrenAbove8">Number of Children above 8:</label>
                    <input type="number" id="childrenAbove8" class="form-control" placeholder="Enter number of children above 8" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Confirm Booking</button>
            </div>
        </div>
    </div>
</div>
    </section>
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
<script>
  $(document).ready(function() {
            $('#lunch').change(function() {
                if ($(this).is(':checked')) {
                    $('#ilunch').removeClass('fa-times-circle red'); // Remove class when unchecked
                    $('#ilunch').addClass('fa-check-circle')
                    // Add class when checked
                } else {
                    $('#ilunch').removeClass('fa-check-circle'); // Remove class when unchecked
                    $('#ilunch').addClass('fa-times-circle red')
                }
            });
        });
</script>
<script>
    document.querySelectorAll('.select-hotel-btn').forEach(button => {
    button.addEventListener('click', function () {
        const hotelCard = this.closest('.modal-hotel-card');

        // Get data attributes
        const hotelName = hotelCard.getAttribute('data-name');
        const hotelLocation = hotelCard.getAttribute('data-location');
        const hotelImg = hotelCard.getAttribute('data-img');
        const hotelRating = parseInt(hotelCard.getAttribute('data-rating'));
        const hotelPrice = parseInt(hotelCard.getAttribute('data-hotel-price'));

        // Update Main Display
        document.getElementById('main-hotel-name').innerHTML = `${hotelName} <div class="star-rating">${generateStarRating(hotelRating)}</div>`;
        document.getElementById('main-hotel-location').textContent = hotelLocation;
        document.getElementById('main-hotel-img').src = hotelImg;
        var tprice = document.getElementById('tprice').innerHTML;
        var chp = document.getElementById('current_hotel_price').value;
        var days = document.getElementById('days').value;
        var nprice = tprice-chp+(hotelPrice*days);
        var ncprice = hotelPrice*days;
        document.getElementById('tprice').innerHTML = nprice;
        document.getElementById('current_hotel_price').value = ncprice;

        // Close the modal
        $('#hotelSelectionModal').modal('hide');
    });
});

// Function to generate star rating HTML
function generateStarRating(rating) {
    let stars = '';
    for (let i = 0; i < 5; i++) {
        if (i < rating) {
            stars += '<i class="fa fa-star checked"></i>';
        } else {
            stars += '<i class="fa fa-star unchecked"></i>';
        }
    }
    return stars;
}
</script>
</body>
</html>

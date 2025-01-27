<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Kashmir Meridian</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
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
//print_r($blog_result);die;
$default_blog = array();
$default_blog['title'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
$default_blog['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare tempus aliquet Lorem ipsum dolor Lorem ipsum dolor";
$default_blog['post_date'] = "2025-01-23";
$default_blog['link'] = "#";
$default_blog['image_path'] = "images/k1.jpg";
$displayed_rows_blog = 0;
$total_cards_blog = 9;
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
<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Blog Posts <i class="fa fa-chevron-right"></i></span></p>
<h1 class="mb-0 bread">Blog Posts</h1>
</div>
</div>
</div>
</section>
<div class="container my-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-12">
            <h1 class="mb-4">Our Latest Blog Posts</h1>
            <div class="row">
                <!-- Blog Post 1 -->

                <!-- Blog Post 2 -->
                <!-- <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="images/k1.jpg" class="card-img-top" alt="Blog Image 2">
                        <div class="card-body">
                            <h5 class="card-title">Blog Post Title 2</h5>
                            <p class="card-text">This is a brief introduction to the second blog post. It highlights the key points to attract readers.</p>
                        </div>
                        <div class="card-footer">
                            <a href="blog-details.html" class="btn btn-primary">Read More</a>
                            <span class="float-end text-muted">Aug 9, 2024</span>
                        </div>
                    </div>
                </div> -->
                <?php
    if ($blog_result->num_rows > 0) {
        // Display featured packages from the database <?= htmlspecialchars($row['name']) 
        while ($row = $blog_result->fetch_assoc()) {
            $displayed_rows_blog++;
            $image_path = explode(",",$row["image_paths"]);
            //print_r($image_path); die;
            $displayed_rows_blog++;
            if($displayed_rows_blog > 7){
                $dem = "col-md-6";
            }else{
                $dem = "col-md-4";
            }
    ?>
             <div class="<?php echo htmlspecialchars($dem); ?> mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($image_path[0]); ?>" class="card-img-top" alt="Blog Image 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text"><?php
$description = $row['description'];
$words = explode(' ', $description);
$short_description = implode(' ', array_slice($words, 0, 40));

echo htmlspecialchars($short_description) . '...';
?></p>
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
        if($displayed_rows_blog > 7){
            $dem = "col-md-6";
        }else{
            $dem = "col-md-4";
        }
    ?>
        <div class="<?php echo htmlspecialchars($dem); ?> mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($default_blog['image_path']) ?>" class="card-img-top" alt="Blog Image 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($default_blog['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($default_blog['description']) ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?= htmlspecialchars($default_blog['link']) ?>" class="btn btn-primary">Read More</a>
                            <span class="float-end text-muted"><?= htmlspecialchars($default_blog['post_date']) ?></span>
                        </div>
                    </div>
                </div>
    <?php
    }
    ?>	
            </div>

            <!-- Pagination -->
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

        <!-- Sidebar -->
        
    </div>
</div>
<!-- <section class="img vid-section" style="background-image: url(images/bg_4.jpg);">
<div class="overlay"></div>
<div class="container-xl">
<div class="row justify-content-center">
<div class="col-md-6 vid-height d-flex align-items-center justify-content-center text-center">
<div class="video-wrap" data-aos="fade-up">
<h3>Modern House Video</h3>
<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
<a href="#" class="video-icon d-flex align-items-center justify-content-center">
<span class="ion-ios-play"></span>
</a>
</div>
</div>
</div>
</div>
</section> -->
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
    <p class="mb-0"></p><a href="#" class="btn btn-black py-3 px-4" data-toggle="modal" data-target="#contactModal">Get in touch</a></p>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>

<!-- <section class="ftco-gallery">
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
</body>
</html>

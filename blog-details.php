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
     //$conn = new mysqli("localhost", "root", "", "kashmir_tourism");
     include_once("db.php");
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
if(isset($_GET["bid"])){
$id = $_GET["bid"];
}else{
    echo '<script>
    alert("Invalid request. Redirecting to Blog Page...");
    window.location.href = "blog.php"; // Replace with your desired URL
  </script>';
exit; // Ensure the script stops executing further
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
WHERE 
    blogs.id = $id    
GROUP BY 
    blogs.id
LIMIT 1
";
$blog_result = $conn->query($blog_sql);

if ($blog_result && $blog_result->num_rows > 0) {
    // Fetch the data as an associative array
    $blog_data = $blog_result->fetch_assoc();
}else{
    $blog_data = array();
}
$image = explode(",", $blog_data["image_paths"]);
//print_r($image);die;
$post_id = $_GET["bid"]; // Use the actual post ID
$sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['comment'])) {
    $post_id = $_GET["bid"]; // Set this based on the post you're displaying comments for
    $author = $_POST['name'];
    $comment_text = $_POST['comment'];
    $stmt = $conn->prepare("INSERT INTO comments (post_id, author, comment_text) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $post_id, $author, $comment_text);
    $stmt->execute();
    $stmt->close();
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
<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Blogs <i class="fa fa-chevron-right"></i></span></p>
<h1 class="mb-0 bread">Blogs</h1>
</div>
</div>
</div>
</section>
<div class="container blog-post">
    <!-- Back Button -->
    <div class="back-button">
        <a href="blogs.php" class="btn btn-primary">← Back to Blog List</a>
    </div>

    <!-- Blog Post -->
    <article>
        <img src="<?= htmlspecialchars($image[1]) ?>" alt="Blog Post Image">
        <h1 class="mt-4"><?= htmlspecialchars($blog_data['title']) ?></h1>
        <p class="date"><?= htmlspecialchars($blog_data['post_date']) ?></p>
        <?php $description = $blog_data['description'];
$sentences = preg_split('/(?<=[.?!])\s+/', $description); // Split the content by sentence
$grouped_paragraphs = array_chunk($sentences, 5);

foreach ($grouped_paragraphs as $group) {
    $paragraph = implode(' ', $group); // Join the sentences back together into a paragraph
    echo '<p>' . htmlspecialchars($paragraph) . '</p>';
}
?>
    </article>

    <!-- Comments Section -->
    <section class="comments mt-5">
    <h2>Comments</h2>
    <div id="commentList">
        <?php
        // Check if there are any comments
        if ($result->num_rows > 0) {
            // If there are comments, display them
            while ($row = $result->fetch_assoc()) { ?>
                <div class="comment">
                    <p class="comment-author"><?php echo htmlspecialchars($row['author']); ?></p>
                    <p class="comment-date"><?php echo date("M d, Y \a\t h:i A", strtotime($row['created_at'])); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($row['comment_text'])); ?></p>
                </div>
            <?php }
        } else {
            // If no comments, display the "no comments found" message
            echo "<p>No comments found. Be the first to comment!</p>";
        }
        ?>
    </div>
</section>

    <!-- Comment Form -->
    <section class="comment-form mt-5">
    <h2>Leave a Comment</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </form>
</section>
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
  <p class="mb-0"><a href="#" class="btn btn-black py-3 px-4">Get in touch</a></p>
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

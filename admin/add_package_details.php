<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration']; // Get the duration value
    $category = $_POST['category']; // Get category value
    $rating = $_POST['rating']; // Get the rating value
    $reviews = $_POST['reviews']; // Get the reviews value

    // Set category flags based on selected category
    $is_honeymoon = $category == 'honeymoon' ? 1 : 0;
    $is_trending = $category == 'trending' ? 1 : 0;
    $is_featured = $category == 'featured' ? 1 : 0;
    $is_budget = $category == 'budget' ? 1 : 0;
    $is_premium = $category == 'premium' ? 1 : 0;

    // Insert the package into the packages table
    try {
        $stmt = $pdo->prepare("INSERT INTO packages (destination_id, name, description, price, duration, is_trending, is_featured, rating, is_honeymoon, is_budget, is_premium, reviews) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$destination_id, $name, $description, $price, $duration, $is_trending, $is_featured, $rating, $is_honeymoon, $is_budget, $is_premium, $reviews]);

        // Get the last inserted package ID
        $package_id = $pdo->lastInsertId();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }

    // Handle file uploads (same code as before)
    $target_dir = "uploads/"; // Directory to save uploaded images
    $uploadOk = 1;
    $success = '';
    $error = '';

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
            $target_file = $target_dir . basename($_FILES["images"]["name"][$key]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is an actual image
            $check = getimagesize($tmp_name);
            if ($check === false) {
                $error = "File {$target_file} is not an image.";
                $uploadOk = 0;
                continue;
            }

            // Check file size (e.g., limit to 2MB)
            if ($_FILES["images"]["size"][$key] > 2000000) {
                $error = "Sorry, your file {$target_file} is too large.";
                $uploadOk = 0;
                continue;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for file {$target_file}.";
                $uploadOk = 0;
                continue;
            }

            // Attempt to upload the file
            if ($uploadOk) {
                if (move_uploaded_file($tmp_name, $target_file)) {
                    // Insert image record into the database
                    try {
                        $stmtImage = $pdo->prepare("INSERT INTO packages_images (package_id, image) VALUES (?, ?)");
                        $stmtImage->execute([$package_id, $target_file]);
                    } catch (PDOException $e) {
                        $error = "Error: " . $e->getMessage();
                    }
                } else {
                    $error = "Sorry, there was an error uploading your file {$target_file}.";
                }
            }
        }
    }

    if (empty($error)) {
        $success = "Package added successfully! Duration: $duration";
    }
}

// Fetch destinations for the dropdown
$stmtDestinations = $pdo->query("SELECT * FROM destinations");
$destinations = $stmtDestinations->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Package</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Add a New Package</h1>
        
        <?php if (isset($error) && !empty($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif (isset($success)) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
    <!-- Select Package -->
    <div class="form-group">
        <label for="package_id">Select Package</label>
        <select name="package_id" id="package_id" class="form-control" required>
            <option value="">Select a package</option>
            <?php foreach ($packages as $package): ?>
                <option value="<?= $package['id'] ?>"><?= htmlspecialchars($package['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Select Destination -->
    <div class="form-group">
        <label for="destination_id">Select Destination</label>
        <select name="destination_id" id="destination_id" class="form-control" required>
            <option value="">Select a destination</option>
            <?php foreach ($destinations as $destination): ?>
                <option value="<?= $destination['id'] ?>"><?= htmlspecialchars($destination['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Select Car -->
    <div class="form-group">
        <label for="car_id">Select Car</label>
        <select name="car_id" id="car_id" class="form-control" required>
            <option value="">Select a car</option>
            <?php foreach ($cars as $car): ?>
                <option value="<?= $car['id'] ?>"><?= htmlspecialchars($car['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Select Hotel -->
    <div class="form-group">
        <label for="hotel_id">Select Hotel</label>
        <select name="hotel_id" id="hotel_id" class="form-control" required>
            <option value="">Select a hotel</option>
            <?php foreach ($hotels as $hotel): ?>
                <option value="<?= $hotel['id'] ?>"><?= htmlspecialchars($hotel['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Day-Wise Itinerary -->
    <div class="form-group">
        <label>Day-Wise Itinerary</label>
        <div id="itinerary-section">
            <!-- Placeholder for itinerary items -->
            <div class="itinerary-item mb-3">
                <label for="itinerary_day_1">Day 1:</label>
                <textarea name="itinerary[1]" id="itinerary_day_1" class="form-control" placeholder="Description for Day 1" required></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-itinerary-item">Add Another Day</button>
    </div>

    <!-- Inclusions -->
    <div class="form-group">
        <label for="inclusions">Inclusions</label>
        <textarea name="inclusions" id="inclusions" class="form-control" placeholder="List inclusions" required></textarea>
    </div>

    <!-- Exclusions -->
    <div class="form-group">
        <label for="exclusions">Exclusions</label>
        <textarea name="exclusions" id="exclusions" class="form-control" placeholder="List exclusions" required></textarea>
    </div>

    <!-- Charges for Exclusions -->
    <div class="form-group">
        <label for="charges_exclusions">Charges for Exclusions</label>
        <textarea name="charges_exclusions" id="charges_exclusions" class="form-control" placeholder="List charges for exclusions" required></textarea>
    </div>

    <!-- Terms and Conditions -->
    <div class="form-group">
        <label for="terms_conditions">Terms and Conditions</label>
        <textarea name="terms_conditions" id="terms_conditions" class="form-control" placeholder="Write terms and conditions" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Add Package Details</button>
</form>
        
        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
    <script>
    // JavaScript to dynamically add day-wise itinerary fields
    document.getElementById('add-itinerary-item').addEventListener('click', function () {
        const itinerarySection = document.getElementById('itinerary-section');
        const dayCount = itinerarySection.children.length + 1;

        const newItineraryItem = document.createElement('div');
        newItineraryItem.classList.add('itinerary-item', 'mb-3');
        newItineraryItem.innerHTML = `
            <label for="itinerary_day_${dayCount}">Day ${dayCount}:</label>
            <textarea name="itinerary[${dayCount}]" id="itinerary_day_${dayCount}" class="form-control" placeholder="Description for Day ${dayCount}" required></textarea>
        `;
        itinerarySection.appendChild(newItineraryItem);
    });
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Fetch destinations for the dropdown
$stmtDestinations = $pdo->query("SELECT id, name FROM destinations");
$destinations = $stmtDestinations->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $destination_id = $_POST['destination_id'];
    $images = $_FILES['images']; // Change to handle multiple images

    // Insert hotel details into the database
    $stmt = $pdo->prepare("INSERT INTO hotels (name, location, description, price, destination_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $location, $description, $price, $destination_id]);
    $hotel_id = $pdo->lastInsertId(); // Get the last inserted hotel ID

    // Handle image uploads
    if (!empty($images['tmp_name'][0])) {
        foreach ($images['tmp_name'] as $index => $tmpName) {
            if ($images['error'][$index] == 0) {
                $fileName = basename($images["name"][$index]);
                $targetFile = 'uploads/' . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if the file is a valid image
                $check = getimagesize($tmpName);
                if ($check === false) {
                    echo "File is not an image.";
                    continue;
                }

                // Check file size (5MB limit)
                if ($images["size"][$index] > 5000000) {
                    echo "Sorry, your file is too large.";
                    continue;
                }

                // Allow specific file formats
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    continue;
                }

                // Attempt to upload the file
                if (move_uploaded_file($tmpName, $targetFile)) {
                    // Insert each image path into a new table (e.g., hotel_images)
                    $stmtImage = $pdo->prepare("INSERT INTO hotel_images (hotel_id, image_path) VALUES (?, ?)");
                    $stmtImage->execute([$hotel_id, $targetFile]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    echo "The hotel has been added.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Hotel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Hotel</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Hotel Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="form-group">
                <label for="destination_id">Select Destination</label>
                <select class="form-control" name="destination_id" required>
                    <option value="">Select a destination</option>
                    <?php foreach ($destinations as $destination): ?>
                        <option value="<?= $destination['id'] ?>"><?= htmlspecialchars($destination['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="images">Upload Images</label>
                <input type="file" class="form-control" name="images[]" accept="image/*" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Add Hotel</button>
        </form>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Check if hotel ID is provided
if (!isset($_GET['id'])) {
    echo "No hotel ID provided.";
    exit();
}

$hotel_id = $_GET['id'];

// Fetch existing hotel details
$stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch existing images for the hotel
$stmtImages = $pdo->prepare("SELECT * FROM hotel_images WHERE hotel_id = ?");
$stmtImages->execute([$hotel_id]);
$images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

// Fetch destinations for the dropdown
$stmtDestinations = $pdo->query("SELECT id, name FROM destinations");
$destinations = $stmtDestinations->fetchAll(PDO::FETCH_ASSOC);

// Update hotel on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_hotel'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $destination_id = $_POST['destination_id'];

    // Update hotel details
    $stmtUpdate = $pdo->prepare("UPDATE hotels SET name = ?, location = ?, description = ?, price = ?, destination_id = ? WHERE id = ?");
    $stmtUpdate->execute([$name, $location, $description, $price, $destination_id, $hotel_id]);

    // Handle new image uploads
    if (!empty($_FILES['images']['tmp_name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['images']['error'][$index] == 0) {
                $fileName = basename($_FILES["images"]["name"][$index]);
                $targetFile = 'uploads/' . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Validate if the uploaded file is an actual image
                $check = getimagesize($tmpName);
                if ($check === false) {
                    echo "File is not an image.";
                    continue;
                }

                // Check file size (5MB limit)
                if ($_FILES["images"]["size"][$index] > 5000000) {
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
                    // Insert each image path into hotel_images table
                    $stmtImage = $pdo->prepare("INSERT INTO hotel_images (hotel_id, image_path) VALUES (?, ?)");
                    $stmtImage->execute([$hotel_id, $targetFile]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    echo "The hotel has been updated.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Hotel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Hotel</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Hotel Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($hotel['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($hotel['location']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required><?= htmlspecialchars($hotel['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" value="<?= htmlspecialchars($hotel['price']) ?>" required>
            </div>
            <div class="form-group">
                <label for="destination_id">Select Destination</label>
                <select class="form-control" name="destination_id" required>
                    <option value="">Select a destination</option>
                    <?php foreach ($destinations as $destination): ?>
                        <option value="<?= $destination['id'] ?>" <?= $hotel['destination_id'] == $destination['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($destination['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="images">Upload New Images (Optional)</label>
                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
            </div>
            <button name="update_hotel" type="submit" class="btn btn-primary">Update Hotel</button>
        </form>

        <h3 class="mt-5">Existing Images</h3>
        <div class="row">
            <?php foreach ($images as $image): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="Image">
                        <div class="card-body text-center">
                            <form method="POST" action="delete_image_hotel.php">
                                <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                                <input type="hidden" name="hotel_id" value="<?= $hotel_id ?>">
                                <button type="submit" class="btn btn-danger">Delete Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

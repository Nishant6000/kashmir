<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Check if car ID is provided
if (!isset($_GET['id'])) {
    echo "No car ID provided.";
    exit();
}

$car_id = $_GET['id'];

// Fetch existing car details
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch existing images for the car
$stmtImages = $pdo->prepare("SELECT * FROM cars_images WHERE car_id = ?");
$stmtImages->execute([$car_id]);
$images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

// Update car on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_car'])) {
    $model = $_POST['model'];
    $status = $_POST['status'];
    $price = $_POST['price'];

    // Update car details
    $stmt = $pdo->prepare("UPDATE cars SET model = ?, status = ?, price = ? WHERE id = ?");
    $stmt->execute([$model, $status, $price, $car_id]);

    // Handle new image uploads
    if (!empty($_FILES['images']['tmp_name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['images']['error'][$index] == 0) {
                $fileName = basename($_FILES["images"]["name"][$index]);
                $targetFile = 'uploads/' . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if the file is a valid image
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
                    // Insert each image path into the cars_images table
                    $stmt = $pdo->prepare("INSERT INTO cars_images (car_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$car_id, $targetFile]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    echo "The car has been updated.";
}

// Handle image deletion
if (isset($_POST['delete_image_id'])) {
    $image_id = $_POST['delete_image_id'];

    // Fetch the image path to delete it from the server
    $stmt = $pdo->prepare("SELECT image_path FROM cars_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        // Delete the image from the server
        if (file_exists($image['image_path'])) {
            unlink($image['image_path']);
        }

        // Delete the image from the database
        $stmt = $pdo->prepare("DELETE FROM cars_images WHERE id = ?");
        $stmt->execute([$image_id]);
    }
    echo "Image deleted successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Car</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="model">Car Model</label>
                <input type="text" class="form-control" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" required>
                    <option value="available" <?= $car['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="occupied" <?= $car['status'] == 'occupied' ? 'selected' : '' ?>>Occupied</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" value="<?= htmlspecialchars($car['price']) ?>" required>
            </div>
            <div class="form-group">
                <label for="images">Upload New Images (Optional)</label>
                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
            </div>
            <button type="submit" name="update_car" class="btn btn-primary">Update Car</button>
        </form>

        <h3 class="mt-4">Existing Images</h3>
        <div class="row">
            <?php foreach ($images as $image): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="Image">
                        <div class="card-body text-center">
                            <form method="POST" action="">
                                <input type="hidden" name="delete_image_id" value="<?= $image['id'] ?>">
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

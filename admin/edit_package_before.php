<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Check if package ID is provided
if (!isset($_GET['id'])) {
    echo "No package ID provided.";
    exit();
}

$package_id = $_GET['id'];

// Fetch existing package details
$stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->execute([$package_id]);
$package = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch existing images for the package
$stmtImages = $pdo->prepare("SELECT * FROM packages_images WHERE package_id = ?");
$stmtImages->execute([$package_id]);
$images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

// Update package on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration']; // Get the updated duration value

    // Update package details
    $stmt = $pdo->prepare("UPDATE packages SET destination_id = ?, name = ?, description = ?, price = ?, duration = ? WHERE id = ?");
    $stmt->execute([$destination_id, $name, $description, $price, $duration, $package_id]);

    // Handle new image uploads
    if (!empty($_FILES['images']['tmp_name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['images']['error'][$index] == 0) {
                $fileName = basename($_FILES['images']['name'][$index]);
                $targetFile = 'uploads/' . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Validate image
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

                // Try to upload file
                if (move_uploaded_file($tmpName, $targetFile)) {
                    // Insert new image into package_images table
                    $stmt = $pdo->prepare("INSERT INTO packages_images (package_id, image) VALUES (?, ?)");
                    $stmt->execute([$package_id, $targetFile]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    echo "The package has been updated.";
}

// Handle image deletion
if (isset($_GET['delete_image_id'])) {
    $delete_image_id = $_GET['delete_image_id'];
    
    // Fetch image path from the database
    $stmt = $pdo->prepare("SELECT image FROM packages_images WHERE id = ?");
    $stmt->execute([$delete_image_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        // Delete the image file from the server
        if (file_exists($image['image'])) {
            unlink($image['image']);
        }

        // Delete image entry from the database
        $stmt = $pdo->prepare("DELETE FROM packages_images WHERE id = ?");
        $stmt->execute([$delete_image_id]);
        echo "Image deleted successfully.";
    } else {
        echo "Image not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Package</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Package</h1>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="destination_id">Destination</label>
                <select name="destination_id" id="destination_id" class="form-control" required>
                    <?php
                    // Fetch destinations for the dropdown
                    $stmtDestinations = $pdo->query("SELECT * FROM destinations");
                    while ($destination = $stmtDestinations->fetch(PDO::FETCH_ASSOC)) {
                        $selected = $destination['id'] == $package['destination_id'] ? 'selected' : '';
                        echo "<option value=\"{$destination['id']}\" $selected>{$destination['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Package Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($package['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($package['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= htmlspecialchars($package['price']) ?>" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" name="duration" id="duration" class="form-control" value="<?= htmlspecialchars($package['duration']) ?>" required>
            </div>
            <div class="form-group">
                <label for="images">Upload New Images (Optional)</label>
                <input type="file" name="images[]" id="images" class="form-control-file" multiple>
            </div>
            <h3>Existing Images</h3>
            <div class="row">
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4 mb-3">
                        <img src="<?= htmlspecialchars($image['image']) ?>" class="img-fluid" alt="Image">
                        <a href="?id=<?= $package_id ?>&delete_image_id=<?= $image['id'] ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Are you sure you want to delete this image?');">Delete</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Package</button>
        </form>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

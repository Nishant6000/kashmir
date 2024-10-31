<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Check if destination ID is provided
if (!isset($_GET['id'])) {
    echo "No destination ID provided.";
    exit();
}

$destination_id = $_GET['id'];

// Fetch existing destination details
$stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
$stmt->execute([$destination_id]);
$destination = $stmt->fetch(PDO::FETCH_ASSOC);

// Update destination on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $new_images = $_FILES['images'];

    // Update destination details
    $stmt = $pdo->prepare("UPDATE destinations SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $description, $destination_id]);

    // Handle new image uploads
    if (!empty($new_images['tmp_name'][0])) {
        foreach ($new_images['tmp_name'] as $index => $tmpName) {
            if ($new_images['error'][$index] == 0) {
                $fileName = basename($new_images["name"][$index]);
                $targetFile = 'uploads/' . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if the file is a valid image
                $check = getimagesize($tmpName);
                if ($check === false) {
                    echo "File is not an image.";
                    continue;
                }

                // Check file size (5MB limit)
                if ($new_images["size"][$index] > 5000000) {
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
                    // Insert each image path into the destination_images table
                    $stmt = $pdo->prepare("INSERT INTO destination_images (destination_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$destination_id, $targetFile]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    // Redirect back to the edit destination page to reflect changes
    header("Location: edit_destination.php?id=" . $destination_id);
    exit();
}

// Fetch existing images for the destination after potential updates
$stmtImages = $pdo->prepare("SELECT * FROM destination_images WHERE destination_id = ?");
$stmtImages->execute([$destination_id]);
$images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Destination</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Destination</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Destination Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($destination['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required><?= htmlspecialchars($destination['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="images">Upload New Images (Optional)</label>
                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Update Destination</button>
        </form>

        <h3 class="mt-4">Existing Images</h3>
        <div class="row">
            <?php foreach ($images as $image): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="Image">
                        <div class="card-body text-center">
                            <form method="POST" action="delete_image.php">
                                <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                                <input type="hidden" name="destination_id" value="<?= $destination_id ?>">
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

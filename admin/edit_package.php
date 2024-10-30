<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_id = $_POST['package_id'];
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Handle file upload (optional)
    $target_dir = "uploads/"; // Directory to save uploaded images
    $uploadOk = 1;

    if ($_FILES["image"]["name"]) { // Only process upload if a new image is being uploaded
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $error = "File is not an image.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error = "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Update package with new image
                $stmt = $pdo->prepare("UPDATE packages SET destination_id = ?, name = ?, description = ?, price = ?, image = ? WHERE id = ?");
                $stmt->execute([$destination_id, $name, $description, $price, $target_file, $package_id]);
                $success = "Package updated successfully!";
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update package without changing the image
        $stmt = $pdo->prepare("UPDATE packages SET destination_id = ?, name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$destination_id, $name, $description, $price, $package_id]);
        $success = "Package updated successfully!";
    }
} else {
    // Fetch current package details for editing
    $package_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->execute([$package_id]);
    $package = $stmt->fetch();

    if (!$package) {
        header("Location: dashboard.php"); // Redirect if package not found
        exit();
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
        <h1 class="text-center">Edit Package</h1>
        
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif (isset($success)) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
            <div class="form-group">
                <label for="destination_id">Destination ID</label>
                <input type="number" name="destination_id" id="destination_id" class="form-control" value="<?= $package['destination_id'] ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Package Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $package['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required><?= $package['description'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= $package['price'] ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Upload New Image (leave blank if not changing)</label>
                <input type="file" name="image" id="image" class="form-control-file">
                <?php if ($package['image']) : ?>
                    <p>Current Image:</p>
                    <img src="<?= $package['image'] ?>" alt="<?= $package['name'] ?>" width="100">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Package</button>
        </form>
        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

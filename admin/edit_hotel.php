<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $occupied = $_POST['occupied']; // Assuming 0 or 1 for availability
    $available = $_POST['available']; // Assuming 0 or 1 for availability
    
    // Handle file upload (optional)
    $target_dir = "uploads/";
    $uploadOk = 1;

    if ($_FILES["image"]["name"]) {
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
                // Update hotel with new image
                $stmt = $pdo->prepare("UPDATE hotels SET destination_id = ?, name = ?, description = ?, price = ?, image = ?, occupied = ? WHERE id = ?");
                $stmt->execute([$destination_id, $name, $description, $price, $target_file, $occupied, $hotel_id]);
                $success = "Hotel updated successfully!";
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update hotel without changing the image
        $stmt = $pdo->prepare("UPDATE hotels SET destination_id = ?, name = ?, description = ?, price = ?, occupied = ? WHERE id = ?");
        $stmt->execute([$destination_id, $name, $description, $price, $occupied, $hotel_id]);
        $success = "Hotel updated successfully!";
    }
} else {
    $hotel_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
    $stmt->execute([$hotel_id]);
    $hotel = $stmt->fetch();

    if (!$hotel) {
        header("Location: dashboard.php");
        exit();
    }
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
        <h1 class="text-center">Edit Hotel</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif (isset($success)) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
            <div class="form-group">
                <label for="destination_id">Destination ID</label>
                <input type="number" name="destination_id" id="destination_id" class="form-control" value="<?= $hotel['destination_id'] ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Hotel Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $hotel['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required><?= $hotel['description'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= $hotel['price'] ?>" required>
            </div>
            <div class="form-group">
                <label for="occupied">Occupied</label>
                <select name="occupied" id="occupied" class="form-control">
                    <option value="1" <?= $hotel['occupied'] ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= !$hotel['occupied'] ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Upload New Image (leave blank if not changing)</label>
                <input type="file" name="image" id="image" class="form-control-file">
                <?php if ($hotel['image']) : ?>
                    <p>Current Image:</p>
                    <img src="<?= $hotel['image'] ?>" alt="<?= $hotel['name'] ?>" width="100">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Hotel</button>
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

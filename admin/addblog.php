<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $post_date = $_POST['post_date'];
    $images = $_FILES['images'];

    try {
        // Insert blog information
        $stmt = $pdo->prepare("INSERT INTO blogs (title, description, post_date) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $post_date]);
        $blog_id = $pdo->lastInsertId();

        // Handle multiple image uploads
        $uploadDir = 'uploads/';
        foreach ($images['tmp_name'] as $index => $tmpName) {
            if ($images['error'][$index] == 0) {
                $fileName = basename($images["name"][$index]);
                $targetFile = $uploadDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is a real image
                $check = getimagesize($tmpName);
                if ($check === false) {
                    echo "File is not an image.";
                    continue;
                }

                // Check file size (5MB limit)
                if ($images["size"][$index] > 10000000) {
                    echo "Sorry, your file is too large.";
                    continue;
                }

                // Allow only specific file formats
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    continue;
                }

                // Attempt to upload file
                if (move_uploaded_file($tmpName, $targetFile)) {
                    // Insert each image path into blog_images table
                    $stmt = $pdo->prepare("INSERT INTO blog_images (blog_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$blog_id, $targetFile]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Error uploading file.";
            }
        }

        echo "The blog and images have been added.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Blog</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Blog</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Blog Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="post_date">Date of Post</label>
                <input type="date" class="form-control" name="post_date" required>
            </div>
            <div class="form-group">
                <label for="images">Upload Images</label>
                <input type="file" class="form-control" name="images[]" accept="image/*" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Add Blog</button>
        </form>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

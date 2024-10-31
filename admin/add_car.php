<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Fetch destinations for the dropdown
$stmtDestinations = $pdo->query("SELECT * FROM destinations");
$destinations = $stmtDestinations->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST['model'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $destination_id = $_POST['destination_id'];

    // Insert car data
    try {
        $stmt = $pdo->prepare("INSERT INTO cars (model, status, price, destination_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$model, $status, $price, $destination_id]);
        $car_id = $pdo->lastInsertId(); // Get the last inserted car ID

        // Handle multiple image uploads
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] == 0) {
                    $imagePath = 'uploads/' . basename($_FILES['images']['name'][$index]);
                    if (move_uploaded_file($tmpName, $imagePath)) {
                        // Insert image path into cars_images table
                        $stmtImage = $pdo->prepare("INSERT INTO cars_images (car_id, image_path) VALUES (?, ?)");
                        $stmtImage->execute([$car_id, $imagePath]);
                    }
                }
            }
        }

        echo "Car added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Car</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="model">Car Model:</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="destination_id">Destination:</label>
            <select class="form-control" id="destination_id" name="destination_id" required>
                <option value="">Select Destination</option>
                <?php foreach ($destinations as $destination): ?>
                    <option value="<?= htmlspecialchars($destination['id']) ?>"><?= htmlspecialchars($destination['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="images">Upload Images:</label>
            <input type="file" class="form-control-file" id="images" name="images[]" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Add Car</button>
    </form>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>

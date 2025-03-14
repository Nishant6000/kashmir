<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Fetch summaries of each table
try {
    $destinations = $pdo->query("SELECT * FROM destinations")->fetchAll();
    $hotels = $pdo->query("SELECT * FROM hotels")->fetchAll();
    $packages = $pdo->query("SELECT * FROM packages")->fetchAll();
    $cars = $pdo->query("SELECT * FROM cars")->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tourism Dashboard</h1>
        
        <!-- Destinations Section -->
        <h3>Destinations</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th><th>Name</th><th>Actions</th>
            </tr>
            <?php foreach ($destinations as $destination): ?>
            <tr>
                <td><?= $destination['id'] ?></td>
                <td><?= htmlspecialchars($destination['name']) ?></td>
                <td>
                    <a href="edit_destination.php?id=<?= $destination['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?type=destination&id=<?= $destination['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this destination?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Hotels Section -->
        <h3>Hotels</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th><th>Name</th><th>Actions</th>
            </tr>
            <?php foreach ($hotels as $hotel): ?>
            <tr>
                <td><?= $hotel['id'] ?></td>
                <td><?= htmlspecialchars($hotel['name']) ?></td>
                <td>
                    <a href="edit_hotel.php?id=<?= $hotel['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?type=hotel&id=<?= $hotel['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this hotel?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Packages Section -->
        <h3>Packages</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th><th>Name</th><th>Actions</th>
            </tr>
            <?php foreach ($packages as $package): ?>
            <tr>
                <td><?= $package['id'] ?></td>
                <td><?= htmlspecialchars($package['name']) ?></td>
                <td>
                    <a href="edit_package.php?id=<?= $package['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?type=package&id=<?= $package['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this package?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Cars Section -->
        <h3>Cars</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th><th>Model</th><th>Actions</th>
            </tr>
            <?php foreach ($cars as $car): ?>
            <tr>
                <td><?= $car['id'] ?></td>
                <td><?= htmlspecialchars($car['model']) ?></td>
                <td>
                    <a href="edit_car.php?id=<?= $car['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?type=car&id=<?= $car['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <div class="text-center mt-4">
            <a href="add_destination.php" class="btn btn-primary">Add Destination</a>
            <a href="add_hotel.php" class="btn btn-success">Add Hotel</a>
            <a href="add_car.php" class="btn btn-danger">Add Car</a>
            <a href="add_package.php" class="btn btn-warning">Add Package</a>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

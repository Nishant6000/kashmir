<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Fetch destinations
$stmt = $pdo->query("SELECT * FROM destinations");
$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch hotels
$stmt = $pdo->query("SELECT * FROM hotels");
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch cars
$stmt = $pdo->query("SELECT * FROM cars");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch packages
$stmt = $pdo->query("SELECT * FROM packages");
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1 class="text-center">Dashboard</h1>

        <!-- Destinations Section -->
        <div class="mt-5">
            <h2>Destinations</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($destinations as $destination) : ?>
                        <tr>
                            <td><?= $destination['id'] ?></td>
                            <td><?= $destination['name'] ?></td>
                            <td><?= $destination['description'] ?></td>
                            <td>
                                <a href="edit_destination.php?id=<?= $destination['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="add_destination.php" class="btn btn-success">Add Destination</a>
        </div>

        <!-- Hotels Section -->
        <div class="mt-5">
            <h2>Hotels</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Destination ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hotels as $hotel) : ?>
                        <tr>
                            <td><?= $hotel['id'] ?></td>
                            <td><?= $hotel['destination_id'] ?></td>
                            <td><?= $hotel['name'] ?></td>
                            <td><?= $hotel['description'] ?></td>
                            <td><?= $hotel['price'] ?></td>
                            <td>
                                <a href="edit_hotel.php?id=<?= $hotel['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="add_hotel.php" class="btn btn-success">Add Hotel</a>
        </div>

        <!-- Cars Section -->
        <div class="mt-5">
            <h2>Cars</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car) : ?>
                        <tr>
                            <td><?= $car['id'] ?></td>
                            <td><?= $car['name'] ?></td>
                            <td><?= $car['description'] ?></td>
                            <td><?= $car['price'] ?></td>
                            <td>
                                <a href="edit_car.php?id=<?= $car['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="add_car.php" class="btn btn-success">Add Car</a>
        </div>

        <!-- Packages Section -->
        <div class="mt-5">
            <h2>Packages</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Destination ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($packages as $package) : ?>
                        <tr>
                            <td><?= $package['id'] ?></td>
                            <td><?= $package['destination_id'] ?></td>
                            <td><?= $package['name'] ?></td>
                            <td><?= $package['description'] ?></td>
                            <td><?= $package['price'] ?></td>
                            <td>
                                <a href="edit_package.php?id=<?= $package['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="add_package.php" class="btn btn-success">Add Package</a>
        </div>

        <div class="text-center mt-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

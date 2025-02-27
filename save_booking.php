<?php
// Database connection
// $host = 'localhost';
// $username = 'root';
// $password = ''; // Update if you have a password
// $database = 'your_database_name';

$conn = new mysqli("localhost", "root", "", "kashmir_tourism");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$adults = $_POST['adults'];
$childrenBelow5 = $_POST['childrenBelow5'];
$childrenAbove5 = $_POST['childrenAbove5'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$totalCost = str_replace(",", "", $_POST['totalCost']);
$package_id = $_POST['package_id'];
$car_id = $_POST['car_id'];
$hotel_id = $_POST['hotel_id'];
$uid = $_POST['uid'];

// Insert data into database
$sql = "INSERT INTO bookings (adults, children_below_5, children_above_5, email, phone, total_cost, package_id, car_id, hotel_id, uid) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiissdiiis", $adults, $childrenBelow5, $childrenAbove5, $email, $phone, $totalCost, $package_id, $car_id, $hotel_id, $uid);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>

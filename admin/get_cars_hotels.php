<?php
// Database connection using mysqli
$conn = new mysqli("localhost", "root", "", "kashmir_tourism");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Rest of the code for fetching cars and hotels...
if (isset($_POST['destination_id'])) {
    $destination_id = $_POST['destination_id'];

    // Prepare and execute the queries
    $cars_query = "SELECT id, model, destination_id FROM cars WHERE destination_id = ?";
    $hotels_query = "SELECT id, name FROM hotels WHERE destination_id = ?";

    // Prepare and bind the statement for cars
    $stmt = $conn->prepare($cars_query);
    $stmt->bind_param("i", $destination_id);  // "i" means integer
    $stmt->execute();
    $cars_result = $stmt->get_result();
    $cars = $cars_result->fetch_all(MYSQLI_ASSOC);

    // Prepare and bind the statement for hotels
    $stmt = $conn->prepare($hotels_query);
    $stmt->bind_param("i", $destination_id);  // "i" means integer
    $stmt->execute();
    $hotels_result = $stmt->get_result();
    $hotels = $hotels_result->fetch_all(MYSQLI_ASSOC);

    // Return the results as JSON
    echo json_encode([
        'cars' => $cars,
        'hotels' => $hotels
    ]);
}
?>

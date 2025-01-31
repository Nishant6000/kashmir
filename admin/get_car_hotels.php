<?php
if (isset($_POST['destination_id'])) {
    $destination_id = $_POST['destination_id'];

    // Fetch cars and hotels associated with the destination
    $cars_query = "SELECT id, name FROM cars WHERE destination_id = ?";
    $hotels_query = "SELECT id, name FROM hotels WHERE destination_id = ?";

    // Prepare and execute the queries
    $stmt = $pdo->prepare($cars_query);
    $stmt->execute([$destination_id]);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare($hotels_query);
    $stmt->execute([$destination_id]);
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode([
        'cars' => $cars,
        'hotels' => $hotels
    ]);
}
?>

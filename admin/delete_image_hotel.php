<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

// Check if image ID and hotel ID are provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image_id']) && isset($_POST['hotel_id'])) {
    $image_id = $_POST['image_id'];
    $hotel_id = $_POST['hotel_id'];

    // Fetch the image path to delete from the filesystem
    $stmt = $pdo->prepare("SELECT image_path FROM hotel_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        // Delete the image file from the server
        unlink($image['image_path']);

        // Delete the image entry from the database
        $stmtDelete = $pdo->prepare("DELETE FROM hotel_images WHERE id = ?");
        $stmtDelete->execute([$image_id]);
    }

    // Redirect back to edit hotel page
    header("Location: edit_hotel.php?id=" . $hotel_id);
    exit();
}

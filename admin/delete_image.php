<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_id = $_POST['image_id'];
    $destination_id = $_POST['destination_id'];

    // Fetch the image path to delete from the file system
    $stmt = $pdo->prepare("SELECT image_path FROM destination_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        // Remove the file from the server
        unlink($image['image_path']);

        // Delete the image record from the database
        $stmt = $pdo->prepare("DELETE FROM destination_images WHERE id = ?");
        $stmt->execute([$image_id]);
        echo "Image deleted successfully.";
    } else {
        echo "Image not found.";
    }
}

// Redirect back to the edit destination page
header("Location: edit_destination.php?id=" . $destination_id);
exit();
?>

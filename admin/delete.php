<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = (int) $_GET['id'];
    $tableName = "";

    switch ($type) {
        case "destination":
            $tableName = "destinations";
            break;
        case "hotel":
            $tableName = "hotels";
            break;
        case "package":
            $tableName = "packages";
            break;
        case "car":
            $tableName = "cars";
            break;
        case "blog":
            $tableName = "blogs";
            break;
        default:
            echo "Invalid type.";
            exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM $tableName WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: dashboard.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>

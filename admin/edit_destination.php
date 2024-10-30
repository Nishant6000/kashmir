<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $stmt = $pdo->prepare("UPDATE destinations SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $description, $destination_id]);
    $success = "Destination updated successfully!";
} else {
    $destination_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->execute([$destination_id]);
    $destination = $stmt->fetch();

    if (!$destination) {
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Destination</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Destination</h1>

        <?php if (isset($success)) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post" class="mt-4">
            <input type="hidden" name="destination_id" value="<?= $destination['id'] ?>">
            <div class="form-group">
                <label for="name">Destination Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $destination['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required><?= $destination['description'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Destination</button>
        </form>
        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

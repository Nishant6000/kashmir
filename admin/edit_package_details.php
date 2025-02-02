<?php
$conn = new mysqli("localhost", "root", "", "kashmir_tourism");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available destinations and packages for dropdowns
$sqlDestinations = "SELECT * FROM destinations";
$resultDestinations = $conn->query($sqlDestinations);
$destinations = $resultDestinations->fetch_all(MYSQLI_ASSOC);

$sqlPackages = "SELECT * FROM packages";
$resultPackages = $conn->query($sqlPackages);
$packages_det = $resultPackages->fetch_all(MYSQLI_ASSOC);

// Initialize variables
$package_details = [];
$package_details_id = $_GET['id'] ?? null;

// Fetch existing package details for editing
if ($package_details_id) {
    $sql = "SELECT * FROM package_details WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $package_details_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package_details = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $package_id = $_POST['package_id'];
    $destination_id = $_POST['destination_id'];
    $car_id = $_POST['car_id'];
    $hotel_id = $_POST['hotel_id'];
    $itinerary = implode('*', $_POST['itinerary']);
    $inclusions = $_POST['inclusions'];
    $exclusions = $_POST['exclusions'];
    $charges_for_exclusions = $_POST['charges_exclusions'];
    $terms_and_conditions = $_POST['terms_conditions'];

    // Update the package_details table
    $sql = "UPDATE package_details 
            SET package_id = ?, destination_id = ?, car_id = ?, hotel_id = ?, itinerary = ?, inclusions = ?, exclusions = ?, charges_for_exclusions = ?, terms_and_conditions = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiiisssdsi', $package_id, $destination_id, $car_id, $hotel_id, $itinerary, $inclusions, $exclusions, $charges_for_exclusions, $terms_and_conditions, $package_details_id);

    if ($stmt->execute()) {
        $success = "Package details updated successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Package</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Package Details</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif (isset($success)) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
            <!-- Select Package -->
            <label for="package_id">Select Package</label>
            <select name="package_id" id="package_id" class="form-control" required onchange="fetchCarsAndHotels()">
                <option value="">Select a package</option>
                <?php foreach ($packages_det as $package): ?>
                    <option value="<?= $package['id'] ?>" data-destination="<?= $package['destination_id'] ?>"
                        <?= ($package_details['package_id'] ?? '') == $package['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($package['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Hidden Destination -->
            <input type="hidden" name="destination_id" id="destination_id" value="<?= $package_details['destination_id'] ?? '' ?>">

            <!-- Select Car -->
            <div class="form-group">
                <label for="car_id">Select Car</label>
                <select name="car_id" id="car_id" class="form-control" required>
                    <option value="">Select a car</option>
                    <!-- Cars will be loaded dynamically -->
                </select>
            </div>

            <!-- Select Hotel -->
            <div class="form-group">
                <label for="hotel_id">Select Hotel</label>
                <select name="hotel_id" id="hotel_id" class="form-control" required>
                    <option value="">Select a hotel</option>
                    <!-- Hotels will be loaded dynamically -->
                </select>
            </div>

            <!-- Day-Wise Itinerary -->
            <div class="form-group">
                <label>Day-Wise Itinerary</label>
                <div id="itinerary-section">
                    <?php 
                        $itinerary_days = explode('*', $package_details['itinerary'] ?? '');
                        foreach ($itinerary_days as $index => $day_desc):
                    ?>
                        <div class="itinerary-item mb-3">
                            <label for="itinerary_day_<?= $index + 1 ?>">Day <?= $index + 1 ?>:</label>
                            <textarea name="itinerary[<?= $index + 1 ?>]" id="itinerary_day_<?= $index + 1 ?>" 
                                class="form-control" required><?= htmlspecialchars($day_desc) ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="add-itinerary-item">Add Another Day</button>
            </div>

            <!-- Inclusions -->
            <div class="form-group">
                <label for="inclusions">Inclusions</label>
                <textarea name="inclusions" id="inclusions" class="form-control" required><?= htmlspecialchars($package_details['inclusions'] ?? '') ?></textarea>
            </div>

            <!-- Exclusions -->
            <div class="form-group">
                <label for="exclusions">Exclusions</label>
                <textarea name="exclusions" id="exclusions" class="form-control" required><?= htmlspecialchars($package_details['exclusions'] ?? '') ?></textarea>
            </div>

            <!-- Charges for Exclusions -->
            <div class="form-group">
                <label for="charges_exclusions">Charges for Exclusions</label>
                <textarea name="charges_exclusions" id="charges_exclusions" class="form-control" required><?= htmlspecialchars($package_details['charges_for_exclusions'] ?? '') ?></textarea>
            </div>

            <!-- Terms and Conditions -->
            <div class="form-group">
                <label for="terms_conditions">Terms and Conditions</label>
                <textarea name="terms_conditions" id="terms_conditions" class="form-control" required><?= htmlspecialchars($package_details['terms_and_conditions'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Update Package Details</button>
        </form>

        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <!-- JavaScript for adding itinerary days dynamically -->
    <script>
    document.getElementById('add-itinerary-item').addEventListener('click', function () {
        const itinerarySection = document.getElementById('itinerary-section');
        const dayCount = itinerarySection.children.length + 1;

        const newItineraryItem = document.createElement('div');
        newItineraryItem.classList.add('itinerary-item', 'mb-3');
        newItineraryItem.innerHTML = `
            <label for="itinerary_day_${dayCount}">Day ${dayCount}:</label>
            <textarea name="itinerary[${dayCount}]" id="itinerary_day_${dayCount}" class="form-control" required></textarea>
        `;
        itinerarySection.appendChild(newItineraryItem);
    });

    // Fetch cars and hotels based on the selected package
    function fetchCarsAndHotels() {
        var packageId = document.getElementById('package_id').value;
        if (packageId) {
            var destinationId = document.querySelector('#package_id option:checked').getAttribute('data-destination');
            document.getElementById('destination_id').value = destinationId;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_cars_hotels.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('destination_id=' + destinationId);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);

                    // Update car dropdown
                    var carSelect = document.getElementById('car_id');
                    carSelect.innerHTML = '<option value="">Select a car</option>';
                    data.cars.forEach(function(car) {
                        var option = document.createElement('option');
                        option.value = car.id;
                        option.textContent = car.model;
                        if (<?= json_encode($package_details['car_id'] ?? '') ?> == car.id) {
                            option.selected = true;
                        }
                        carSelect.appendChild(option);
                    });

                    // Update hotel dropdown
                    var hotelSelect = document.getElementById('hotel_id');
                    hotelSelect.innerHTML = '<option value="">Select a hotel</option>';
                    data.hotels.forEach(function(hotel) {
                        var option = document.createElement('option');
                        option.value = hotel.id;
                        option.textContent = hotel.name;
                        if (<?= json_encode($package_details['hotel_id'] ?? '') ?> == hotel.id) {
                            option.selected = true;
                        }
                        hotelSelect.appendChild(option);
                    });
                }
            };
        }
    }

    // Automatically fetch cars and hotels if editing
    window.onload = fetchCarsAndHotels;
    </script>
</body>
</html>

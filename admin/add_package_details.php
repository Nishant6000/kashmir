<?php
$conn = new mysqli("localhost", "root", "", "kashmir_tourism");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sqlDestinations = "SELECT * FROM destinations";
$resultDestinations = $conn->query($sqlDestinations);
$destinations = $resultDestinations->fetch_all(MYSQLI_ASSOC);

$sqlPackages = "SELECT * FROM packages";
$resultPackages = $conn->query($sqlPackages);
$packages_det = $resultPackages->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    // include 'db_connection.php';

    // Fetch form data
    $package_id = $_POST['package_id'];
    $destination_id = $_POST['destination_id'];
    $car_id = $_POST['car_id'];
    $hotel_id = $_POST['hotel_id'];
    // $itinerary = $_POST['itinerary'];
    $itinerary = implode('*', $_POST['itinerary']);
    $inclusions = $_POST['inclusions'];
    $exclusions = $_POST['exclusions'];
    $charges_for_exclusions = $_POST['charges_exclusions'];
    $terms_and_conditions = $_POST['terms_conditions'];

    //============================================================
    

    // Insert into package_details table
    $sql = "INSERT INTO package_details 
            (package_id, destination_id, car_id, hotel_id, itinerary, inclusions, exclusions, charges_for_exclusions, terms_and_conditions) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiiisssds', $package_id, $destination_id, $car_id, $hotel_id, $itinerary, $inclusions, $exclusions, $charges_for_exclusions, $terms_and_conditions);

    if ($stmt->execute()) {
        echo "Package details added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}else{

}



// Fetch destinations for the dropdown
// $stmtDestinations = $pdo->query("SELECT * FROM destinations");
// $destinations = $stmtDestinations->fetchAll(PDO::FETCH_ASSOC);
// $stmtPackages = $pdo->query("SELECT * FROM packages");
// $packages_det = $stmtPackages->fetchAll(PDO::FETCH_ASSOC);
//$destination_id = $packages_det[0]['destination_id'];

//print_r($packages_det[0]['destination_id']);die;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Package</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Add a New Package</h1>
        
        <?php if (isset($error) && !empty($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif (isset($success)) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
    <!-- Select Package -->
    <label for="destination_id">Select Package</label>
    <select name="package_id" id="package_id" class="form-control" required onchange="fetchCarsAndHotels()">
    <option value="">Select a package</option>
    <?php foreach ($packages_det as $package): ?>
        <option value="<?= $package['id'] ?>" data-destination="<?= $package['destination_id'] ?>"><?= htmlspecialchars($package['name']) ?></option>
    <?php endforeach; ?>
    </select>

    <!-- Select Destination -->
    <input type="hidden" name="destination_id" id="destination_id" value="">


    <!-- Select Car -->
    <div class="form-group">
        <label for="car_id">Select Car</label>
        <select name="car_id" id="car_id" class="form-control" required>
            <option value="">Select a car</option>
            <?php foreach ($cars as $car): ?>
                <option value="<?= $car['id'] ?>"><?= htmlspecialchars($car['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Select Hotel -->
    <div class="form-group">
        <label for="hotel_id">Select Hotel</label>
        <select name="hotel_id" id="hotel_id" class="form-control" required>
            <option value="">Select a hotel</option>
            <?php foreach ($hotels as $hotel): ?>
                <option value="<?= $hotel['id'] ?>"><?= htmlspecialchars($hotel['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Day-Wise Itinerary -->
    <div class="form-group">
        <label>Day-Wise Itinerary</label>
        <div id="itinerary-section">
            <!-- Placeholder for itinerary items -->
            <div class="itinerary-item mb-3">
                <label for="itinerary_day_1">Day 1:</label>
                <textarea name="itinerary[1]" id="itinerary_day_1" class="form-control" placeholder="Description for Day 1" required></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-itinerary-item">Add Another Day</button>
    </div>

    <!-- Inclusions -->
    <div class="form-group">
        <label for="inclusions">Inclusions</label>
        <textarea name="inclusions" id="inclusions" class="form-control" placeholder="List inclusions" required></textarea>
    </div>

    <!-- Exclusions -->
    <div class="form-group">
        <label for="exclusions">Exclusions</label>
        <textarea name="exclusions" id="exclusions" class="form-control" placeholder="List exclusions" required></textarea>
    </div>

    <!-- Charges for Exclusions -->
    <div class="form-group">
        <label for="charges_exclusions">Charges for Exclusions</label>
        <textarea name="charges_exclusions" id="charges_exclusions" class="form-control" placeholder="List charges for exclusions" required></textarea>
    </div>

    <!-- Terms and Conditions -->
    <div class="form-group">
        <label for="terms_conditions">Terms and Conditions</label>
        <textarea name="terms_conditions" id="terms_conditions" class="form-control" placeholder="Write terms and conditions" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Add Package Details</button>
</form>
        
        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
    <script>
    // JavaScript to dynamically add day-wise itinerary fields
    document.getElementById('add-itinerary-item').addEventListener('click', function () {
        const itinerarySection = document.getElementById('itinerary-section');
        const dayCount = itinerarySection.children.length + 1;

        const newItineraryItem = document.createElement('div');
        newItineraryItem.classList.add('itinerary-item', 'mb-3');
        newItineraryItem.innerHTML = `
            <label for="itinerary_day_${dayCount}">Day ${dayCount}:</label>
            <textarea name="itinerary[${dayCount}]" id="itinerary_day_${dayCount}" class="form-control" placeholder="Description for Day ${dayCount}" required></textarea>
        `;
        itinerarySection.appendChild(newItineraryItem);
    });


</script>
<script>
function fetchCarsAndHotels() {
    var packageId = document.getElementById('package_id').value;
    if (packageId) {
        var destinationId = document.querySelector('#package_id option:checked').getAttribute('data-destination');

        // Create a new AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_cars_hotels.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Send the destination ID to the server
        xhr.send('destination_id=' + destinationId);

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Parse the response
                var data = JSON.parse(xhr.responseText);

                // Update car options
                var carSelect = document.getElementById('car_id');
                document.getElementById('destination_id').value = data.cars[0].destination_id;
                carSelect.innerHTML = '<option value="">Select a car</option>';
                // console.log(data.cars[0].destination_id);
                data.cars.forEach(function(car) {
                    var option = document.createElement('option');
                    option.value = car.id;
                    option.textContent = car.model;
                    carSelect.appendChild(option);
                });
                
                // Update hotel options
                var hotelSelect = document.getElementById('hotel_id');
                hotelSelect.innerHTML = '<option value="">Select a hotel</option>';
                data.hotels.forEach(function(hotel) {
                    var option = document.createElement('option');
                    option.value = hotel.id;
                    option.textContent = hotel.name;
                    hotelSelect.appendChild(option);
                });
            }
        };
    }
}
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

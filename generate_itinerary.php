<?php
require('fpdf/fpdf.php'); // Include FPDF library

// Database connection
//$conn = new mysqli("localhost", "root", "", "kashmir_tourism");
include_once("db.php");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Package Data Securely
$uid = intval($_GET["uid"]);
$sql = "SELECT * FROM bookings WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_assoc();
$stmt->close();

// Fetch Hotel Data
$hotel_id = intval($bookings['hotel_id']);
$sql2 = "SELECT hotels.*, GROUP_CONCAT(hotel_images.image_path SEPARATOR ', ') AS image_paths FROM hotels LEFT JOIN hotel_images ON hotels.id = hotel_images.hotel_id WHERE hotels.id = ? GROUP BY hotels.id";
$stmt = $conn->prepare($sql2);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result2 = $stmt->get_result();
$hotels = $result2->fetch_assoc();
$stmt->close();

// Fetch Package Data
$package_id = intval($bookings['package_id']);
$sql3 = "SELECT packages.*, GROUP_CONCAT(packages_images.image SEPARATOR ', ') AS image_paths FROM packages LEFT JOIN packages_images ON packages.id = packages_images.package_id WHERE packages.id = ? GROUP BY packages.id";
$stmt = $conn->prepare($sql3);
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result3 = $stmt->get_result();
$pack_details = $result3->fetch_assoc();
$stmt->close();

// Fetch Package Details
$sql4 = "SELECT * FROM package_details WHERE package_id = ?";
$stmt = $conn->prepare($sql4);
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result4 = $stmt->get_result();
$packdetails = $result4->fetch_assoc();
$stmt->close();

// Fetch Car Details
$car_id = intval($bookings['car_id']);
$sql5 = "SELECT cars.*, GROUP_CONCAT(cars_images.image_path SEPARATOR ', ') AS image_paths FROM cars LEFT JOIN cars_images ON cars.id = cars_images.car_id WHERE cars.id = ? GROUP BY cars.id";
$stmt = $conn->prepare($sql5);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result5 = $stmt->get_result();
$cardetails = $result5->fetch_assoc();
$stmt->close();

// Extract Required Data
$total_adults = $bookings['adults'];
$children_below_5 = $bookings['children_below_5'];
$children_above_5 = $bookings['children_above_5'];
$total_cost = $bookings['total_cost'];
$package_name = $pack_details['name'];
$package_price = $pack_details['price'];
$price_per_adult = $package_price * $total_adults;
$price_children_above5 = ($package_price/2) * $children_above_5;
$extra_cost = abs(($price_per_adult + $price_children_above5) - $total_cost);

$duration = $pack_details['duration'];
$hotel_name = $hotels['name'];
$hotel_location = $hotels['location'];
$car_model = $cardetails['model'];

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
// Company Logo
$pdf->Cell(190, 30, '', 1, 1, 'C');
$pdf->Image('logo2.png', 80, 15, 60);
$pdf->Ln(10);
$pdf->Cell(190, 10, 'Travel Itinerary', 1, 1, 'C');
$pdf->Ln(10);

// Package Table
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Package Details', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Package:', 1);
$pdf->Cell(140, 10, $package_name, 1, 1);
$pdf->Cell(50, 10, 'Duration:', 1);
$pdf->Cell(140, 10, $duration, 1, 1);
$pdf->Ln(5);
// Package Images
$x = $pdf->GetX(); // Store initial X position
$y = $pdf->GetY(); // Store initial Y position

foreach (explode(', ', $pack_details['image_paths']) as $image) {
    $pdf->Image("./".$image, $x, $y, 30); // Place image at X, Y with width 30
    $x += 35; // Move X position for the next image (Adjust spacing as needed)

    // Check if the next image exceeds the page width
    if ($x + 30 > $pdf->GetPageWidth() - 10) { 
        $x = $pdf->GetX(); // Reset X position
        $y += 35; // Move to the next row
    }
}
$pdf->Ln(40); // Space after images

// Hotel Table
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Hotel Details', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Hotel:', 1);
$pdf->Cell(140, 10, $hotel_name, 1, 1);
$pdf->Cell(50, 10, 'Location:', 1);
$pdf->Cell(140, 10, $hotel_location, 1, 1);
$pdf->Ln(5);
// // Hotel Images
$x = $pdf->GetX();
$y = $pdf->GetY();
foreach (explode(', ', $hotels['image_paths']) as $image) {
    $pdf->Image("admin/".$image, $x, $y, 30);
    $x += 35;
    if ($x + 30 > $pdf->GetPageWidth() - 10) {
        $x = $pdf->GetX();
        $y += 35;
    }
}
$pdf->Ln(40);

// Car Table
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Vehicle Details', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Vehicle:', 1);
$pdf->Cell(140, 10, $car_model, 1, 1);
$pdf->Ln(5);
$x = $pdf->GetX();
$y = $pdf->GetY();
foreach (explode(', ', $cardetails['image_paths']) as $image) {
    $pdf->Image("admin/".$image, $x, $y, 30);
    $x += 35;
    if ($x + 30 > $pdf->GetPageWidth() - 10) {
        $x = $pdf->GetX();
        $y += 35;
    }
}
$pdf->Ln(40);

// Itinerary
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Itinerary', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);

// Explode itinerary based on '*' delimiter
$itinerary_days = explode('*', $packdetails['itinerary']);

foreach ($itinerary_days as $index => $day) {
    if (!empty(trim($day))) { // Ignore empty values
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 10, "Day " . ($index + 1), 1, 1, 'L'); // Day heading
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(190, 10, trim($day), 1);
        $pdf->Ln(5); // Add space between days
    }
}

// Inclusions & Exclusions
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Inclusions', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 10, $packdetails['inclusions'], 1);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Exclusions', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 10, $packdetails['exclusions'], 1);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Pricing', 1, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total No of Adults :- " . ($total_adults), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total No of childrens Above age 5 :- " . ($children_above_5), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total No of childrens below age 5 :- " . ($children_below_5), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total cost  for Adults :- " . ($price_per_adult), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total cost for childrens Above age 5 :- " . ($price_children_above5), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total cost for childrens below age 5 :- " . (0), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Extra charges for hotels and cars :- " . ($extra_cost), 1, 1, 'L'); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Total cost:- " . ($total_cost), 1, 1, 'L'); 
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Terms & Conditions', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 10, $packdetails['terms_and_conditions'], 1);
$pdf->Ln(5);

// $total_adults = $bookings['adults'];
// $children_below_5 = $bookings['children_below_5'];
// $children_above_5 = $bookings['children_above_5'];
// $total_cost = $bookings['total_cost'];
// $package_name = $pack_details['name'];
// $duration = $pack_details['duration'];
// $hotel_name = $hotels['name'];
// $hotel_location = $hotels['location'];
// $car_model = $cardetails['model'];
// $package_price = $pack_details['price'];
// $price_per_adult = $package_price * $total_adults;
// $price_children_above5 = ($package_price/2) * $children_above_5;
// $extra_cost = ($price_per_adult + $price_children_above5) - $total_cost;

// Save & Output PDF
$pdf->Output('F', 'itinerary.pdf');
echo "success";
$conn->close();
?>
<?php
require('fpdf/fpdf.php'); // Include FPDF library

// Database connection
$conn = new mysqli("localhost", "root", "", "kashmir_tourism");

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
$duration = $pack_details['duration'];
$hotel_name = $hotels['name'];
$hotel_location = $hotels['location'];
$car_model = $cardetails['model'];

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
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

// Hotel Table
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Hotel Details', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Hotel:', 1);
$pdf->Cell(140, 10, $hotel_name, 1, 1);
$pdf->Cell(50, 10, 'Location:', 1);
$pdf->Cell(140, 10, $hotel_location, 1, 1);
$pdf->Ln(5);

// Car Table
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Vehicle Details', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Vehicle:', 1);
$pdf->Cell(140, 10, $car_model, 1, 1);
$pdf->Ln(5);

// Itinerary
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Itinerary', 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 10, $packdetails['itinerary'], 1);
$pdf->Ln(5);

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

// Save & Output PDF
$pdf->Output('F', 'itinerary.pdf');
echo "success";
$conn->close();
?>
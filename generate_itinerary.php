<?php
require('fpdf/fpdf.php'); // Include FPDF library

// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; // Update if needed
$database = 'your_database_name';
$conn = new mysqli("localhost", "root", "", "kashmir_tourism");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Package Data
$package_id = 6; // Fetch dynamically if needed
$sql = "SELECT * FROM packages WHERE id = $package_id"; 
$result = $conn->query($sql);
$package = $result->fetch_assoc();

// Create a PDF instance
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(190, 10, 'Travel Itinerary', 1, 1, 'C');
$pdf->Ln(10);

// Package Details
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Package: ");
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(100, 10, $package['name'], 0, 1);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Description: ");
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $package['description']);
$pdf->Ln(5);

// Hotel Details
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Hotel: ");
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(100, 10, "Gulmarg 3 Star - NEAR ALPONSE GARDEN", 0, 1);
$pdf->Ln(5);

// Vehicle Details
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Vehicle: ");
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(100, 10, "Hyundai Santro Lx", 0, 1);
$pdf->Ln(5);

// Itinerary
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Itinerary: ");
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "Day 1: Arrival in Leh - Acclimatization at high altitude.");
$pdf->MultiCell(0, 10, "Day 2: Leh Local Sightseeing - Visit Shanti Stupa, Leh Palace.");
$pdf->MultiCell(0, 10, "Day 3: Travel to Nubra Valley via Khardung La Pass.");
$pdf->Ln(5);

// Inclusions & Exclusions
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Inclusions: ");
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "- Accommodation in 3-star hotels.");
$pdf->MultiCell(0, 10, "- Daily breakfast and dinner.");
$pdf->MultiCell(0, 10, "- Airport transfers.");
$pdf->MultiCell(0, 10, "- Private cab for sightseeing.");

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(40, 10, "Exclusions: ");
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "- Airfare not included.");
$pdf->MultiCell(0, 10, "- Personal expenses.");
$pdf->MultiCell(0, 10, "- Travel insurance not included.");

// Save & Output PDF
$pdf->Output('F', 'itinerary.pdf');
//echo "success";
echo "success"; // AJAX will handle this response
$conn->close();
?>

<?php
require('../fpdf/fpdf.php');
include('config.php');

// Check if application_id is provided in the URL
if (!isset($_GET["application_id"])) {
    header("Location: admin_dashboard.php");
    exit;
}

$application_id = $_GET["application_id"];

// Fetch visa application details from the database
$sql_application = "SELECT v.*, e.full_name 
                    FROM visa_applications v 
                    JOIN employees e ON v.employee_id = e.employee_id 
                    WHERE v.application_id = '$application_id'";
$result_application = mysqli_query($conn, $sql_application);
$row_application = mysqli_fetch_assoc($result_application);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Visa Application', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '', 0, 1);

$pdf->Cell(50, 10, 'Employee Name:', 0);
$pdf->Cell(0, 10, $row_application["full_name"], 0, 1);

$pdf->Cell(50, 10, 'Country:', 0);
$pdf->Cell(0, 10, $row_application["country"], 0, 1);

$pdf->Cell(50, 10, 'Visa Type:', 0);
$pdf->Cell(0, 10, $row_application["visa_type"], 0, 1);

$pdf->Cell(50, 10, 'Application Date:', 0);
$pdf->Cell(0, 10, $row_application["application_date"], 0, 1);

$pdf->Cell(50, 10, 'Interview Date:', 0);
$pdf->Cell(0, 10, $row_application["interview_date"], 0, 1);

$pdf->Cell(50, 10, 'Interview Status:', 0);
$pdf->Cell(0, 10, $row_application["interview_status"], 0, 1);

$pdf->Cell(50, 10, 'Visa Status:', 0);
$pdf->Cell(0, 10, $row_application["visa_status"], 0, 1);

$pdf->Cell(50, 10, 'Visa Issued Date:', 0);
$pdf->Cell(0, 10, $row_application["visa_issued_date"], 0, 1);

$pdf->Cell(50, 10, 'Visa Expiry Date:', 0);
$pdf->Cell(0, 10, $row_application["visa_expiry_date"], 0, 1);

$pdf->Output();
?>

<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Count total HRs
$sql_total_hrs = "SELECT COUNT(*) AS total_hrs FROM hr";
$result_total_hrs = mysqli_query($conn, $sql_total_hrs);
$row_total_hrs = mysqli_fetch_assoc($result_total_hrs);
$total_hrs = $row_total_hrs['total_hrs'];

// Count total employees
$sql_total_employees = "SELECT COUNT(*) AS total_employees FROM employees";
$result_total_employees = mysqli_query($conn, $sql_total_employees);
$row_total_employees = mysqli_fetch_assoc($result_total_employees);
$total_employees = $row_total_employees['total_employees'];

// Count total visa applications
$sql_total_visa_applications = "SELECT COUNT(*) AS total_visa_applications FROM visa_applications";
$result_total_visa_applications = mysqli_query($conn, $sql_total_visa_applications);
$row_total_visa_applications = mysqli_fetch_assoc($result_total_visa_applications);
$total_visa_applications = $row_total_visa_applications['total_visa_applications'];

// Count total feedbacks
$sql_total_feedbacks = "SELECT COUNT(*) AS total_feedbacks FROM feedbacks";
$result_total_feedbacks = mysqli_query($conn, $sql_total_feedbacks);
$row_total_feedbacks = mysqli_fetch_assoc($result_total_feedbacks);
$total_feedbacks = $row_total_feedbacks['total_feedbacks'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include('admin_navbar.php'); ?>
<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total HRs</h5>
                    <p class="card-text"><?php echo $total_hrs; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Employees</h5>
                    <p class="card-text"><?php echo $total_employees; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Visa Applications</h5>
                    <p class="card-text"><?php echo $total_visa_applications; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Feedbacks</h5>
                    <p class="card-text"><?php echo $total_feedbacks; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

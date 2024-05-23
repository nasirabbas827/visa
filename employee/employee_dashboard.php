<?php
session_start();
include('config.php');

// Check if employee is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "employee") {
    header("Location: employee_login.php");
    exit;
}

// Fetch employee details from the database
$employee_id = $_SESSION["employee_id"];
$sql_employee = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
$result_employee = mysqli_query($conn, $sql_employee);
$row_employee = mysqli_fetch_assoc($result_employee);

// Fetch visa applications for the employee from the database
$sql_applications = "SELECT * FROM visa_applications WHERE employee_id = '$employee_id'";
$result_applications = mysqli_query($conn, $sql_applications);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container mt-5">
    <h2>Welcome, <?php echo $row_employee["full_name"]; ?></h2>
    <p>Email: <?php echo $row_employee["email"]; ?></p>

    <h3>Visa Application Details</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Country</th>
                <th>Visa Type</th>
                <th>Application Date</th>
                <th>Interview Date</th>
                <th>Interview Status</th>
                <th>Visa Status</th>
                <th>Visa Issued Date</th>
                <th>Visa Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row_application = mysqli_fetch_assoc($result_applications)) {
                echo "<tr>";
                echo "<td>".$row_application["application_id"]."</td>";
                echo "<td>".$row_application["country"]."</td>";
                echo "<td>".$row_application["visa_type"]."</td>";
                echo "<td>".$row_application["application_date"]."</td>";
                echo "<td>".$row_application["interview_date"]."</td>";
                echo "<td>".$row_application["interview_status"]."</td>";
                echo "<td>".$row_application["visa_status"]."</td>";
                echo "<td>".$row_application["visa_issued_date"]."</td>";
                echo "<td>".$row_application["visa_expiry_date"]."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
    <a href="view_schedule.php" class="btn btn-primary">View Schedule</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

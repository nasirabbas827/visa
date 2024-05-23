<?php
session_start();
include('config.php');

// Check if HR is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "hr") {
    header("Location: hr_login.php");
    exit;
}

// Fetch HR details from the database
$email = $_SESSION["email"];
$sql_hr = "SELECT * FROM hr WHERE email = '$email'";
$result_hr = mysqli_query($conn, $sql_hr);
$row_hr = mysqli_fetch_assoc($result_hr);

// Fetch all employees
$sql_employees = "SELECT * FROM employees";
$result_employees = mysqli_query($conn, $sql_employees);

// Display HR dashboard
?>

<!DOCTYPE html>
<html>
<head>
    <title>HR Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include'navbar.php'; ?>
<div class="container mt-5">
    <h2>Welcome, <?php echo $row_hr["full_name"]; ?></h2>
    <p>Email: <?php echo $row_hr["email"]; ?></p>

    <h3>All Employees</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row_employee = mysqli_fetch_assoc($result_employees)) {
                echo "<tr>";
                echo "<td>".$row_employee["employee_id"]."</td>";
                echo "<td>".$row_employee["email"]."</td>";
                echo "<td>".$row_employee["full_name"]."</td>";
                echo "<td><a href='add_schedule.php?employee_id=".$row_employee["employee_id"]."' class='m-2 btn btn-info'>Add Schedule</a><a href='add_visa_details.php?employee_id=".$row_employee["employee_id"]."' class='m-2 btn btn-info'>Add Visa Details</a><a href='view_application.php?employee_id=".$row_employee["employee_id"]."' class='btn btn-primary'>View Application</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

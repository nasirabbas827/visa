<?php
session_start();
include('config.php');

// Check if admin is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all schedules with employee names from the database
$sql_schedules = "SELECT s.*, e.full_name AS employee_name 
                  FROM schedules s 
                  JOIN employees e ON s.employee_id = e.employee_id";
$result_schedules = mysqli_query($conn, $sql_schedules);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Schedules</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>
<div class="container mt-5">
    <h2>View Schedules</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Period</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row_schedule = mysqli_fetch_assoc($result_schedules)) {
                echo "<tr>";
                echo "<td>".$row_schedule["schedule_id"]."</td>";
                echo "<td>".$row_schedule["employee_name"]."</td>";
                echo "<td>".$row_schedule["source"]."</td>";
                echo "<td>".$row_schedule["destination"]."</td>";
                echo "<td>".$row_schedule["period"]."</td>";
                echo "<td><a href='view_schedule_details.php?schedule_id=".$row_schedule["schedule_id"]."' class='btn btn-info'>View Details</a></td>";
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

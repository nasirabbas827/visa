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

// Fetch schedules with details for the employee from the database
$sql_schedules = "SELECT s.*, d.* 
                  FROM schedules s 
                  JOIN schedules d ON s.schedule_id = d.schedule_id
                  WHERE s.employee_id = '$employee_id'";
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
<?php include('navbar.php'); ?>
<div class="container mt-5">
    <h2>View Schedules</h2>
    <h3>Welcome, <?php echo $row_employee["full_name"]; ?></h3>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
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
                echo "<td>".$row_schedule["source"]."</td>";
                echo "<td>".$row_schedule["destination"]."</td>";
                echo "<td>".$row_schedule["period"]."</td>";
                echo "<td><a href='add_details.php?schedule_id=".$row_schedule["schedule_id"]."' class='btn btn-info'>Add Details</a></td>";
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

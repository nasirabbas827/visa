<?php
session_start();
include('config.php');

// Check if admin is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if schedule_id is provided in the URL
if (!isset($_GET["schedule_id"])) {
    header("Location: admin_dashboard.php");
    exit;
}

$schedule_id = $_GET["schedule_id"];

// Fetch schedule details from the database
$sql_details = "SELECT * FROM schedule_details WHERE schedule_id = '$schedule_id'";
$result_details = mysqli_query($conn, $sql_details);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedule Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>
<div class="container mt-5">
    <h2>Schedule Details</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Schedule ID</th>
                <th>Details</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row_detail = mysqli_fetch_assoc($result_details)) {
                echo "<tr>";
                echo "<td>".$row_detail["detail_id"]."</td>";
                echo "<td>".$row_detail["schedule_id"]."</td>";
                echo "<td>".$row_detail["details"]."</td>";
                echo "<td>".$row_detail["created_at"]."</td>";
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

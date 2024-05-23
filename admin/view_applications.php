<?php
session_start();
include('config.php');

// Check if admin is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch search keyword if provided
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
}

// Fetch all visa applications from the database
$sql_applications = "SELECT v.*, e.full_name 
                     FROM visa_applications v 
                     JOIN employees e ON v.employee_id = e.employee_id 
                     WHERE e.full_name LIKE '%$search_keyword%'";
$result_applications = mysqli_query($conn, $sql_applications);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Visa Applications</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>
<div class="container mt-5">
    <h2>View Visa Applications</h2>
    <form class="form-inline mb-3" method="GET" action="">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search by Employee Name" name="search">
        </div>
        <button type="submit" class="btn btn-primary ml-2">Search</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Employee Name</th>
                <th>Country</th>
                <th>Visa Type</th>
                <th>Application Date</th>
                <th>Interview Date</th>
                <th>Interview Status</th>
                <th>Visa Status</th>
                <th>Visa Issued Date</th>
                <th>Visa Expiry Date</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row_application = mysqli_fetch_assoc($result_applications)) {
                echo "<tr>";
                echo "<td>".$row_application["application_id"]."</td>";
                echo "<td>".$row_application["full_name"]."</td>";
                echo "<td>".$row_application["country"]."</td>";
                echo "<td>".$row_application["visa_type"]."</td>";
                echo "<td>".$row_application["application_date"]."</td>";
                echo "<td>".$row_application["interview_date"]."</td>";
                echo "<td>".$row_application["interview_status"]."</td>";
                echo "<td>".$row_application["visa_status"]."</td>";
                echo "<td>".$row_application["visa_issued_date"]."</td>";
                echo "<td>".$row_application["visa_expiry_date"]."</td>";
                echo "<td>".$row_application["created_at"]."</td>";
                echo "<td>".$row_application["updated_at"]."</td>";
                echo "<td><a href='print_application.php?application_id=".$row_application["application_id"]."' class='btn btn-info'>Print Application</a></td>";
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

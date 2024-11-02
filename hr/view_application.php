<?php
session_start();
include('config.php');

// Check if HR is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "hr") {
    header("Location: hr_login.php");
    exit;
}

// Check if employee_id is provided in the URL
if (!isset($_GET["employee_id"])) {
    header("Location: hr_dashboard.php");
    exit;
}

$employee_id = $_GET["employee_id"];
$message = "";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_application"])) {
    $application_id = $_POST["application_id"];

    // Delete visa application from the database
    $sql_delete = "DELETE FROM visa_applications WHERE application_id = '$application_id'";
    if (mysqli_query($conn, $sql_delete)) {
        $message = "Visa application deleted successfully.";
    } else {
        $message = "Error deleting application: " . mysqli_error($conn);
    }
}

// Fetch employee details from the database
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
    <title>View Visa Applications</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script>
        // Display the message if set
        function showMessage() {
            <?php if ($message): ?>
                alert("<?php echo $message; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body onload="showMessage()">
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>View Visa Applications for <?php echo $row_employee["full_name"]; ?></h2>
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
                <th>Action</th>
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
                echo "<td>
                        <a href='edit_application.php?application_id=".$row_application["application_id"]."&employee_id=".$employee_id."' class='mb-2 btn btn-primary'>Edit</a>
                        <form method='post' action='".htmlspecialchars($_SERVER["PHP_SELF"])."?employee_id=".$employee_id."' style='display:inline;'>
                            <input type='hidden' name='application_id' value='".$row_application["application_id"]."'>
                            <button type='submit' name='delete_application' class='btn btn-danger'>Delete</button>
                        </form>
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

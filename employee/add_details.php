<?php
session_start();
include('config.php');

// Check if employee is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "employee") {
    header("Location: employee_login.php");
    exit;
}

// Check if schedule_id is provided in the URL
if (!isset($_GET["schedule_id"])) {
    header("Location: view_schedules.php");
    exit;
}

// Fetch employee details from the database
$employee_id = $_SESSION["employee_id"];
$sql_employee = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
$result_employee = mysqli_query($conn, $sql_employee);
$row_employee = mysqli_fetch_assoc($result_employee);

// Fetch schedule details from the database
$schedule_id = $_GET["schedule_id"];
$sql_schedule = "SELECT * FROM schedules WHERE schedule_id = '$schedule_id' AND employee_id = '$employee_id'";
$result_schedule = mysqli_query($conn, $sql_schedule);
$row_schedule = mysqli_fetch_assoc($result_schedule);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $details = $_POST["details"];

    // Insert details into the database
    $sql_insert = "INSERT INTO schedule_details (schedule_id, details, created_at) 
                   VALUES ('$schedule_id', '$details', NOW())";

    if (mysqli_query($conn, $sql_insert)) {
        $success_message = "Details added successfully!";
    } else {
        $error_message = "Error adding details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container mt-5">
    <h2>Add Details</h2>
    <h3>Schedule ID: <?php echo $row_schedule["schedule_id"]; ?></h3>

    <?php 
    if (isset($success_message)) {
        echo "<div class='alert alert-success' role='alert'>$success_message</div>";
    } elseif (isset($error_message)) {
        echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?schedule_id=$schedule_id"; ?>">
        <div class="form-group">
            <label for="details">Details:</label>
            <textarea class="form-control" id="details" name="details" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Details</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

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

// Fetch employee details from the database
$sql_employee = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
$result_employee = mysqli_query($conn, $sql_employee);
$row_employee = mysqli_fetch_assoc($result_employee);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source = $_POST["source"];
    $destination = $_POST["destination"];
    $period = $_POST["period"];

    // Insert schedule into the database
    $sql_insert_schedule = "INSERT INTO schedules (employee_id, source, destination, period) 
                            VALUES ('$employee_id', '$source', '$destination', '$period')";

    if (mysqli_query($conn, $sql_insert_schedule)) {
        $success_message = "Schedule added successfully!";
    } else {
        $error_message = "Error adding schedule: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Schedule</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include'navbar.php'; ?>
<div class="container mt-5">
    <h2>Add Schedule for <?php echo $row_employee["full_name"]; ?></h2>
    <?php 
    if (isset($success_message)) {
        echo "<div class='alert alert-success' role='alert'>$success_message</div>";
    } elseif (isset($error_message)) {
        echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?employee_id=' . $employee_id; ?>">
        <div class="form-group">
            <label for="source">Source:</label>
            <input type="text" class="form-control" id="source" name="source" required>
        </div>
        <div class="form-group">
            <label for="destination">Destination:</label>
            <input type="text" class="form-control" id="destination" name="destination" required>
        </div>
        <div class="form-group">
            <label for="period">Period:</label>
            <input type="date" class="form-control" id="period" name="period" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Schedule</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

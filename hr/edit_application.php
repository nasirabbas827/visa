<?php
session_start();
include('config.php');

// Check if HR is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "hr") {
    header("Location: hr_login.php");
    exit;
}

// Check if application_id is provided in the URL
if (!isset($_GET["application_id"]) || !isset($_GET["employee_id"])) {
    header("Location: hr_dashboard.php");
    exit;
}

$application_id = $_GET["application_id"];
$employee_id = $_GET["employee_id"];

// Fetch visa application details from the database
$sql_application = "SELECT * FROM visa_applications WHERE application_id = '$application_id'";
$result_application = mysqli_query($conn, $sql_application);
$row_application = mysqli_fetch_assoc($result_application);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $country = $_POST["country"];
    $visa_type = $_POST["visa_type"];
    $application_date = $_POST["application_date"];
    $interview_date = $_POST["interview_date"];
    $interview_status = $_POST["interview_status"];
    $visa_status = $_POST["visa_status"];
    $visa_issued_date = $_POST["visa_issued_date"];
    $visa_expiry_date = $_POST["visa_expiry_date"];

    // Update visa application details in the database
    $sql_update = "UPDATE visa_applications SET 
                    country = '$country', 
                    visa_type = '$visa_type', 
                    application_date = '$application_date', 
                    interview_date = '$interview_date', 
                    interview_status = '$interview_status', 
                    visa_status = '$visa_status', 
                    visa_issued_date = '$visa_issued_date', 
                    visa_expiry_date = '$visa_expiry_date' 
                    WHERE application_id = '$application_id'";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: view_application.php?employee_id=".$employee_id);
        exit;
    } else {
        $error_message = "Error updating application: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Visa Application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include'navbar.php'; ?>
<div class="container mt-5 mb-5">
    <h2>Edit Visa Application</h2>
    <?php if (!empty($error_message)) {
        echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
    } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?application_id=".$application_id."&employee_id=".$employee_id; ?>">
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" value="<?php echo $row_application["country"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="visa_type">Visa Type:</label>
            <input type="text" class="form-control" id="visa_type" name="visa_type" value="<?php echo $row_application["visa_type"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="application_date">Application Date:</label>
            <input type="date" class="form-control" id="application_date" name="application_date" value="<?php echo $row_application["application_date"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="interview_date">Interview Date:</label>
            <input type="date" class="form-control" id="interview_date" name="interview_date" value="<?php echo $row_application["interview_date"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="interview_status">Interview Status:</label>
            <input type="text" class="form-control" id="interview_status" name="interview_status" value="<?php echo $row_application["interview_status"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="visa_status">Visa Status:</label>
            <input type="text" class="form-control" id="visa_status" name="visa_status" value="<?php echo $row_application["visa_status"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="visa_issued_date">Visa Issued Date:</label>
            <input type="date" class="form-control" id="visa_issued_date" name="visa_issued_date" value="<?php echo $row_application["visa_issued_date"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="visa_expiry_date">Visa Expiry Date:</label>
            <input type="date" class="form-control" id="visa_expiry_date" name="visa_expiry_date" value="<?php echo $row_application["visa_expiry_date"]; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

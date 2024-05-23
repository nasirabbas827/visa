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

// Initialize variables for form fields
$country = $visa_type = $application_date = $interview_date = $interview_status = $visa_status = $visa_issued_date = $visa_expiry_date = "";
$error_message = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
    $visa_type = mysqli_real_escape_string($conn, $_POST["visa_type"]);
    $application_date = mysqli_real_escape_string($conn, $_POST["application_date"]);
    $interview_date = mysqli_real_escape_string($conn, $_POST["interview_date"]);
    $interview_status = mysqli_real_escape_string($conn, $_POST["interview_status"]);
    $visa_status = mysqli_real_escape_string($conn, $_POST["visa_status"]);
    $visa_issued_date = mysqli_real_escape_string($conn, $_POST["visa_issued_date"]);
    $visa_expiry_date = mysqli_real_escape_string($conn, $_POST["visa_expiry_date"]);

    // Insert visa application details into the database
    $sql = "INSERT INTO visa_applications (employee_id, country, visa_type, application_date, interview_date, interview_status, visa_status, visa_issued_date, visa_expiry_date) VALUES ('$employee_id', '$country', '$visa_type', '$application_date', '$interview_date', '$interview_status', '$visa_status', '$visa_issued_date', '$visa_expiry_date')";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_applications.php");
        exit;
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Visa Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include'navbar.php'; ?>
<div class="container mt-5 mb-5">
    <h2>Add Visa Details</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?employee_id=' . $employee_id; ?>">
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>
        <div class="form-group">
            <label for="visa_type">Visa Type:</label>
            <input type="text" class="form-control" id="visa_type" name="visa_type" required>
        </div>
        <div class="form-group">
            <label for="application_date">Application Date:</label>
            <input type="date" class="form-control" id="application_date" name="application_date" required>
        </div>
        <div class="form-group">
            <label for="interview_date">Interview Date:</label>
            <input type="date" class="form-control" id="interview_date" name="interview_date" required>
        </div>
        <div class="form-group">
            <label for="interview_status">Interview Status:</label>
            <input type="text" class="form-control" id="interview_status" name="interview_status" required>
        </div>
        <div class="form-group">
            <label for="visa_status">Visa Status:</label>
            <input type="text" class="form-control" id="visa_status" name="visa_status" required>
        </div>
        <div class="form-group">
            <label for="visa_issued_date">Visa Issued Date:</label>
            <input type="date" class="form-control" id="visa_issued_date" name="visa_issued_date" required>
        </div>
        <div class="form-group">
            <label for="visa_expiry_date">Visa Expiry Date:</label>
            <input type="date" class="form-control" id="visa_expiry_date" name="visa_expiry_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <?php if (!empty($error_message)) {
            echo "<div class='alert alert-danger mt-3' role='alert'>$error_message</div>";
        } ?>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

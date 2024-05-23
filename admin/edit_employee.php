<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if Employee ID is provided in the URL
if (!isset($_GET["employee_id"])) {
    header("Location: view_employees.php");
    exit;
}

$employee_id = $_GET["employee_id"];

// Fetch employee details from the database
$sql = "SELECT * FROM employees WHERE employee_id = $employee_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Employee not found";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Function to update employee details
function updateEmployee($conn, $employee_id, $email, $password, $full_name, $position, $department, $location, $hire_date, $current_visa_status, $visa_expiry_date) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE employees SET email='$email', full_name='$full_name', position='$position', department='$department', location='$location', hire_date='$hire_date', current_visa_status='$current_visa_status', visa_expiry_date='$visa_expiry_date'";
    if (!empty($password)) {
        $sql .= ", password='$hashed_password'";
    }
    $sql .= " WHERE employee_id = $employee_id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>Employee details updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating employee details: " . mysqli_error($conn) . "</div>";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $full_name = $_POST["full_name"];
    $position = $_POST["position"];
    $department = $_POST["department"];
    $location = $_POST["location"];
    $hire_date = $_POST["hire_date"];
    $current_visa_status = $_POST["current_visa_status"];
    $visa_expiry_date = $_POST["visa_expiry_date"];

    // Update employee details
    updateEmployee($conn, $employee_id, $email, $password, $full_name, $position, $department, $location, $hire_date, $current_visa_status, $visa_expiry_date);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Edit Employee</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include('admin_navbar.php');
?>

<div class="container mt-5 mb-5">
    <h2>Edit Employee</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?employee_id=' . $employee_id; ?>">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
            <small id="passwordHelp" class="form-text text-muted">Leave blank to keep the same password.</small>
        </div>
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $row["full_name"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="position">Position:</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo $row["position"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="department">Department:</label>
            <input type="text" class="form-control" id="department" name="department" value="<?php echo $row["department"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $row["location"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="hire_date">Hire Date:</label>
            <input type="date" class="form-control" id="hire_date" name="hire_date" value="<?php echo $row["hire_date"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="current_visa_status">Current Visa Status:</label>
            <select class="form-control" id="current_visa_status" name="current_visa_status" required>
                <option value="Valid" <?php if ($row["current_visa_status"] == "Valid") echo "selected"; ?>>Valid</option>
                <option value="Expired" <?php if ($row["current_visa_status"] == "Expired") echo "selected"; ?>>Expired</option>
                <option value="Pending" <?php if ($row["current_visa_status"] == "Pending") echo "selected"; ?>>Pending</option>
            </select>
        </div>
        <div class="form-group">
            <label for="visa_expiry_date">Visa Expiry Date:</label>
            <input type="date" class="form-control" id="visa_expiry_date" name="visa_expiry_date" value="<?php echo $row["visa_expiry_date"]; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


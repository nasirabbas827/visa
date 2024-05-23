<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Function to add employee
function addEmployee($conn, $email, $password, $full_name, $position, $department, $location, $hire_date, $current_visa_status, $visa_expiry_date) {
    $created_at = date('Y-m-d H:i:s');
    $sql = "INSERT INTO employees (email, password, full_name, position, department, location, hire_date, current_visa_status, visa_expiry_date, created_at, updated_at) 
            VALUES ('$email', '$password', '$full_name', '$position', '$department', '$location', '$hire_date', '$current_visa_status', '$visa_expiry_date', '$created_at', '$created_at')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>Employee added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error adding employee: " . mysqli_error($conn) . "</div>";
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

    // Add employee
    addEmployee($conn, $email, $password, $full_name, $position, $department, $location, $hire_date, $current_visa_status, $visa_expiry_date);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Add Employee</title>
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
    <h2>Add Employee</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="form-group">
            <label for="position">Position:</label>
            <input type="text" class="form-control" id="position" name="position" required>
        </div>
        <div class="form-group">
            <label for="department">Department:</label>
            <input type="text" class="form-control" id="department" name="department" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="hire_date">Hire Date:</label>
            <input type="date" class="form-control" id="hire_date" name="hire_date" required>
        </div>
        <div class="form-group">
            <label for="current_visa_status">Current Visa Status:</label>
            <select class="form-control" id="current_visa_status" name="current_visa_status" required>
                <option value="Valid">Valid</option>
                <option value="Expired">Expired</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div class="form-group">
            <label for="visa_expiry_date">Visa Expiry Date:</label>
            <input type="date" class="form-control" id="visa_expiry_date" name="visa_expiry_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Employee</button>
        <a class="btn btn-outline-dark" href="view_employees.php">View Employees</a>

    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

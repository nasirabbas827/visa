<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if HR ID is provided in the URL
if (!isset($_GET["hr_id"])) {
    header("Location: view_hrs.php");
    exit;
}

$hr_id = $_GET["hr_id"];

// Fetch HR details from the database
$sql = "SELECT * FROM hr WHERE hr_id = $hr_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "HR not found";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Function to update HR details
function updateHR($conn, $hr_id, $username, $full_name, $email, $password) {
    $sql = "UPDATE hr SET username='$username', full_name='$full_name', email='$email'";
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password='$hashed_password'";
    }
    $sql .= " WHERE hr_id = $hr_id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>HR details updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating HR details: " . mysqli_error($conn) . "</div>";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Update HR details
    updateHR($conn, $hr_id, $username, $full_name, $email, $password);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Edit HR</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include('admin_navbar.php');
?>

<div class="container mt-5">
    <h2>Edit HR</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?hr_id=' . $hr_id; ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row["username"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $row["full_name"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
            <small id="passwordHelp" class="form-text text-muted">Leave blank to keep the same password.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update HR</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

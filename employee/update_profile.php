<?php
session_start();
include('config.php');

// Check if employee is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "employee") {
    header("Location: employee_login.php");
    exit;
}

// Fetch employee details from the session
$employee_id = $_SESSION["employee_id"];
$sql_employee = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
$result_employee = mysqli_query($conn, $sql_employee);
$row_employee = mysqli_fetch_assoc($result_employee);

// Initialize variables for storing messages
$success_message = '';
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Update employee profile
    $sql_update = "UPDATE employees SET full_name = '$full_name', email = '$email' WHERE employee_id = '$employee_id'";
    if (mysqli_query($conn, $sql_update)) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . mysqli_error($conn);
    }

    // Check if password is provided for updating
    if (!empty($password)) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update password
        $sql_update_password = "UPDATE employees SET password = '$hashed_password' WHERE employee_id = '$employee_id'";
        if (mysqli_query($conn, $sql_update_password)) {
            $success_message = "Password updated successfully!";
        } else {
            $error_message = "Error updating password: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container mt-5">
    <h2>Update Profile</h2>
    <?php 
    if (!empty($success_message)) {
        echo "<div class='alert alert-success' role='alert'>$success_message</div>";
    } elseif (!empty($error_message)) {
        echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $row_employee["full_name"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row_employee["email"]; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

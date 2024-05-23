<?php
session_start();
include('config.php');

// Check if employee is already logged in
if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] === "employee") {
    header("Location: employee_dashboard.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate email and password (you can add more validation)
    if (!empty($email) && !empty($password)) {
        // Check employee credentials
        $sql = "SELECT * FROM employees WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                // Employee login successful
                $_SESSION["usertype"] = "employee";
                $_SESSION["employee_id"] = $row['employee_id'];
                header("Location: employee/employee_dashboard.php");
                exit;
            } else {
                $error_message = "Incorrect password";
            }
        } else {
            $error_message = "Employee with this email does not exist";
        }
    } else {
        $error_message = "Please enter both email and password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container mt-5">
    <h2>Employee Login</h2>
    <?php
    if (isset($error_message)) {
        echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

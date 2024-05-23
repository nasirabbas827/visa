<?php
session_start();
include('config.php');

// Check if HR is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "hr") {
    header("Location: hr_login.php");
    exit;
}

// Fetch HR details from the database
$email = $_SESSION["email"];
$sql = "SELECT * FROM hr WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST["feedback"];

    // Get HR ID from the fetched row
    $hr_id = $row["hr_id"];

    // Insert feedback into the database
    $sql_insert_feedback = "INSERT INTO feedbacks (hr_id, feedback, created_at) 
                            VALUES ('$hr_id', '$feedback', NOW())";

    if (mysqli_query($conn, $sql_insert_feedback)) {
        $success_message = "Feedback posted successfully!";
    } else {
        $error_message = "Error posting feedback: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Feedback</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include'navbar.php'; ?>
<div class="container mt-5">
    <h2>Post Feedback</h2>
    <?php 
    if (isset($success_message)) {
        echo "<div class='alert alert-success' role='alert'>$success_message</div>";
    } elseif (isset($error_message)) {
        echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="feedback">Feedback:</label>
            <textarea class="form-control" id="feedback" name="feedback" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post Feedback</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

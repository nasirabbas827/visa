<?php
session_start();
include('config.php');

// Check if admin is logged in
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all feedbacks from the database with employee and HR names
$sql_feedbacks = "SELECT f.feedback_id, f.feedback, f.created_at, e.full_name AS employee_name, h.full_name AS hr_name
                 FROM feedbacks f
                 LEFT JOIN employees e ON f.employee_id = e.employee_id
                 LEFT JOIN hr h ON f.hr_id = h.hr_id";
$result_feedbacks = mysqli_query($conn, $sql_feedbacks);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Feedbacks</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>
<div class="container mt-5">
    <h2>View Feedbacks</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>HR Name</th>
                <th>Employee Name</th>
                <th>Feedback</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row_feedback = mysqli_fetch_assoc($result_feedbacks)) {
                echo "<tr>";
                echo "<td>".$row_feedback["feedback_id"]."</td>";
                echo "<td>".$row_feedback["hr_name"]."</td>";
                echo "<td>".$row_feedback["employee_name"]."</td>";
                echo "<td>".$row_feedback["feedback"]."</td>";
                echo "<td>".$row_feedback["created_at"]."</td>";
                echo "<td>
                        <form method='post' action='delete_feedback.php' style='display:inline;'>
                            <input type='hidden' name='feedback_id' value='".$row_feedback["feedback_id"]."'>
                            <button type='submit' name='delete_feedback' class='btn btn-danger'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

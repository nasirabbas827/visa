<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Function to delete HR
function deleteHR($conn, $hr_id) {
    $sql = "DELETE FROM hr WHERE hr_id = $hr_id";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>HR deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting HR: " . mysqli_error($conn) . "</div>";
    }
}

// Check if HR deletion request is sent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_hr"])) {
    $hr_id = $_POST["hr_id"];
    deleteHR($conn, $hr_id);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - View HR</title>
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
    <h2>View HRs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all HRs from database
            $sql = "SELECT * FROM hr";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row["username"]."</td>";
                    echo "<td>".$row["full_name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["password"]."</td>";
                    echo "<td>
                            <a href='edit_hr.php?hr_id=".$row["hr_id"]."' class='btn btn-primary btn-sm'>Edit</a>
                            <form method='post' action='".htmlspecialchars($_SERVER["PHP_SELF"])."' style='display:inline;'>
                                <input type='hidden' name='hr_id' value='".$row["hr_id"]."'>
                                <button type='submit' name='delete_hr' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No HRs found</td></tr>";
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

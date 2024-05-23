<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Function to delete employee
function deleteEmployee($conn, $employee_id) {
    $sql = "DELETE FROM employees WHERE employee_id = $employee_id";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>Employee deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting employee: " . mysqli_error($conn) . "</div>";
    }
}

// Check if employee deletion request is sent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_employee"])) {
    $employee_id = $_POST["employee_id"];
    deleteEmployee($conn, $employee_id);
}

// Fetch employees from the database
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);

// Fetch employees from the database
if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $search_name = mysqli_real_escape_string($conn, $_GET['search_name']);
    $sql = "SELECT * FROM employees WHERE full_name LIKE '%$search_name%'";
} else {
    $sql = "SELECT * FROM employees";
}
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - View Employees</title>
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
    <h2>View Employees</h2>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="search_name">Search by Name:</label>
            <input type="text" class="form-control" id="search_name" name="search_name" value="<?php echo isset($_GET['search_name']) ? $_GET['search_name'] : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Position</th>
                <th>Department</th>
                <th>Location</th>
                <th>Hire Date</th>
                <th>Current Visa Status</th>
                <th>Visa Expiry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row["employee_id"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["full_name"]."</td>";
                    echo "<td>".$row["position"]."</td>";
                    echo "<td>".$row["department"]."</td>";
                    echo "<td>".$row["location"]."</td>";
                    echo "<td>".$row["hire_date"]."</td>";
                    echo "<td>".$row["current_visa_status"]."</td>";
                    echo "<td>".$row["visa_expiry_date"]."</td>";
                    echo "<td>
                            <a href='edit_employee.php?employee_id=".$row["employee_id"]."' class='mb-2 btn btn-primary btn-sm'>Edit</a>
                            <form method='post' action='".htmlspecialchars($_SERVER["PHP_SELF"])."' style='display:inline;'>
                                <input type='hidden' name='employee_id' value='".$row["employee_id"]."'>
                                <button type='submit' name='delete_employee' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No employees found</td></tr>";
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

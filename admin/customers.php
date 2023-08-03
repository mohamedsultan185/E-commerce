<?php
session_start();
if (!isset($_SESSION['admin_username'])) { 
    header("location: auth/login.php");
    exit(); // Make sure to exit after redirecting to prevent further execution of the script.
}

include '../database/connection.php';

// Fetch data from the "customers" table
$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);

include_once 'includes/header.php';
include_once 'includes/bar.php';
?>
<div class="container mt-4">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Loop through the results and display the data in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['first_name'] . '</td>';
            echo '<td>' . $row['last_name'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['phone_number'] . '</td>';
            echo '<td>' . $row['address'] . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '<td>' . $row['updated_at'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<?php include_once 'includes/footer.php'; ?>

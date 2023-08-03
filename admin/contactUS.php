<?php
session_start();
if (!isset($_SESSION['admin_username'])) { 
    header("location: auth/login.php");
    exit(); // Make sure to exit after redirecting to prevent further execution of the script.
}

include '../database/connection.php';

include_once 'includes/header.php';
include_once 'includes/bar.php';
?>
<div class="container mt-4">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Messages</th>
                <th scope="col"> AT Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch data from the contact_form_data table
            $sql = "SELECT * FROM contact_form_data";
            $result = $conn->query($sql);

            // Loop through the records and display them in the table
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td>{$row['message']}</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include_once 'includes/footer.php'; ?>

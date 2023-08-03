<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // include fill database 
    include '../database/connection.php';

    // Sanitize and validate the form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Not using mysqli_real_escape_string for password
    $confirm_password = $_POST['confirm_password']; // Not using mysqli_real_escape_string for confirm_password
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Validate form data (you can add more validation rules if needed)
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number) || empty($address)) {
        die("Please fill in all the required fields.");
    }

    if ($password !== $confirm_password) {
        die("Password and Confirm Password do not match.");
    }

    // Check if the email already exists in the database
    $email_check_query = "SELECT COUNT(*) as count FROM customers WHERE email='$email'";
    $email_result = $conn->query($email_check_query);
    $email_count = $email_result->fetch_assoc()['count'];

    if ($email_count > 0) {
        die("Email address already exists. Please use a different email.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to insert data into the table
    $sql = "INSERT INTO customers (first_name, last_name, email, password, phone_number, address) 
            VALUES ('$first_name', '$last_name', '$email', '$hashed_password', '$phone_number', '$address')";

    if ($conn->query($sql) === TRUE) {
        header('location: ../index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>






<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/stylecreat.css">
    <title>My Frist Page </title>
    <meta  This Is Description For My First Page>

</head>
<body>
    <form class="honda" action="register.php" method="post">
        <fieldset style="background-color: rgb(255, 255, 255);">
            <legend>Register an account</legend>
            <label>First name</label>
            <input type="text" name="first_name" placeholder="First name">

            <label>Last name</label>
            <input type="text" name="last_name" placeholder="Last name">

            <br><br>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password">

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password">

            <br><br>

            <label>Email</label>
            <input type="email" name="email" placeholder="@gmail">

            <label>Address</label>
            <input type="text" name="address" placeholder="Address">

            <br><br>

            <label>Phone</label>
            <input type="text" name="phone_number" placeholder="Phone number">

            <br><br>

            <input type="submit" value="SIGN IN">
            <br><br>
        </fieldset>
    </form>
</body>
</html>
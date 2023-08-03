<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // include database connection
    include '../database/connection.php';
    

    // Sanitize and validate the form data
    $phone_email = mysqli_real_escape_string($conn, $_POST['phone_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare and execute the SQL query to check login credentials
    $sql = "SELECT * FROM customers WHERE (phone_number = '$phone_email' OR email = '$phone_email')";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password']; // Assuming the password column in the database is named 'password'

        // Verify the password using password_verify()
        if (password_verify($password, $hashedPassword)) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $row['id']; // Assuming the primary key column in the 'customers' table is named 'id'
            $_SESSION['email'] = $row['email'];
            $_SESSION['logged_in'] = true;

            // Set cookies if "Remember Me" is checked
            if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days expiry time
                setcookie('remembered_user', $_SESSION['user_id'], $expiry, '/');
            }

            header('location: ../index.php');
            exit();
        } else {
            // Incorrect password, display an error message
            $_SESSION['login_error'] = "Incorrect password. Please try again.";
        }
    } else {
        // User not found, display an error message
        $_SESSION['login_error'] = "User not found. Please check your phone/email and try again.";
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styleoflogin.css">
</head>
<body>
    <div class="tamplet">
        <form class="form" id="login" method="post">
            <h1 class="form-title">LOGIN</h1>
            <?php if (isset($_SESSION['login_error'])) { ?>
                <div class="form_massage"><?php echo $_SESSION['login_error']; ?></div>
            <?php } ?>
            <div class="form-inputs">
                <input type="text" name="phone_email" class="input-user" placeholder=" phone, or email">
            </div>
            <div class="form-inputs">
                <input type="password" name="password" class="input-user" placeholder="Enter your password">
            </div>
            <div class="form-inputs">
                <label>
                    <input type="checkbox" name="remember_me"> Remember Me
                </label>
            </div>
            <button class="form-button" type="submit">Enter</button>
            <p class="form-text">
                <a href="forgetpass.php" class="form-link">Forgot password?</a>
            </p>
            <p class="form-text">
                <a href="register.php" class="form-link">Do not have an account, create an account</a>
            </p>
        </form>
    </div>
</body>
</html>


<?php
// Step 1: Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include '../database/connection.php';

    // Validate and sanitize the form data
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $phone_username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Prepare and execute the SQL query to check login credentials
        $sql = "SELECT * FROM admins WHERE username = '$phone_username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password']; // Assuming the password column in the database is named 'password'

            // Verify the password using password_verify()
            if (password_verify($password, $hashedPassword)) {
                // Login successful, set session variables
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];

                // Set cookies if "Remember Me" is checked
                if (isset($_POST['remember_me']) && $_POST['remember_me'] === 'on') {
                    $expiry = time() + (30 * 24 * 60 * 60); // 30 days expiry time
                    setcookie('remembered_user', $row['id'], $expiry, '/');
                }

                header('Location: ../index.php');
                exit();
            } else {
                // Incorrect password, display an error message
                $login_error = "Incorrect password. Please try again.";
            }
        } else {
            // User not found, display an error message
            $login_error = "User not found. Please check your phone/username and try again.";
        }
    } else {
        // Handle the case when 'username' or 'password' is not set in the form
        $login_error = "Please provide both username and password.";
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
            <?php if (isset($login_error)) { ?>
                <div class="form_massage"><?php echo $login_error; ?></div>
            <?php } ?>
            <div class="form-inputs">
                <input type="text" name="username" class="input-user" placeholder="Phone or Email">
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
                <a href="register.php" class="form-link">Don't have an account? Create an account</a>
            </p>
        </form>
        
        
        
    </div>
</body>
</html>
